<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitorRegistrationRequest;
use App\Jobs\ProcessVisitorRegistrationSubmission;
use App\Models\VisitorRegistration;

class VisitorRegistrationController extends Controller
{
    public function store(VisitorRegistrationRequest $request, string $locale)
    {
        $data = $request->validated();

        $registration = VisitorRegistration::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'job_title' => $data['job_title'],
            'company_name' => $data['company_name'],
            'company_predefined' => null,
            'company_is_other' => false,
            'heard_about' => $data['heard_about'],
            'heard_about_other_text' => $data['heard_about_other_text'] ?? null,
            'interests' => null,
        ]);

        ProcessVisitorRegistrationSubmission::dispatchAfterResponse($registration);

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
