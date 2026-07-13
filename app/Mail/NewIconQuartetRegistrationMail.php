<?php

namespace App\Mail;

use App\Models\IconQuartetRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewIconQuartetRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IconQuartetRegistration $registration,
        public ?string $pdfPath = null,
    ) {}

    public function build(): self
    {
        $mail = $this->subject('New Icon Quartet Registration')
            ->view('emails.new_icon_quartet_registration');

        if ($this->pdfPath) {
            $mail->attach(storage_path('app/public/'.$this->pdfPath));
        }

        return $mail;
    }
}
