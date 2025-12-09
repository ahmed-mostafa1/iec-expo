<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitorRegistrationRequest;
use App\Mail\NewVisitorRegistrationMail;
use App\Models\VisitorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Support\Facades\Mail;

class VisitorRegistrationController extends Controller
{
    public function __construct(
        protected RegistrationPdfService $pdfService
    ) {}

    public function store(VisitorRegistrationRequest $request, string $locale)
    {
        $data = $request->validated();

        $companyPredefined = $data['company_predefined'] ?? null;
        $companyOther = $data['company_other'] ?? null;

        $companyName = $companyOther ?: $companyPredefined;
        $companyIsOther = (bool) $companyOther;

        $registration = VisitorRegistration::create([
            'full_name'             => $data['full_name'],
            'email'                 => $data['email'],
            'phone'                 => $data['phone'],
            'company_name'          => $companyName,
            'company_predefined'    => $companyPredefined,
            'company_is_other'      => $companyIsOther,
            'heard_about'           => $data['heard_about'],
            'heard_about_other_text'=> $data['heard_about_other_text'] ?? null,
            'interests'             => $data['interests'] ?? null,
        ]);

        $pdfPath = $this->pdfService->generateVisitorPdf($registration);
        $registration->update(['pdf_path' => $pdfPath]);

        foreach (config('admin.emails', []) as $adminEmail) {
            Mail::to($adminEmail)->send(
                new NewVisitorRegistrationMail($registration, $pdfPath)
            );
        }

        return back()->with('success', __('registration.visitor.success'));
    }
}
