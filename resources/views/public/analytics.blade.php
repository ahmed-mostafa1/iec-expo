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
            ? 'text-xs font-bold text-white/[0.58]'
            : 'text-xs font-bold uppercase tracking-[0.14em] text-white/[0.58]';
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
                'dot' => 'bg-[#9873AC]',
            ],
            [
                'label' => __('analytics.metrics.sessions'),
                'value' => number_format($dashboard['totals']['sessions']),
                'accent' => '#00a181',
                'dot' => 'bg-[#00a181]',
            ],
            [
                'label' => __('analytics.metrics.views'),
                'value' => number_format($dashboard['totals']['screen_page_views']),
                'accent' => '#d7a23a',
                'dot' => 'bg-[#d7a23a]',
            ],
            [
                'label' => __('analytics.metrics.registrations'),
                'value' => number_format($dashboard['totals']['registrations']),
                'accent' => '#7b7ba7',
                'dot' => 'bg-[#7b7ba7]',
            ],
            [
                'label' => __('analytics.metrics.events'),
                'value' => number_format($dashboard['totals']['event_count']),
                'accent' => '#b544a4',
                'dot' => 'bg-[#b544a4]',
            ],
            [
                'label' => __('analytics.metrics.key_events'),
                'value' => number_format($dashboard['totals']['key_events'], 2),
                'accent' => '#6f86df',
                'dot' => 'bg-[#6f86df]',
            ],
            [
                'label' => __('analytics.metrics.engagement_rate'),
                'value' => number_format($dashboard['totals']['engagement_rate'], 2).'%',
                'accent' => '#5eead4',
                'dot' => 'bg-[#5eead4]',
            ],
            [
                'label' => __('analytics.metrics.avg_session'),
                'value' => number_format($dashboard['totals']['average_session_duration'], 1).__('analytics.units.seconds_short'),
                'accent' => '#d38abc',
                'dot' => 'bg-[#d38abc]',
            ],
        ];
    @endphp

    <section class="space-y-6">
        <section class="overflow-hidden rounded-lg border border-white/10 bg-[#0f0b16] shadow-xl shadow-black/20">
            <div class="grid gap-6 border-b border-white/10 bg-[linear-gradient(135deg,rgba(152,115,172,0.16),rgba(0,161,129,0.08)_42%,rgba(15,11,22,0)_78%)] p-5 lg:grid-cols-[minmax(0,1fr)_360px] lg:p-7">
                <div class="max-w-3xl">
                    <p class="{{ $isRtl ? 'text-sm font-bold text-[#d7b5ea]' : 'text-sm font-bold uppercase tracking-[0.18em] text-[#d7b5ea]' }}">
                        {{ __('analytics.eyebrow') }}
                    </p>
                    <h1 class="mt-3 text-3xl font-semibold leading-tight tracking-normal text-white sm:text-4xl">
                        {{ __('analytics.title') }}
                    </h1>
                    <p class="mt-3 max-w-2xl text-base leading-7 text-white/[0.68]">
                        {{ __('analytics.description') }}
                    </p>
                </div>

                <form method="GET" action="{{ route('public.analytics', ['locale' => $locale]) }}"
                    class="rounded-lg border border-white/10 bg-black/20 p-4">
                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                        <label class="block">
                            <span class="{{ $smallLabelClass }}">{{ __('analytics.filters.from') }}</span>
                            <input id="date_from" name="date_from" type="date" value="{{ $dateFrom->toDateString() }}"
                                class="mt-2 w-full rounded-md border-white/10 bg-[#07040b] text-sm font-semibold text-white shadow-sm [color-scheme:dark] focus:border-[#c69be4] focus:ring-[#c69be4]">
                        </label>
                        <label class="block">
                            <span class="{{ $smallLabelClass }}">{{ __('analytics.filters.to') }}</span>
                            <input id="date_to" name="date_to" type="date" value="{{ $dateTo->toDateString() }}"
                                class="mt-2 w-full rounded-md border-white/10 bg-[#07040b] text-sm font-semibold text-white shadow-sm [color-scheme:dark] focus:border-[#c69be4] focus:ring-[#c69be4]">
                        </label>
                    </div>

                    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-md bg-[#9873AC] px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-black/20 transition hover:bg-[#ad88c1] focus:outline-none focus:ring-2 focus:ring-[#e2b7ff] focus:ring-offset-2 focus:ring-offset-[#0f0b16]">
                            <svg class="{{ $isRtl ? 'ms-2' : 'me-2' }} h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 7h16M7 12h10M10 17h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            {{ __('analytics.filters.apply') }}
                        </button>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}"
                            class="inline-flex items-center justify-center rounded-md border border-white/[0.12] bg-white/[0.05] px-4 py-2.5 text-sm font-bold text-white/[0.86] transition hover:border-[#c69be4]/60 hover:bg-white/[0.08] focus:outline-none focus:ring-2 focus:ring-[#e2b7ff] focus:ring-offset-2 focus:ring-offset-[#0f0b16]">
                            <svg class="{{ $isRtl ? 'ms-2' : 'me-2' }} h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 3v11m0 0 4-4m-4 4-4-4M5 19h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ __('analytics.export_csv') }}
                        </a>
                    </div>
                </form>
            </div>

            <div class="grid gap-3 p-5 text-sm text-white/70 sm:grid-cols-2 lg:p-6">
                <div class="flex items-center gap-3 rounded-md border border-white/10 bg-white/[0.035] px-4 py-3">
                    <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-[#00a181]"></span>
                    <span>{{ __('analytics.range') }}: <span class="font-semibold text-white">{{ $dateRangeLabel }}</span></span>
                </div>
                @if ($dashboard['lastSync'])
                    <div class="flex items-center gap-3 rounded-md border border-white/10 bg-white/[0.035] px-4 py-3">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-[#9873AC]"></span>
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

        @if ($dashboard['series']['labels'] === [])
            <div class="rounded-lg border border-amber-300/30 bg-amber-400/10 p-4 text-sm font-medium text-amber-100">
                {{ __('analytics.empty_range') }}
            </div>
        @endif

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($metricCards as $card)
                <div class="{{ $isRtl ? 'border-r-4' : 'border-l-4' }} rounded-lg border border-white/10 bg-[#0f0b16] p-4 shadow-lg shadow-black/[0.15] transition hover:bg-[#14101d]"
                    style="{{ $isRtl ? 'border-right-color' : 'border-left-color' }}: {{ $card['accent'] }}">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="{{ $labelClass }}">{{ $card['label'] }}</p>
                            <p class="mt-2 text-3xl font-semibold tracking-normal text-white">{{ $card['value'] }}</p>
                        </div>
                        <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full {{ $card['dot'] }}"></span>
                    </div>
                </div>
            @endforeach
        </div>

        <section class="rounded-lg border border-white/10 bg-[#0f0b16] p-5 shadow-xl shadow-black/20 lg:p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold tracking-normal text-white">{{ __('analytics.charts.traffic') }}</h2>
                    <p class="mt-1 text-sm leading-6 text-white/[0.52]">{{ __('analytics.charts.traffic_hint') }}</p>
                </div>
                <span class="rounded-md border border-white/10 bg-white/[0.04] px-3 py-1.5 text-sm font-semibold text-white/[0.64]">{{ $dateRangeLabel }}</span>
            </div>
            <div class="mt-5 h-[22rem] rounded-md border border-white/10 bg-[#090511] p-3">
                <canvas id="trafficChart" class="h-full w-full"></canvas>
            </div>
        </section>

        <nav class="sticky top-24 z-20 rounded-lg border border-white/10 bg-[#0b0610]/[0.92] p-2 shadow-xl shadow-black/30 backdrop-blur" aria-label="{{ __('analytics.reports.daily') }}">
            <div class="flex gap-2 overflow-x-auto">
                @foreach ($reportOrder as $report)
                    <a href="#report-{{ $report }}"
                        class="whitespace-nowrap rounded-md border border-transparent px-3.5 py-2 text-sm font-bold text-white/[0.68] transition hover:border-white/10 hover:bg-white/[0.06] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#c69be4]">
                        {{ $reports[$report] }}
                    </a>
                @endforeach
            </div>
        </nav>

        <div class="grid gap-4 xl:grid-cols-2">
            @foreach ($reportOrder as $report)
                <section id="report-{{ $report }}" class="scroll-mt-36 overflow-hidden rounded-lg border border-white/10 bg-[#0f0b16] shadow-xl shadow-black/20">
                    <div class="flex items-center justify-between gap-4 border-b border-white/10 bg-white/[0.035] px-5 py-4">
                        <h2 class="text-lg font-semibold tracking-normal text-white">{{ $reports[$report] }}</h2>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => $report]) }}"
                            class="inline-flex items-center rounded-md border border-white/10 bg-white/[0.04] px-3 py-1.5 text-xs font-bold text-white/[0.82] transition hover:border-[#c69be4]/60 hover:bg-white/[0.08] focus:outline-none focus:ring-2 focus:ring-[#c69be4]">
                            <svg class="{{ $isRtl ? 'ms-1.5' : 'me-1.5' }} h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 4v10m0 0 3-3m-3 3-3-3M5 20h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ __('analytics.export') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="{{ $tableHeadClass }} bg-white/[0.025]">
                                <tr class="border-b border-white/10">
                                    <th class="px-5 py-3 text-start font-bold">{{ __('analytics.table.dimension') }}</th>
                                    <th class="px-5 py-3 text-end font-bold">{{ __('analytics.table.users') }}</th>
                                    <th class="px-5 py-3 text-end font-bold">{{ __('analytics.table.sessions') }}</th>
                                    <th class="px-5 py-3 text-end font-bold">{{ $report === 'events' ? __('analytics.table.events') : __('analytics.table.views') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse ($dashboard['reports'][$report] as $row)
                                    <tr class="transition hover:bg-white/[0.035]">
                                        <td class="max-w-xs px-5 py-4 font-medium text-white/[0.86]">
                                            <span class="break-words">{{ $row['label'] }}</span>
                                        </td>
                                        <td class="px-5 py-4 text-end font-semibold text-white/[0.76]">{{ number_format($row['active_users']) }}</td>
                                        <td class="px-5 py-4 text-end font-semibold text-white/[0.76]">{{ number_format($row['sessions']) }}</td>
                                        <td class="px-5 py-4 text-end font-semibold text-white/[0.76]">
                                            {{ number_format($report === 'events' ? $row['event_count'] : $row['screen_page_views']) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-10 text-center text-sm font-medium text-white/[0.52]">
                                            {{ __('analytics.no_rows') }}
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
                const grid = 'rgba(255, 255, 255, 0.08)';

                new window.Chart(chartElement, {
                    type: 'line',
                    data: {
                        labels: series.labels,
                        datasets: [{
                                label: @json(__('analytics.metrics.active_users')),
                                data: series.active_users,
                                borderColor: '#9873AC',
                                backgroundColor: 'rgba(152, 115, 172, 0.12)',
                                pointBackgroundColor: '#9873AC',
                                pointBorderColor: '#090511',
                                pointRadius: 3,
                                fill: true,
                                tension: 0.35,
                            },
                            {
                                label: @json(__('analytics.metrics.sessions')),
                                data: series.sessions,
                                borderColor: '#00a181',
                                backgroundColor: 'rgba(0, 161, 129, 0.08)',
                                pointBackgroundColor: '#00a181',
                                pointBorderColor: '#090511',
                                pointRadius: 3,
                                tension: 0.35,
                            },
                            {
                                label: @json(__('analytics.metrics.views')),
                                data: series.screen_page_views,
                                borderColor: '#d7a23a',
                                backgroundColor: 'rgba(215, 162, 58, 0.08)',
                                pointBackgroundColor: '#d7a23a',
                                pointBorderColor: '#090511',
                                pointRadius: 3,
                                tension: 0.35,
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
                                    boxWidth: 10,
                                    boxHeight: 10,
                                    usePointStyle: true,
                                    padding: 18,
                                },
                            },
                            tooltip: {
                                rtl: isRtl,
                                textDirection: isRtl ? 'rtl' : 'ltr',
                                backgroundColor: '#090512',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: '#9873AC',
                                borderWidth: 1,
                            },
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: mutedText,
                                    maxRotation: 0,
                                    autoSkip: true
                                },
                                grid: {
                                    color: grid
                                },
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: mutedText,
                                    precision: 0
                                },
                                grid: {
                                    color: grid
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
