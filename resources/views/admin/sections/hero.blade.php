@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">{{ __('Hero section') }}</h1>
                <p class="text-sm text-gray-500">{{ __('Edit the hero stats that appear on the landing page.') }}</p>
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

        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @php
                $stats = old('stats', $content['stats'] ?? []);
            @endphp

            <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="flex flex-col gap-2 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Stats strip') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('Click a stat card to edit its bilingual copy and number inline.') }}</p>
                </div>

                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4" data-node-group>
                    @foreach ($stats as $index => $stat)
                        <div class="rounded-xl border border-gray-200 bg-gradient-to-br from-gray-50 to-white p-4 space-y-3">
                            <button type="button"
                                class="w-full rounded-lg bg-white border border-emerald-100 px-3 py-2 text-left transition hover:border-emerald-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500"
                                data-node-trigger="stat-{{ $index }}">
                                <div class="text-s font-semibold text-emerald-700 uppercase tracking-wide">
                                    {{ __('Stat card') }} #{{ $loop->iteration }}
                                </div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">
                                    {{ $stat['value'] ?? 0 }}<span class="text-base text-gray-500">{{ $stat['suffix'] ?? '' }}</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ data_get($stat, 'label.en') }}
                                </div>
                            </button>

                            <div class="space-y-3 rounded-lg border border-gray-100 bg-white p-3 text-sm hidden" data-node-panel="stat-{{ $index }}">
                                <input type="hidden" name="stats[{{ $index }}][id]" value="{{ $stat['id'] ?? ('stat_' . $index) }}">
                                <div class="grid gap-2">
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Value') }}</label>
                                    <input type="number" name="stats[{{ $index }}][value]"
                                        value="{{ old('stats.' . $index . '.value', $stat['value'] ?? 0) }}"
                                        class="rounded-lg border-gray-200 text-sm" min="0">
                                </div>
                                <div class="grid gap-2">
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Suffix') }}</label>
                                    <input type="text" name="stats[{{ $index }}][suffix]"
                                        value="{{ old('stats.' . $index . '.suffix', $stat['suffix'] ?? '') }}"
                                        class="rounded-lg border-gray-200 text-sm">
                                </div>
                                <div class="grid gap-2">
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('English label') }}</label>
                                    <input type="text" name="stats[{{ $index }}][label][en]"
                                        value="{{ old('stats.' . $index . '.label.en', data_get($stat, 'label.en')) }}"
                                        class="rounded-lg border-gray-200 text-sm">
                                </div>
                                <div class="grid gap-2">
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Arabic label') }}</label>
                                    <input type="text" name="stats[{{ $index }}][label][ar]"
                                        value="{{ old('stats.' . $index . '.label.ar', data_get($stat, 'label.ar')) }}"
                                        class="rounded-lg border-gray-200 text-sm">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="flex items-center justify-end gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 transition">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>{{ __('Save hero section') }}</span>
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
                group.querySelectorAll('[data-node-panel]').forEach(panel => {
                    if (panel.getAttribute('data-node-panel') === target) {
                        panel.classList.toggle('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }
                });
            });
        });
    </script>
@endsection
