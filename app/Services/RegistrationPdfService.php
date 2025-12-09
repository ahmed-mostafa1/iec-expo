<?php

namespace App\Services;

use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class RegistrationPdfService
{
    public function generateSponsorPdf(SponsorRegistration $registration): string
    {
        $pdf = Pdf::loadView('pdf.sponsor_registration', [
            'registration' => $registration,
        ]);

        $path = "registrations/sponsors/{$registration->id}.pdf";

        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    public function generateVisitorPdf(VisitorRegistration $registration): string
    {
        $pdf = Pdf::loadView('pdf.visitor_registration', [
            'registration' => $registration,
        ]);

        $path = "registrations/visitors/{$registration->id}.pdf";

        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }
}