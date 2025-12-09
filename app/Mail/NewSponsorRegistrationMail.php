<?php

namespace App\Mail;

use App\Models\SponsorRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSponsorRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SponsorRegistration $registration,
        public ?string $pdfPath = null,
    ) {}

    public function build(): self
    {
        $mail = $this->subject('New Sponsor Registration')
            ->view('emails.new_sponsor_registration');

        if ($this->pdfPath) {
            $mail->attach(storage_path('app/public/' . $this->pdfPath));
        }

        return $mail;
    }
}
