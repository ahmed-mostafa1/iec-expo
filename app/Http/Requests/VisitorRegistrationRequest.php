<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255'],
            'phone'      => ['required', 'string', 'max:50'],

            // company selection: either predefined or other
            'company_predefined'     => ['nullable', 'string', 'max:255'],
            'company_other'          => ['nullable', 'string', 'max:255'],

            'heard_about'            => ['required', 'string', 'in:social_media,ads,friends,other'],
            'heard_about_other_text' => ['nullable', 'string', 'max:1000'],

            'interests'              => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $predefined = $this->input('company_predefined');
            $other      = $this->input('company_other');

            if (! $predefined && ! $other) {
                $validator->errors()->add('company_predefined', __('validation.required'));
            }

            if ($this->input('heard_about') === 'other' && ! $this->input('heard_about_other_text')) {
                $validator->errors()->add('heard_about_other_text', __('validation.required'));
            }
        });
    }
}
