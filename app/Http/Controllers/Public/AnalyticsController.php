<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnalyticsFilterRequest;
use App\Services\Analytics\AnalyticsDashboardQuery;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticsController extends Controller
{
    public function index(AnalyticsFilterRequest $request, AnalyticsDashboardQuery $dashboardQuery): View
    {
        [$dateFrom, $dateTo] = $this->dateRange($request, $dashboardQuery);

        return view('public.analytics', [
            'currentLocale' => app()->getLocale(),
            'dir' => app()->getLocale() === 'ar' ? 'rtl' : 'ltr',
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'availableRange' => $dashboardQuery->availableRange(),
            'dashboard' => $dashboardQuery->dashboard($dateFrom, $dateTo),
            'reports' => [
                'daily' => __('Daily totals'),
                'acquisition' => __('Acquisition'),
                'content' => __('Content'),
                'geography' => __('Geography'),
                'technology' => __('Technology'),
                'events' => __('Events'),
            ],
        ]);
    }

    public function export(AnalyticsFilterRequest $request, AnalyticsDashboardQuery $dashboardQuery): StreamedResponse
    {
        [$dateFrom, $dateTo] = $this->dateRange($request, $dashboardQuery);
        $validated = $request->validated();
        $report = $validated['report'] ?? 'daily';
        $rows = $dashboardQuery->rowsForExport($report, $dateFrom, $dateTo);
        $fileName = "analytics_{$report}_{$dateFrom->format('Ymd')}_{$dateTo->format('Ymd')}.csv";

        return response()->streamDownload(function () use ($rows, $report): void {
            $handle = fopen('php://output', 'w');

            if ($report === 'daily') {
                fputcsv($handle, [
                    'date',
                    'active_users',
                    'new_users',
                    'sessions',
                    'screen_page_views',
                    'event_count',
                    'key_events',
                    'average_session_duration',
                    'engagement_rate',
                    'sponsor_registrations',
                    'icon_registrations',
                    'visitor_registrations',
                ]);
            } else {
                fputcsv($handle, [
                    'label',
                    'dimensions',
                    'active_users',
                    'sessions',
                    'screen_page_views',
                    'event_count',
                    'key_events',
                ]);
            }

            foreach ($rows as $row) {
                if ($report === 'daily') {
                    fputcsv($handle, [
                        $row['date'],
                        $row['active_users'],
                        $row['new_users'],
                        $row['sessions'],
                        $row['screen_page_views'],
                        $row['event_count'],
                        $row['key_events'],
                        $row['average_session_duration'],
                        $row['engagement_rate'],
                        $row['sponsor_registrations'],
                        $row['icon_registrations'],
                        $row['visitor_registrations'],
                    ]);

                    continue;
                }

                fputcsv($handle, [
                    $row['label'],
                    json_encode($row['dimensions'], JSON_UNESCAPED_SLASHES),
                    $row['active_users'],
                    $row['sessions'],
                    $row['screen_page_views'],
                    $row['event_count'],
                    $row['key_events'],
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * @return array{CarbonImmutable, CarbonImmutable}
     */
    private function dateRange(AnalyticsFilterRequest $request, AnalyticsDashboardQuery $dashboardQuery): array
    {
        $availableRange = $dashboardQuery->availableRange();
        $latest = $availableRange['latest']
            ? CarbonImmutable::parse($availableRange['latest'])
            : CarbonImmutable::today();

        $defaultFrom = $latest->subDays(29);
        $validated = $request->validated();

        $dateFrom = isset($validated['date_from'])
            ? CarbonImmutable::parse($validated['date_from'])
            : $defaultFrom;
        $dateTo = isset($validated['date_to'])
            ? CarbonImmutable::parse($validated['date_to'])
            : $latest;

        if ($dateFrom->gt($dateTo)) {
            $dateFrom = $dateTo;
        }

        return [
            Carbon::parse($dateFrom->toDateString())->toImmutable(),
            Carbon::parse($dateTo->toDateString())->toImmutable(),
        ];
    }
}
