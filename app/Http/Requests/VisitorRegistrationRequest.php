<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\HasSaudiPhoneValidation;
use Illuminate\Foundation\Http\FormRequest;

class VisitorRegistrationRequest extends FormRequest
{
    use HasSaudiPhoneValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'form_identifier'        => ['nullable', 'in:visitor'],
            'full_name'              => ['required', 'string', 'max:255'],
            'email'                  => ['required', 'email', 'max:255'],
            'phone'                  => ['required', 'string', 'max:50', $this->saudiPhoneRule()],
            'job_title'              => ['required', 'string', 'max:255'],
            'company_name'           => ['required', 'string', 'max:255'],
            'heard_about'            => ['required', 'string', 'in:social_media,ads,friends,other'],
            'heard_about_other_text' => ['required_if:heard_about,other', 'nullable', 'string', 'max:1000'],
            'privacy_policy'         => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => $this->saudiPhoneMessage(),
        ];
    }

    // No additional conditional requirements.
}
