<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
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
            'phone'           => ['required', 'string', 'min:10', 'max:50', 'regex:/^\d+$/'],
            'job_title'       => ['required', 'string', 'max:255'],
            'organization'    => ['required', 'string', 'max:255'],
            'sponsor_tier'    => ['required', 'string', 'max:50', Rule::in($this->sponsorTierOptions())],
            'location_selection' => ['nullable', 'string', 'max:255'],
            'vat_number'      => ['required', 'digits:15', new UniqueSponsorVatCr],
            'cr_number'       => ['required', 'string', 'min:10', 'max:255', 'regex:/^\d+$/', new UniqueSponsorVatCr],
            'cr_copy'                   => ['required', 'file', 'mimes:pdf', 'max:8192'],
            'national_address_document' => ['required', 'file', 'mimes:pdf', 'max:8192'],
            'company_logo'              => ['required', 'file', 'mimes:pdf', 'max:8192'],
            'privacy_policy'            => ['accepted'],
        ];
    }

    public function attributes(): array
    {
        return [
            'organization' => __('Company / Organization'),
            'sponsor_tier' => __('Sponsor tier'),
            'vat_number' => __('registration.sponsor.vat_number'),
            'cr_number'  => __('registration.sponsor.cr_number'),
            'privacy_policy' => __('Privacy Policy'),
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

    private function sponsorTierOptions(): array
    {
        return [
            'strategic',
            'diamond',
            'government',
            'marketing',
            'media',
            'technology',
            'safety-security',
            'gold',
            'other',
        ];
    }
}
