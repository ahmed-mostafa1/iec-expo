<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\HasSaudiPhoneValidation;
use App\Services\HallSpaceService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class IconQuartetRegistrationRequest extends FormRequest
{
    use HasSaudiPhoneValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'form_identifier' => ['nullable', 'in:icon-quartet'],
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
                    $quartet = $this->validateQuartet((string) $value, 'icon-quartet');

                    if ($quartet === null) {
                        $fail(__('registration.icon_quartet.invalid_location'));

                        return;
                    }

                    foreach ($quartet as $space) {
                        if (HallSpaceService::isOccupied($space)) {
                            $fail(__('registration.common.location_occupied'));

                            return;
                        }
                    }
                },
            ],
            'vat_number' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'cr_copy_file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'cr_copy' => ['required', 'digits:10'],
            'national_address_document' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'company_logo' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'privacy_policy' => ['accepted'],
        ];
    }

    /**
     * Splits the joined "L.W.1, L.W.2, L.W.29, L.W.30" value and checks it is
     * exactly one valid in-range quartet for $target. Returns the normalized
     * 4-name quartet, or null if invalid.
     *
     * @return array<int, string>|null
     */
    protected function validateQuartet(string $value, string $target): ?array
    {
        $parts = array_values(array_filter(array_map(
            fn (string $part): ?string => HallSpaceService::normalize($part),
            explode(',', $value)
        )));

        if (count($parts) !== 4) {
            return null;
        }

        $quartet = HallSpaceService::quartetFor($parts[0]);

        if ($quartet === [] || array_diff($quartet, $parts) !== [] || array_diff($parts, $quartet) !== []) {
            return null;
        }

        if (array_diff($quartet, HallSpaceService::allowedSpaces($target)) !== []) {
            return null;
        }

        return $quartet;
    }

    public function attributes(): array
    {
        return [
            'location_selection' => __('Book Location'),
            'vat_number' => __('registration.icon_quartet.vat_number'),
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
