<?php

namespace App\Mail;

use App\Models\SponsorRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SponsorTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SponsorRegistration $registration,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Your entry QR code | رمز الدخول الخاص بك')
            ->view('emails.sponsor_ticket');
    }
}
