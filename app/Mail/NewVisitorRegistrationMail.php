<?php

namespace App\Mail;

use App\Models\VisitorRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewVisitorRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public VisitorRegistration $registration,
        public ?string $pdfPath = null,
    ) {}

    public function build(): self
    {
        $mail = $this->subject('New Visitor Registration')
            ->view('emails.new_visitor_registration');

        if ($this->pdfPath) {
            $mail->attach(storage_path('app/public/' . $this->pdfPath));
        }

        return $mail;
    }
}
