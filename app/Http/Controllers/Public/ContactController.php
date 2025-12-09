<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(ContactRequest $request, string $locale)
    {
        $data = $request->validated();

        foreach (config('admin.emails', []) as $adminEmail) {
            Mail::to($adminEmail)->send(
                new ContactFormMail(
                    $data['name'],
                    $data['email'],
                    $data['phone'] ?? null,
                    $data['message'],
                )
            );
        }

        return back()->with('success', __('contact.success'));
    }
}
