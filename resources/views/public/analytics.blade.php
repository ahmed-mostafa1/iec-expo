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
        $sectionLinks = [
            ['id' => 'overview', 'label' => __('analytics.sections.overview')],
            ['id' => 'traffic', 'label' => __('analytics.sections.traffic')],
        ];

        $metricCards = [
            [
                'label' => __('analytics.metrics.active_users'),
                'value' => number_format($dashboard['totals']['active_users']),
                'accent' => '#b879ff',
                'tone' => 'from-[#b879ff]/24 to-[#b879ff]/5',
            ],
            [
                'label' => __('analytics.metrics.sessions'),
                'value' => number_format($dashboard['totals']['sessions']),
                'accent' => '#32d6b0',
                'tone' => 'from-[#32d6b0]/22 to-[#32d6b0]/5',
            ],
            [
                'label' => __('analytics.metrics.views'),
                'value' => number_format($dashboard['totals']['screen_page_views']),
                'accent' => '#f2b84b',
                'tone' => 'from-[#f2b84b]/20 to-[#f2b84b]/5',
            ],
            [
                'label' => __('analytics.metrics.registrations'),
                'value' => number_format($dashboard['totals']['registrations']),
                'accent' => '#d8a7ff',
                'tone' => 'from-[#d8a7ff]/18 to-[#d8a7ff]/5',
            ],
            [
                'label' => __('analytics.metrics.events'),
                'value' => number_format($dashboard['totals']['event_count']),
                'accent' => '#ff7bbd',
                'tone' => 'from-[#ff7bbd]/18 to-[#ff7bbd]/5',
            ],
            [
                'label' => __('analytics.metrics.key_events'),
                'value' => number_format($dashboard['totals']['key_events'], 2),
                'accent' => '#8fb2ff',
                'tone' => 'from-[#8fb2ff]/18 to-[#8fb2ff]/5',
            ],
            [
                'label' => __('analytics.metrics.engagement_rate'),
                'value' => number_format($dashboard['totals']['engagement_rate'], 2).'%',
                'accent' => '#4be3ca',
                'tone' => 'from-[#4be3ca]/18 to-[#4be3ca]/5',
            ],
            [
                'label' => __('analytics.metrics.avg_session'),
                'value' => number_format($dashboard['totals']['average_session_duration'], 1).__('analytics.units.seconds_short'),
                'accent' => '#e9c46a',
                'tone' => 'from-[#e9c46a]/18 to-[#e9c46a]/5',
            ],
        ];
    @endphp

    <style>
        .analytics-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .analytics-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .analytics-report-tab[aria-selected="true"] {
            border-color: rgb(216 167 255 / 0.72);
            background: linear-gradient(135deg, rgb(152 115 172 / 0.42), rgb(116 65 151 / 0.28));
            color: #ffffff;
            box-shadow: 0 14px 34px rgb(80 24 120 / 0.34);
        }
    </style>

    <section class="space-y-7 text-[#f8f0ff]">
        <section id="overview" class="scroll-mt-40 overflow-hidden rounded-lg border border-[#7b4aa1]/35 bg-[#150b22] shadow-2xl shadow-black/35">
            <div class="bg-[linear-gradient(135deg,#351854_0%,#1c102b_58%,#0d0714_100%)] px-5 py-6 sm:px-7 lg:px-8">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <p class="{{ $isRtl ? 'text-sm font-bold text-[#d8a7ff]' : 'text-sm font-bold uppercase tracking-[0.18em] text-[#d8a7ff]' }}">
                            {{ __('analytics.eyebrow') }}
                        </p>
                        <h1 class="mt-3 text-3xl font-semibold leading-tight tracking-normal text-white sm:text-4xl">
                            {{ __('analytics.title') }}
                        </h1>
                        <p class="mt-4 max-w-2xl text-base leading-relaxed text-[#dcc9ed]">
                            {{ __('analytics.description') }}
                        </p>
                    </div>

                    <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#d8a7ff]/30 bg-white/10 px-4 py-2 text-sm font-bold text-white transition hover:border-[#d8a7ff]/70 hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-[#d8a7ff] focus:ring-offset-2 focus:ring-offset-[#1c102b]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 4v10m0 0 3-3m-3 3-3-3M5 20h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        {{ __('analytics.export_csv') }}
                    </a>
                </div>
            </div>

            <div class="grid gap-3 border-t border-[#7b4aa1]/25 bg-[#12091e]/88 p-4 text-sm text-[#dcc9ed] sm:grid-cols-2 lg:p-5">
                <div class="flex items-center gap-3 rounded-lg border border-[#7b4aa1]/28 bg-[#1d102d]/82 px-4 py-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#32d6b0]/14 text-[#55e5c5]">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span>{{ __('analytics.range') }}: <span class="font-semibold text-white">{{ $dateRangeLabel }}</span></span>
                </div>

                @if ($dashboard['lastSync'])
                    <div class="flex items-center gap-3 rounded-lg border border-[#7b4aa1]/28 bg-[#1d102d]/82 px-4 py-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#b879ff]/16 text-[#d8a7ff]">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
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

        <div class="sticky top-[72px] z-30 -mx-4 border-y border-[#7b4aa1]/28 bg-[#150b22]/92 shadow-xl shadow-black/30 backdrop-blur-xl sm:mx-0 sm:rounded-lg sm:border lg:top-[88px]">
            <div class="space-y-4 p-4 sm:px-5">
                <form method="GET" action="{{ route('public.analytics', ['locale' => $locale]) }}" class="flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div class="flex items-center gap-2">
                            <label for="date_from" class="shrink-0 text-xs font-bold text-[#c8b3da]">{{ __('analytics.filters.from') }}</label>
                            <input id="date_from" name="date_from" type="date" value="{{ $dateFrom->toDateString() }}"
                                class="rounded-lg border-[#7b4aa1]/45 bg-[#0f0718] px-3 py-2 text-sm font-semibold text-white shadow-sm [color-scheme:dark] transition focus:border-[#d8a7ff] focus:ring-[#d8a7ff]">
                        </div>
                        <div class="flex items-center gap-2">
                            <label for="date_to" class="shrink-0 text-xs font-bold text-[#c8b3da]">{{ __('analytics.filters.to') }}</label>
                            <input id="date_to" name="date_to" type="date" value="{{ $dateTo->toDateString() }}"
                                class="rounded-lg border-[#7b4aa1]/45 bg-[#0f0718] px-3 py-2 text-sm font-semibold text-white shadow-sm [color-scheme:dark] transition focus:border-[#d8a7ff] focus:ring-[#d8a7ff]">
                        </div>
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-[#8f4fbc] px-4 py-2 text-sm font-bold text-white shadow-lg shadow-[#6f2b94]/30 transition hover:bg-[#a962d2] focus:outline-none focus:ring-2 focus:ring-[#d8a7ff] focus:ring-offset-2 focus:ring-offset-[#150b22]">
                            {{ __('analytics.filters.apply') }}
                        </button>
                    </div>

                    <div class="flex items-center gap-2 rounded-lg border border-[#7b4aa1]/25 bg-[#1d102d]/70 px-3 py-2 text-xs font-semibold text-[#dcc9ed]">
                        <span class="h-2 w-2 rounded-full bg-[#32d6b0] shadow-[0_0_16px_rgba(50,214,176,0.72)]"></span>
                        <span>{{ __('analytics.range') }}: {{ $dateRangeLabel }}</span>
                    </div>
                </form>

                <div class="flex gap-2 overflow-x-auto pb-1 analytics-scrollbar" aria-label="{{ __('analytics.sections.navigation') }}">
                    @foreach ($sectionLinks as $link)
                        <a href="#{{ $link['id'] }}"
                            class="whitespace-nowrap rounded-lg border border-[#7b4aa1]/28 bg-[#201130]/75 px-3 py-2 text-sm font-bold text-[#dcc9ed] transition hover:border-[#d8a7ff]/60 hover:bg-[#2a153f] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#d8a7ff]">
                            {{ $link['label'] }}
                        </a>
                    @endforeach

                    <div class="flex gap-2" role="tablist" aria-label="{{ __('analytics.sections.report_tabs') }}">
                        @foreach ($reportOrder as $report)
                            @php
                                $isDefaultReport = $report === 'acquisition';
                            @endphp
                            <button type="button"
                                id="tab-{{ $report }}"
                                class="analytics-report-tab whitespace-nowrap rounded-lg border border-[#7b4aa1]/28 bg-[#201130]/75 px-3 py-2 text-sm font-bold text-[#c8b3da] transition hover:border-[#d8a7ff]/60 hover:bg-[#2a153f] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#d8a7ff]"
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
            <div class="flex items-center gap-3 rounded-lg border border-[#f2b84b]/30 bg-[#3a2715]/82 p-5 text-sm font-semibold text-[#ffe5ad] shadow-lg shadow-black/20">
                <svg class="h-5 w-5 shrink-0 text-[#f2b84b]" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                </svg>
                {{ __('analytics.empty_range') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="{{ __('analytics.sections.overview') }}">
            @foreach ($metricCards as $card)
                <div class="relative overflow-hidden rounded-lg border border-[#7b4aa1]/25 bg-[#160b23] p-5 shadow-xl shadow-black/20 transition hover:-translate-y-0.5 hover:border-[#d8a7ff]/45 hover:bg-[#1b0f2a]">
                    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r {{ $card['tone'] }}"></div>
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="{{ $isRtl ? 'text-xs font-bold text-[#c8b3da]' : 'text-xs font-bold uppercase tracking-[0.14em] text-[#c8b3da]' }}">
                                {{ $card['label'] }}
                            </p>
                            <p class="mt-3 text-3xl font-semibold tracking-normal text-white">{{ $card['value'] }}</p>
                        </div>
                        <span class="mt-1 h-3 w-3 shrink-0 rounded-full" style="background-color: {{ $card['accent'] }}; box-shadow: 0 0 22px {{ $card['accent'] }}66;"></span>
                    </div>
                </div>
            @endforeach
        </div>

        <section id="traffic" class="scroll-mt-40 rounded-lg border border-[#7b4aa1]/28 bg-[#150b22] p-5 shadow-2xl shadow-black/30 lg:p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold tracking-normal text-white">{{ __('analytics.charts.traffic') }}</h2>
                    <p class="mt-1 text-sm leading-6 text-[#c8b3da]">{{ __('analytics.charts.traffic_hint') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="rounded-lg border border-[#7b4aa1]/28 bg-[#201130]/78 px-3 py-2 text-xs font-bold text-[#dcc9ed]">{{ $dateRangeLabel }}</span>
                    <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}"
                        class="inline-flex items-center justify-center rounded-lg border border-[#7b4aa1]/35 bg-[#201130]/78 p-2 text-[#f8f0ff] transition hover:border-[#d8a7ff]/70 hover:bg-[#2a153f] focus:outline-none focus:ring-2 focus:ring-[#d8a7ff] focus:ring-offset-2 focus:ring-offset-[#150b22]"
                        title="{{ __('analytics.export_csv') }}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3v11m0 0 4-4m-4 4-4-4M5 19h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="sr-only">{{ __('analytics.export_csv') }}</span>
                    </a>
                </div>
            </div>
            <div class="mt-6 h-[24rem] w-full rounded-lg border border-[#7b4aa1]/20 bg-[#0f0718]/62 p-3">
                <canvas id="trafficChart"></canvas>
            </div>
        </section>

        <section id="reports" class="scroll-mt-40 overflow-hidden rounded-lg border border-[#7b4aa1]/28 bg-[#150b22] shadow-2xl shadow-black/30">
            @foreach ($reportOrder as $report)
                @php
                    $isDefaultReport = $report === 'acquisition';
                    $maxUsers = collect($dashboard['reports'][$report])->max('active_users');
                    $maxUsers = $maxUsers > 0 ? $maxUsers : 1;
                @endphp
                <section id="report-{{ $report }}"
                    role="tabpanel"
                    tabindex="0"
                    aria-labelledby="tab-{{ $report }}"
                    data-report-panel="{{ $report }}"
                    @unless ($isDefaultReport) hidden @endunless>
                    <div class="flex flex-col gap-4 border-b border-[#7b4aa1]/25 bg-[#1d102d]/82 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="{{ $isRtl ? 'text-xs font-bold text-[#c8b3da]' : 'text-xs font-bold uppercase tracking-[0.14em] text-[#c8b3da]' }}">
                                {{ __('analytics.sections.report_tabs') }}
                            </p>
                            <h2 class="mt-1 text-xl font-semibold tracking-normal text-white">{{ $reports[$report] }}</h2>
                        </div>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => $report]) }}"
                            class="inline-flex items-center justify-center rounded-lg border border-[#d8a7ff]/30 bg-[#251438] px-3 py-2 text-xs font-bold text-white transition hover:border-[#d8a7ff]/70 hover:bg-[#321c4a] focus:outline-none focus:ring-2 focus:ring-[#d8a7ff] focus:ring-offset-2 focus:ring-offset-[#1d102d]">
                            <svg class="{{ $isRtl ? 'ms-1.5' : 'me-1.5' }} h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 4v10m0 0 3-3m-3 3-3-3M5 20h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ __('analytics.export') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full whitespace-nowrap text-sm">
                            <thead class="{{ $isRtl ? 'text-xs text-[#c8b3da]' : 'text-xs uppercase tracking-[0.12em] text-[#c8b3da]' }} bg-[#0f0718]/76">
                                <tr class="border-b border-[#7b4aa1]/24">
                                    <th class="px-5 py-4 text-start font-bold">{{ __('analytics.table.dimension') }}</th>
                                    <th class="px-5 py-4 text-end font-bold">{{ __('analytics.table.users') }}</th>
                                    <th class="px-5 py-4 text-end font-bold">{{ __('analytics.table.sessions') }}</th>
                                    <th class="px-5 py-4 text-end font-bold">{{ $report === 'events' ? __('analytics.table.events') : __('analytics.table.views') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#7b4aa1]/16">
                                @forelse ($dashboard['reports'][$report] as $row)
                                    @php
                                        $percentage = min(($row['active_users'] / $maxUsers) * 100, 100);
                                    @endphp
                                    <tr class="group bg-[#12091e]/54 transition odd:bg-[#180d25]/54 hover:bg-[#251438]/74">
                                        <td class="relative max-w-[220px] px-5 py-4 font-semibold text-white sm:max-w-sm">
                                            <span class="absolute inset-y-2 {{ $isRtl ? 'right-3' : 'left-3' }} rounded-lg bg-[#8f4fbc]/20 transition-all duration-500 group-hover:bg-[#8f4fbc]/30" style="width: {{ $percentage }}%; max-width: calc(100% - 1.5rem);"></span>
                                            <span class="relative block truncate" title="{{ $row['label'] }}">{{ $row['label'] }}</span>
                                        </td>
                                        <td class="px-5 py-4 text-end font-bold text-white">{{ number_format($row['active_users']) }}</td>
                                        <td class="px-5 py-4 text-end font-semibold text-[#dcc9ed]">{{ number_format($row['sessions']) }}</td>
                                        <td class="px-5 py-4 text-end font-semibold text-[#dcc9ed]">
                                            {{ number_format($report === 'events' ? $row['event_count'] : $row['screen_page_views']) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-12 text-center">
                                            <div class="inline-flex flex-col items-center justify-center text-[#a993ba]">
                                                <svg class="mb-3 h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
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
                const chartText = '#f8f0ff';
                const mutedText = 'rgba(220, 201, 237, 0.72)';
                const grid = 'rgba(216, 167, 255, 0.11)';

                new window.Chart(chartElement, {
                    type: 'line',
                    data: {
                        labels: series.labels,
                        datasets: [{
                                label: @json(__('analytics.metrics.active_users')),
                                data: series.active_users,
                                borderColor: '#b879ff',
                                backgroundColor: 'rgba(184, 121, 255, 0.16)',
                                pointBackgroundColor: '#b879ff',
                                pointBorderColor: '#150b22',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                                tension: 0.4,
                            },
                            {
                                label: @json(__('analytics.metrics.sessions')),
                                data: series.sessions,
                                borderColor: '#32d6b0',
                                backgroundColor: 'rgba(50, 214, 176, 0.08)',
                                pointBackgroundColor: '#32d6b0',
                                pointBorderColor: '#150b22',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.4,
                            },
                            {
                                label: @json(__('analytics.metrics.views')),
                                data: series.screen_page_views,
                                borderColor: '#f2b84b',
                                backgroundColor: 'rgba(242, 184, 75, 0.08)',
                                pointBackgroundColor: '#f2b84b',
                                pointBorderColor: '#150b22',
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
                                backgroundColor: 'rgba(15, 7, 24, 0.94)',
                                titleColor: '#ffffff',
                                bodyColor: '#f8f0ff',
                                borderColor: 'rgba(216, 167, 255, 0.22)',
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
