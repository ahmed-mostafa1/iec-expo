@extends('layouts.public')

@section('content')
    @php
        $locale = app()->getLocale();
        $isRtl = $locale === 'ar';
        $dateRangeLabel = $dateFrom->toDateString().' - '.$dateTo->toDateString();
        $exportParams = [
            'locale' => $locale,
            'date_from' => $dateFrom->toDateString(),
            'date_to' => $dateTo->toDateString(),
        ];
        $labelClass = $isRtl
            ? 'text-xs font-bold text-white/[0.68]'
            : 'text-xs font-bold uppercase tracking-[0.14em] text-white/[0.68]';
        $smallLabelClass = $isRtl
            ? 'text-xs font-semibold text-white/[0.64]'
            : 'text-xs font-semibold uppercase tracking-[0.12em] text-white/[0.64]';
        $tableHeadClass = $isRtl
            ? 'text-xs text-white/[0.52]'
            : 'text-xs uppercase tracking-[0.12em] text-white/[0.52]';
        $reportOrder = ['acquisition', 'content', 'geography', 'technology', 'events'];

        $metricCards = [
            [
                'label' => __('analytics.metrics.active_users'),
                'value' => number_format($dashboard['totals']['active_users']),
                'accent' => '#9873AC',
            ],
            [
                'label' => __('analytics.metrics.sessions'),
                'value' => number_format($dashboard['totals']['sessions']),
                'accent' => '#00a181',
            ],
            [
                'label' => __('analytics.metrics.views'),
                'value' => number_format($dashboard['totals']['screen_page_views']),
                'accent' => '#d7a23a',
            ],
            [
                'label' => __('analytics.metrics.registrations'),
                'value' => number_format($dashboard['totals']['registrations']),
                'accent' => '#7b7ba7',
            ],
            [
                'label' => __('analytics.metrics.events'),
                'value' => number_format($dashboard['totals']['event_count']),
                'accent' => '#b544a4',
            ],
            [
                'label' => __('analytics.metrics.key_events'),
                'value' => number_format($dashboard['totals']['key_events'], 2),
                'accent' => '#6f86df',
            ],
            [
                'label' => __('analytics.metrics.engagement_rate'),
                'value' => number_format($dashboard['totals']['engagement_rate'], 2).'%',
                'accent' => '#5eead4',
            ],
            [
                'label' => __('analytics.metrics.avg_session'),
                'value' => number_format($dashboard['totals']['average_session_duration'], 1).__('analytics.units.seconds_short'),
                'accent' => '#d38abc',
            ],
        ];
    @endphp

    <section class="space-y-8">
        {{-- Hero Header --}}
        <section class="overflow-hidden rounded-2xl border border-white/[0.06] bg-[#0f0b16] shadow-2xl shadow-black/40">
            <div class="grid gap-6 border-b border-white/[0.06] bg-[linear-gradient(135deg,rgba(152,115,172,0.12),rgba(0,161,129,0.05)_42%,rgba(15,11,22,0)_78%)] p-6 lg:p-8">
                <div class="max-w-3xl">
                    <p class="{{ $isRtl ? 'text-sm font-bold text-[#d7b5ea]' : 'text-sm font-bold uppercase tracking-[0.18em] text-[#d7b5ea]' }}">
                        {{ __('analytics.eyebrow') }}
                    </p>
                    <h1 class="mt-3 text-3xl font-semibold leading-tight tracking-normal text-white sm:text-4xl">
                        {{ __('analytics.title') }}
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-relaxed text-white/[0.68]">
                        {{ __('analytics.description') }}
                    </p>
                </div>
            </div>

            <div class="grid gap-4 p-5 text-sm text-white/70 sm:grid-cols-2 lg:p-6 bg-white/[0.01]">
                <div class="flex items-center gap-3 rounded-lg border border-white/[0.06] bg-[#050208]/50 px-4 py-3">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#00a181]/20 text-[#00a181]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span>{{ __('analytics.range') }}: <span class="font-semibold text-white">{{ $dateRangeLabel }}</span></span>
                </div>
                @if ($dashboard['lastSync'])
                    <div class="flex items-center gap-3 rounded-lg border border-white/[0.06] bg-[#050208]/50 px-4 py-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#9873AC]/20 text-[#9873AC]">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span>
                            {{ __('analytics.last_sync') }}:
                            <span class="font-semibold text-white">
                                {{ $dashboard['lastSync']->started_at->format('Y-m-d H:i') }}
                                ({{ __("analytics.status.{$dashboard['lastSync']->status}") }})
                            </span>
                        </span>
                    </div>
                @endif
            </div>
        </section>

        {{-- Sticky Control & Nav Bar --}}
        <div class="sticky top-[64px] z-30 -mx-4 bg-[#050208]/80 backdrop-blur-xl border-y border-white/[0.06] shadow-lg shadow-black/20 sm:mx-0 sm:rounded-xl sm:border sm:top-[80px]">
            <div class="p-4 sm:px-6">
                <form method="GET" action="{{ route('public.analytics', ['locale' => $locale]) }}" class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex flex-col sm:flex-row gap-3 sm:items-center">
                        <div class="flex items-center gap-2">
                            <label class="shrink-0 {{ $smallLabelClass }}">{{ __('analytics.filters.from') }}</label>
                            <input id="date_from" name="date_from" type="date" value="{{ $dateFrom->toDateString() }}"
                                class="rounded-lg border-white/[0.12] bg-[#0f0b16] px-3 py-1.5 text-sm font-medium text-white shadow-sm [color-scheme:dark] transition focus:border-[#9873AC] focus:ring-[#9873AC]">
                        </div>
                        <div class="hidden h-px w-4 bg-white/10 sm:block"></div>
                        <div class="flex items-center gap-2">
                            <label class="shrink-0 {{ $smallLabelClass }}">{{ __('analytics.filters.to') }}</label>
                            <input id="date_to" name="date_to" type="date" value="{{ $dateTo->toDateString() }}"
                                class="rounded-lg border-white/[0.12] bg-[#0f0b16] px-3 py-1.5 text-sm font-medium text-white shadow-sm [color-scheme:dark] transition focus:border-[#9873AC] focus:ring-[#9873AC]">
                        </div>
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-[#9873AC] px-4 py-1.5 text-sm font-bold text-white shadow-lg shadow-[#9873AC]/20 transition hover:bg-[#ad88c1] focus:outline-none focus:ring-2 focus:ring-[#e2b7ff] focus:ring-offset-2 focus:ring-offset-[#050208]">
                            {{ __('analytics.filters.apply') }}
                        </button>
                    </div>

                    {{-- Quick Report Nav --}}
                    <nav class="flex gap-2 overflow-x-auto pb-1 lg:pb-0 hide-scrollbar" aria-label="{{ __('analytics.reports.daily') }}">
                        <style>
                            .hide-scrollbar::-webkit-scrollbar { display: none; }
                            .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
                        </style>
                        @foreach ($reportOrder as $report)
                            <a href="#report-{{ $report }}"
                                class="whitespace-nowrap rounded-lg border border-transparent px-3 py-1.5 text-sm font-semibold text-white/[0.68] transition hover:bg-white/[0.06] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#c69be4]">
                                {{ $reports[$report] }}
                            </a>
                        @endforeach
                    </nav>
                </form>
            </div>
        </div>

        @if ($dashboard['series']['labels'] === [])
            <div class="rounded-xl border border-amber-300/20 bg-amber-400/10 p-5 text-sm font-medium text-amber-100 flex items-center gap-3 shadow-lg">
                <svg class="h-5 w-5 text-amber-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                </svg>
                {{ __('analytics.empty_range') }}
            </div>
        @endif

        {{-- KPI Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($metricCards as $card)
                <div class="relative overflow-hidden rounded-xl border border-white/[0.06] bg-[#0f0b16] p-5 shadow-xl shadow-black/20 transition hover:bg-white/[0.03]">
                    <div class="absolute {{ $isRtl ? 'right-0' : 'left-0' }} top-0 h-full w-1" style="background-color: {{ $card['accent'] }}"></div>
                    <div class="min-w-0">
                        <p class="{{ $labelClass }}">{{ $card['label'] }}</p>
                        <p class="mt-2 text-3xl font-semibold tracking-normal text-white">{{ $card['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Main Chart --}}
        <section class="rounded-xl border border-white/[0.06] bg-[#0f0b16] p-5 shadow-2xl shadow-black/30 lg:p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold tracking-normal text-white">{{ __('analytics.charts.traffic') }}</h2>
                    <p class="mt-1 text-sm leading-6 text-white/[0.52]">{{ __('analytics.charts.traffic_hint') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="rounded-lg border border-white/[0.08] bg-white/[0.02] px-3 py-1.5 text-xs font-semibold text-white/[0.64]">{{ $dateRangeLabel }}</span>
                    <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}"
                        class="inline-flex items-center justify-center rounded-lg border border-white/[0.12] bg-white/[0.04] p-1.5 text-white/[0.82] transition hover:border-[#c69be4]/60 hover:bg-white/[0.08] focus:outline-none focus:ring-2 focus:ring-[#e2b7ff] focus:ring-offset-2 focus:ring-offset-[#0f0b16]"
                        title="{{ __('analytics.export_csv') }}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3v11m0 0 4-4m-4 4-4-4M5 19h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="mt-6 h-[24rem] w-full">
                <canvas id="trafficChart"></canvas>
            </div>
        </section>

        {{-- Tables Grid --}}
        <div class="grid gap-6 xl:grid-cols-2">
            @foreach ($reportOrder as $report)
                @php
                    $maxUsers = collect($dashboard['reports'][$report])->max('active_users');
                    $maxUsers = $maxUsers > 0 ? $maxUsers : 1;
                @endphp
                <section id="report-{{ $report }}" class="scroll-mt-40 overflow-hidden rounded-xl border border-white/[0.06] bg-[#0f0b16] shadow-xl shadow-black/30">
                    <div class="flex items-center justify-between gap-4 border-b border-white/[0.06] bg-white/[0.02] px-5 py-4">
                        <h2 class="text-lg font-semibold tracking-normal text-white">{{ $reports[$report] }}</h2>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => $report]) }}"
                            class="inline-flex items-center rounded-lg border border-white/[0.12] bg-white/[0.04] px-3 py-1.5 text-xs font-bold text-white/[0.82] transition hover:border-white/[0.2] hover:bg-white/[0.08] focus:outline-none focus:ring-2 focus:ring-[#c69be4]">
                            <svg class="{{ $isRtl ? 'ms-1.5' : 'me-1.5' }} h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 4v10m0 0 3-3m-3 3-3-3M5 20h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ __('analytics.export') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm whitespace-nowrap">
                            <thead class="{{ $tableHeadClass }} bg-[#050208]/40">
                                <tr class="border-b border-white/[0.06]">
                                    <th class="px-5 py-4 text-start font-bold">{{ __('analytics.table.dimension') }}</th>
                                    <th class="px-5 py-4 text-end font-bold">{{ __('analytics.table.users') }}</th>
                                    <th class="px-5 py-4 text-end font-bold">{{ __('analytics.table.sessions') }}</th>
                                    <th class="px-5 py-4 text-end font-bold">{{ $report === 'events' ? __('analytics.table.events') : __('analytics.table.views') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/[0.04]">
                                @forelse ($dashboard['reports'][$report] as $row)
                                    @php
                                        $percentage = ($row['active_users'] / $maxUsers) * 100;
                                    @endphp
                                    <tr class="group transition hover:bg-white/[0.02] relative z-0">
                                        <td class="max-w-[200px] sm:max-w-xs px-5 py-4 font-medium text-white/[0.86] relative">
                                            {{-- Progress Bar Background --}}
                                            <div class="absolute inset-y-1 {{ $isRtl ? 'right-1' : 'left-1' }} bg-[#9873AC]/15 rounded-md -z-10 transition-all duration-500" style="width: calc({{ $percentage }}% - 8px);"></div>
                                            <span class="truncate block" title="{{ $row['label'] }}">{{ $row['label'] }}</span>
                                        </td>
                                        <td class="px-5 py-4 text-end font-semibold text-white">{{ number_format($row['active_users']) }}</td>
                                        <td class="px-5 py-4 text-end font-medium text-white/[0.68]">{{ number_format($row['sessions']) }}</td>
                                        <td class="px-5 py-4 text-end font-medium text-white/[0.68]">
                                            {{ number_format($report === 'events' ? $row['event_count'] : $row['screen_page_views']) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-12 text-center">
                                            <div class="inline-flex flex-col items-center justify-center text-white/[0.4]">
                                                <svg class="mb-3 h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <span class="text-sm font-medium">{{ __('analytics.no_rows') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            @endforeach
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const renderCharts = () => {
                if (!window.Chart) {
                    window.setTimeout(renderCharts, 80);
                    return;
                }

                const chartElement = document.getElementById('trafficChart');

                if (!chartElement) {
                    return;
                }

                const series = @json($dashboard['series']);
                const isRtl = @json($isRtl);
                const chartText = '#f8f3ff';
                const mutedText = 'rgba(255, 255, 255, 0.58)';
                const grid = 'rgba(255, 255, 255, 0.04)';

                new window.Chart(chartElement, {
                    type: 'line',
                    data: {
                        labels: series.labels,
                        datasets: [{
                                label: @json(__('analytics.metrics.active_users')),
                                data: series.active_users,
                                borderColor: '#9873AC',
                                backgroundColor: 'rgba(152, 115, 172, 0.16)',
                                pointBackgroundColor: '#9873AC',
                                pointBorderColor: '#0f0b16',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                                tension: 0.4,
                            },
                            {
                                label: @json(__('analytics.metrics.sessions')),
                                data: series.sessions,
                                borderColor: '#00a181',
                                backgroundColor: 'rgba(0, 161, 129, 0.08)',
                                pointBackgroundColor: '#00a181',
                                pointBorderColor: '#0f0b16',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.4,
                            },
                            {
                                label: @json(__('analytics.metrics.views')),
                                data: series.screen_page_views,
                                borderColor: '#d7a23a',
                                backgroundColor: 'rgba(215, 162, 58, 0.08)',
                                pointBackgroundColor: '#d7a23a',
                                pointBorderColor: '#0f0b16',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.4,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                rtl: isRtl,
                                textDirection: isRtl ? 'rtl' : 'ltr',
                                labels: {
                                    color: chartText,
                                    boxWidth: 12,
                                    boxHeight: 12,
                                    usePointStyle: true,
                                    padding: 24,
                                    font: {
                                        size: 13,
                                        family: 'inherit'
                                    }
                                },
                            },
                            tooltip: {
                                rtl: isRtl,
                                textDirection: isRtl ? 'rtl' : 'ltr',
                                backgroundColor: 'rgba(5, 2, 8, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(255, 255, 255, 0.1)',
                                borderWidth: 1,
                                padding: 12,
                                boxPadding: 6,
                                usePointStyle: true,
                                cornerRadius: 8,
                            },
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: mutedText,
                                    maxRotation: 0,
                                    autoSkip: true,
                                    font: { family: 'inherit' }
                                },
                                grid: {
                                    color: grid,
                                    drawBorder: false,
                                },
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: mutedText,
                                    precision: 0,
                                    font: { family: 'inherit' }
                                },
                                border: {
                                    dash: [4, 4],
                                    display: false
                                },
                                grid: {
                                    color: grid,
                                },
                            },
                        },
                    },
                });
            };

            renderCharts();
        });
    </script>
@endsection