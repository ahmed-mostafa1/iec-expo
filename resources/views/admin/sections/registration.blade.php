@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">{{ __('Registration section') }}</h1>
                <p class="text-sm text-gray-500">{{ __('Edit the registration hero, cards, and bilingual form skeletons.') }}</p>
            </div>
            <a href="{{ $previewUrl }}" target="_blank" rel="noopener"
                class="text-s inline-flex items-center gap-2 rounded-full border border-emerald-600 px-4 py-2 font-semibold text-emerald-700 hover:bg-emerald-50 transition">
                <span>{{ __('Preview on landing') }}</span>
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900 space-y-1">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        @php
            $title = old('title', $content['title'] ?? []);
            $description = old('description', $content['description'] ?? []);
            $visitorCard = old('visitor_card', $content['visitor_card'] ?? []);
            $visitorForm = old('visitor_form', $content['visitor_form'] ?? []);
            $visitorFields = $visitorForm['fields'] ?? [];
            $exhibitorCard = old('exhibitor_card', $content['exhibitor_card'] ?? []);
            $exhibitorForm = old('exhibitor_form', $content['exhibitor_form'] ?? []);
            $exhibitorFieldsStepOne = $exhibitorForm['fields_step_one'] ?? [];
            $exhibitorFieldsStepTwo = $exhibitorForm['fields_step_two'] ?? [];
            $iconCard = old('icon_card', $content['icon_card'] ?? []);
            $iconForm = old('icon_form', $content['icon_form'] ?? []);
            $iconFieldsStepOne = $iconForm['fields_step_one'] ?? [];
            $iconFieldsStepTwo = $iconForm['fields_step_two'] ?? [];
        @endphp

        <form method="POST" class="space-y-6">
            @csrf

            <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Section header') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('Inputs render where the title and description sit on the landing page.') }}</p>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (EN)') }}</label>
                        <input type="text" name="title[en]" value="{{ old('title.en', data_get($title, 'en')) }}"
                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                    </div>
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (AR)') }}</label>
                        <input type="text" name="title[ar]" value="{{ old('title.ar', data_get($title, 'ar')) }}"
                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (EN)') }}</label>
                        <textarea name="description[en]" rows="3" class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('description.en', data_get($description, 'en')) }}</textarea>
                    </div>
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (AR)') }}</label>
                        <textarea name="description[ar]" rows="3" class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('description.ar', data_get($description, 'ar')) }}</textarea>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6">
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="space-y-4" data-node-group>
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Guest pathway') }}</h2>
                        <div class="rounded-xl border border-gray-200 p-4 bg-gradient-to-br from-gray-50 to-white space-y-3">
                            <button type="button" class="w-full text-left" data-node-trigger="visitor-card">
                                <p class="text-s uppercase font-semibold text-emerald-700">{{ __('Card block') }}</p>
                                <p class="text-lg font-bold text-gray-900">{{ data_get($visitorCard, 'title.en') }}</p>
                                <p class="text-sm text-gray-600">{{ data_get($visitorCard, 'description.en') }}</p>
                            </button>
                            <div class="space-y-4 hidden" data-node-panel="visitor-card">
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (EN)') }}</label>
                                    <input type="text" name="visitor_card[title][en]"
                                        value="{{ old('visitor_card.title.en', data_get($visitorCard, 'title.en')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (AR)') }}</label>
                                    <input type="text" name="visitor_card[title][ar]"
                                        value="{{ old('visitor_card.title.ar', data_get($visitorCard, 'title.ar')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (EN)') }}</label>
                                    <textarea name="visitor_card[description][en]" rows="2"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('visitor_card.description.en', data_get($visitorCard, 'description.en')) }}</textarea>
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (AR)') }}</label>
                                    <textarea name="visitor_card[description][ar]" rows="2"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('visitor_card.description.ar', data_get($visitorCard, 'description.ar')) }}</textarea>
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('CTA Label (EN)') }}</label>
                                    <input type="text" name="visitor_card[cta_label][en]"
                                        value="{{ old('visitor_card.cta_label.en', data_get($visitorCard, 'cta_label.en')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('CTA Label (AR)') }}</label>
                                    <input type="text" name="visitor_card[cta_label][ar]"
                                        value="{{ old('visitor_card.cta_label.ar', data_get($visitorCard, 'cta_label.ar')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-dashed border-emerald-200 bg-emerald-50/30 p-4 space-y-4" data-node-group>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ __('Visitor form skeleton') }}</h3>
                                    <p class="text-s text-gray-500">{{ __('Click any field stub to edit labels, placeholders, and hints.') }}</p>
                                </div>
                                <button type="button" class="text-s font-semibold text-emerald-700" data-node-trigger="visitor-form-meta">
                                    {{ __('Edit header') }}
                                </button>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-white p-4 space-y-4 hidden" data-node-panel="visitor-form-meta">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Form title (EN)') }}</label>
                                        <input type="text" name="visitor_form[title][en]"
                                            value="{{ old('visitor_form.title.en', data_get($visitorForm, 'title.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Form title (AR)') }}</label>
                                        <input type="text" name="visitor_form[title][ar]"
                                            value="{{ old('visitor_form.title.ar', data_get($visitorForm, 'title.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Submit button (EN)') }}</label>
                                        <input type="text" name="visitor_form[cta_submit][en]"
                                            value="{{ old('visitor_form.cta_submit.en', data_get($visitorForm, 'cta_submit.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Submit button (AR)') }}</label>
                                        <input type="text" name="visitor_form[cta_submit][ar]"
                                            value="{{ old('visitor_form.cta_submit.ar', data_get($visitorForm, 'cta_submit.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Contact link (EN)') }}</label>
                                        <input type="text" name="visitor_form[cta_contact][en]"
                                            value="{{ old('visitor_form.cta_contact.en', data_get($visitorForm, 'cta_contact.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Contact link (AR)') }}</label>
                                        <input type="text" name="visitor_form[cta_contact][ar]"
                                            value="{{ old('visitor_form.cta_contact.ar', data_get($visitorForm, 'cta_contact.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4" data-node-group>
                                @foreach ($visitorFields as $index => $field)
                                    <div class="rounded-xl border border-gray-200 bg-white p-3">
                                        <button type="button" class="flex w-full items-center justify-between text-left text-sm" data-node-trigger="visitor-field-{{ $index }}">
                                            <div>
                                                <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Field') }} #{{ $loop->iteration }}</p>
                                                <p class="font-semibold text-gray-900">{{ data_get($field, 'label.en') }}</p>
                                                <p class="text-s text-gray-500">{{ strtoupper($field['type'] ?? 'text') }}</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M6 9l6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>

                                        <div class="mt-3 space-y-3 hidden" data-node-panel="visitor-field-{{ $index }}">
                                            <input type="hidden" name="visitor_form[fields][{{ $index }}][name]" value="{{ $field['name'] }}">
                                            <input type="hidden" name="visitor_form[fields][{{ $index }}][type]" value="{{ $field['type'] }}">
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Label (EN)') }}</label>
                                                <input type="text" name="visitor_form[fields][{{ $index }}][label][en]"
                                                    value="{{ old("visitor_form.fields.$index.label.en", data_get($field, 'label.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Label (AR)') }}</label>
                                                <input type="text" name="visitor_form[fields][{{ $index }}][label][ar]"
                                                    value="{{ old("visitor_form.fields.$index.label.ar", data_get($field, 'label.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Placeholder (EN)') }}</label>
                                                <input type="text" name="visitor_form[fields][{{ $index }}][placeholder][en]"
                                                    value="{{ old("visitor_form.fields.$index.placeholder.en", data_get($field, 'placeholder.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Placeholder (AR)') }}</label>
                                                <input type="text" name="visitor_form[fields][{{ $index }}][placeholder][ar]"
                                                    value="{{ old("visitor_form.fields.$index.placeholder.ar", data_get($field, 'placeholder.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            @if (($field['hint']['en'] ?? null) !== null || ($field['hint']['ar'] ?? null) !== null || ($field['type'] ?? null) === 'file')
                                                <div>
                                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Hint (EN)') }}</label>
                                                    <input type="text" name="visitor_form[fields][{{ $index }}][hint][en]"
                                                        value="{{ old("visitor_form.fields.$index.hint.en", data_get($field, 'hint.en')) }}"
                                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                                </div>
                                                <div>
                                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Hint (AR)') }}</label>
                                                    <input type="text" name="visitor_form[fields][{{ $index }}][hint][ar]"
                                                        value="{{ old("visitor_form.fields.$index.hint.ar", data_get($field, 'hint.ar')) }}"
                                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                                </div>
                                            @endif

                                            @if (($field['type'] ?? '') === 'select')
                                                <div class="space-y-3">
                                                    <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Options') }}</p>
                                                @foreach ($field['options'] ?? [] as $optionIndex => $option)
                                                        <div class="grid gap-2 md:grid-cols-2">
                                                            <input type="hidden"
                                                                name="visitor_form[fields][{{ $index }}][options][{{ $optionIndex }}][value]"
                                                                value="{{ old("visitor_form.fields.$index.options.$optionIndex.value", $option['value'] ?? '') }}">
                                                            <input type="text"
                                                                name="visitor_form[fields][{{ $index }}][options][{{ $optionIndex }}][en]"
                                                                value="{{ old("visitor_form.fields.$index.options.$optionIndex.en", $option['en']) }}"
                                                                class="rounded-lg border-gray-200 text-sm"
                                                                placeholder="{{ __('Option (EN)') }}" />
                                                            <input type="text"
                                                                name="visitor_form[fields][{{ $index }}][options][{{ $optionIndex }}][ar]"
                                                                value="{{ old("visitor_form.fields.$index.options.$optionIndex.ar", $option['ar']) }}"
                                                                class="rounded-lg border-gray-200 text-sm"
                                                                placeholder="{{ __('Option (AR)') }}" />
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4" data-node-group>
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Exhibitor pathway') }}</h2>
                        <div class="rounded-xl border border-gray-200 p-4 bg-gradient-to-br from-gray-50 to-white space-y-3">
                            <button type="button" class="w-full text-left" data-node-trigger="exhibitor-card">
                                <p class="text-s uppercase font-semibold text-emerald-700">{{ __('Card block') }}</p>
                                <p class="text-lg font-bold text-gray-900">{{ data_get($exhibitorCard, 'title.en') }}</p>
                                <p class="text-sm text-gray-600">{{ data_get($exhibitorCard, 'description.en') }}</p>
                            </button>
                            <div class="space-y-4 hidden" data-node-panel="exhibitor-card">
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (EN)') }}</label>
                                    <input type="text" name="exhibitor_card[title][en]"
                                        value="{{ old('exhibitor_card.title.en', data_get($exhibitorCard, 'title.en')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (AR)') }}</label>
                                    <input type="text" name="exhibitor_card[title][ar]"
                                        value="{{ old('exhibitor_card.title.ar', data_get($exhibitorCard, 'title.ar')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (EN)') }}</label>
                                    <textarea name="exhibitor_card[description][en]" rows="2"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('exhibitor_card.description.en', data_get($exhibitorCard, 'description.en')) }}</textarea>
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (AR)') }}</label>
                                    <textarea name="exhibitor_card[description][ar]" rows="2"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('exhibitor_card.description.ar', data_get($exhibitorCard, 'description.ar')) }}</textarea>
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('CTA Label (EN)') }}</label>
                                    <input type="text" name="exhibitor_card[cta_label][en]"
                                        value="{{ old('exhibitor_card.cta_label.en', data_get($exhibitorCard, 'cta_label.en')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('CTA Label (AR)') }}</label>
                                    <input type="text" name="exhibitor_card[cta_label][ar]"
                                        value="{{ old('exhibitor_card.cta_label.ar', data_get($exhibitorCard, 'cta_label.ar')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-dashed border-indigo-200 bg-indigo-50/30 p-4 space-y-4" data-node-group>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ __('Exhibitor multi-step form') }}</h3>
                                    <p class="text-s text-gray-500">{{ __('Capture both steps using the skeleton layout.') }}</p>
                                </div>
                                <button type="button" class="text-s font-semibold text-indigo-700" data-node-trigger="exhibitor-form-meta">
                                    {{ __('Edit header') }}
                                </button>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-white p-4 space-y-4 hidden" data-node-panel="exhibitor-form-meta">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Form title (EN)') }}</label>
                                        <input type="text" name="exhibitor_form[title][en]"
                                            value="{{ old('exhibitor_form.title.en', data_get($exhibitorForm, 'title.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Form title (AR)') }}</label>
                                        <input type="text" name="exhibitor_form[title][ar]"
                                            value="{{ old('exhibitor_form.title.ar', data_get($exhibitorForm, 'title.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Step one label (EN)') }}</label>
                                        <input type="text" name="exhibitor_form[step_one][en]"
                                            value="{{ old('exhibitor_form.step_one.en', data_get($exhibitorForm, 'step_one.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Step one label (AR)') }}</label>
                                        <input type="text" name="exhibitor_form[step_one][ar]"
                                            value="{{ old('exhibitor_form.step_one.ar', data_get($exhibitorForm, 'step_one.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Step two label (EN)') }}</label>
                                        <input type="text" name="exhibitor_form[step_two][en]"
                                            value="{{ old('exhibitor_form.step_two.en', data_get($exhibitorForm, 'step_two.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Step two label (AR)') }}</label>
                                        <input type="text" name="exhibitor_form[step_two][ar]"
                                            value="{{ old('exhibitor_form.step_two.ar', data_get($exhibitorForm, 'step_two.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Next CTA (EN)') }}</label>
                                        <input type="text" name="exhibitor_form[cta_next][en]"
                                            value="{{ old('exhibitor_form.cta_next.en', data_get($exhibitorForm, 'cta_next.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Next CTA (AR)') }}</label>
                                        <input type="text" name="exhibitor_form[cta_next][ar]"
                                            value="{{ old('exhibitor_form.cta_next.ar', data_get($exhibitorForm, 'cta_next.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Submit CTA (EN)') }}</label>
                                        <input type="text" name="exhibitor_form[cta_submit][en]"
                                            value="{{ old('exhibitor_form.cta_submit.en', data_get($exhibitorForm, 'cta_submit.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Submit CTA (AR)') }}</label>
                                        <input type="text" name="exhibitor_form[cta_submit][ar]"
                                            value="{{ old('exhibitor_form.cta_submit.ar', data_get($exhibitorForm, 'cta_submit.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4" data-node-group>
                                <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Step one fields') }}</p>
                                @foreach ($exhibitorFieldsStepOne as $index => $field)
                                    <div class="rounded-xl border border-gray-200 bg-white p-3">
                                        <button type="button" class="flex w-full items-center justify-between text-left text-sm" data-node-trigger="ex1-field-{{ $index }}">
                                            <div>
                                                <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Field') }} #{{ $loop->iteration }}</p>
                                                <p class="font-semibold text-gray-900">{{ data_get($field, 'label.en') }}</p>
                                                <p class="text-s text-gray-500">{{ strtoupper($field['type'] ?? 'text') }}</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M6 9l6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <div class="mt-3 space-y-3 hidden" data-node-panel="ex1-field-{{ $index }}">
                                            <input type="hidden" name="exhibitor_form[fields_step_one][{{ $index }}][name]" value="{{ $field['name'] }}">
                                            <input type="hidden" name="exhibitor_form[fields_step_one][{{ $index }}][type]" value="{{ $field['type'] }}">
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Label (EN)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_one][{{ $index }}][label][en]"
                                                    value="{{ old("exhibitor_form.fields_step_one.$index.label.en", data_get($field, 'label.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Label (AR)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_one][{{ $index }}][label][ar]"
                                                    value="{{ old("exhibitor_form.fields_step_one.$index.label.ar", data_get($field, 'label.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Placeholder (EN)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_one][{{ $index }}][placeholder][en]"
                                                    value="{{ old("exhibitor_form.fields_step_one.$index.placeholder.en", data_get($field, 'placeholder.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Placeholder (AR)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_one][{{ $index }}][placeholder][ar]"
                                                    value="{{ old("exhibitor_form.fields_step_one.$index.placeholder.ar", data_get($field, 'placeholder.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Hint (EN)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_one][{{ $index }}][hint][en]"
                                                    value="{{ old("exhibitor_form.fields_step_one.$index.hint.en", data_get($field, 'hint.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Hint (AR)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_one][{{ $index }}][hint][ar]"
                                                    value="{{ old("exhibitor_form.fields_step_one.$index.hint.ar", data_get($field, 'hint.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-4" data-node-group>
                                <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Step two fields') }}</p>
                                @foreach ($exhibitorFieldsStepTwo as $index => $field)
                                    <div class="rounded-xl border border-gray-200 bg-white p-3">
                                        <button type="button" class="flex w-full items-center justify-between text-left text-sm" data-node-trigger="ex2-field-{{ $index }}">
                                            <div>
                                                <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Field') }} #{{ $loop->iteration }}</p>
                                                <p class="font-semibold text-gray-900">{{ data_get($field, 'label.en') }}</p>
                                                <p class="text-s text-gray-500">{{ strtoupper($field['type'] ?? 'text') }}</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M6 9l6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <div class="mt-3 space-y-3 hidden" data-node-panel="ex2-field-{{ $index }}">
                                            <input type="hidden" name="exhibitor_form[fields_step_two][{{ $index }}][name]" value="{{ $field['name'] }}">
                                            <input type="hidden" name="exhibitor_form[fields_step_two][{{ $index }}][type]" value="{{ $field['type'] }}">
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Label (EN)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_two][{{ $index }}][label][en]"
                                                    value="{{ old("exhibitor_form.fields_step_two.$index.label.en", data_get($field, 'label.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Label (AR)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_two][{{ $index }}][label][ar]"
                                                    value="{{ old("exhibitor_form.fields_step_two.$index.label.ar", data_get($field, 'label.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Placeholder (EN)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_two][{{ $index }}][placeholder][en]"
                                                    value="{{ old("exhibitor_form.fields_step_two.$index.placeholder.en", data_get($field, 'placeholder.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Placeholder (AR)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_two][{{ $index }}][placeholder][ar]"
                                                    value="{{ old("exhibitor_form.fields_step_two.$index.placeholder.ar", data_get($field, 'placeholder.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Hint (EN)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_two][{{ $index }}][hint][en]"
                                                    value="{{ old("exhibitor_form.fields_step_two.$index.hint.en", data_get($field, 'hint.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Hint (AR)') }}</label>
                                                <input type="text" name="exhibitor_form[fields_step_two][{{ $index }}][hint][ar]"
                                                    value="{{ old("exhibitor_form.fields_step_two.$index.hint.ar", data_get($field, 'hint.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4" data-node-group>
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Icon pathway') }}</h2>
                        <div class="rounded-xl border border-gray-200 p-4 bg-gradient-to-br from-gray-50 to-white space-y-3">
                            <button type="button" class="w-full text-left" data-node-trigger="icon-card">
                                <p class="text-s uppercase font-semibold text-emerald-700">{{ __('Card block') }}</p>
                                <p class="text-lg font-bold text-gray-900">{{ data_get($iconCard, 'title.en') }}</p>
                                <p class="text-sm text-gray-600">{{ data_get($iconCard, 'description.en') }}</p>
                            </button>
                            <div class="space-y-4 hidden" data-node-panel="icon-card">
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (EN)') }}</label>
                                    <input type="text" name="icon_card[title][en]"
                                        value="{{ old('icon_card.title.en', data_get($iconCard, 'title.en')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (AR)') }}</label>
                                    <input type="text" name="icon_card[title][ar]"
                                        value="{{ old('icon_card.title.ar', data_get($iconCard, 'title.ar')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (EN)') }}</label>
                                    <textarea name="icon_card[description][en]" rows="2"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('icon_card.description.en', data_get($iconCard, 'description.en')) }}</textarea>
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (AR)') }}</label>
                                    <textarea name="icon_card[description][ar]" rows="2"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('icon_card.description.ar', data_get($iconCard, 'description.ar')) }}</textarea>
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('CTA Label (EN)') }}</label>
                                    <input type="text" name="icon_card[cta_label][en]"
                                        value="{{ old('icon_card.cta_label.en', data_get($iconCard, 'cta_label.en')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('CTA Label (AR)') }}</label>
                                    <input type="text" name="icon_card[cta_label][ar]"
                                        value="{{ old('icon_card.cta_label.ar', data_get($iconCard, 'cta_label.ar')) }}"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-dashed border-purple-200 bg-purple-50/30 p-4 space-y-4" data-node-group>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ __('Icon multi-step form') }}</h3>
                                    <p class="text-s text-gray-500">{{ __('Capture both steps using the skeleton layout.') }}</p>
                                </div>
                                <button type="button" class="text-s font-semibold text-purple-700" data-node-trigger="icon-form-meta">
                                    {{ __('Edit header') }}
                                </button>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-white p-4 space-y-4 hidden" data-node-panel="icon-form-meta">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Form title (EN)') }}</label>
                                        <input type="text" name="icon_form[title][en]"
                                            value="{{ old('icon_form.title.en', data_get($iconForm, 'title.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Form title (AR)') }}</label>
                                        <input type="text" name="icon_form[title][ar]"
                                            value="{{ old('icon_form.title.ar', data_get($iconForm, 'title.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Step one label (EN)') }}</label>
                                        <input type="text" name="icon_form[step_one][en]"
                                            value="{{ old('icon_form.step_one.en', data_get($iconForm, 'step_one.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Step one label (AR)') }}</label>
                                        <input type="text" name="icon_form[step_one][ar]"
                                            value="{{ old('icon_form.step_one.ar', data_get($iconForm, 'step_one.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Step two label (EN)') }}</label>
                                        <input type="text" name="icon_form[step_two][en]"
                                            value="{{ old('icon_form.step_two.en', data_get($iconForm, 'step_two.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Step two label (AR)') }}</label>
                                        <input type="text" name="icon_form[step_two][ar]"
                                            value="{{ old('icon_form.step_two.ar', data_get($iconForm, 'step_two.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Next CTA (EN)') }}</label>
                                        <input type="text" name="icon_form[cta_next][en]"
                                            value="{{ old('icon_form.cta_next.en', data_get($iconForm, 'cta_next.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Next CTA (AR)') }}</label>
                                        <input type="text" name="icon_form[cta_next][ar]"
                                            value="{{ old('icon_form.cta_next.ar', data_get($iconForm, 'cta_next.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Back CTA (EN)') }}</label>
                                        <input type="text" name="icon_form[cta_back][en]"
                                            value="{{ old('icon_form.cta_back.en', data_get($iconForm, 'cta_back.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Back CTA (AR)') }}</label>
                                        <input type="text" name="icon_form[cta_back][ar]"
                                            value="{{ old('icon_form.cta_back.ar', data_get($iconForm, 'cta_back.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Submit CTA (EN)') }}</label>
                                        <input type="text" name="icon_form[cta_submit][en]"
                                            value="{{ old('icon_form.cta_submit.en', data_get($iconForm, 'cta_submit.en')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Submit CTA (AR)') }}</label>
                                        <input type="text" name="icon_form[cta_submit][ar]"
                                            value="{{ old('icon_form.cta_submit.ar', data_get($iconForm, 'cta_submit.ar')) }}"
                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4" data-node-group>
                                <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Step one fields') }}</p>
                                @foreach ($iconFieldsStepOne as $index => $field)
                                    <div class="rounded-xl border border-gray-200 bg-white p-3">
                                        <button type="button" class="flex w-full items-center justify-between text-left text-sm" data-node-trigger="ic1-field-{{ $index }}">
                                            <div>
                                                <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Field') }} #{{ $loop->iteration }}</p>
                                                <p class="font-semibold text-gray-900">{{ data_get($field, 'label.en') }}</p>
                                                <p class="text-s text-gray-500">{{ strtoupper($field['type'] ?? 'text') }}</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M6 9l6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <div class="mt-3 space-y-3 hidden" data-node-panel="ic1-field-{{ $index }}">
                                            <input type="hidden" name="icon_form[fields_step_one][{{ $index }}][name]" value="{{ $field['name'] }}">
                                            <input type="hidden" name="icon_form[fields_step_one][{{ $index }}][type]" value="{{ $field['type'] }}">
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Label (EN)') }}</label>
                                                <input type="text" name="icon_form[fields_step_one][{{ $index }}][label][en]"
                                                    value="{{ old("icon_form.fields_step_one.$index.label.en", data_get($field, 'label.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Label (AR)') }}</label>
                                                <input type="text" name="icon_form[fields_step_one][{{ $index }}][label][ar]"
                                                    value="{{ old("icon_form.fields_step_one.$index.label.ar", data_get($field, 'label.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Placeholder (EN)') }}</label>
                                                <input type="text" name="icon_form[fields_step_one][{{ $index }}][placeholder][en]"
                                                    value="{{ old("icon_form.fields_step_one.$index.placeholder.en", data_get($field, 'placeholder.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Placeholder (AR)') }}</label>
                                                <input type="text" name="icon_form[fields_step_one][{{ $index }}][placeholder][ar]"
                                                    value="{{ old("icon_form.fields_step_one.$index.placeholder.ar", data_get($field, 'placeholder.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Hint (EN)') }}</label>
                                                <input type="text" name="icon_form[fields_step_one][{{ $index }}][hint][en]"
                                                    value="{{ old("icon_form.fields_step_one.$index.hint.en", data_get($field, 'hint.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Hint (AR)') }}</label>
                                                <input type="text" name="icon_form[fields_step_one][{{ $index }}][hint][ar]"
                                                    value="{{ old("icon_form.fields_step_one.$index.hint.ar", data_get($field, 'hint.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-4" data-node-group>
                                <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Step two fields') }}</p>
                                @foreach ($iconFieldsStepTwo as $index => $field)
                                    <div class="rounded-xl border border-gray-200 bg-white p-3">
                                        <button type="button" class="flex w-full items-center justify-between text-left text-sm" data-node-trigger="ic2-field-{{ $index }}">
                                            <div>
                                                <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Field') }} #{{ $loop->iteration }}</p>
                                                <p class="font-semibold text-gray-900">{{ data_get($field, 'label.en') }}</p>
                                                <p class="text-s text-gray-500">{{ strtoupper($field['type'] ?? 'text') }}</p>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M6 9l6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <div class="mt-3 space-y-3 hidden" data-node-panel="ic2-field-{{ $index }}">
                                            <input type="hidden" name="icon_form[fields_step_two][{{ $index }}][name]" value="{{ $field['name'] }}">
                                            <input type="hidden" name="icon_form[fields_step_two][{{ $index }}][type]" value="{{ $field['type'] }}">
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Label (EN)') }}</label>
                                                <input type="text" name="icon_form[fields_step_two][{{ $index }}][label][en]"
                                                    value="{{ old("icon_form.fields_step_two.$index.label.en", data_get($field, 'label.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Label (AR)') }}</label>
                                                <input type="text" name="icon_form[fields_step_two][{{ $index }}][label][ar]"
                                                    value="{{ old("icon_form.fields_step_two.$index.label.ar", data_get($field, 'label.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Placeholder (EN)') }}</label>
                                                <input type="text" name="icon_form[fields_step_two][{{ $index }}][placeholder][en]"
                                                    value="{{ old("icon_form.fields_step_two.$index.placeholder.en", data_get($field, 'placeholder.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Placeholder (AR)') }}</label>
                                                <input type="text" name="icon_form[fields_step_two][{{ $index }}][placeholder][ar]"
                                                    value="{{ old("icon_form.fields_step_two.$index.placeholder.ar", data_get($field, 'placeholder.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Hint (EN)') }}</label>
                                                <input type="text" name="icon_form[fields_step_two][{{ $index }}][hint][en]"
                                                    value="{{ old("icon_form.fields_step_two.$index.hint.en", data_get($field, 'hint.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Hint (AR)') }}</label>
                                                <input type="text" name="icon_form[fields_step_two][{{ $index }}][hint][ar]"
                                                    value="{{ old("icon_form.fields_step_two.$index.hint.ar", data_get($field, 'hint.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 transition">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>{{ __('Save registration section') }}</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('[data-node-group]').forEach(group => {
            group.addEventListener('click', event => {
                const trigger = event.target.closest('[data-node-trigger]');
                if (!trigger) {
                    return;
                }
                const target = trigger.getAttribute('data-node-trigger');
                const panels = group.querySelectorAll('[data-node-panel]');
                panels.forEach(panel => {
                    if (panel.getAttribute('data-node-panel') === target) {
                        panel.classList.toggle('hidden');
                    } else if (!panel.closest('[data-node-panel="' + target + '"]')) {
                        panel.classList.add('hidden');
                    }
                });
            });
        });
    </script>
@endsection
