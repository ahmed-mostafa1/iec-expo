<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    public function rules(): array
    {
        if (! $this->isMethod('post')) {
            return [];
        }

        return [
            'title.en' => ['required', 'string'],
            'title.ar' => ['required', 'string'],
            'description.en' => ['required', 'string'],
            'description.ar' => ['required', 'string'],
            'form_title.en' => ['required', 'string'],
            'form_title.ar' => ['required', 'string'],
            'form_button.en' => ['required', 'string'],
            'form_button.ar' => ['required', 'string'],
            'map_embed' => ['required', 'string'],
            'location_title.en' => ['required', 'string'],
            'location_title.ar' => ['required', 'string'],
            'location_address.en' => ['required', 'string'],
            'location_address.ar' => ['required', 'string'],
            'support_cards' => ['required', 'array', 'min:1'],
            'support_cards.*.id' => ['required', 'string'],
            'support_cards.*.title.en' => ['required', 'string'],
            'support_cards.*.title.ar' => ['required', 'string'],
            'support_cards.*.columns' => ['required', 'array', 'min:1'],
            'support_cards.*.columns.*.heading.en' => ['required', 'string'],
            'support_cards.*.columns.*.heading.ar' => ['required', 'string'],
            'support_cards.*.columns.*.contacts' => ['required', 'array', 'min:1'],
            'support_cards.*.columns.*.contacts.*.type' => ['required', 'in:phone,email'],
            'support_cards.*.columns.*.contacts.*.value' => ['required', 'string'],
            'location_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ];
    }
}
