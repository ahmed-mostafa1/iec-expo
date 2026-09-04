<?php

namespace App\Mail;

use App\Models\VisitorRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitorTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public VisitorRegistration $registration,
        public ?string $badgeCardPng = null,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Your entry QR code | رمز الدخول الخاص بك')
            ->view('emails.visitor_ticket');
    }
}
