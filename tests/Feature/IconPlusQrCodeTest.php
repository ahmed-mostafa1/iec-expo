<?php

namespace Tests\Feature;

use App\Jobs\ProcessIconPlusRegistrationSubmission;
use App\Mail\IconPlusTicketMail;
use App\Models\IconPlusRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Zxing\QrReader;

class IconPlusQrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_qr_code_opens_a_badge_page_with_the_submitted_data(): void
    {
        $registration = IconPlusRegistration::create([
            'full_name' => 'زائر ICON Plus تجريبي',
            'email' => 'iconplus@example.com',
            'phone' => '0555555555',
            'job_title' => 'مدير',
            'organization' => 'Icon Plus Co',
            'location_selection' => 'B1',
        ]);

        $decodedUrl = (new QrReader($registration->qrPng(), QrReader::SOURCE_TYPE_BLOB))->text();

        $response = $this->get($decodedUrl);

        $response->assertOk();
        $response->assertSee('زائر ICON Plus تجريبي', false);
        $response->assertSee('Icon Plus Co', false);
        $response->assertSee('ICON', false);
    }

    public function test_ticket_mail_is_sent_once_regardless_of_pdf_outcome(): void
    {
        Mail::fake();

        $registration = IconPlusRegistration::create([
            'full_name' => 'Icon Plus User',
            'email' => 'iconplus@example.com',
            'phone' => '0555555555',
            'job_title' => 'Manager',
            'organization' => 'Icon Plus Co',
            'location_selection' => 'B1',
        ]);

        $job = new ProcessIconPlusRegistrationSubmission($registration);
        $job->handle(app(RegistrationPdfService::class));
        $job->handle(app(RegistrationPdfService::class));

        Mail::assertSent(
            IconPlusTicketMail::class,
            fn (IconPlusTicketMail $mail) => $mail->hasTo($registration->email)
        );
        Mail::assertSentTimes(IconPlusTicketMail::class, 1);
    }
}
