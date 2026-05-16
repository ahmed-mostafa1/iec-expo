@extends('layouts.public')

@section('content')
    @php
        $metricCards = [
            ['label' => __('Active users'), 'value' => number_format($dashboard['totals']['active_users'])],
            ['label' => __('Sessions'), 'value' => number_format($dashboard['totals']['sessions'])],
            ['label' => __('Views'), 'value' => number_format($dashboard['totals']['screen_page_views'])],
            ['label' => __('Registrations'), 'value' => number_format($dashboard['totals']['registrations'])],
            ['label' => __('Events'), 'value' => number_format($dashboard['totals']['event_count'])],
            ['label' => __('Key events'), 'value' => number_format($dashboard['totals']['key_events'], 2)],
            ['label' => __('Engagement rate'), 'value' => number_format($dashboard['totals']['engagement_rate'], 2).'%'],
            ['label' => __('Avg. session'), 'value' => number_format($dashboard['totals']['average_session_duration'], 1).'s'],
        ];

        $exportParams = [
            'locale' => app()->getLocale(),
            'date_from' => $dateFrom->toDateString(),
            'date_to' => $dateTo->toDateString(),
        ];
    @endphp

    <section class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-emerald-700">{{ __('Public analytics') }}</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-normal text-gray-950">
                    {{ __('Google Analytics Workspace') }}
                </h1>
                <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600">
                    {{ __('Stored aggregate history from Google Analytics with local registration conversions.') }}
                </p>
                @if ($dashboard['lastSync'])
                    <p class="mt-2 text-xs text-gray-500">
                        {{ __('Last sync') }}:
                        {{ $dashboard['lastSync']->started_at->format('Y-m-d H:i') }}
                        ({{ __($dashboard['lastSync']->status) }})
                    </p>
                @endif
            </div>

            <form method="GET" action="{{ route('public.analytics', ['locale' => app()->getLocale()]) }}"
                class="flex flex-wrap items-end gap-3 rounded-lg border border-gray-200 bg-white p-3">
                <div>
                    <label for="date_from" class="block text-xs font-medium text-gray-500">{{ __('From') }}</label>
                    <input id="date_from" name="date_from" type="date" value="{{ $dateFrom->toDateString() }}"
                        class="mt-1 w-40 rounded-md border-gray-300 text-sm">
                </div>
                <div>
                    <label for="date_to" class="block text-xs font-medium text-gray-500">{{ __('To') }}</label>
                    <input id="date_to" name="date_to" type="date" value="{{ $dateTo->toDateString() }}"
                        class="mt-1 w-40 rounded-md border-gray-300 text-sm">
                </div>
                <button type="submit"
                    class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                    {{ __('Apply') }}
                </button>
                <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    {{ __('Export CSV') }}
                </a>
            </form>
        </div>

        @if ($dashboard['series']['labels'] === [])
            <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                {{ __('No stored analytics data is available for this date range yet.') }}
            </div>
        @endif

        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($metricCards as $card)
                <div class="rounded-lg border border-gray-200 bg-white p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ $card['label'] }}</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-950">{{ $card['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-4 lg:grid-cols-5">
            <div class="rounded-lg border border-gray-200 bg-white p-4 lg:col-span-3">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-base font-semibold text-gray-950">{{ __('Traffic trend') }}</h2>
                    <span class="text-xs text-gray-500">{{ $dateFrom->toDateString() }} - {{ $dateTo->toDateString() }}</span>
                </div>
                <div class="mt-4 h-80">
                    <canvas id="trafficChart"></canvas>
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 lg:col-span-2">
                <h2 class="text-base font-semibold text-gray-950">{{ __('Registration mix') }}</h2>
                <div class="mt-4 h-80">
                    <canvas id="conversionChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            @foreach (['acquisition', 'content', 'geography', 'technology', 'events'] as $report)
                <section class="rounded-lg border border-gray-200 bg-white">
                    <div class="flex items-center justify-between gap-3 border-b border-gray-100 px-4 py-3">
                        <h2 class="text-base font-semibold text-gray-950">{{ $reports[$report] }}</h2>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => $report]) }}"
                            class="text-xs font-semibold text-emerald-700 hover:text-emerald-900">
                            {{ __('Export') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th class="px-4 py-2 text-start">{{ __('Dimension') }}</th>
                                    <th class="px-4 py-2 text-end">{{ __('Users') }}</th>
                                    <th class="px-4 py-2 text-end">{{ __('Sessions') }}</th>
                                    <th class="px-4 py-2 text-end">{{ $report === 'events' ? __('Events') : __('Views') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($dashboard['reports'][$report] as $row)
                                    <tr>
                                        <td class="max-w-xs px-4 py-3 text-gray-800">
                                            <span class="break-words">{{ $row['label'] }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-end text-gray-700">{{ number_format($row['active_users']) }}</td>
                                        <td class="px-4 py-3 text-end text-gray-700">{{ number_format($row['sessions']) }}</td>
                                        <td class="px-4 py-3 text-end text-gray-700">
                                            {{ number_format($report === 'events' ? $row['event_count'] : $row['screen_page_views']) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                            {{ __('No rows for this report.') }}
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
            if (!window.Chart) {
                return;
            }

            const series = @json($dashboard['series']);
            const totals = @json($dashboard['totals']);
            const chartText = '#111827';
            const grid = '#e5e7eb';

            new window.Chart(document.getElementById('trafficChart'), {
                type: 'line',
                data: {
                    labels: series.labels,
                    datasets: [
                        {
                            label: @json(__('Active users')),
                            data: series.active_users,
                            borderColor: '#047857',
                            backgroundColor: 'rgba(4, 120, 87, 0.12)',
                            fill: true,
                            tension: 0.32,
                        },
                        {
                            label: @json(__('Sessions')),
                            data: series.sessions,
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.08)',
                            tension: 0.32,
                        },
                        {
                            label: @json(__('Views')),
                            data: series.screen_page_views,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.08)',
                            tension: 0.32,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { labels: { color: chartText } } },
                    scales: {
                        x: { ticks: { color: chartText, maxRotation: 0, autoSkip: true }, grid: { color: grid } },
                        y: { beginAtZero: true, ticks: { color: chartText, precision: 0 }, grid: { color: grid } },
                    },
                },
            });

            new window.Chart(document.getElementById('conversionChart'), {
                type: 'doughnut',
                data: {
                    labels: [
                        @json(__('Sponsor registrations')),
                        @json(__('Icon registrations')),
                        @json(__('Visitor registrations')),
                    ],
                    datasets: [{
                        data: [
                            totals.sponsor_registrations,
                            totals.icon_registrations,
                            totals.visitor_registrations,
                        ],
                        backgroundColor: ['#047857', '#2563eb', '#f59e0b'],
                        borderColor: '#ffffff',
                        borderWidth: 3,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { color: chartText } } },
                },
            });
        });
    </script>
@endsection
