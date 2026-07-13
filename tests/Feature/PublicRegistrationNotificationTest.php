<?php

namespace Tests\Feature;

use App\Mail\ContractConfirmationMail;
use App\Mail\NewIconRegistrationMail;
use App\Mail\NewSponsorRegistrationMail;
use App\Mail\NewVisitorRegistrationMail;
use App\Models\IconRegistration;
use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicRegistrationNotificationTest extends TestCase
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

        $this->app->instance(RegistrationPdfService::class, new class extends RegistrationPdfService
        {
            public function generateSponsorPdf(SponsorRegistration $registration): string
            {
                return "registrations/sponsors/{$registration->id}.pdf";
            }

            public function generateVisitorPdf(VisitorRegistration $registration): string
            {
                return "registrations/visitors/{$registration->id}.pdf";
            }

            public function generateIconPdf(IconRegistration $registration): string
            {
                return "registrations/icons/{$registration->id}.pdf";
            }
        });
    }

    public function test_visitor_registration_notifies_all_admin_recipients(): void
    {
        Mail::fake();

        $response = $this->post(
            route('public.register.visitor', ['locale' => 'en']),
            [
                'form_identifier' => 'visitor',
                'full_name' => 'Visitor User',
                'email' => 'visitor@example.com',
                'phone' => '0555555555',
                'job_title' => 'Manager',
                'company_name' => 'Visitor Co',
                'heard_about' => 'social_media',
                'privacy_policy' => '1',
            ],
            ['Accept' => 'application/json']
        );

        $response->assertCreated();

        Mail::assertSent(NewVisitorRegistrationMail::class, count($this->adminEmails));
        Mail::assertNotSent(ContractConfirmationMail::class);

        foreach ($this->adminEmails as $adminEmail) {
            Mail::assertSent(NewVisitorRegistrationMail::class, fn (NewVisitorRegistrationMail $mail) => $mail->hasTo($adminEmail));
        }
    }

    public function test_sponsor_registration_notifies_all_admin_recipients_and_confirms_customer(): void
    {
        Mail::fake();

        $response = $this->post(
            route('public.register.sponsor', ['locale' => 'en']),
            [
                'full_name' => 'Sponsor User',
                'email' => 'sponsor@example.com',
                'phone' => '+966512345678',
                'job_title' => 'Director',
                'organization' => 'Sponsor Co',
                'sponsor_tier' => 'gold',
                'location_selection' => 'B12',
                'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
                'cr_copy_file' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
                'cr_copy' => '1234567890',
                'national_address_document' => UploadedFile::fake()->create('address.pdf', 100, 'application/pdf'),
                'company_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
                'privacy_policy' => '1',
            ],
            ['Accept' => 'application/json']
        );

        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'toast_title',
                'registration_id',
                'pdf_url',
                'pdf_name',
            ])
            ->assertJsonPath('message', __('registration.sponsor.success_pdf_pending'))
            ->assertJsonPath('pdf_url', null)
            ->assertJsonPath('pdf_name', null);

        $registration = SponsorRegistration::query()->sole();

        $this->assertSame('generated', $registration->pdf_status);
        $this->assertNull($registration->pdf_error);
        $this->assertNotNull($registration->pdf_generated_at);
        $this->assertSame('registrations/sponsors/1.pdf', $registration->pdf_path);

        Mail::assertNotSent(ContractConfirmationMail::class);
        Mail::assertSent(NewSponsorRegistrationMail::class, count($this->adminEmails) + 1);

        foreach ($this->adminEmails as $adminEmail) {
            Mail::assertSent(NewSponsorRegistrationMail::class, fn (NewSponsorRegistrationMail $mail) => $mail->hasTo($adminEmail));
        }

        Mail::assertSent(NewSponsorRegistrationMail::class, fn (NewSponsorRegistrationMail $mail) => $mail->hasTo('eidddsheba@gmail.com'));
    }

    public function test_icon_registration_notifies_all_admin_recipients_and_confirms_customer(): void
    {
        Mail::fake();

        $response = $this->post(
            route('public.register.icon', ['locale' => 'en']),
            [
                'full_name' => 'Icon User',
                'email' => 'icon@example.com',
                'phone' => '966512345678',
                'job_title' => 'Lead',
                'organization' => 'Icon Co',
                'location_selection' => 'L.W.50',
                'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
                'cr_copy_file' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
                'cr_copy' => '1234567890',
                'national_address_document' => UploadedFile::fake()->create('address.pdf', 100, 'application/pdf'),
                'company_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
                'privacy_policy' => '1',
            ],
            ['Accept' => 'application/json']
        );

        $response->assertCreated()
            ->assertJsonPath('message', __('registration.icon.success_pdf_pending'));

        $registration = IconRegistration::query()->sole();

        $this->assertSame('generated', $registration->pdf_status);
        $this->assertNull($registration->pdf_error);
        $this->assertNotNull($registration->pdf_generated_at);
        $this->assertSame('registrations/icons/1.pdf', $registration->pdf_path);

        Mail::assertNotSent(ContractConfirmationMail::class);
        Mail::assertSent(NewIconRegistrationMail::class, count($this->adminEmails) + 1);

        foreach ($this->adminEmails as $adminEmail) {
            Mail::assertSent(NewIconRegistrationMail::class, fn (NewIconRegistrationMail $mail) => $mail->hasTo($adminEmail));
        }

        Mail::assertSent(NewIconRegistrationMail::class, fn (NewIconRegistrationMail $mail) => $mail->hasTo('eidddsheba@gmail.com'));

        // Admin email shows the commercial record number, not the old VAT line.
        Mail::assertSent(NewIconRegistrationMail::class, function (NewIconRegistrationMail $mail) {
            $body = $mail->render();

            return str_contains($body, 'Commercial record:')
                && str_contains($body, '1234567890')
                && ! str_contains($body, '<strong>VAT:</strong>');
        });
    }

    public function test_icon_registration_still_succeeds_when_pdf_lifecycle_columns_are_missing(): void
    {
        Mail::fake();

        Schema::table('icon_registrations', function ($table) {
            $table->dropColumn([
                'pdf_status',
                'pdf_error',
                'pdf_generated_at',
            ]);
        });

        $response = $this->post(
            route('public.register.icon', ['locale' => 'en']),
            [
                'full_name' => 'Icon User',
                'email' => 'icon@example.com',
                'phone' => '966512345678',
                'job_title' => 'Lead',
                'organization' => 'Icon Co',
                'location_selection' => 'L.W.50',
                'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
                'cr_copy_file' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
                'cr_copy' => '1234567890',
                'national_address_document' => UploadedFile::fake()->create('address.pdf', 100, 'application/pdf'),
                'company_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
                'privacy_policy' => '1',
            ],
            ['Accept' => 'application/json']
        );

        $response->assertCreated()
            ->assertJsonPath('message', __('registration.icon.success_pdf_pending'));

        $this->assertDatabaseHas('icon_registrations', [
            'email' => 'icon@example.com',
            'pdf_path' => 'registrations/icons/1.pdf',
        ]);

        Mail::assertNotSent(ContractConfirmationMail::class);
        Mail::assertSent(NewIconRegistrationMail::class, count($this->adminEmails) + 1);

        foreach ($this->adminEmails as $adminEmail) {
            Mail::assertSent(NewIconRegistrationMail::class, fn (NewIconRegistrationMail $mail) => $mail->hasTo($adminEmail));
        }

        Mail::assertSent(NewIconRegistrationMail::class, fn (NewIconRegistrationMail $mail) => $mail->hasTo('eidddsheba@gmail.com'));
    }

    public function test_registration_forms_reject_invalid_saudi_phone_format(): void
    {
        $visitorResponse = $this->postJson(
            route('public.register.visitor', ['locale' => 'en']),
            [
                'form_identifier' => 'visitor',
                'full_name' => 'Visitor User',
                'email' => 'visitor@example.com',
                'phone' => '0123456789',
                'privacy_policy' => '1',
            ]
        );

        $visitorResponse
            ->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
        $this->assertSame(
            'يرجى إدخال رقم سعودي صحيح',
            $visitorResponse->json('errors.phone.0')
        );

        $sponsorResponse = $this->postJson(
            route('public.register.sponsor', ['locale' => 'en']),
            [
                'full_name' => 'Sponsor User',
                'email' => 'sponsor@example.com',
                'phone' => '512345678',
                'job_title' => 'Director',
                'organization' => 'Sponsor Co',
                'sponsor_tier' => 'gold',
                'location_selection' => 'B12',
                'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
                'cr_copy_file' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
                'cr_copy' => '1234567890',
                'national_address_document' => UploadedFile::fake()->create('address.pdf', 100, 'application/pdf'),
                'company_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
                'privacy_policy' => '1',
            ]
        );

        $sponsorResponse
            ->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
        $this->assertSame(
            'يرجى إدخال رقم سعودي صحيح',
            $sponsorResponse->json('errors.phone.0')
        );

        $iconResponse = $this->postJson(
            route('public.register.icon', ['locale' => 'en']),
            [
                'full_name' => 'Icon User',
                'email' => 'icon@example.com',
                'phone' => '+966612345678',
                'job_title' => 'Lead',
                'organization' => 'Icon Co',
                'location_selection' => 'L.W.50',
                'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
                'cr_copy_file' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
                'cr_copy' => '1234567890',
                'national_address_document' => UploadedFile::fake()->create('address.pdf', 100, 'application/pdf'),
                'company_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
                'privacy_policy' => '1',
            ]
        );

        $iconResponse
            ->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
        $this->assertSame(
            'يرجى إدخال رقم سعودي صحيح',
            $iconResponse->json('errors.phone.0')
        );
    }
}
