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
        $reportOrder = ['acquisition', 'content', 'geography', 'technology', 'events'];
        $reportMetricKeys = [
            'acquisition' => 'sessions',
            'content' => 'screen_page_views',
            'geography' => 'active_users',
            'technology' => 'sessions',
            'events' => 'event_count',
        ];
        $reportMetricLabels = [
            'acquisition' => __('analytics.table.sessions'),
            'content' => __('analytics.table.views'),
            'geography' => __('analytics.table.users'),
            'technology' => __('analytics.table.sessions'),
            'events' => __('analytics.table.events'),
        ];

        $metricCards = [
            [
                'label' => __('analytics.metrics.active_users'),
                'value' => number_format($dashboard['totals']['active_users']),
                'summary' => __('analytics.metric_groups.audience'),
                'accent' => '#6d3bbd',
                'surface' => 'bg-violet-50 text-violet-700',
            ],
            [
                'label' => __('analytics.metrics.sessions'),
                'value' => number_format($dashboard['totals']['sessions']),
                'summary' => __('analytics.metric_groups.traffic'),
                'accent' => '#0891b2',
                'surface' => 'bg-cyan-50 text-cyan-700',
            ],
            [
                'label' => __('analytics.metrics.views'),
                'value' => number_format($dashboard['totals']['screen_page_views']),
                'summary' => __('analytics.metric_groups.content'),
                'accent' => '#b7791f',
                'surface' => 'bg-amber-50 text-amber-700',
            ],
            [
                'label' => __('analytics.metrics.registrations'),
                'value' => number_format($dashboard['totals']['registrations']),
                'summary' => __('analytics.metric_groups.conversions'),
                'accent' => '#7c3aed',
                'surface' => 'bg-purple-50 text-purple-700',
            ],
            [
                'label' => __('analytics.metrics.events'),
                'value' => number_format($dashboard['totals']['event_count']),
                'summary' => __('analytics.metric_groups.activity'),
                'accent' => '#be185d',
                'surface' => 'bg-pink-50 text-pink-700',
            ],
            [
                'label' => __('analytics.metrics.key_events'),
                'value' => number_format($dashboard['totals']['key_events'], 2),
                'summary' => __('analytics.metric_groups.quality'),
                'accent' => '#4f46e5',
                'surface' => 'bg-indigo-50 text-indigo-700',
            ],
            [
                'label' => __('analytics.metrics.engagement_rate'),
                'value' => number_format($dashboard['totals']['engagement_rate'], 2).'%',
                'summary' => __('analytics.metric_groups.engagement'),
                'accent' => '#0f766e',
                'surface' => 'bg-teal-50 text-teal-700',
            ],
            [
                'label' => __('analytics.metrics.avg_session'),
                'value' => number_format($dashboard['totals']['average_session_duration'], 1).__('analytics.units.seconds_short'),
                'summary' => __('analytics.metric_groups.duration'),
                'accent' => '#9333ea',
                'surface' => 'bg-fuchsia-50 text-fuchsia-700',
            ],
        ];
    @endphp

    <style>
        body {
            background: #f7f4fb !important;
        }

        .analytics-main {
            max-width: 80rem !important;
        }

        .analytics-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .analytics-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .analytics-report-tab[aria-selected="true"] {
            border-color: #6d3bbd;
            background: #3f2169;
            color: #ffffff;
            box-shadow: 0 14px 28px rgb(63 33 105 / 0.22);
        }
    </style>

    <section class="-mx-4 space-y-6 rounded-[1.5rem] bg-[#f7f4fb] px-4 py-5 text-[#22172f] sm:mx-0 sm:px-5 lg:px-6">
        <section id="overview" class="scroll-mt-40 overflow-hidden rounded-2xl border border-violet-100 bg-white shadow-[0_24px_70px_rgba(68,42,100,0.12)]">
            <div class="grid gap-6 bg-[linear-gradient(135deg,#ffffff_0%,#f5edff_56%,#e7fbf7_100%)] p-5 lg:grid-cols-[1fr_auto] lg:items-end lg:p-7">
                <div class="max-w-3xl">
                    <p class="{{ $isRtl ? 'text-sm font-bold text-[#6d3bbd]' : 'text-sm font-bold uppercase tracking-[0.18em] text-[#6d3bbd]' }}">
                        {{ __('analytics.sections.command_center') }}
                    </p>
                    <h1 class="mt-3 text-3xl font-semibold leading-tight tracking-normal text-[#1d1329] sm:text-4xl">
                        {{ __('analytics.title') }}
                    </h1>
                    <p class="mt-3 max-w-2xl text-base leading-relaxed text-[#5d526b]">
                        {{ __('analytics.description') }}
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 lg:min-w-[25rem]">
                    <div class="rounded-xl border border-violet-100 bg-white/85 p-4 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#756781]">{{ __('analytics.range') }}</p>
                        <p class="mt-2 text-sm font-bold text-[#1d1329]">{{ $dateRangeLabel }}</p>
                    </div>
                    <div class="rounded-xl border border-violet-100 bg-white/85 p-4 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#756781]">{{ __('analytics.last_sync') }}</p>
                        <p class="mt-2 text-sm font-bold text-[#1d1329]">
                            @if ($dashboard['lastSync'])
                                {{ $dashboard['lastSync']->started_at->format('Y-m-d H:i') }}
                                <span class="text-[#0f766e]">({{ __("analytics.status.{$dashboard['lastSync']->status}") }})</span>
                            @else
                                {{ __('analytics.status.not_available') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid gap-3 border-t border-violet-100 bg-white p-4 sm:grid-cols-3 lg:p-5">
                <a href="#traffic" class="group rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-[#352345] transition hover:border-cyan-300 hover:bg-cyan-50">
                    <span class="block text-xs font-bold uppercase tracking-[0.13em] text-[#756781]">{{ __('analytics.sections.quick_action') }}</span>
                    <span class="mt-1 flex items-center justify-between gap-3">
                        {{ __('analytics.sections.view_traffic') }}
                        <span class="text-cyan-600 transition group-hover:translate-x-0.5 {{ $isRtl ? 'rotate-180' : '' }}">&rarr;</span>
                    </span>
                </a>
                <a href="#reports" class="group rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-[#352345] transition hover:border-violet-300 hover:bg-violet-50">
                    <span class="block text-xs font-bold uppercase tracking-[0.13em] text-[#756781]">{{ __('analytics.sections.quick_action') }}</span>
                    <span class="mt-1 flex items-center justify-between gap-3">
                        {{ __('analytics.sections.view_reports') }}
                        <span class="text-violet-700 transition group-hover:translate-x-0.5 {{ $isRtl ? 'rotate-180' : '' }}">&rarr;</span>
                    </span>
                </a>
                <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}"
                    class="group rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-[#352345] transition hover:border-amber-300 hover:bg-amber-50">
                    <span class="block text-xs font-bold uppercase tracking-[0.13em] text-[#756781]">{{ __('analytics.export_csv') }}</span>
                    <span class="mt-1 flex items-center justify-between gap-3">
                        {{ __('analytics.reports.daily') }}
                        <span class="text-amber-600 transition group-hover:-translate-y-0.5">&darr;</span>
                    </span>
                </a>
            </div>
        </section>

        <div class="sticky top-[72px] z-30 -mx-4 border-y border-violet-100 bg-white/92 shadow-lg shadow-violet-950/10 backdrop-blur-xl sm:mx-0 sm:rounded-2xl sm:border lg:top-[88px]">
            <div class="space-y-4 p-4 lg:p-5">
                <form method="GET" action="{{ route('public.analytics', ['locale' => $locale]) }}" class="grid gap-3 xl:grid-cols-[1fr_auto] xl:items-end">
                    <div class="grid gap-3 sm:grid-cols-[minmax(0,12rem)_minmax(0,12rem)_auto] sm:items-end">
                        <div>
                            <label for="date_from" class="block text-xs font-bold uppercase tracking-[0.13em] text-[#756781]">{{ __('analytics.filters.from') }}</label>
                            <input id="date_from" name="date_from" type="date" value="{{ $dateFrom->toDateString() }}"
                                class="mt-1 w-full rounded-xl border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-[#22172f] shadow-sm transition focus:border-[#6d3bbd] focus:ring-[#6d3bbd]">
                        </div>
                        <div>
                            <label for="date_to" class="block text-xs font-bold uppercase tracking-[0.13em] text-[#756781]">{{ __('analytics.filters.to') }}</label>
                            <input id="date_to" name="date_to" type="date" value="{{ $dateTo->toDateString() }}"
                                class="mt-1 w-full rounded-xl border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-[#22172f] shadow-sm transition focus:border-[#6d3bbd] focus:ring-[#6d3bbd]">
                        </div>
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-[#3f2169] px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-violet-950/20 transition hover:bg-[#512b84] focus:outline-none focus:ring-2 focus:ring-[#6d3bbd] focus:ring-offset-2">
                            {{ __('analytics.filters.apply') }}
                        </button>
                    </div>

                    <div class="inline-flex items-center gap-2 rounded-xl border border-teal-100 bg-teal-50 px-3 py-2 text-xs font-bold text-teal-800">
                        <span class="h-2 w-2 rounded-full bg-teal-500"></span>
                        {{ __('analytics.sections.active_range') }}: {{ $dateRangeLabel }}
                    </div>
                </form>

                <div class="flex gap-2 overflow-x-auto pb-1 analytics-scrollbar" aria-label="{{ __('analytics.sections.navigation') }}">
                    <a href="#overview" class="whitespace-nowrap rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-bold text-[#493b58] transition hover:border-violet-300 hover:bg-violet-50">
                        {{ __('analytics.sections.overview') }}
                    </a>
                    <a href="#traffic" class="whitespace-nowrap rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-bold text-[#493b58] transition hover:border-cyan-300 hover:bg-cyan-50">
                        {{ __('analytics.sections.traffic') }}
                    </a>

                    <div class="flex gap-2" role="tablist" aria-label="{{ __('analytics.sections.report_tabs') }}">
                        @foreach ($reportOrder as $report)
                            @php
                                $isDefaultReport = $report === 'acquisition';
                            @endphp
                            <button type="button"
                                id="tab-{{ $report }}"
                                class="analytics-report-tab whitespace-nowrap rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-[#493b58] transition hover:border-violet-300 hover:bg-violet-50 focus:outline-none focus:ring-2 focus:ring-[#6d3bbd] focus:ring-offset-2"
                                role="tab"
                                aria-selected="{{ $isDefaultReport ? 'true' : 'false' }}"
                                aria-controls="panel-{{ $report }}"
                                data-report-tab="{{ $report }}">
                                {{ $reports[$report] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @if ($dashboard['series']['labels'] === [])
            <div class="flex items-center gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm font-semibold text-amber-900 shadow-sm">
                <svg class="h-5 w-5 shrink-0 text-amber-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                </svg>
                {{ __('analytics.empty_range') }}
            </div>
        @endif

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="{{ __('analytics.sections.overview') }}">
            @foreach ($metricCards as $card)
                <article class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl hover:shadow-violet-950/10">
                    <div class="absolute inset-y-0 {{ $isRtl ? 'right-0' : 'left-0' }} w-1" style="background-color: {{ $card['accent'] }}"></div>
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs font-bold uppercase tracking-[0.13em] text-[#756781]">{{ $card['summary'] }}</p>
                            <h2 class="mt-2 text-sm font-bold text-[#493b58]">{{ $card['label'] }}</h2>
                            <p class="mt-3 text-3xl font-semibold tracking-normal text-[#1d1329]">{{ $card['value'] }}</p>
                        </div>
                        <span class="{{ $card['surface'] }} inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-black">
                            {{ $loop->iteration }}
                        </span>
                    </div>
                </article>
            @endforeach
        </section>

        <section id="traffic" class="scroll-mt-40 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#6d3bbd]">{{ __('analytics.sections.traffic') }}</p>
                    <h2 class="mt-2 text-2xl font-semibold tracking-normal text-[#1d1329]">{{ __('analytics.charts.traffic') }}</h2>
                    <p class="mt-1 text-sm leading-6 text-[#756781]">{{ __('analytics.charts.traffic_hint') }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-bold text-[#493b58]">{{ $dateRangeLabel }}</span>
                    <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-violet-200 bg-violet-50 px-3 py-2 text-xs font-bold text-violet-800 transition hover:border-violet-300 hover:bg-violet-100 focus:outline-none focus:ring-2 focus:ring-[#6d3bbd] focus:ring-offset-2"
                        title="{{ __('analytics.export_csv') }}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3v11m0 0 4-4m-4 4-4-4M5 19h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        {{ __('analytics.export') }}
                    </a>
                </div>
            </div>
            <div class="mt-6 h-[24rem] w-full rounded-2xl border border-slate-100 bg-[#fbfaff] p-3">
                <canvas id="trafficChart"></canvas>
            </div>
        </section>

        <section id="reports" class="scroll-mt-40 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            @foreach ($reportOrder as $report)
                @php
                    $isDefaultReport = $report === 'acquisition';
                    $metricKey = $reportMetricKeys[$report];
                    $maxMetric = collect($dashboard['reports'][$report])->max($metricKey);
                    $maxMetric = $maxMetric > 0 ? $maxMetric : 1;
                @endphp
                <section id="report-{{ $report }}"
                    role="tabpanel"
                    tabindex="0"
                    aria-labelledby="tab-{{ $report }}"
                    data-report-panel="{{ $report }}"
                    @unless ($isDefaultReport) hidden @endunless>
                    <div class="flex flex-col gap-4 border-b border-slate-200 bg-[#fbfaff] px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#6d3bbd]">{{ __('analytics.sections.report_tabs') }}</p>
                            <h2 class="mt-2 text-2xl font-semibold tracking-normal text-[#1d1329]">{{ $reports[$report] }}</h2>
                            <p class="mt-1 text-sm text-[#756781]">{{ __('analytics.sections.ranked_by') }} {{ $reportMetricLabels[$report] }}</p>
                        </div>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => $report]) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-violet-200 bg-white px-3 py-2 text-xs font-bold text-violet-800 transition hover:border-violet-300 hover:bg-violet-50 focus:outline-none focus:ring-2 focus:ring-[#6d3bbd] focus:ring-offset-2">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 4v10m0 0 3-3m-3 3-3-3M5 20h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ __('analytics.export') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full whitespace-nowrap text-sm">
                            <thead class="bg-white text-xs uppercase tracking-[0.12em] text-[#756781]">
                                <tr class="border-b border-slate-200">
                                    <th class="px-5 py-4 text-start font-bold">{{ __('analytics.table.rank') }}</th>
                                    <th class="px-5 py-4 text-start font-bold">{{ __('analytics.table.dimension') }}</th>
                                    <th class="px-5 py-4 text-end font-bold">{{ __('analytics.table.users') }}</th>
                                    <th class="px-5 py-4 text-end font-bold">{{ __('analytics.table.sessions') }}</th>
                                    <th class="px-5 py-4 text-end font-bold">{{ $report === 'events' ? __('analytics.table.events') : __('analytics.table.views') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($dashboard['reports'][$report] as $row)
                                    @php
                                        $primaryValue = (int) $row[$metricKey];
                                        $percentage = min(($primaryValue / $maxMetric) * 100, 100);
                                        $isTopRow = $loop->first;
                                    @endphp
                                    <tr class="{{ $isTopRow ? 'bg-violet-50/80' : 'bg-white odd:bg-slate-50/60' }} transition hover:bg-cyan-50/70">
                                        <td class="px-5 py-4">
                                            <span class="{{ $isTopRow ? 'bg-[#3f2169] text-white' : 'bg-slate-100 text-[#493b58]' }} inline-flex h-8 min-w-8 items-center justify-center rounded-full px-2 text-xs font-black">
                                                #{{ $loop->iteration }}
                                            </span>
                                        </td>
                                        <td class="min-w-[18rem] max-w-[28rem] px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-center gap-2">
                                                        <span class="truncate font-bold text-[#1d1329]" title="{{ $row['label'] }}">{{ $row['label'] }}</span>
                                                        @if ($isTopRow)
                                                            <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[0.68rem] font-black uppercase tracking-[0.12em] text-amber-800">{{ __('analytics.table.top_result') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
                                                        <div class="h-full rounded-full bg-[linear-gradient(90deg,#6d3bbd,#0891b2)]" style="width: {{ $percentage }}%;"></div>
                                                    </div>
                                                </div>
                                                <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs font-bold text-[#493b58]">{{ number_format($primaryValue) }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-end font-bold text-[#1d1329]">{{ number_format($row['active_users']) }}</td>
                                        <td class="px-5 py-4 text-end font-semibold text-[#493b58]">{{ number_format($row['sessions']) }}</td>
                                        <td class="px-5 py-4 text-end font-semibold text-[#493b58]">
                                            {{ number_format($report === 'events' ? $row['event_count'] : $row['screen_page_views']) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-12 text-center">
                                            <div class="inline-flex flex-col items-center justify-center text-[#756781]">
                                                <svg class="mb-3 h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <span class="text-sm font-semibold">{{ __('analytics.no_rows') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            @endforeach
        </section>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const reportTabs = Array.from(document.querySelectorAll('[data-report-tab]'));
            const reportPanels = Array.from(document.querySelectorAll('[data-report-panel]'));
            const reportsSection = document.getElementById('reports');

            const reportFromHash = () => {
                const hash = window.location.hash || '';

                if (!hash.startsWith('#report-')) {
                    return null;
                }

                return hash.replace('#report-', '');
            };

            const activateReport = (report, scrollToReports = false, updateHash = false) => {
                const selectedTab = reportTabs.find((tab) => tab.dataset.reportTab === report);

                if (!selectedTab) {
                    return false;
                }

                reportTabs.forEach((tab) => {
                    tab.setAttribute('aria-selected', tab.dataset.reportTab === report ? 'true' : 'false');
                });

                reportPanels.forEach((panel) => {
                    panel.hidden = panel.dataset.reportPanel !== report;
                });

                if (updateHash) {
                    window.history.replaceState(null, '', `#report-${report}`);
                }

                if (scrollToReports && reportsSection) {
                    reportsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

                return true;
            };

            reportTabs.forEach((tab) => {
                tab.addEventListener('click', () => {
                    activateReport(tab.dataset.reportTab, true, true);
                });
            });

            activateReport(reportFromHash() || 'acquisition');

            window.addEventListener('hashchange', () => {
                const report = reportFromHash();

                if (report) {
                    activateReport(report, true);
                }
            });

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
                const chartText = '#22172f';
                const mutedText = '#756781';
                const grid = 'rgba(109, 59, 189, 0.10)';

                new window.Chart(chartElement, {
                    type: 'line',
                    data: {
                        labels: series.labels,
                        datasets: [{
                                label: @json(__('analytics.metrics.active_users')),
                                data: series.active_users,
                                borderColor: '#6d3bbd',
                                backgroundColor: 'rgba(109, 59, 189, 0.12)',
                                pointBackgroundColor: '#6d3bbd',
                                pointBorderColor: '#ffffff',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                                tension: 0.4,
                            },
                            {
                                label: @json(__('analytics.metrics.sessions')),
                                data: series.sessions,
                                borderColor: '#0891b2',
                                backgroundColor: 'rgba(8, 145, 178, 0.08)',
                                pointBackgroundColor: '#0891b2',
                                pointBorderColor: '#ffffff',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.4,
                            },
                            {
                                label: @json(__('analytics.metrics.views')),
                                data: series.screen_page_views,
                                borderColor: '#b7791f',
                                backgroundColor: 'rgba(183, 121, 31, 0.08)',
                                pointBackgroundColor: '#b7791f',
                                pointBorderColor: '#ffffff',
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
                                backgroundColor: 'rgba(34, 23, 47, 0.94)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(109, 59, 189, 0.22)',
                                borderWidth: 1,
                                padding: 12,
                                boxPadding: 6,
                                usePointStyle: true,
                                cornerRadius: 10,
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
