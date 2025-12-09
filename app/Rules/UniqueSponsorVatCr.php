<?php

namespace App\Rules;

use App\Models\SponsorRegistration;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueSponsorVatCr implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $vat = request()->input('vat_number');
        $cr  = request()->input('cr_number');

        $query = SponsorRegistration::query();

        if ($vat) {
            $query->where('vat_number', $vat);
        }

        if ($cr) {
            $query->orWhere('cr_number', $cr);
        }

        if ($query->exists()) {
            // single generic error key; we'll attach it to vat_number
            $fail(__('registration.sponsor.duplicate'));
        }
    }
}
