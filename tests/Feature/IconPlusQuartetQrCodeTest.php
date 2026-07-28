<?php

namespace Tests\Feature;

use App\Jobs\ProcessIconPlusQuartetRegistrationSubmission;
use App\Mail\IconPlusQuartetTicketMail;
use App\Models\IconPlusQuartetRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Zxing\QrReader;

class IconPlusQuartetQrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_qr_code_opens_a_badge_page_with_the_submitted_data(): void
    {
        $registration = IconPlusQuartetRegistration::create([
            'full_name' => 'زائر ICON Plus Quartet تجريبي',
            'email' => 'iconplusquartet@example.com',
            'phone' => '0555555555',
            'job_title' => 'مدير',
            'organization' => 'Icon Plus Quartet Co',
            'location_selection' => 'D1',
        ]);

        $decodedUrl = (new QrReader($registration->qrPng(), QrReader::SOURCE_TYPE_BLOB))->text();

        $response = $this->get($decodedUrl);

        $response->assertOk();
        $response->assertSee('زائر ICON Plus Quartet تجريبي', false);
        $response->assertSee('Icon Plus Quartet Co', false);
        $response->assertSee('ICON', false);
    }

    public function test_ticket_mail_is_sent_once_regardless_of_pdf_outcome(): void
    {
        Mail::fake();

        $registration = IconPlusQuartetRegistration::create([
            'full_name' => 'Icon Plus Quartet User',
            'email' => 'iconplusquartet@example.com',
            'phone' => '0555555555',
            'job_title' => 'Manager',
            'organization' => 'Icon Plus Quartet Co',
            'location_selection' => 'D1',
        ]);

        $job = new ProcessIconPlusQuartetRegistrationSubmission($registration);
        $job->handle(app(RegistrationPdfService::class));
        $job->handle(app(RegistrationPdfService::class));

        Mail::assertSent(
            IconPlusQuartetTicketMail::class,
            fn (IconPlusQuartetTicketMail $mail) => $mail->hasTo($registration->email)
        );
        Mail::assertSentTimes(IconPlusQuartetTicketMail::class, 1);
    }
}
