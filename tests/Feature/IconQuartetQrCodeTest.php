<?php

namespace Tests\Feature;

use App\Jobs\ProcessIconQuartetRegistrationSubmission;
use App\Mail\IconQuartetTicketMail;
use App\Models\IconQuartetRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Zxing\QrReader;

class IconQuartetQrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_qr_code_opens_a_badge_page_with_the_submitted_data(): void
    {
        $registration = IconQuartetRegistration::create([
            'full_name' => 'زائر ICON Quartet تجريبي',
            'email' => 'iconquartet@example.com',
            'phone' => '0555555555',
            'job_title' => 'مدير',
            'organization' => 'Icon Quartet Co',
            'location_selection' => 'C1',
        ]);

        $decodedUrl = (new QrReader($registration->qrPng(), QrReader::SOURCE_TYPE_BLOB))->text();

        $response = $this->get($decodedUrl);

        $response->assertOk();
        $response->assertSee('زائر ICON Quartet تجريبي', false);
        $response->assertSee('Icon Quartet Co', false);
        $response->assertSee('ICON', false);
    }

    public function test_ticket_mail_is_sent_once_regardless_of_pdf_outcome(): void
    {
        Mail::fake();

        $registration = IconQuartetRegistration::create([
            'full_name' => 'Icon Quartet User',
            'email' => 'iconquartet@example.com',
            'phone' => '0555555555',
            'job_title' => 'Manager',
            'organization' => 'Icon Quartet Co',
            'location_selection' => 'C1',
        ]);

        $job = new ProcessIconQuartetRegistrationSubmission($registration);
        $job->handle(app(RegistrationPdfService::class));
        $job->handle(app(RegistrationPdfService::class));

        Mail::assertSent(
            IconQuartetTicketMail::class,
            fn (IconQuartetTicketMail $mail) => $mail->hasTo($registration->email)
        );
        Mail::assertSentTimes(IconQuartetTicketMail::class, 1);
    }
}
