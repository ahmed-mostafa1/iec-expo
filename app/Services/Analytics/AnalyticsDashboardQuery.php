<?php

namespace App\Services\Analytics;

use App\Models\AnalyticsDailyStat;
use App\Models\AnalyticsReportRow;
use App\Models\AnalyticsSyncRun;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class AnalyticsDashboardQuery
{
    /**
     * @return array{earliest: string|null, latest: string|null}
     */
    public function availableRange(): array
    {
        return [
            'earliest' => AnalyticsDailyStat::query()->min('date'),
            'latest' => AnalyticsDailyStat::query()->max('date'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function dashboard(CarbonInterface $dateFrom, CarbonInterface $dateTo): array
    {
        $daily = AnalyticsDailyStat::query()
            ->whereBetween('date', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->orderBy('date')
            ->get();

        $totals = [
            'active_users' => (int) $daily->sum('active_users'),
            'new_users' => (int) $daily->sum('new_users'),
            'sessions' => (int) $daily->sum('sessions'),
            'screen_page_views' => (int) $daily->sum('screen_page_views'),
            'event_count' => (int) $daily->sum('event_count'),
            'key_events' => round((float) $daily->sum('key_events'), 2),
            'average_session_duration' => round((float) $daily->avg('average_session_duration'), 2),
            'engagement_rate' => round((float) $daily->avg('engagement_rate') * 100, 2),
            'sponsor_registrations' => (int) $daily->sum('sponsor_registrations'),
            'icon_registrations' => (int) $daily->sum('icon_registrations'),
            'visitor_registrations' => (int) $daily->sum('visitor_registrations'),
        ];

        $totals['registrations'] = $totals['sponsor_registrations']
            + $totals['icon_registrations']
            + $totals['visitor_registrations'];

        return [
            'totals' => $totals,
            'series' => $this->series($daily),
            'reports' => [
                'acquisition' => $this->topRows('acquisition', $dateFrom, $dateTo, 'sessions'),
                'content' => $this->topRows('content', $dateFrom, $dateTo, 'screen_page_views'),
                'geography' => $this->topRows('geography', $dateFrom, $dateTo, 'active_users'),
                'technology' => $this->topRows('technology', $dateFrom, $dateTo, 'sessions'),
                'events' => $this->topRows('events', $dateFrom, $dateTo, 'event_count'),
            ],
            'lastSync' => AnalyticsSyncRun::query()
                ->latest('started_at')
                ->first(),
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function rowsForExport(string $report, CarbonInterface $dateFrom, CarbonInterface $dateTo): array
    {
        if ($report === 'daily') {
            return AnalyticsDailyStat::query()
                ->whereBetween('date', [$dateFrom->toDateString(), $dateTo->toDateString()])
                ->orderBy('date')
                ->get()
                ->map(fn (AnalyticsDailyStat $row): array => [
                    'date' => $row->date->toDateString(),
                    'active_users' => $row->active_users,
                    'new_users' => $row->new_users,
                    'sessions' => $row->sessions,
                    'screen_page_views' => $row->screen_page_views,
                    'event_count' => $row->event_count,
                    'key_events' => $row->key_events,
                    'average_session_duration' => $row->average_session_duration,
                    'engagement_rate' => $row->engagement_rate,
                    'sponsor_registrations' => $row->sponsor_registrations,
                    'icon_registrations' => $row->icon_registrations,
                    'visitor_registrations' => $row->visitor_registrations,
                ])
                ->all();
        }

        return $this->topRows($report, $dateFrom, $dateTo, $this->defaultSortMetric($report), 1000);
    }

    /**
     * @param  Collection<int, AnalyticsDailyStat>  $daily
     * @return array<string, list<int|float|string>>
     */
    private function series(Collection $daily): array
    {
        return [
            'labels' => $daily->map(fn (AnalyticsDailyStat $row): string => $row->date->format('Y-m-d'))->values()->all(),
            'active_users' => $daily->pluck('active_users')->map(fn ($value): int => (int) $value)->values()->all(),
            'sessions' => $daily->pluck('sessions')->map(fn ($value): int => (int) $value)->values()->all(),
            'screen_page_views' => $daily->pluck('screen_page_views')->map(fn ($value): int => (int) $value)->values()->all(),
            'registrations' => $daily->map(fn (AnalyticsDailyStat $row): int => $row->sponsor_registrations + $row->icon_registrations + $row->visitor_registrations)->values()->all(),
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function topRows(
        string $report,
        CarbonInterface $dateFrom,
        CarbonInterface $dateTo,
        string $sortMetric,
        int $limit = 10
    ): array {
        return AnalyticsReportRow::query()
            ->selectRaw('report, dimension_hash, MIN(label) as label, SUM(active_users) as active_users, SUM(sessions) as sessions, SUM(screen_page_views) as screen_page_views, SUM(event_count) as event_count, SUM(key_events) as key_events')
            ->where('report', $report)
            ->whereBetween('date', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->groupBy('report', 'dimension_hash')
            ->orderByDesc($sortMetric)
            ->limit($limit)
            ->get()
            ->map(fn (AnalyticsReportRow $row): array => [
                'report' => $row->report,
                'label' => $row->label,
                'dimensions' => [],
                'active_users' => (int) $row->active_users,
                'sessions' => (int) $row->sessions,
                'screen_page_views' => (int) $row->screen_page_views,
                'event_count' => (int) $row->event_count,
                'key_events' => round((float) $row->key_events, 2),
            ])
            ->all();
    }

    private function defaultSortMetric(string $report): string
    {
        return match ($report) {
            'content' => 'screen_page_views',
            'geography' => 'active_users',
            'events' => 'event_count',
            default => 'sessions',
        };
    }
}
