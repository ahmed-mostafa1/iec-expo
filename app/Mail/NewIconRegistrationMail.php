<?php

namespace App\Mail;

use App\Models\IconRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewIconRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IconRegistration $registration,
        public ?string $pdfPath = null,
    ) {}

    public function build(): self
    {
        $mail = $this->subject('New Icon Registration')
            ->view('emails.new_icon_registration');

        if ($this->pdfPath) {
            $mail->attach(storage_path('app/public/' . $this->pdfPath));
        }

        return $mail;
    }
}
