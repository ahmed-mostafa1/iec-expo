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
            'title.en' => ['required', 'string'],
            'title.ar' => ['required', 'string'],
            'description.en' => ['required', 'string'],
            'description.ar' => ['required', 'string'],
            'visitor_card.title.en' => ['required', 'string'],
            'visitor_card.title.ar' => ['required', 'string'],
            'visitor_card.description.en' => ['required', 'string'],
            'visitor_card.description.ar' => ['required', 'string'],
            'visitor_card.cta_label.en' => ['required', 'string'],
            'visitor_card.cta_label.ar' => ['required', 'string'],
            'visitor_form.title.en' => ['required', 'string'],
            'visitor_form.title.ar' => ['required', 'string'],
            'visitor_form.cta_submit.en' => ['required', 'string'],
            'visitor_form.cta_submit.ar' => ['required', 'string'],
            'visitor_form.cta_contact.en' => ['required', 'string'],
            'visitor_form.cta_contact.ar' => ['required', 'string'],
            'visitor_form.fields' => ['required', 'array', 'min:1'],
            'visitor_form.fields.*.name' => ['required', 'string'],
            'visitor_form.fields.*.label.en' => ['required', 'string'],
            'visitor_form.fields.*.label.ar' => ['required', 'string'],
            'visitor_form.fields.*.placeholder.en' => ['nullable', 'string'],
            'visitor_form.fields.*.placeholder.ar' => ['nullable', 'string'],
            'visitor_form.fields.*.options' => ['nullable', 'array'],
            'visitor_form.fields.*.options.*.value' => ['nullable', 'string'],
            'visitor_form.fields.*.options.*.en' => ['required_with:visitor_form.fields.*.options', 'string'],
            'visitor_form.fields.*.options.*.ar' => ['required_with:visitor_form.fields.*.options', 'string'],
            'exhibitor_card.title.en' => ['required', 'string'],
            'exhibitor_card.title.ar' => ['required', 'string'],
            'exhibitor_card.description.en' => ['required', 'string'],
            'exhibitor_card.description.ar' => ['required', 'string'],
            'exhibitor_card.cta_label.en' => ['required', 'string'],
            'exhibitor_card.cta_label.ar' => ['required', 'string'],
            'exhibitor_form.title.en' => ['required', 'string'],
            'exhibitor_form.title.ar' => ['required', 'string'],
            'exhibitor_form.step_one.en' => ['required', 'string'],
            'exhibitor_form.step_one.ar' => ['required', 'string'],
            'exhibitor_form.step_two.en' => ['required', 'string'],
            'exhibitor_form.step_two.ar' => ['required', 'string'],
            'exhibitor_form.cta_next.en' => ['required', 'string'],
            'exhibitor_form.cta_next.ar' => ['required', 'string'],
            'exhibitor_form.cta_submit.en' => ['required', 'string'],
            'exhibitor_form.cta_submit.ar' => ['required', 'string'],
            'exhibitor_form.fields_step_one' => ['required', 'array', 'min:1'],
            'exhibitor_form.fields_step_one.*.name' => ['required', 'string'],
            'exhibitor_form.fields_step_one.*.label.en' => ['required', 'string'],
            'exhibitor_form.fields_step_one.*.label.ar' => ['required', 'string'],
            'exhibitor_form.fields_step_one.*.placeholder.en' => ['nullable', 'string'],
            'exhibitor_form.fields_step_one.*.placeholder.ar' => ['nullable', 'string'],
            'exhibitor_form.fields_step_one.*.hint.en' => ['nullable', 'string'],
            'exhibitor_form.fields_step_one.*.hint.ar' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two' => ['required', 'array', 'min:1'],
            'exhibitor_form.fields_step_two.*.name' => ['required', 'string'],
            'exhibitor_form.fields_step_two.*.label.en' => ['required', 'string'],
            'exhibitor_form.fields_step_two.*.label.ar' => ['required', 'string'],
            'exhibitor_form.fields_step_two.*.placeholder.en' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two.*.placeholder.ar' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two.*.hint.en' => ['nullable', 'string'],
            'exhibitor_form.fields_step_two.*.hint.ar' => ['nullable', 'string'],
            'icon_card.title.en' => ['required', 'string'],
            'icon_card.title.ar' => ['required', 'string'],
            'icon_card.description.en' => ['required', 'string'],
            'icon_card.description.ar' => ['required', 'string'],
            'icon_card.cta_label.en' => ['required', 'string'],
            'icon_card.cta_label.ar' => ['required', 'string'],
            'icon_form.title.en' => ['required', 'string'],
            'icon_form.title.ar' => ['required', 'string'],
            'icon_form.step_one.en' => ['required', 'string'],
            'icon_form.step_one.ar' => ['required', 'string'],
            'icon_form.step_two.en' => ['required', 'string'],
            'icon_form.step_two.ar' => ['required', 'string'],
            'icon_form.cta_next.en' => ['required', 'string'],
            'icon_form.cta_next.ar' => ['required', 'string'],
            'icon_form.cta_back.en' => ['required', 'string'],
            'icon_form.cta_back.ar' => ['required', 'string'],
            'icon_form.cta_submit.en' => ['required', 'string'],
            'icon_form.cta_submit.ar' => ['required', 'string'],
            'icon_form.fields_step_one' => ['required', 'array', 'min:1'],
            'icon_form.fields_step_one.*.name' => ['required', 'string'],
            'icon_form.fields_step_one.*.label.en' => ['required', 'string'],
            'icon_form.fields_step_one.*.label.ar' => ['required', 'string'],
            'icon_form.fields_step_one.*.placeholder.en' => ['nullable', 'string'],
            'icon_form.fields_step_one.*.placeholder.ar' => ['nullable', 'string'],
            'icon_form.fields_step_one.*.hint.en' => ['nullable', 'string'],
            'icon_form.fields_step_one.*.hint.ar' => ['nullable', 'string'],
            'icon_form.fields_step_two' => ['required', 'array', 'min:1'],
            'icon_form.fields_step_two.*.name' => ['required', 'string'],
            'icon_form.fields_step_two.*.label.en' => ['required', 'string'],
            'icon_form.fields_step_two.*.label.ar' => ['required', 'string'],
            'icon_form.fields_step_two.*.placeholder.en' => ['nullable', 'string'],
            'icon_form.fields_step_two.*.placeholder.ar' => ['nullable', 'string'],
            'icon_form.fields_step_two.*.hint.en' => ['nullable', 'string'],
            'icon_form.fields_step_two.*.hint.ar' => ['nullable', 'string'],
        ];
    }
}
