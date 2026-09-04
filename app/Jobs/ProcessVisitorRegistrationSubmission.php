<?php

namespace App\Jobs;

use App\Mail\NewVisitorRegistrationMail;
use App\Mail\VisitorTicketMail;
use App\Models\VisitorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ProcessVisitorRegistrationSubmission implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public int $timeout = 180;

    public function __construct(
        public VisitorRegistration $registration,
    ) {}

    public function handle(RegistrationPdfService $pdfService): void
    {
        $registration = $this->registration->fresh();

        if (! $registration) {
            return;
        }

        $pdfPath = null;

        try {
            $pdfPath = $pdfService->generateVisitorPdf($registration);
            $registration->update(['pdf_path' => $pdfPath]);
        } catch (Throwable $exception) {
            report($exception);
        }

        foreach (config('admin.registration_emails', []) as $adminEmail) {
            Mail::to($adminEmail)->send(
                new NewVisitorRegistrationMail($registration, $pdfPath)
            );
        }

        $badgeCardPng = null;

        try {
            $badgeCardPng = $pdfService->generateVisitorBadgeCardPng($registration);
        } catch (Throwable $exception) {
            report($exception);
        }

        Mail::to($registration->email)->send(
            new VisitorTicketMail($registration, $badgeCardPng)
        );
    }
}
