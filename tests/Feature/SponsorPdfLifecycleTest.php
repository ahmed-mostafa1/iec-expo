<?php

namespace Tests\Feature;

use App\Mail\ContractConfirmationMail;
use App\Mail\NewSponsorRegistrationMail;
use App\Models\Admin;
use App\Models\SponsorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use RuntimeException;
use Tests\TestCase;
use ZipArchive;

class SponsorPdfLifecycleTest extends TestCase
{
    use RefreshDatabase;

    private array $adminEmails = [
        'iec360@umbrella.sa',
        'mo.faour@gmail.com',
        'aomar@umbrella.sa',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        config(['admin.emails' => $this->adminEmails]);

        Storage::fake('public');
    }

    public function test_sponsor_registration_marks_pdf_as_failed_and_notifies_admins_without_customer_contract(): void
    {
        Mail::fake();

        $this->app->instance(RegistrationPdfService::class, new class extends RegistrationPdfService
        {
            public function generateSponsorPdf(SponsorRegistration $registration): string
            {
                throw new RuntimeException('CloudConvert conversion timed out before export was ready.');
            }
        });

        $response = $this->post(route('public.register.sponsor', ['locale' => 'en']), [
            'full_name' => 'Sponsor User',
            'email' => 'sponsor@example.com',
            'phone' => '+966512345678',
            'job_title' => 'Director',
            'organization' => 'Sponsor Co',
            'sponsor_tier' => 'gold',
            'location_selection' => '',
            'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
            'cr_copy' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
            'national_address_document' => UploadedFile::fake()->create('address.pdf', 100, 'application/pdf'),
            'company_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
            'privacy_policy' => '1',
        ], ['Accept' => 'application/json']);

        $response->assertCreated()
            ->assertJsonPath('message', __('registration.sponsor.success_pdf_pending'))
            ->assertJsonPath('pdf_url', null)
            ->assertJsonPath('pdf_name', null);

        $registration = SponsorRegistration::query()->sole();

        $this->assertSame('failed', $registration->pdf_status);
        $this->assertSame('CloudConvert conversion timed out before export was ready.', $registration->pdf_error);
        $this->assertNull($registration->pdf_generated_at);
        $this->assertNull($registration->pdf_path);

        Mail::assertNotSent(ContractConfirmationMail::class);
        Mail::assertSent(NewSponsorRegistrationMail::class, count($this->adminEmails));

        foreach ($this->adminEmails as $adminEmail) {
            Mail::assertSent(NewSponsorRegistrationMail::class, fn (NewSponsorRegistrationMail $mail) => $mail->hasTo($adminEmail) && $mail->pdfPath === null);
        }
    }

    public function test_admin_regenerate_pdf_marks_sponsor_as_failed_when_generation_fails(): void
    {
        $admin = Admin::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $registration = SponsorRegistration::query()->create([
            'full_name' => 'Sponsor User',
            'email' => 'sponsor@example.com',
            'phone' => '+966512345678',
            'job_title' => 'Director',
            'organization' => 'Sponsor Co',
            'sponsor_tier' => 'gold',
            'location_selection' => null,
            'vat_number' => null,
            'vat_certificate_path' => 'registrations/sponsors/vat-certificate/2026/vat.pdf',
            'national_address' => '',
            'document_path' => null,
            'cr_copy_path' => 'registrations/sponsors/cr-copy/2026/cr.pdf',
            'national_address_doc_path' => 'registrations/sponsors/national-address/2026/address.pdf',
            'company_logo_path' => 'registrations/sponsors/company-logo/2026/logo.pdf',
            'pdf_path' => null,
            'pdf_status' => 'pending',
            'pdf_error' => null,
            'pdf_generated_at' => null,
            'status' => 'pending',
        ]);

        $this->app->instance(RegistrationPdfService::class, new class extends RegistrationPdfService
        {
            public function generateSponsorPdf(SponsorRegistration $registration): string
            {
                throw new RuntimeException('CloudConvert job creation failed.');
            }
        });

        $response = $this->actingAs($admin, 'admin')
            ->from(route('admin.sponsors.show', $registration))
            ->post(route('admin.sponsors.regenerate-pdf', $registration));

        $response->assertRedirect(route('admin.sponsors.show', $registration));
        $response->assertSessionHas('error', __('PDF regeneration failed. The team can review the error details below.'));

        $registration->refresh();

        $this->assertSame('failed', $registration->pdf_status);
        $this->assertSame('CloudConvert job creation failed.', $registration->pdf_error);
        $this->assertNull($registration->pdf_generated_at);
        $this->assertNull($registration->pdf_path);
    }

    public function test_sponsor_contract_template_can_be_filled_without_leaving_placeholders(): void
    {
        $templatePath = public_path('sponsor-contract.docx');

        $this->assertFileExists($templatePath);

        $tempFilePath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'sponsor-contract-test-'.uniqid().'.docx';

        try {
            $template = new TemplateProcessor($templatePath);
            $template->setValue('organization', 'شركة الراعي');
            $template->setValue('full_name', 'اسم المسؤول');
            $template->setValue('sponsor_tier', 'الذهبي');
            $template->setValue('cr_copy', 'مرفق نسخة السجل التجاري');
            $template->saveAs($tempFilePath);

            $zipArchive = new ZipArchive;

            $this->assertTrue($zipArchive->open($tempFilePath) === true);

            $documentXml = $zipArchive->getFromName('word/document.xml');

            $zipArchive->close();

            $this->assertIsString($documentXml);
            $this->assertStringContainsString('شركة الراعي', $documentXml);
            $this->assertStringContainsString('اسم المسؤول', $documentXml);
            $this->assertStringContainsString('الذهبي', $documentXml);
            $this->assertStringContainsString('مرفق نسخة السجل التجاري', $documentXml);
            $this->assertSame(0, preg_match_all('/\$\{[^}]+\}/', $documentXml));
        } finally {
            if (is_file($tempFilePath)) {
                @unlink($tempFilePath);
            }
        }
    }
}
