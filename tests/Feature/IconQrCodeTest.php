<?php

namespace Tests\Feature;

use App\Jobs\ProcessIconRegistrationSubmission;
use App\Mail\IconTicketMail;
use App\Models\IconRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Zxing\QrReader;

class IconQrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_qr_code_opens_a_badge_page_with_the_submitted_data(): void
    {
        $registration = IconRegistration::create([
            'full_name' => 'زائر ICON تجريبي',
            'email' => 'icon@example.com',
            'phone' => '0555555555',
            'job_title' => 'مدير',
            'organization' => 'Icon Co',
            'location_selection' => 'A1',
        ]);

        $decodedUrl = (new QrReader($registration->qrPng(), QrReader::SOURCE_TYPE_BLOB))->text();

        $response = $this->get($decodedUrl);

        $response->assertOk();
        $response->assertSee('زائر ICON تجريبي', false);
        $response->assertSee('Icon Co', false);
        $response->assertSee('ICON', false);
    }

    public function test_ticket_mail_is_sent_once_regardless_of_pdf_outcome(): void
    {
        Mail::fake();

        $registration = IconRegistration::create([
            'full_name' => 'Icon User',
            'email' => 'icon@example.com',
            'phone' => '0555555555',
            'job_title' => 'Manager',
            'organization' => 'Icon Co',
            'location_selection' => 'A1',
        ]);

        $job = new ProcessIconRegistrationSubmission($registration);
        $job->handle(app(RegistrationPdfService::class));
        $job->handle(app(RegistrationPdfService::class));

        Mail::assertSent(
            IconTicketMail::class,
            fn (IconTicketMail $mail) => $mail->hasTo($registration->email)
        );
        Mail::assertSentTimes(IconTicketMail::class, 1);
    }
}
