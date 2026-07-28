<?php

namespace App\Mail;

use App\Models\IconPlusRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IconPlusTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IconPlusRegistration $registration,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Your entry QR code | رمز الدخول الخاص بك')
            ->view('emails.icon_plus_ticket');
    }
}
