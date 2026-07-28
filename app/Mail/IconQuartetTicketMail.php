<?php

namespace App\Mail;

use App\Models\IconQuartetRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IconQuartetTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IconQuartetRegistration $registration,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Your entry QR code | رمز الدخول الخاص بك')
            ->view('emails.icon_quartet_ticket');
    }
}
