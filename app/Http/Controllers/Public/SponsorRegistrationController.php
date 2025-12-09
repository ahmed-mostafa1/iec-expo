<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\SponsorRegistrationRequest;
use App\Mail\NewSponsorRegistrationMail;
use App\Models\SponsorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SponsorRegistrationController extends Controller
{
    public function __construct(
        protected RegistrationPdfService $pdfService
    ) {}

    public function store(SponsorRegistrationRequest $request, string $locale)
    {
        $data = $request->validated();

        // Handle optional document upload
        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store(
                'sponsors_docs/' . now()->year,
                'public'
            );
        }

        $registration = SponsorRegistration::create([
            'full_name'        => $data['full_name'],
            'email'            => $data['email'],
            'phone'            => $data['phone'],
            'job_title'        => $data['job_title'],
            'organization'     => $data['organization'],
            'vat_number'       => $data['vat_number'],
            'cr_number'        => $data['cr_number'],
            'national_address' => $data['national_address'],
            'document_path'    => $documentPath,
            'status'           => 'pending',
        ]);

        // Generate and save PDF
        $pdfPath = $this->pdfService->generateSponsorPdf($registration);
        $registration->update(['pdf_path' => $pdfPath]);

        // Send email to admin(s)
        foreach (config('admin.emails', []) as $adminEmail) {
            Mail::to($adminEmail)->send(
                new NewSponsorRegistrationMail($registration, $pdfPath)
            );
        }

        return back()->with('success', __('registration.sponsor.success'));
    }
}
