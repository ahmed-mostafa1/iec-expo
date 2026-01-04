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
            'title.en' => ['nullable', 'string'],
            'title.ar' => ['nullable', 'string'],
            'description.en' => ['nullable', 'string'],
            'description.ar' => ['nullable', 'string'],
            'form_title.en' => ['nullable', 'string'],
            'form_title.ar' => ['nullable', 'string'],
            'form_button.en' => ['nullable', 'string'],
            'form_button.ar' => ['nullable', 'string'],
            'map_embed' => ['nullable', 'string'],
            'location_title.en' => ['nullable', 'string'],
            'location_title.ar' => ['nullable', 'string'],
            'location_address.en' => ['nullable', 'string'],
            'location_address.ar' => ['nullable', 'string'],
            'support_cards' => ['nullable', 'array', 'min:1'],
            'support_cards.*.id' => ['nullable', 'string'],
            'support_cards.*.title.en' => ['nullable', 'string'],
            'support_cards.*.title.ar' => ['nullable', 'string'],
            'support_cards.*.columns' => ['nullable', 'array', 'min:1'],
            'support_cards.*.columns.*.heading.en' => ['nullable', 'string'],
            'support_cards.*.columns.*.heading.ar' => ['nullable', 'string'],
            'support_cards.*.columns.*.contacts' => ['nullable', 'array', 'min:1'],
            'support_cards.*.columns.*.contacts.*.type' => ['nullable', 'in:phone,email'],
            'support_cards.*.columns.*.contacts.*.value' => ['nullable', 'string'],
            'location_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ];
    }
}

