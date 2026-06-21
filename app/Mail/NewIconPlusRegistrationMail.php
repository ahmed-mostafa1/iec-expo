<?php

namespace App\Mail;

use App\Models\IconPlusRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewIconPlusRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IconPlusRegistration $registration,
        public ?string $pdfPath = null,
    ) {}

    public function build(): self
    {
        $mail = $this->subject('New Icon Plus Registration')
            ->view('emails.new_icon_plus_registration');

        if ($this->pdfPath) {
            $mail->attach(storage_path('app/public/'.$this->pdfPath));
        }

        return $mail;
    }
}
