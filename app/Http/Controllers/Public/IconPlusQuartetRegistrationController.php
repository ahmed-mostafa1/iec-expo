<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\IconPlusQuartetRegistrationRequest;
use App\Jobs\ProcessIconPlusQuartetRegistrationSubmission;
use App\Models\IconPlusQuartetRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class IconPlusQuartetRegistrationController extends Controller
{
    public function store(IconPlusQuartetRegistrationRequest $request, string $locale): JsonResponse|RedirectResponse
    {
        $data = $request->validated();

        $crCopyPath = $request->hasFile('cr_copy_file')
            ? $request->file('cr_copy_file')->store(
                'registrations/icon-plus-quartet/cr-copy/'.now()->year,
                'public'
            )
            : null;

        $nationalAddressDocPath = $request->hasFile('national_address_document')
            ? $request->file('national_address_document')->store(
                'registrations/icon-plus-quartet/national-address/'.now()->year,
                'public'
            )
            : null;

        $companyLogoPath = $request->hasFile('company_logo')
            ? $request->file('company_logo')->store(
                'registrations/icon-plus-quartet/company-logo/'.now()->year,
                'public'
            )
            : null;

        $vatCertificatePath = $request->hasFile('vat_number')
            ? $request->file('vat_number')->store(
                'registrations/icon-plus-quartet/vat-certificate/'.now()->year,
                'public'
            )
            : null;

        $registration = IconPlusQuartetRegistration::create(
            IconPlusQuartetRegistration::filterPersistableAttributes([
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'job_title' => $data['job_title'],
                'organization' => $data['organization'] ?? '',
                'location_selection' => $data['location_selection'],
                'vat_certificate_path' => $vatCertificatePath,
                'cr_copy_path' => $crCopyPath,
                'cr_copy' => $data['cr_copy'],
                'national_address_doc_path' => $nationalAddressDocPath,
                'company_logo_path' => $companyLogoPath,
                'pdf_status' => 'pending',
                'pdf_error' => null,
                'pdf_generated_at' => null,
                'status' => 'pending',
            ])
        );

        ProcessIconPlusQuartetRegistrationSubmission::dispatchAfterResponse($registration);

        $message = __('registration.icon_plus_quartet.success_pdf_pending');
        $toastTitle = __('registration.icon_plus_quartet.toast_title');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'toast_title' => $toastTitle,
                'registration_id' => $registration->id,
            ], 201);
        }

        return back()->with('icon_plus_quartet_success', $message);
    }

    public function download(string $locale, IconPlusQuartetRegistration $registration): BinaryFileResponse
    {
        if (! $registration->pdf_path) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($registration->pdf_path);

        if (! file_exists($fullPath)) {
            abort(404);
        }

        return response()->download($fullPath, "icon-plus-quartet-registration-{$registration->id}.pdf");
    }
}
