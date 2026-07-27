<?php

namespace Tests\Feature;

use App\Mail\VisitorTicketMail;
use App\Models\VisitorRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Zxing\QrReader;

class VisitorQrCodeTest extends TestCase
{
    use RefreshDatabase;

    private array $validPayload = [
        'form_identifier' => 'visitor',
        'full_name' => 'Visitor User',
        'email' => 'visitor@example.com',
        'phone' => '0555555555',
        'job_title' => 'Manager',
        'company_name' => 'Visitor Co',
        'heard_about' => 'social_media',
        'privacy_policy' => '1',
    ];

    public function test_every_visitor_field_is_required(): void
    {
        $response = $this->postJson(
            route('public.register.visitor', ['locale' => 'en']),
            ['form_identifier' => 'visitor']
        );

        $response->assertStatus(422)->assertJsonValidationErrors([
            'full_name',
            'email',
            'phone',
            'job_title',
            'company_name',
            'heard_about',
            'privacy_policy',
        ]);
    }

    public function test_other_source_is_required_only_when_heard_about_is_other(): void
    {
        $this->postJson(
            route('public.register.visitor', ['locale' => 'en']),
            ['heard_about' => 'other'] + $this->validPayload
        )->assertStatus(422)->assertJsonValidationErrors('heard_about_other_text');

        $this->postJson(
            route('public.register.visitor', ['locale' => 'en']),
            $this->validPayload
        )->assertCreated();
    }

    public function test_visitor_receives_a_ticket_mail_at_their_own_address(): void
    {
        Mail::fake();

        $this->postJson(
            route('public.register.visitor', ['locale' => 'en']),
            $this->validPayload
        )->assertCreated();

        Mail::assertSent(
            VisitorTicketMail::class,
            fn (VisitorTicketMail $mail) => $mail->hasTo($this->validPayload['email'])
        );
    }

    public function test_generated_qr_code_scans_back_to_the_submitted_data(): void
    {
        $registration = VisitorRegistration::create([
            'full_name' => 'زائر تجريبي',
            'email' => 'visitor@example.com',
            'phone' => '0555555555',
            'job_title' => 'مدير',
            'company_name' => 'Visitor Co',
            'heard_about' => 'other',
            'heard_about_other_text' => 'Conference website',
        ]);

        $decoded = json_decode((new QrReader($registration->qrPng(), QrReader::SOURCE_TYPE_BLOB))->text(), true);

        $this->assertSame($registration->qrPayload(), $decoded);
        $this->assertSame('زائر تجريبي', $decoded['full_name']);
        $this->assertSame('Conference website', $decoded['heard_about_other_text']);
    }
}
