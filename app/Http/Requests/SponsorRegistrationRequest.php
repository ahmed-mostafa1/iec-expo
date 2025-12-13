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
            'vat_number'      => ['required', 'string', 'max:255', new UniqueSponsorVatCr],
            'cr_number'       => ['required', 'string', 'max:255'],
            'national_address'=> ['required', 'string'],
            'corporate_profile'      => ['required', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:8192'],
            'cr_copy'                => ['required', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:8192'],
            'national_address_document' => ['required', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:8192'],
            'company_logo'           => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ];
    }

    public function attributes(): array
    {
        return [
            'vat_number' => __('registration.sponsor.vat_number'),
            'cr_number'  => __('registration.sponsor.cr_number'),
        ];
    }

    /**
     * When validation fails due to duplicate VAT/CR, set scroll_to_contact flag.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($validator->errors()->has('vat_number')) {
            session()->flash('scroll_to_contact', true);
        }

        parent::failedValidation($validator);
    }
}
