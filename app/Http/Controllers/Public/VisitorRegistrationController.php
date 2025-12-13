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

        $registration = VisitorRegistration::create([
            'full_name'             => $data['full_name'],
            'email'                 => $data['email'],
            'phone'                 => $data['phone'],
            'job_title'             => $data['job_title'],
            'company_name'          => $data['company_name'],
            'company_predefined'    => null,
            'company_is_other'      => false,
            'heard_about'           => $data['heard_about'],
            'heard_about_other_text'=> $data['heard_about_other_text'] ?? null,
            'interests'             => null,
        ]);

        $pdfPath = $this->pdfService->generateVisitorPdf($registration);
        $registration->update(['pdf_path' => $pdfPath]);

        foreach (config('admin.emails', []) as $adminEmail) {
            Mail::to($adminEmail)->send(
                new NewVisitorRegistrationMail($registration, $pdfPath)
            );
        }

        $message = __('registration.visitor.success');
        $toastTitle = __('registration.visitor.toast_title');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'toast_title' => $toastTitle,
                'registration_id' => $registration->id,
            ], 201);
        }

        return back()->with('visitor_success', $message);
    }
}
