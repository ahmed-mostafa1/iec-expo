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

        if (! $vat && ! $cr) {
            return;
        }

        $query = SponsorRegistration::query();

        $query->where(function ($innerQuery) use ($vat, $cr) {
            if ($vat) {
                $innerQuery->where('vat_number', $vat);
            }

            if ($cr) {
                if ($vat) {
                    $innerQuery->orWhere('cr_number', $cr);
                } else {
                    $innerQuery->where('cr_number', $cr);
                }
            }
        });

        if ($query->exists()) {
            // single generic error key; we'll attach it to vat_number
            $fail(__('registration.sponsor.duplicate'));
        }
    }
}
