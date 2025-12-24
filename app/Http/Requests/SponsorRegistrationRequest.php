<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\UniqueSponsorVatCr;

class SponsorRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public form
    }

    public function rules(): array
    {
        return [
            'full_name'       => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255'],
            'phone'           => ['required', 'string', 'max:50'],
            'job_title'       => ['required', 'string', 'max:255'],
            'organization'    => ['required', 'string', 'max:255'],
            'vat_number'      => ['nullable', 'digits:15', new UniqueSponsorVatCr],
            'cr_number'       => ['nullable', 'string', 'max:255', new UniqueSponsorVatCr],
            'national_address'=> ['nullable', 'string'],
            'corporate_profile'         => ['nullable', 'file', 'mimes:pdf', 'max:8192'],
            'cr_copy'                   => ['nullable', 'file', 'mimes:pdf', 'max:8192'],
            'national_address_document' => ['nullable', 'file', 'mimes:pdf', 'max:8192'],
            'company_logo'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ];
    }

    public function attributes(): array
    {
        return [
            'organization' => __('Company / Organization'),
            'vat_number' => __('registration.sponsor.vat_number'),
            'cr_number'  => __('registration.sponsor.cr_number'),
        ];
    }

    /**
     * When validation fails due to duplicate VAT/CR, set scroll_to_contact flag.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($validator->errors()->has('vat_number') || $validator->errors()->has('cr_number')) {
            session()->flash('scroll_to_contact', true);
        }

        parent::failedValidation($validator);
    }
}
