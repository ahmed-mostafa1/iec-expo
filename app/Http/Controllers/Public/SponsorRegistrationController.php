<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\SponsorRegistrationRequest;
use App\Mail\NewSponsorRegistrationMail;
use App\Models\SponsorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Support\Facades\Mail;

class SponsorRegistrationController extends Controller
{
    public function __construct(
        protected RegistrationPdfService $pdfService
    ) {}

    public function store(SponsorRegistrationRequest $request, string $locale)
    {
        $data = $request->validated();

        $corporateProfilePath = $request->file('corporate_profile')->store(
            'registrations/sponsors/corporate-profile/' . now()->year,
            'public'
        );

        $crCopyPath = $request->file('cr_copy')->store(
            'registrations/sponsors/cr-copy/' . now()->year,
            'public'
        );

        $nationalAddressDocPath = $request->file('national_address_document')->store(
            'registrations/sponsors/national-address/' . now()->year,
            'public'
        );

        $companyLogoPath = $request->file('company_logo')->store(
            'registrations/sponsors/company-logo/' . now()->year,
            'public'
        );

        $registration = SponsorRegistration::create([
            'full_name'        => $data['full_name'],
            'email'            => $data['email'],
            'phone'            => $data['phone'],
            'job_title'        => $data['job_title'],
            'organization'     => $data['organization'],
            'vat_number'       => $data['vat_number'],
            'cr_number'        => $data['cr_number'],
            'national_address' => $data['national_address'],
            'document_path'    => $corporateProfilePath,
            'cr_copy_path'     => $crCopyPath,
            'national_address_doc_path' => $nationalAddressDocPath,
            'company_logo_path'=> $companyLogoPath,
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

        $message = __('registration.sponsor.success');
        $toastTitle = __('registration.sponsor.toast_title');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'toast_title' => $toastTitle,
                'registration_id' => $registration->id,
            ], 201);
        }

        return back()->with('sponsor_success', $message);
    }
}
