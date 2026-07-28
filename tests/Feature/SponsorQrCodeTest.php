<?php

namespace Tests\Feature;

use App\Jobs\ProcessSponsorRegistrationSubmission;
use App\Mail\SponsorTicketMail;
use App\Models\SponsorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Zxing\QrReader;

class SponsorQrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_qr_code_opens_a_badge_page_with_the_submitted_data(): void
    {
        $registration = SponsorRegistration::create([
            'full_name' => 'راعي تجريبي',
            'email' => 'sponsor@example.com',
            'phone' => '0555555555',
            'job_title' => 'مدير',
            'organization' => 'Sponsor Co',
            'sponsor_tier' => 'gold',
            'national_address' => 'N/A',
        ]);

        $decodedUrl = (new QrReader($registration->qrPng(), QrReader::SOURCE_TYPE_BLOB))->text();

        $response = $this->get($decodedUrl);

        $response->assertOk();
        $response->assertSee('راعي تجريبي', false);
        $response->assertSee('Sponsor Co', false);
        $response->assertSee('SPONSOR', false);
    }

    public function test_ticket_mail_is_sent_once_regardless_of_pdf_outcome(): void
    {
        Mail::fake();

        $registration = SponsorRegistration::create([
            'full_name' => 'Sponsor User',
            'email' => 'sponsor@example.com',
            'phone' => '0555555555',
            'job_title' => 'Manager',
            'organization' => 'Sponsor Co',
            'sponsor_tier' => 'gold',
            'national_address' => 'N/A',
        ]);

        $job = new ProcessSponsorRegistrationSubmission($registration);
        $job->handle(app(RegistrationPdfService::class));
        $job->handle(app(RegistrationPdfService::class));

        Mail::assertSent(
            SponsorTicketMail::class,
            fn (SponsorTicketMail $mail) => $mail->hasTo($registration->email)
        );
        Mail::assertSentTimes(SponsorTicketMail::class, 1);
    }
}
