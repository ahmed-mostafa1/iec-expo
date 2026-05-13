<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\IconRegistrationRequest;
use App\Jobs\ProcessIconRegistrationSubmission;
use App\Models\IconRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class IconRegistrationController extends Controller
{
    public function store(IconRegistrationRequest $request, string $locale): JsonResponse|RedirectResponse
    {
        $data = $request->validated();

        $crCopyPath = $request->hasFile('cr_copy')
            ? $request->file('cr_copy')->store(
                'registrations/icons/cr-copy/'.now()->year,
                'public'
            )
            : null;

        $nationalAddressDocPath = $request->hasFile('national_address_document')
            ? $request->file('national_address_document')->store(
                'registrations/icons/national-address/'.now()->year,
                'public'
            )
            : null;

        $companyLogoPath = $request->hasFile('company_logo')
            ? $request->file('company_logo')->store(
                'registrations/icons/company-logo/'.now()->year,
                'public'
            )
            : null;

        $vatCertificatePath = $request->hasFile('vat_number')
            ? $request->file('vat_number')->store(
                'registrations/icons/vat-certificate/'.now()->year,
                'public'
            )
            : null;

        $registration = IconRegistration::create(
            IconRegistration::filterPersistableAttributes([
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'job_title' => $data['job_title'],
                'organization' => $data['organization'] ?? '',
                'location_selection' => $data['location_selection'],
                'vat_number' => null,
                'vat_certificate_path' => $vatCertificatePath,
                'national_address' => $data['national_address'] ?? '',
                'document_path' => null,
                'cr_copy_path' => $crCopyPath,
                'national_address_doc_path' => $nationalAddressDocPath,
                'company_logo_path' => $companyLogoPath,
                'pdf_status' => 'pending',
                'pdf_error' => null,
                'pdf_generated_at' => null,
                'status' => 'pending',
            ])
        );

        ProcessIconRegistrationSubmission::dispatchAfterResponse($registration);

        $message = __('registration.icon.success_pdf_pending');
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

    public function download(string $locale, IconRegistration $registration): BinaryFileResponse
    {
        if (! $registration->pdf_path) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($registration->pdf_path);

        if (! file_exists($fullPath)) {
            abort(404);
        }

        return response()->download($fullPath, "icon-registration-{$registration->id}.pdf");
    }
}
