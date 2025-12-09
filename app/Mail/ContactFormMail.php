<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public ?string $phone,
        public string $messageBody,
    ) {}

    public function build(): self
    {
        return $this->subject('Contact Form Submission')
            ->view('emails.contact_form');
    }
}