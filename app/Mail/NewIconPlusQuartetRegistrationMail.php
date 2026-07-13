<?php

namespace App\Mail;

use App\Models\IconPlusQuartetRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewIconPlusQuartetRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IconPlusQuartetRegistration $registration,
        public ?string $pdfPath = null,
    ) {}

    public function build(): self
    {
        $mail = $this->subject('New Icon Plus Quartet Registration')
            ->view('emails.new_icon_plus_quartet_registration');

        if ($this->pdfPath) {
            $mail->attach(storage_path('app/public/'.$this->pdfPath));
        }

        return $mail;
    }
}
