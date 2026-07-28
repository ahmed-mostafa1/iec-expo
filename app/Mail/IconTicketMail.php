<?php

namespace App\Mail;

use App\Models\IconRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IconTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IconRegistration $registration,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Your entry QR code | رمز الدخول الخاص بك')
            ->view('emails.icon_ticket');
    }
}
