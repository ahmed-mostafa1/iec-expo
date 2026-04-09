<?php

namespace App\Http\Requests\Concerns;

trait HasSaudiPhoneValidation
{
    protected function saudiPhoneRule(): string
    {
        return 'regex:/^(?:\\+9665\\d{8}|05\\d{8}|9665\\d{8})$/';
    }

    protected function saudiPhoneMessage(): string
    {
        return 'يرجى إدخال رقم سعودي صحيح';
    }
}
