<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueIconVatCr;
use Illuminate\Contracts\Validation\Validator;

class IconRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'       => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255'],
            'phone'           => ['required', 'string', 'max:50'],
            'job_title'       => ['required', 'string', 'max:255'],
            'organization'    => ['nullable', 'string', 'max:255'],
            'location_selection' => ['required', 'string', 'max:255'],
            'vat_number'      => ['nullable', 'digits:15', new UniqueIconVatCr],
            'cr_number'       => ['nullable', 'string', 'max:255', new UniqueIconVatCr],
            'corporate_profile'         => ['nullable', 'file', 'mimes:pdf', 'max:8192'],
            'cr_copy'                   => ['nullable', 'file', 'mimes:pdf', 'max:8192'],
            'national_address_document' => ['nullable', 'file', 'mimes:pdf', 'max:8192'],
            'company_logo'              => ['nullable', 'file', 'mimes:pdf', 'max:8192'],
            'privacy_policy'            => ['accepted'],
        ];
    }

    public function attributes(): array
    {
        return [
            'location_selection' => __('Book Location'),
            'vat_number' => __('registration.icon.vat_number'),
            'cr_number'  => __('registration.icon.cr_number'),
            'privacy_policy' => __('Privacy Policy'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->errors()->has('vat_number') || $validator->errors()->has('cr_number')) {
            session()->flash('scroll_to_contact', true);
        }

        parent::failedValidation($validator);
    }
}
