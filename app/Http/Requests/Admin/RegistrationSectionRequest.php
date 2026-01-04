<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationSectionRequest extends FormRequest
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
            'visitor_card.title.en' => ['nullable', 'string'],
            'visitor_card.title.ar' => ['nullable', 'string'],
            'visitor_card.description.en' => ['nullable', 'string'],
            'visitor_card.description.ar' => ['nullable', 'string'],
            'visitor_card.cta_label.en' => ['nullable', 'string'],
            'visitor_card.cta_label.ar' => ['nullable', 'string'],
            'visitor_form.title.en' => ['nullable', 'string'],
            'visitor_form.title.ar' => ['nullable', 'string'],
            'visitor_form.cta_submit.en' => ['nullable', 'string'],
            'visitor_form.cta_submit.ar' => ['nullable', 'string'],
            'visitor_form.cta_contact.en' => ['nullable', 'string'],
            'visitor_form.cta_contact.ar' => ['nullable', 'string'],
            'visitor_form.fields' => ['nullable', 'array', 'min:1'],
            'visitor_form.fields.*.name' => ['nullable', 'string'],
            'visitor_form.fields.*.label.en' => ['nullable', 'string'],
            'visitor_form.fields.*.label.ar' => ['nullable', 'string'],
            'visitor_form.fields.*.placeholder.en' => ['nullable', 'string'],
            'visitor_form.fields.*.placeholder.ar' => ['nullable', 'string'],
            'visitor_form.fields.*.options' => ['nullable', 'array'],
            'visitor_form.fields.*.options.*.value' => ['nullable', 'string'],
            'visitor_form.fields.*.options.*.en' => ['nullable', 'string'],
            'visitor_form.fields.*.options.*.ar' => ['nullable', 'string'],
            'exhibitor_card.title.en' => ['nullable', 'string'],
            'exhibitor_card.title.ar' => ['nullable', 'string'],
            'exhibitor_card.description.en' => ['nullable', 'string'],
            'exhibitor_card.description.ar' => ['nullable', 'string'],
            'exhibitor_card.cta_label.en' => ['nullable', 'string'],
            'exhibitor_card.cta_label.ar' => ['nullable', 'string'],
            'exhibitor_form.title.en' => ['nullable', 'string'],
            'exhibitor_form.title.ar' => ['nullable', 'string'],
            'exhibitor_form.step_one.en' => ['nullable', 'string'],
            'exhibitor_form.step_one.ar' => ['nullable', 'string'],
            'exhibitor_form.step_two.en' => ['nullable', 'string'],
            'exhibitor_form.step_two.ar' => ['nullable', 'string'],
            'exhibitor_form.cta_next.en' => ['nullable', 'string'],
            'exhibitor_form.cta_next.ar' => ['nullable', 'string'],
            'exhibitor_form.cta_submit.en' => ['nullable', 'string'],
            'exhibitor_form.cta_submit.ar' => ['nullable', 'string'],
            'exhibitor_form.fields_step_one' => ['nullable', 'array', 'min:1'],
            'exhibitor_form.fields_step_one.*.name' => ['nullable', 'string'],
            'exhibitor_form.fields_step_one.*.label.en' => ['nullable', 'string'],
            'exhibitor_form.fields_step_one.*.label.ar' => ['nullable', 'string'],
            'exhibitor_form.fields_step_one.*.placeholder.en' => ['nullable', 'string'],
            'exhibitor_form.fields_step_one.*.placeholder.ar' => ['nullable', 'string'],
            'exhibitor_form.fields_step_one.*.hint.en' => ['nullable', 'string'],
            'exhibitor_form.fields_step_one.*.hint.ar' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two' => ['nullable', 'array', 'min:1'],
            'exhibitor_form.fields_step_two.*.name' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two.*.label.en' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two.*.label.ar' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two.*.placeholder.en' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two.*.placeholder.ar' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two.*.hint.en' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two.*.hint.ar' => ['nullable', 'string'],
            'icon_card.title.en' => ['nullable', 'string'],
            'icon_card.title.ar' => ['nullable', 'string'],
            'icon_card.description.en' => ['nullable', 'string'],
            'icon_card.description.ar' => ['nullable', 'string'],
            'icon_card.cta_label.en' => ['nullable', 'string'],
            'icon_card.cta_label.ar' => ['nullable', 'string'],
            'icon_form.title.en' => ['nullable', 'string'],
            'icon_form.title.ar' => ['nullable', 'string'],
            'icon_form.step_one.en' => ['nullable', 'string'],
            'icon_form.step_one.ar' => ['nullable', 'string'],
            'icon_form.step_two.en' => ['nullable', 'string'],
            'icon_form.step_two.ar' => ['nullable', 'string'],
            'icon_form.cta_next.en' => ['nullable', 'string'],
            'icon_form.cta_next.ar' => ['nullable', 'string'],
            'icon_form.cta_back.en' => ['nullable', 'string'],
            'icon_form.cta_back.ar' => ['nullable', 'string'],
            'icon_form.cta_submit.en' => ['nullable', 'string'],
            'icon_form.cta_submit.ar' => ['nullable', 'string'],
            'icon_form.fields_step_one' => ['nullable', 'array', 'min:1'],
            'icon_form.fields_step_one.*.name' => ['nullable', 'string'],
            'icon_form.fields_step_one.*.label.en' => ['nullable', 'string'],
            'icon_form.fields_step_one.*.label.ar' => ['nullable', 'string'],
            'icon_form.fields_step_one.*.placeholder.en' => ['nullable', 'string'],
            'icon_form.fields_step_one.*.placeholder.ar' => ['nullable', 'string'],
            'icon_form.fields_step_one.*.hint.en' => ['nullable', 'string'],
            'icon_form.fields_step_one.*.hint.ar' => ['nullable', 'string'],
            'icon_form.fields_step_two' => ['nullable', 'array', 'min:1'],
            'icon_form.fields_step_two.*.name' => ['nullable', 'string'],
            'icon_form.fields_step_two.*.label.en' => ['nullable', 'string'],
            'icon_form.fields_step_two.*.label.ar' => ['nullable', 'string'],
            'icon_form.fields_step_two.*.placeholder.en' => ['nullable', 'string'],
            'icon_form.fields_step_two.*.placeholder.ar' => ['nullable', 'string'],
            'icon_form.fields_step_two.*.hint.en' => ['nullable', 'string'],
            'icon_form.fields_step_two.*.hint.ar' => ['nullable', 'string'],
        ];
    }
}

