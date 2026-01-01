<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\IconRegistrationRequest;
use App\Mail\NewIconRegistrationMail;
use App\Models\IconRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Support\Facades\Mail;

class IconRegistrationController extends Controller
{
    public function __construct(
        protected RegistrationPdfService $pdfService
    ) {}

    public function store(IconRegistrationRequest $request, string $locale)
    {
        $data = $request->validated();

        $crCopyPath = $request->hasFile('cr_copy')
            ? $request->file('cr_copy')->store(
                'registrations/icons/cr-copy/' . now()->year,
                'public'
            )
            : null;

        $nationalAddressDocPath = $request->hasFile('national_address_document')
            ? $request->file('national_address_document')->store(
                'registrations/icons/national-address/' . now()->year,
                'public'
            )
            : null;

        $companyLogoPath = $request->hasFile('company_logo')
            ? $request->file('company_logo')->store(
                'registrations/icons/company-logo/' . now()->year,
                'public'
            )
            : null;

        $registration = IconRegistration::create([
            'full_name'        => $data['full_name'],
            'email'            => $data['email'],
            'phone'            => $data['phone'],
            'job_title'        => $data['job_title'],
            'organization'     => $data['organization'] ?? '',
            'location_selection' => $data['location_selection'],
            'vat_number'       => $data['vat_number'] ?? '',
            'cr_number'        => $data['cr_number'] ?? '',
            'national_address' => $data['national_address'] ?? '',
            'document_path'    => null,
            'cr_copy_path'     => $crCopyPath,
            'national_address_doc_path' => $nationalAddressDocPath,
            'company_logo_path'=> $companyLogoPath,
            'status'           => 'pending',
        ]);

        $pdfPath = $this->pdfService->generateIconPdf($registration);
        $registration->update(['pdf_path' => $pdfPath]);

        foreach (config('admin.emails', []) as $adminEmail) {
            Mail::to($adminEmail)->send(
                new NewIconRegistrationMail($registration, $pdfPath)
            );
        }

        $message = __('registration.icon.success');
        $toastTitle = __('registration.icon.toast_title');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'toast_title' => $toastTitle,
                'registration_id' => $registration->id,
            ], 201);
        }

        return back()->with('icon_success', $message);
    }
}
