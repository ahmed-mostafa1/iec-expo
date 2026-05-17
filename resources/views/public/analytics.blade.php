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
            ? 'text-xs font-bold text-white/50'
            : 'text-xs font-bold uppercase tracking-[0.2em] text-white/50';
        $smallLabelClass = $isRtl
            ? 'text-xs font-semibold text-white/[0.58]'
            : 'text-xs font-semibold uppercase tracking-[0.18em] text-white/[0.58]';
        $reportOrder = ['acquisition', 'content', 'geography', 'technology', 'events'];

        $metricCards = [
            [
                'label' => __('analytics.metrics.active_users'),
                'value' => number_format($dashboard['totals']['active_users']),
                'accent' => 'from-[#8b2bbd] to-[#b16ce2]',
            ],
            [
                'label' => __('analytics.metrics.sessions'),
                'value' => number_format($dashboard['totals']['sessions']),
                'accent' => 'from-[#006b5b] to-[#27b59b]',
            ],
            [
                'label' => __('analytics.metrics.views'),
                'value' => number_format($dashboard['totals']['screen_page_views']),
                'accent' => 'from-[#c28b28] to-[#f3c95d]',
            ],
            [
                'label' => __('analytics.metrics.registrations'),
                'value' => number_format($dashboard['totals']['registrations']),
                'accent' => 'from-[#32324f] to-[#7b7ba7]',
            ],
            [
                'label' => __('analytics.metrics.events'),
                'value' => number_format($dashboard['totals']['event_count']),
                'accent' => 'from-[#6c236f] to-[#b544a4]',
            ],
            [
                'label' => __('analytics.metrics.key_events'),
                'value' => number_format($dashboard['totals']['key_events'], 2),
                'accent' => 'from-[#2f3c82] to-[#6f86df]',
            ],
            [
                'label' => __('analytics.metrics.engagement_rate'),
                'value' => number_format($dashboard['totals']['engagement_rate'], 2).'%',
                'accent' => 'from-[#0f766e] to-[#5eead4]',
            ],
            [
                'label' => __('analytics.metrics.avg_session'),
                'value' => number_format($dashboard['totals']['average_session_duration'], 1).__('analytics.units.seconds_short'),
                'accent' => 'from-[#4a243f] to-[#b56a9a]',
            ],
        ];
    @endphp

    <section class="space-y-8">
        <div class="overflow-hidden rounded-[1.75rem] bg-[#08050d] text-white shadow-2xl shadow-purple-950/30 ring-1 ring-white/10">
            <div class="grid gap-8 bg-[linear-gradient(145deg,rgba(75,23,101,0.55)_0%,rgba(22,7,32,0.96)_44%,rgba(8,5,13,1)_100%)] p-5 sm:p-7 lg:grid-cols-[1fr_420px] lg:p-9">
                <div class="flex min-h-64 flex-col justify-between gap-8">
                    <div>
                        <p class="{{ $isRtl ? 'text-sm font-semibold text-[#c69be4]' : 'text-sm font-semibold uppercase tracking-[0.28em] text-[#c69be4]' }}">
                            {{ __('analytics.eyebrow') }}
                        </p>
                        <h1 class="mt-4 max-w-3xl text-3xl font-semibold leading-tight tracking-normal sm:text-4xl lg:text-5xl">
                            {{ __('analytics.title') }}
                        </h1>
                        <p class="mt-4 max-w-2xl text-base leading-7 text-white/[0.72]">
                            {{ __('analytics.description') }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3 text-sm text-white/[0.76]">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/[0.08] px-4 py-2 shadow-sm shadow-black/20">
                            <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                            {{ __('analytics.range') }}: {{ $dateRangeLabel }}
                        </span>
                        @if ($dashboard['lastSync'])
                            <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/[0.08] px-4 py-2 shadow-sm shadow-black/20">
                                <span class="h-2 w-2 rounded-full bg-[#c69be4]"></span>
                                {{ __('analytics.last_sync') }}:
                                {{ $dashboard['lastSync']->started_at->format('Y-m-d H:i') }}
                                ({{ __("analytics.status.{$dashboard['lastSync']->status}") }})
                            </span>
                        @endif
                    </div>
                </div>

                <form method="GET" action="{{ route('public.analytics', ['locale' => $locale]) }}"
                    class="self-end rounded-3xl border border-white/[0.14] bg-[#0d0713]/85 p-4 shadow-2xl shadow-black/30 backdrop-blur">
                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                        <label class="block">
                            <span class="{{ $smallLabelClass }}">{{ __('analytics.filters.from') }}</span>
                            <input id="date_from" name="date_from" type="date" value="{{ $dateFrom->toDateString() }}"
                                class="mt-2 w-full rounded-2xl border-white/10 bg-[#050208] text-sm font-semibold text-white shadow-sm [color-scheme:dark] focus:border-[#c69be4] focus:ring-[#c69be4]">
                        </label>
                        <label class="block">
                            <span class="{{ $smallLabelClass }}">{{ __('analytics.filters.to') }}</span>
                            <input id="date_to" name="date_to" type="date" value="{{ $dateTo->toDateString() }}"
                                class="mt-2 w-full rounded-2xl border-white/10 bg-[#050208] text-sm font-semibold text-white shadow-sm [color-scheme:dark] focus:border-[#c69be4] focus:ring-[#c69be4]">
                        </label>
                    </div>

                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-[linear-gradient(135deg,#b56ad8_0%,#7c2ea4_48%,#4f126b_100%)] px-4 py-3 text-sm font-bold text-white shadow-lg shadow-purple-950/50 ring-1 ring-white/15 transition hover:-translate-y-0.5 hover:shadow-xl hover:shadow-purple-900/40 focus:outline-none focus:ring-2 focus:ring-[#e2b7ff] focus:ring-offset-2 focus:ring-offset-[#08050d]">
                            <svg class="{{ $isRtl ? 'ms-2' : 'me-2' }} h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 7h16M7 12h10M10 17h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            {{ __('analytics.filters.apply') }}
                        </button>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-[#c69be4]/40 bg-[#150c20] px-4 py-3 text-sm font-bold text-[#f4dcff] shadow-lg shadow-black/20 transition hover:-translate-y-0.5 hover:border-[#e2b7ff] hover:bg-[#24102f] focus:outline-none focus:ring-2 focus:ring-[#e2b7ff] focus:ring-offset-2 focus:ring-offset-[#08050d]">
                            <svg class="{{ $isRtl ? 'ms-2' : 'me-2' }} h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 3v11m0 0 4-4m-4 4-4-4M5 19h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ __('analytics.export_csv') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if ($dashboard['series']['labels'] === [])
            <div class="rounded-2xl border border-amber-300/30 bg-amber-400/10 p-4 text-sm font-medium text-amber-100">
                {{ __('analytics.empty_range') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($metricCards as $card)
                <div class="group overflow-hidden rounded-3xl border border-white/10 bg-[linear-gradient(180deg,#12091a_0%,#0b0610_100%)] p-5 shadow-xl shadow-black/20 transition hover:-translate-y-0.5 hover:border-[#9873AC]/60 hover:shadow-purple-950/30">
                    <div class="mb-5 h-1 w-16 rounded-full bg-gradient-to-r {{ $card['accent'] }}"></div>
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="{{ $labelClass }}">{{ $card['label'] }}</p>
                            <p class="mt-3 text-3xl font-semibold tracking-normal text-white">{{ $card['value'] }}</p>
                        </div>
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.04] text-sm font-bold text-white/60">
                            {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            <section class="rounded-3xl border border-white/10 bg-[#100817] p-5 shadow-xl shadow-black/20">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold tracking-normal text-white">{{ __('analytics.charts.traffic') }}</h2>
                        <p class="text-sm text-white/[0.52]">{{ __('analytics.charts.traffic_hint') }}</p>
                    </div>
                    <span class="text-sm font-semibold text-white/[0.52]">{{ $dateRangeLabel }}</span>
                </div>
                <div class="mt-5 h-[24rem] rounded-2xl border border-white/10 bg-[#090511] p-3">
                    <canvas id="trafficChart" class="h-full w-full"></canvas>
                </div>
            </section>
        </div>

        <nav class="sticky top-24 z-20 rounded-3xl border border-white/10 bg-[#0b0610]/90 p-2 shadow-xl shadow-black/30 backdrop-blur">
            <div class="flex gap-2 overflow-x-auto">
                @foreach ($reportOrder as $report)
                    <a href="#report-{{ $report }}"
                        class="whitespace-nowrap rounded-2xl border border-white/10 px-4 py-2 text-sm font-bold text-white/70 transition hover:border-[#c69be4]/60 hover:bg-[#1b0d26] hover:text-white">
                        {{ $reports[$report] }}
                    </a>
                @endforeach
            </div>
        </nav>

        <div class="grid gap-5 xl:grid-cols-2">
            @foreach ($reportOrder as $report)
                <section id="report-{{ $report }}" class="scroll-mt-36 overflow-hidden rounded-3xl border border-white/10 bg-[#100817] shadow-xl shadow-black/20">
                    <div class="flex items-center justify-between gap-4 border-b border-white/10 bg-white/[0.04] px-5 py-4">
                        <h2 class="text-lg font-semibold tracking-normal text-white">{{ $reports[$report] }}</h2>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => $report]) }}"
                            class="rounded-full border border-[#c69be4]/[0.35] bg-[#1b0d26] px-3 py-1.5 text-xs font-bold text-[#f4dcff] shadow-sm shadow-black/20 transition hover:-translate-y-0.5 hover:border-[#e2b7ff] hover:bg-[#2a1238]">
                            <svg class="{{ $isRtl ? 'ms-1.5' : 'me-1.5' }} inline h-3.5 w-3.5 align-[-2px]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 4v10m0 0 3-3m-3 3-3-3M5 20h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ __('analytics.export') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-xs uppercase tracking-[0.16em] text-white/[0.45]">
                                <tr class="border-b border-white/10">
                                    <th class="px-5 py-3 text-start font-bold">{{ __('analytics.table.dimension') }}</th>
                                    <th class="px-5 py-3 text-end font-bold">{{ __('analytics.table.users') }}</th>
                                    <th class="px-5 py-3 text-end font-bold">{{ __('analytics.table.sessions') }}</th>
                                    <th class="px-5 py-3 text-end font-bold">{{ $report === 'events' ? __('analytics.table.events') : __('analytics.table.views') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse ($dashboard['reports'][$report] as $row)
                                    <tr class="transition hover:bg-white/[0.04]">
                                        <td class="max-w-xs px-5 py-4 font-medium text-white/[0.86]">
                                            <span class="break-words">{{ $row['label'] }}</span>
                                        </td>
                                        <td class="px-5 py-4 text-end font-semibold text-white/[0.78]">{{ number_format($row['active_users']) }}</td>
                                        <td class="px-5 py-4 text-end font-semibold text-white/[0.78]">{{ number_format($row['sessions']) }}</td>
                                        <td class="px-5 py-4 text-end font-semibold text-white/[0.78]">
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

                const series = @json($dashboard['series']);
                const isRtl = @json($isRtl);
                const chartText = '#f8f3ff';
                const mutedText = 'rgba(255, 255, 255, 0.58)';
                const grid = 'rgba(255, 255, 255, 0.09)';

                new window.Chart(document.getElementById('trafficChart'), {
                    type: 'line',
                    data: {
                        labels: series.labels,
                        datasets: [{
                                label: @json(__('analytics.metrics.active_users')),
                                data: series.active_users,
                                borderColor: '#9873AC',
                                backgroundColor: 'rgba(152, 115, 172, 0.14)',
                                pointBackgroundColor: '#9873AC',
                                pointBorderColor: '#090511',
                                pointRadius: 3,
                                fill: true,
                                tension: 0.35,
                            },
                            {
                                label: @json(__('analytics.metrics.sessions')),
                                data: series.sessions,
                                borderColor: '#007a66',
                                backgroundColor: 'rgba(0, 122, 102, 0.08)',
                                pointBackgroundColor: '#007a66',
                                pointBorderColor: '#090511',
                                pointRadius: 3,
                                tension: 0.35,
                            },
                            {
                                label: @json(__('analytics.metrics.views')),
                                data: series.screen_page_views,
                                borderColor: '#c28b28',
                                backgroundColor: 'rgba(194, 139, 40, 0.08)',
                                pointBackgroundColor: '#c28b28',
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
