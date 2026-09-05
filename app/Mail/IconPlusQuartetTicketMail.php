<?php

namespace App\Mail;

use App\Models\IconPlusQuartetRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IconPlusQuartetTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IconPlusQuartetRegistration $registration,
        public ?string $badgeCardPng = null,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Your entry QR code | رمز الدخول الخاص بك')
            ->view('emails.icon_plus_quartet_ticket');
    }
}
