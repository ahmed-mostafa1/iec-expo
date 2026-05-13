<?php

namespace Tests\Feature;

use App\Mail\ContractConfirmationMail;
use App\Mail\NewIconRegistrationMail;
use App\Mail\NewSponsorRegistrationMail;
use App\Models\Admin;
use App\Models\IconRegistration;
use App\Models\SponsorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use PHPUnit\Framework\Attributes\DataProvider;
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

    public function test_sponsor_registration_marks_pdf_as_failed_and_notifies_admins_and_customer_without_contract_attachment(): void
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

        Mail::assertSent(
            ContractConfirmationMail::class,
            function (ContractConfirmationMail $mail): bool {
                $this->assertStringContainsString(
                    'PDF contract generation had a problem. Please contact the sales team to receive your contract copy.',
                    $mail->render()
                );

                return $mail->hasTo('sponsor@example.com')
                    && $mail->pdfPath === null
                    && $mail->build()->attachments === [];
            }
        );
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

    public function test_icon_registration_marks_pdf_as_failed_and_notifies_admins_without_customer_contract(): void
    {
        Mail::fake();

        $this->app->instance(RegistrationPdfService::class, new class extends RegistrationPdfService
        {
            public function generateIconPdf(IconRegistration $registration): string
            {
                throw new RuntimeException('CloudConvert conversion timed out before export was ready.');
            }
        });

        $response = $this->post(route('public.register.icon', ['locale' => 'en']), [
            'full_name' => 'Icon User',
            'email' => 'icon@example.com',
            'phone' => '+966512345678',
            'job_title' => 'Lead',
            'organization' => 'Icon Co',
            'location_selection' => 'A01',
            'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
            'cr_copy' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
            'national_address_document' => UploadedFile::fake()->create('address.pdf', 100, 'application/pdf'),
            'company_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
            'privacy_policy' => '1',
        ], ['Accept' => 'application/json']);

        $response->assertCreated()
            ->assertJsonPath('message', __('registration.icon.success_pdf_pending'));

        $registration = IconRegistration::query()->sole();

        $this->assertSame('failed', $registration->pdf_status);
        $this->assertSame('CloudConvert conversion timed out before export was ready.', $registration->pdf_error);
        $this->assertNull($registration->pdf_generated_at);
        $this->assertNull($registration->pdf_path);

        Mail::assertNotSent(ContractConfirmationMail::class);
        Mail::assertSent(NewIconRegistrationMail::class, count($this->adminEmails));

        foreach ($this->adminEmails as $adminEmail) {
            Mail::assertSent(NewIconRegistrationMail::class, fn (NewIconRegistrationMail $mail) => $mail->hasTo($adminEmail) && $mail->pdfPath === null);
        }
    }

    public function test_admin_regenerate_icon_pdf_marks_registration_as_failed_when_generation_fails(): void
    {
        $admin = Admin::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $registration = IconRegistration::query()->create([
            'full_name' => 'Icon User',
            'email' => 'icon@example.com',
            'phone' => '+966512345678',
            'job_title' => 'Lead',
            'organization' => 'Icon Co',
            'location_selection' => 'A01',
            'vat_number' => null,
            'vat_certificate_path' => 'registrations/icons/vat-certificate/2026/vat.pdf',
            'national_address' => '',
            'document_path' => null,
            'cr_copy_path' => 'registrations/icons/cr-copy/2026/cr.pdf',
            'national_address_doc_path' => 'registrations/icons/national-address/2026/address.pdf',
            'company_logo_path' => 'registrations/icons/company-logo/2026/logo.pdf',
            'pdf_path' => null,
            'pdf_status' => 'pending',
            'pdf_error' => null,
            'pdf_generated_at' => null,
            'status' => 'pending',
        ]);

        $this->app->instance(RegistrationPdfService::class, new class extends RegistrationPdfService
        {
            public function generateIconPdf(IconRegistration $registration): string
            {
                throw new RuntimeException('CloudConvert job creation failed.');
            }
        });

        $response = $this->actingAs($admin, 'admin')
            ->from(route('admin.icons.show', $registration))
            ->post(route('admin.icons.regenerate-pdf', $registration));

        $response->assertRedirect(route('admin.icons.show', $registration));
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
            $template->setValue('space', '8×5 متر مربع');
            $template->setValue('price', '200,000 ريال');
            $template->setValue('final_price_vat', '230,000 ريال');
            $template->setValue('final_price', 'مئتان وثلاثون ألف ريالاً سعودياً فقط لا غير');
            $template->saveAs($tempFilePath);

            $zipArchive = new ZipArchive;

            $this->assertTrue($zipArchive->open($tempFilePath) === true);

            $documentXml = $zipArchive->getFromName('word/document.xml');

            $zipArchive->close();

            $this->assertIsString($documentXml);
            $this->assertStringContainsString('شركة الراعي', $documentXml);
            $this->assertStringContainsString('اسم المسؤول', $documentXml);
            $this->assertStringContainsString('الذهبي', $documentXml);
            $this->assertStringContainsString('8×5 متر مربع', $documentXml);
            $this->assertStringContainsString('200,000 ريال', $documentXml);
            $this->assertStringContainsString('230,000 ريال', $documentXml);
            $this->assertStringContainsString('مئتان وثلاثون ألف ريالاً سعودياً فقط لا غير', $documentXml);
            $this->assertSame(0, preg_match_all('/\$\{[^}]+\}/', $documentXml));
        } finally {
            if (is_file($tempFilePath)) {
                @unlink($tempFilePath);
            }
        }
    }

    public function test_sponsor_pdf_generation_falls_back_to_shared_contract_template_when_sponsor_template_is_missing(): void
    {
        $registration = new SponsorRegistration([
            'full_name' => 'Sponsor User',
            'organization' => 'Sponsor Co',
            'sponsor_tier' => 'gold',
            'location_selection' => 'B12',
        ]);
        $registration->id = 7;
        $service = new class extends RegistrationPdfService
        {
            public string $usedTemplatePath = '';

            public array $usedValues = [];

            protected function sponsorTemplatePaths(): array
            {
                return [
                    public_path('missing-sponsor-contract.docx'),
                    public_path('contract-v2.docx'),
                ];
            }

            protected function generateContractPdf(string $templatePath, array $values, string $destinationPath): string
            {
                $this->usedTemplatePath = $templatePath;
                $this->usedValues = $values;

                return $destinationPath;
            }
        };

        $generatedPath = $service->generateSponsorPdf($registration);

        $this->assertSame('registrations/sponsors/7.pdf', $generatedPath);
        $this->assertSame(public_path('contract-v2.docx'), $service->usedTemplatePath);
        $this->assertSame([
            'organization' => 'Sponsor Co',
            'name' => 'Sponsor User',
            'cr_copy' => 'مرفق نسخة السجل التجاري',
            'hall' => 'B12',
        ], $service->usedValues);
    }

    public function test_contract_template_resolution_checks_document_root_for_shared_hosting_public_files(): void
    {
        $documentRoot = storage_path('framework/testing/document-root-'.uniqid());
        $templatePath = $documentRoot.DIRECTORY_SEPARATOR.'hosted-contract.docx';
        $hadDocumentRoot = array_key_exists('DOCUMENT_ROOT', $_SERVER);
        $previousDocumentRoot = $_SERVER['DOCUMENT_ROOT'] ?? null;

        mkdir($documentRoot, 0777, true);
        touch($templatePath);
        $_SERVER['DOCUMENT_ROOT'] = $documentRoot;

        try {
            $service = new class extends RegistrationPdfService
            {
                public function resolveSharedHostingTemplate(string $filename): string
                {
                    return $this->resolveTemplatePath($this->templatePathsFor($filename));
                }
            };

            $this->assertSame($templatePath, $service->resolveSharedHostingTemplate('hosted-contract.docx'));
        } finally {
            if ($hadDocumentRoot) {
                $_SERVER['DOCUMENT_ROOT'] = $previousDocumentRoot;
            } else {
                unset($_SERVER['DOCUMENT_ROOT']);
            }

            if (is_file($templatePath)) {
                @unlink($templatePath);
            }

            if (is_dir($documentRoot)) {
                @rmdir($documentRoot);
            }
        }
    }

    public function test_icon_pdf_generation_uses_shared_contract_template_resolution(): void
    {
        $registration = new IconRegistration([
            'full_name' => 'Icon User',
            'organization' => 'Icon Co',
            'location_selection' => 'A10',
        ]);
        $registration->id = 11;

        $service = new class extends RegistrationPdfService
        {
            public string $usedTemplatePath = '';

            public array $usedValues = [];

            protected function sharedTemplatePaths(): array
            {
                return [
                    public_path('missing-contract-v2.docx'),
                    public_path('contract-v2.docx'),
                ];
            }

            protected function generateContractPdf(string $templatePath, array $values, string $destinationPath): string
            {
                $this->usedTemplatePath = $templatePath;
                $this->usedValues = $values;

                return $destinationPath;
            }
        };

        $generatedPath = $service->generateIconPdf($registration);

        $this->assertSame('registrations/icons/11.pdf', $generatedPath);
        $this->assertSame(public_path('contract-v2.docx'), $service->usedTemplatePath);
        $this->assertSame([
            'organization' => 'Icon Co',
            'name' => 'Icon User',
            'cr_copy' => 'See attached file',
            'hall' => 'A10',
        ], $service->usedValues);
    }

    #[DataProvider('sponsorTierContractValuesProvider')]
    public function test_sponsor_contract_values_include_space_price_and_final_price(string $tier, array $expectedValues): void
    {
        $registration = new SponsorRegistration([
            'full_name' => 'Sponsor User',
            'organization' => 'Sponsor Co',
            'sponsor_tier' => $tier,
        ]);
        $service = new class extends RegistrationPdfService
        {
            public function inspectSponsorContractValues(SponsorRegistration $registration): array
            {
                return $this->sponsorContractValues($registration, public_path('sponsor-contract.docx'));
            }
        };

        $this->assertSame($expectedValues, $service->inspectSponsorContractValues($registration));
    }

    public static function sponsorTierContractValuesProvider(): array
    {
        return [
            'strategic' => [
                'tier' => 'strategic',
                'expectedValues' => [
                    'organization' => 'Sponsor Co',
                    'full_name' => 'Sponsor User',
                    'sponsor_tier' => 'الاستراتيجي',
                    'space' => '8×12 متر مربع',
                    'price' => '900,000 ريال',
                    'final_price_vat' => '1,035,000 ريال',
                    'final_price' => 'مليون وخمسة وثلاثون ألف ريالاً سعودياً فقط لا غير',
                ],
            ],
            'government' => [
                'tier' => 'government',
                'expectedValues' => [
                    'organization' => 'Sponsor Co',
                    'full_name' => 'Sponsor User',
                    'sponsor_tier' => 'الحكومي',
                    'space' => '8×5 متر مربع',
                    'price' => '0 ريال',
                    'final_price_vat' => '0 ريال',
                    'final_price' => 'صفر ريالاً سعودياً فقط لا غير',
                ],
            ],
            'diamond' => [
                'tier' => 'diamond',
                'expectedValues' => [
                    'organization' => 'Sponsor Co',
                    'full_name' => 'Sponsor User',
                    'sponsor_tier' => 'الماسي',
                    'space' => '8×8 متر مربع',
                    'price' => '450,000 ريال',
                    'final_price_vat' => '517,500 ريال',
                    'final_price' => 'خمسمئة وسبعة عشر ألف وخمسمئة ريالاً سعودياً فقط لا غير',
                ],
            ],
            'gold' => [
                'tier' => 'gold',
                'expectedValues' => [
                    'organization' => 'Sponsor Co',
                    'full_name' => 'Sponsor User',
                    'sponsor_tier' => 'الذهبي',
                    'space' => '8×5 متر مربع',
                    'price' => '200,000 ريال',
                    'final_price_vat' => '230,000 ريال',
                    'final_price' => 'مئتان وثلاثون ألف ريالاً سعودياً فقط لا غير',
                ],
            ],
            'media' => [
                'tier' => 'media',
                'expectedValues' => [
                    'organization' => 'Sponsor Co',
                    'full_name' => 'Sponsor User',
                    'sponsor_tier' => 'الإعلامي',
                    'space' => '-',
                    'price' => '0 ريال',
                    'final_price_vat' => '0 ريال',
                    'final_price' => 'صفر ريالاً سعودياً فقط لا غير',
                ],
            ],
            'safety-security' => [
                'tier' => 'safety-security',
                'expectedValues' => [
                    'organization' => 'Sponsor Co',
                    'full_name' => 'Sponsor User',
                    'sponsor_tier' => 'السلامة والأمن',
                    'space' => '0 متر مربع',
                    'price' => '200,000 ريال',
                    'final_price_vat' => '230,000 ريال',
                    'final_price' => 'مئتان وثلاثون ألف ريالاً سعودياً فقط لا غير',
                ],
            ],
            'marketing' => [
                'tier' => 'marketing',
                'expectedValues' => [
                    'organization' => 'Sponsor Co',
                    'full_name' => 'Sponsor User',
                    'sponsor_tier' => 'التسويقي',
                    'space' => '0 متر مربع',
                    'price' => '200,000 ريال',
                    'final_price_vat' => '230,000 ريال',
                    'final_price' => 'مئتان وثلاثون ألف ريالاً سعودياً فقط لا غير',
                ],
            ],
            'technology' => [
                'tier' => 'technology',
                'expectedValues' => [
                    'organization' => 'Sponsor Co',
                    'full_name' => 'Sponsor User',
                    'sponsor_tier' => 'التقني',
                    'space' => '0 متر مربع',
                    'price' => '200,000 ريال',
                    'final_price_vat' => '230,000 ريال',
                    'final_price' => 'مئتان وثلاثون ألف ريالاً سعودياً فقط لا غير',
                ],
            ],
            'other' => [
                'tier' => 'other',
                'expectedValues' => [
                    'organization' => 'Sponsor Co',
                    'full_name' => 'Sponsor User',
                    'sponsor_tier' => 'أخرى',
                    'space' => '0 متر مربع',
                    'price' => '200,000 ريال',
                    'final_price_vat' => '230,000 ريال',
                    'final_price' => 'مئتان وثلاثون ألف ريالاً سعودياً فقط لا غير',
                ],
            ],
        ];
    }
}
