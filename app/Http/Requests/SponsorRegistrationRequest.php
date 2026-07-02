<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\HasSaudiPhoneValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;


class SponsorRegistrationRequest extends FormRequest
{
    use HasSaudiPhoneValidation;

    public function authorize(): bool
    {
        return true; // public form
    }

    public function rules(): array
    {
        return [
            'full_name'       => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255'],
            'phone'           => ['required', 'string', 'max:50', $this->saudiPhoneRule()],
            'job_title'       => ['required', 'string', 'max:255'],
            'organization'    => ['required', 'string', 'max:255'],
            'sponsor_tier'    => ['required', 'string', 'max:50', Rule::in($this->sponsorTierOptions())],
            'location_selection' => ['nullable', 'string', 'max:255'],
            'vat_number'      => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'cr_copy'                   => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'national_address_document' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'company_logo'              => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'privacy_policy'            => ['accepted'],
        ];
    }

    public function attributes(): array
    {
        return [
            'organization' => __('Company / Organization'),
            'sponsor_tier' => __('Sponsor tier'),
            'vat_number' => __('registration.sponsor.vat_number'),

            'privacy_policy' => __('Privacy Policy'),
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => $this->saudiPhoneMessage(),
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
