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
            'phone'           => ['required', 'string', 'min:10', 'max:50', 'regex:/^\d+$/'],
            'job_title'       => ['required', 'string', 'max:255'],
            'organization'    => ['required', 'string', 'max:255'],
            'location_selection' => ['required', 'string', 'max:255'],
            'vat_number'      => ['required', 'digits:15', new UniqueIconVatCr],
            'cr_number'       => ['required', 'string', 'min:10', 'max:255', 'regex:/^\d+$/', new UniqueIconVatCr],
            'cr_copy'                   => ['required', 'file', 'mimes:pdf', 'max:8192'],
            'national_address_document' => ['required', 'file', 'mimes:pdf', 'max:8192'],
            'company_logo'              => ['required', 'file', 'mimes:pdf', 'max:8192'],
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
