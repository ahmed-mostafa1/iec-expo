<?php

namespace App\Jobs;

use App\Mail\NewSponsorRegistrationMail;
use App\Mail\SponsorTicketMail;
use App\Models\SponsorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ProcessSponsorRegistrationSubmission implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public int $timeout = 180;

    public function __construct(
        public SponsorRegistration $registration,
    ) {}

    public function handle(RegistrationPdfService $pdfService): void
    {
        $registration = $this->registration->fresh();

        if (! $registration) {
            return;
        }

        $pdfPath = null;

        try {
            $pdfPath = $pdfService->generateSponsorPdf($registration);

            $registration->update([
                'pdf_path' => $pdfPath,
                'pdf_status' => 'generated',
                'pdf_error' => null,
                'pdf_generated_at' => now(),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            $registration->update([
                'pdf_path' => null,
                'pdf_status' => 'failed',
                'pdf_error' => $exception->getMessage(),
                'pdf_generated_at' => null,
            ]);
        }

        $registration->refresh();

        foreach (config('admin.registration_emails', []) as $adminEmail) {
            Mail::to($adminEmail)->send(
                new NewSponsorRegistrationMail($registration, $pdfPath)
            );
        }

        if (! $registration->ticket_sent_at) {
            try {
                Mail::to($registration->email)->send(new SponsorTicketMail($registration));
                $registration->update(['ticket_sent_at' => now()]);
            } catch (Throwable $exception) {
                report($exception);
            }
        }
    }
}
