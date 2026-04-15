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
                'cr_copy' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
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
            ->assertJsonPath('pdf_name', 'sponsor-registration-1.pdf');

        Mail::assertSent(ContractConfirmationMail::class, fn (ContractConfirmationMail $mail) => $mail->hasTo('sponsor@example.com'));
        Mail::assertSent(NewSponsorRegistrationMail::class, count($this->adminEmails));

        foreach ($this->adminEmails as $adminEmail) {
            Mail::assertSent(NewSponsorRegistrationMail::class, fn (NewSponsorRegistrationMail $mail) => $mail->hasTo($adminEmail));
        }
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
                'location_selection' => 'A01',
                'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
                'cr_copy' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
                'national_address_document' => UploadedFile::fake()->create('address.pdf', 100, 'application/pdf'),
                'company_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
                'privacy_policy' => '1',
            ],
            ['Accept' => 'application/json']
        );

        $response->assertCreated();

        Mail::assertSent(ContractConfirmationMail::class, fn (ContractConfirmationMail $mail) => $mail->hasTo('icon@example.com'));
        Mail::assertSent(NewIconRegistrationMail::class, count($this->adminEmails));

        foreach ($this->adminEmails as $adminEmail) {
            Mail::assertSent(NewIconRegistrationMail::class, fn (NewIconRegistrationMail $mail) => $mail->hasTo($adminEmail));
        }
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
                'cr_copy' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
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
                'location_selection' => 'A01',
                'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
                'cr_copy' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
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
