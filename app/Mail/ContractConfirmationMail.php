<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContractConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $hall,
        public string $pdfPath,
    ) {
    }

    public function build(): self
    {
        $subject = "طلب حجز مساحة رقم {$this->hall} في معرض IEC 360° {$this->name}";

        return $this->subject($subject)
            ->view('emails.contract_confirmation')
            ->attach(storage_path('app/public/' . $this->pdfPath));
    }
}
