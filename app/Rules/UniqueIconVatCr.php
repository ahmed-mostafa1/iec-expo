<?php

namespace App\Rules;

use App\Models\IconRegistration;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueIconVatCr implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $vat = request()->input('vat_number');
        $cr  = request()->input('cr_copy');

        if (! $vat && ! $cr) {
            return;
        }

        $query = IconRegistration::query();

        $query->where(function ($innerQuery) use ($vat, $cr) {
            if ($vat) {
                $innerQuery->where('vat_number', $vat);
            }

            if ($cr) {
                if ($vat) {
                    $innerQuery->orWhere('cr_copy', $cr);
                } else {
                    $innerQuery->where('cr_copy', $cr);
                }
            }
        });

        if ($query->exists()) {
            $fail(__('registration.icon.duplicate'));
        }
    }
}
