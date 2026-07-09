<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\HasSaudiPhoneValidation;
use App\Services\HallSpaceService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class IconRegistrationRequest extends FormRequest
{
    use HasSaudiPhoneValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50', $this->saudiPhoneRule()],
            'job_title' => ['required', 'string', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'location_selection' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (HallSpaceService::isIconPlusSpace((string) $value)) {
                        $fail(__('registration.icon.reserved_icon_plus_space'));

                        return;
                    }

                    if (HallSpaceService::isOccupied((string) $value)) {
                        $fail(__('registration.common.location_occupied'));
                    }
                },
            ],
            'vat_number' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'cr_copy_file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'cr_number' => ['required', 'digits:10'],
            'national_address_document' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'company_logo' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'privacy_policy' => ['accepted'],
        ];
    }

    public function attributes(): array
    {
        return [
            'location_selection' => __('Book Location'),
            'vat_number' => __('registration.icon.vat_number'),

            'privacy_policy' => __('Privacy Policy'),
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => $this->saudiPhoneMessage(),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->errors()->has('vat_number')) {
            session()->flash('scroll_to_contact', true);
        }

        parent::failedValidation($validator);
    }
}
