@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">{{ __('About section') }}</h1>
                <p class="text-sm text-gray-500">{{ __('Edit the mission block and goals for the landing page.') }}</p>
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
            $mission = old('mission', $content['mission'] ?? []);
            $missionParagraphs = $mission['paragraphs'] ?? [];
            $goals = old('goals', $content['goals'] ?? []);
        @endphp

        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4" data-node-group>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Mission block') }}</h2>
                        <p class="text-sm text-gray-500">{{ __('Inputs sit exactly where copy renders on the landing section.') }}</p>
                    </div>
                    <button type="button" class="text-s font-semibold text-emerald-700" data-node-trigger="mission-card">
                        {{ __('Edit block') }}
                    </button>
                </div>

                <div class="rounded-2xl border border-emerald-200 bg-emerald-50/40 p-5 space-y-4 hidden" data-node-panel="mission-card">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Section title (EN)') }}</label>
                            <input type="text" name="title[en]" value="{{ old('title.en', data_get($title, 'en')) }}"
                                class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                        </div>
                        <div>
                            <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Section title (AR)') }}</label>
                            <input type="text" name="title[ar]" value="{{ old('title.ar', data_get($title, 'ar')) }}"
                                class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                        </div>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Mission title (EN)') }}</label>
                            <input type="text" name="mission[title][en]" value="{{ old('mission.title.en', data_get($mission, 'title.en')) }}"
                                class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                        </div>
                        <div>
                            <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Mission title (AR)') }}</label>
                            <input type="text" name="mission[title][ar]" value="{{ old('mission.title.ar', data_get($mission, 'title.ar')) }}"
                                class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                        </div>
                    </div>

                    <div class="space-y-3" data-collection="mission-paragraphs">
                        <div class="flex items-center justify-between">
                            <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Mission paragraphs') }}</p>
                            <button type="button" class="text-s font-semibold text-emerald-700" data-add-entry="mission">
                                {{ __('Add paragraph') }}
                            </button>
                        </div>
                        @foreach ($missionParagraphs as $index => $paragraph)
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <textarea name="mission[paragraphs][{{ $index }}][en]" rows="3" class="w-full rounded-lg border-gray-200 text-sm">{{ old("mission.paragraphs.$index.en", data_get($paragraph, 'en')) }}</textarea>
                                </div>
                                <div>
                                    <textarea name="mission[paragraphs][{{ $index }}][ar]" rows="3" class="w-full rounded-lg border-gray-200 text-sm">{{ old("mission.paragraphs.$index.ar", data_get($paragraph, 'ar')) }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Goals cards') }}</h2>
                        <p class="text-sm text-gray-500">{{ __('Each goal maps to a card in the two-column layout.') }}</p>
                    </div>
                    <button type="button" class="text-s font-semibold text-emerald-700" data-add-entry="goal">
                        {{ __('Add goal') }}
                    </button>
                </div>

                <div class="grid gap-4 md:grid-cols-2" data-collection="goals">
                    @foreach ($goals as $index => $goal)
                        <div class="rounded-xl border border-gray-200 bg-gradient-to-br from-gray-50 to-white p-4 space-y-3">
                            <div>
                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (EN)') }}</label>
                                <input type="text" name="goals[{{ $index }}][title][en]"
                                    value="{{ old("goals.$index.title.en", data_get($goal, 'title.en')) }}"
                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                            </div>
                            <div>
                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (AR)') }}</label>
                                <input type="text" name="goals[{{ $index }}][title][ar]"
                                    value="{{ old("goals.$index.title.ar", data_get($goal, 'title.ar')) }}"
                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                            </div>
                            <div>
                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (EN)') }}</label>
                                <textarea name="goals[{{ $index }}][description][en]" rows="2" class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old("goals.$index.description.en", data_get($goal, 'description.en')) }}</textarea>
                            </div>
                            <div>
                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (AR)') }}</label>
                                <textarea name="goals[{{ $index }}][description][ar]" rows="2" class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old("goals.$index.description.ar", data_get($goal, 'description.ar')) }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 transition">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>{{ __('Save about section') }}</span>
                </button>
            </div>
        </form>
    </div>

    <template id="mission-paragraph-template">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <textarea name="mission[paragraphs][__INDEX__][en]" rows="3" class="w-full rounded-lg border-gray-200 text-sm"></textarea>
            </div>
            <div>
                <textarea name="mission[paragraphs][__INDEX__][ar]" rows="3" class="w-full rounded-lg border-gray-200 text-sm"></textarea>
            </div>
        </div>
    </template>

    <template id="goal-template">
        <div class="rounded-xl border border-gray-200 bg-gradient-to-br from-gray-50 to-white p-4 space-y-3">
            <div>
                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (EN)') }}</label>
                <input type="text" name="goals[__INDEX__][title][en]" class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
            </div>
            <div>
                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (AR)') }}</label>
                <input type="text" name="goals[__INDEX__][title][ar]" class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
            </div>
            <div>
                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (EN)') }}</label>
                <textarea name="goals[__INDEX__][description][en]" rows="2" class="w-full mt-1 rounded-lg border-gray-200 text-sm"></textarea>
            </div>
            <div>
                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (AR)') }}</label>
                <textarea name="goals[__INDEX__][description][ar]" rows="2" class="w-full mt-1 rounded-lg border-gray-200 text-sm"></textarea>
            </div>
        </div>
    </template>

    <script>
        document.querySelectorAll('[data-node-group]').forEach(group => {
            group.addEventListener('click', event => {
                const trigger = event.target.closest('[data-node-trigger]');
                if (!trigger) return;
                const target = trigger.getAttribute('data-node-trigger');
                group.querySelectorAll('[data-node-panel]').forEach(panel => {
                    if (panel.getAttribute('data-node-panel') === target) {
                        panel.classList.toggle('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }
                });
            });
        });

        document.querySelectorAll('[data-add-entry]').forEach(button => {
            button.addEventListener('click', () => {
                const type = button.getAttribute('data-add-entry');
                const templateId = type === 'mission' ? '#mission-paragraph-template' : '#goal-template';
                const containerSelector = type === 'mission' ? '[data-collection="mission-paragraphs"]' : '[data-collection="goals"]';
                const container = document.querySelector(containerSelector);
                const template = document.querySelector(templateId);
                if (!container || !template) return;

                const uniqueIndex = Date.now().toString();
                const html = template.innerHTML.replace(/__INDEX__/g, uniqueIndex);
                container.insertAdjacentHTML('beforeend', html);
            });
        });
    </script>
@endsection
