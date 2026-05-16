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
        <div class="overflow-hidden rounded-[1.75rem] bg-[#08050d] text-white shadow-2xl shadow-purple-950/10">
            <div class="grid gap-8 border border-white/10 bg-[radial-gradient(circle_at_top,#3d1551_0%,#14091f_42%,#08050d_100%)] p-5 sm:p-7 lg:grid-cols-[1fr_420px] lg:p-9">
                <div class="flex min-h-64 flex-col justify-between gap-8">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-[#c69be4]">
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
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/[0.08] px-4 py-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                            {{ __('analytics.range') }}: {{ $dateRangeLabel }}
                        </span>
                        @if ($dashboard['lastSync'])
                            <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/[0.08] px-4 py-2">
                                <span class="h-2 w-2 rounded-full bg-[#c69be4]"></span>
                                {{ __('analytics.last_sync') }}:
                                {{ $dashboard['lastSync']->started_at->format('Y-m-d H:i') }}
                                ({{ __("analytics.status.{$dashboard['lastSync']->status}") }})
                            </span>
                        @endif
                    </div>
                </div>

                <form method="GET" action="{{ route('public.analytics', ['locale' => $locale]) }}"
                    class="self-end rounded-3xl border border-white/[0.12] bg-white/[0.08] p-4 shadow-xl shadow-black/20 backdrop-blur">
                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                        <label class="block">
                            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-white/[0.58]">{{ __('analytics.filters.from') }}</span>
                            <input id="date_from" name="date_from" type="date" value="{{ $dateFrom->toDateString() }}"
                                class="mt-2 w-full rounded-2xl border-white/10 bg-white text-sm font-semibold text-[#150d20] shadow-sm focus:border-[#9873AC] focus:ring-[#9873AC]">
                        </label>
                        <label class="block">
                            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-white/[0.58]">{{ __('analytics.filters.to') }}</span>
                            <input id="date_to" name="date_to" type="date" value="{{ $dateTo->toDateString() }}"
                                class="mt-2 w-full rounded-2xl border-white/10 bg-white text-sm font-semibold text-[#150d20] shadow-sm focus:border-[#9873AC] focus:ring-[#9873AC]">
                        </label>
                    </div>

                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-[#9873AC] px-4 py-3 text-sm font-bold text-white shadow-lg shadow-purple-950/25 transition hover:bg-[#875ca0] focus:outline-none focus:ring-2 focus:ring-[#c69be4] focus:ring-offset-2 focus:ring-offset-[#08050d]">
                            {{ __('analytics.filters.apply') }}
                        </button>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-white/[0.14] bg-white/10 px-4 py-3 text-sm font-bold text-white transition hover:bg-white/[0.16] focus:outline-none focus:ring-2 focus:ring-[#c69be4] focus:ring-offset-2 focus:ring-offset-[#08050d]">
                            {{ __('analytics.export_csv') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if ($dashboard['series']['labels'] === [])
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm font-medium text-amber-900">
                {{ __('analytics.empty_range') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($metricCards as $card)
                <div class="group overflow-hidden rounded-3xl border border-[#ece7f1] bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl hover:shadow-purple-950/[0.08]">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">{{ $card['label'] }}</p>
                            <p class="mt-3 text-3xl font-semibold tracking-normal text-[#090512]">{{ $card['value'] }}</p>
                        </div>
                        <span class="h-11 w-1.5 rounded-full bg-gradient-to-b {{ $card['accent'] }}"></span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid gap-5 xl:grid-cols-[minmax(0,1.45fr)_minmax(320px,0.75fr)]">
            <section class="rounded-3xl border border-[#ece7f1] bg-white p-5 shadow-sm">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold tracking-normal text-[#090512]">{{ __('analytics.charts.traffic') }}</h2>
                        <p class="text-sm text-slate-500">{{ __('analytics.charts.traffic_hint') }}</p>
                    </div>
                    <span class="text-sm font-semibold text-slate-500">{{ $dateRangeLabel }}</span>
                </div>
                <div class="mt-5 h-[22rem] rounded-2xl bg-[#fbfafc] p-3">
                    <canvas id="trafficChart" class="h-full w-full"></canvas>
                </div>
            </section>

            <section class="rounded-3xl border border-[#ece7f1] bg-white p-5 shadow-sm">
                <div>
                    <h2 class="text-xl font-semibold tracking-normal text-[#090512]">{{ __('analytics.charts.registrations') }}</h2>
                    <p class="text-sm text-slate-500">{{ __('analytics.charts.registrations_hint') }}</p>
                </div>
                <div class="mt-5 h-[22rem] rounded-2xl bg-[#fbfafc] p-3">
                    <canvas id="conversionChart" class="h-full w-full"></canvas>
                </div>
            </section>
        </div>

        <div class="grid gap-5 xl:grid-cols-2">
            @foreach (['acquisition', 'content', 'geography', 'technology', 'events'] as $report)
                <section class="overflow-hidden rounded-3xl border border-[#ece7f1] bg-white shadow-sm">
                    <div class="flex items-center justify-between gap-4 border-b border-[#f0ecf4] bg-[#fbfafc] px-5 py-4">
                        <h2 class="text-lg font-semibold tracking-normal text-[#090512]">{{ $reports[$report] }}</h2>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => $report]) }}"
                            class="rounded-full border border-[#dfd4e8] px-3 py-1.5 text-xs font-bold text-[#6f3f87] transition hover:border-[#9873AC] hover:bg-[#f5eff9]">
                            {{ __('analytics.export') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-xs uppercase tracking-[0.16em] text-slate-500">
                                <tr class="border-b border-[#f0ecf4]">
                                    <th class="px-5 py-3 text-start font-bold">{{ __('analytics.table.dimension') }}</th>
                                    <th class="px-5 py-3 text-end font-bold">{{ __('analytics.table.users') }}</th>
                                    <th class="px-5 py-3 text-end font-bold">{{ __('analytics.table.sessions') }}</th>
                                    <th class="px-5 py-3 text-end font-bold">{{ $report === 'events' ? __('analytics.table.events') : __('analytics.table.views') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#f0ecf4]">
                                @forelse ($dashboard['reports'][$report] as $row)
                                    <tr class="transition hover:bg-[#fbfafc]">
                                        <td class="max-w-xs px-5 py-4 font-medium text-[#1b1230]">
                                            <span class="break-words">{{ $row['label'] }}</span>
                                        </td>
                                        <td class="px-5 py-4 text-end font-semibold text-[#302544]">{{ number_format($row['active_users']) }}</td>
                                        <td class="px-5 py-4 text-end font-semibold text-[#302544]">{{ number_format($row['sessions']) }}</td>
                                        <td class="px-5 py-4 text-end font-semibold text-[#302544]">
                                            {{ number_format($report === 'events' ? $row['event_count'] : $row['screen_page_views']) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-10 text-center text-sm font-medium text-slate-500">
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
                const totals = @json($dashboard['totals']);
                const isRtl = @json($isRtl);
                const chartText = '#302544';
                const mutedText = '#64748b';
                const grid = '#ece7f1';

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
                                pointBorderColor: '#ffffff',
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
                                pointBorderColor: '#ffffff',
                                pointRadius: 3,
                                tension: 0.35,
                            },
                            {
                                label: @json(__('analytics.metrics.views')),
                                data: series.screen_page_views,
                                borderColor: '#c28b28',
                                backgroundColor: 'rgba(194, 139, 40, 0.08)',
                                pointBackgroundColor: '#c28b28',
                                pointBorderColor: '#ffffff',
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

                new window.Chart(document.getElementById('conversionChart'), {
                    type: 'doughnut',
                    data: {
                        labels: [
                            @json(__('analytics.registrations.sponsor')),
                            @json(__('analytics.registrations.icon')),
                            @json(__('analytics.registrations.visitor')),
                        ],
                        datasets: [{
                            data: [
                                totals.sponsor_registrations,
                                totals.icon_registrations,
                                totals.visitor_registrations,
                            ],
                            backgroundColor: ['#9873AC', '#007a66', '#c28b28'],
                            borderColor: '#fbfafc',
                            borderWidth: 4,
                            hoverOffset: 6,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
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
                    },
                });
            };

            renderCharts();
        });
    </script>
@endsection
