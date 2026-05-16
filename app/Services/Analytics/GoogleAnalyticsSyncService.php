<?php

namespace App\Services\Analytics;

use App\Models\AnalyticsDailyStat;
use App\Models\AnalyticsReportRow;
use App\Models\AnalyticsSyncRun;
use App\Models\IconRegistration;
use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class GoogleAnalyticsSyncService
{
    /**
     * @var array<string, array{dimensions: list<string>, metrics: list<string>}>
     */
    private array $reports = [
        'daily' => [
            'dimensions' => ['date'],
            'metrics' => [
                'activeUsers',
                'newUsers',
                'sessions',
                'screenPageViews',
                'eventCount',
                'keyEvents',
                'averageSessionDuration',
                'engagementRate',
            ],
        ],
        'acquisition' => [
            'dimensions' => ['date', 'sessionDefaultChannelGroup', 'sessionSourceMedium', 'sessionCampaignName'],
            'metrics' => ['activeUsers', 'sessions', 'screenPageViews', 'eventCount', 'keyEvents'],
        ],
        'content' => [
            'dimensions' => ['date', 'pagePath', 'pageTitle'],
            'metrics' => ['activeUsers', 'sessions', 'screenPageViews', 'eventCount', 'keyEvents'],
        ],
        'geography' => [
            'dimensions' => ['date', 'country', 'city'],
            'metrics' => ['activeUsers', 'sessions', 'screenPageViews', 'eventCount', 'keyEvents'],
        ],
        'technology' => [
            'dimensions' => ['date', 'deviceCategory', 'browser', 'operatingSystem'],
            'metrics' => ['activeUsers', 'sessions', 'screenPageViews', 'eventCount', 'keyEvents'],
        ],
        'events' => [
            'dimensions' => ['date', 'eventName'],
            'metrics' => ['activeUsers', 'eventCount', 'keyEvents'],
        ],
    ];

    public function __construct(
        private AnalyticsDataClient $client
    ) {}

    public function sync(CarbonInterface $dateFrom, CarbonInterface $dateTo, bool $force = false): AnalyticsSyncRun
    {
        $propertyId = (string) config('services.google_analytics.property_id');

        $run = AnalyticsSyncRun::create([
            'status' => 'running',
            'property_id' => $propertyId !== '' ? $propertyId : null,
            'date_from' => $dateFrom->toDateString(),
            'date_to' => $dateTo->toDateString(),
            'force' => $force,
            'started_at' => now(),
            'reports' => array_keys($this->reports),
            'rows_imported' => 0,
        ]);

        try {
            if ($propertyId === '') {
                throw new \RuntimeException('GA4_PROPERTY_ID is not configured.');
            }

            $rowsImported = 0;
            $quota = [];

            foreach ($this->chunks($dateFrom, $dateTo) as [$chunkFrom, $chunkTo]) {
                foreach ($this->reports as $report => $definition) {
                    $result = $this->client->runReport(
                        $propertyId,
                        $definition['dimensions'],
                        $definition['metrics'],
                        $chunkFrom,
                        $chunkTo,
                        10000
                    );

                    $quota[$report] = $result['quota'];
                    $rowsImported += $this->storeReport($report, $result['rows'], $chunkFrom, $chunkTo);
                }

                $this->syncLocalConversions($chunkFrom, $chunkTo);
            }

            $run->update([
                'status' => 'succeeded',
                'finished_at' => now(),
                'quota' => $quota,
                'rows_imported' => $rowsImported,
            ]);

            return $run->refresh();
        } catch (Throwable $throwable) {
            $run->update([
                'status' => 'failed',
                'finished_at' => now(),
                'error' => $throwable->getMessage(),
            ]);

            throw $throwable;
        }
    }

    /**
     * @param  list<array{dimensions: array<string, string>, metrics: array<string, int|float|string>}>  $rows
     */
    private function storeReport(string $report, array $rows, CarbonInterface $dateFrom, CarbonInterface $dateTo): int
    {
        if ($report !== 'daily') {
            AnalyticsReportRow::query()
                ->where('report', $report)
                ->whereBetween('date', [$dateFrom->toDateString(), $dateTo->toDateString()])
                ->delete();
        }

        $stored = 0;

        foreach ($rows as $row) {
            if (! isset($row['dimensions']['date'])) {
                continue;
            }

            $date = $this->normalizeAnalyticsDate($row['dimensions']['date']);

            if ($report === 'daily') {
                AnalyticsDailyStat::updateOrCreate(
                    ['date' => $date],
                    [
                        'active_users' => $this->metricInteger($row['metrics'], 'activeUsers'),
                        'new_users' => $this->metricInteger($row['metrics'], 'newUsers'),
                        'sessions' => $this->metricInteger($row['metrics'], 'sessions'),
                        'screen_page_views' => $this->metricInteger($row['metrics'], 'screenPageViews'),
                        'event_count' => $this->metricInteger($row['metrics'], 'eventCount'),
                        'key_events' => $this->metricFloat($row['metrics'], 'keyEvents'),
                        'average_session_duration' => $this->metricFloat($row['metrics'], 'averageSessionDuration'),
                        'engagement_rate' => $this->metricFloat($row['metrics'], 'engagementRate'),
                    ]
                );
            } else {
                $dimensions = $row['dimensions'];
                unset($dimensions['date']);

                AnalyticsReportRow::updateOrCreate(
                    [
                        'report' => $report,
                        'date' => $date,
                        'dimension_hash' => sha1(json_encode($dimensions, JSON_THROW_ON_ERROR)),
                    ],
                    [
                        'dimensions' => $dimensions,
                        'label' => $this->labelFor($report, $dimensions),
                        'active_users' => $this->metricInteger($row['metrics'], 'activeUsers'),
                        'sessions' => $this->metricInteger($row['metrics'], 'sessions'),
                        'screen_page_views' => $this->metricInteger($row['metrics'], 'screenPageViews'),
                        'event_count' => $this->metricInteger($row['metrics'], 'eventCount'),
                        'key_events' => $this->metricFloat($row['metrics'], 'keyEvents'),
                    ]
                );
            }

            $stored++;
        }

        return $stored;
    }

    private function syncLocalConversions(CarbonInterface $dateFrom, CarbonInterface $dateTo): void
    {
        $this->syncModelConversions(SponsorRegistration::class, 'sponsor_registrations', $dateFrom, $dateTo);
        $this->syncModelConversions(IconRegistration::class, 'icon_registrations', $dateFrom, $dateTo);
        $this->syncModelConversions(VisitorRegistration::class, 'visitor_registrations', $dateFrom, $dateTo);
    }

    /**
     * @param  class-string<Model>  $model
     */
    private function syncModelConversions(string $model, string $column, CarbonInterface $dateFrom, CarbonInterface $dateTo): void
    {
        AnalyticsDailyStat::query()
            ->whereBetween('date', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->update([$column => 0]);

        $counts = $model::query()
            ->selectRaw('DATE(created_at) as conversion_date, COUNT(*) as aggregate_count')
            ->whereBetween('created_at', [
                $dateFrom->copy()->startOfDay(),
                $dateTo->copy()->endOfDay(),
            ])
            ->groupBy('conversion_date')
            ->pluck('aggregate_count', 'conversion_date');

        foreach ($counts as $date => $count) {
            AnalyticsDailyStat::updateOrCreate(
                ['date' => $date],
                [$column => (int) $count]
            );
        }
    }

    /**
     * @return list<array{CarbonInterface, CarbonInterface}>
     */
    private function chunks(CarbonInterface $dateFrom, CarbonInterface $dateTo): array
    {
        $chunkDays = max(1, (int) config('services.google_analytics.sync_chunk_days', 31));
        $chunks = [];
        $cursor = $dateFrom->copy()->startOfDay();
        $end = $dateTo->copy()->startOfDay();

        while ($cursor->lte($end)) {
            $chunkEnd = $cursor->copy()->addDays($chunkDays - 1);

            if ($chunkEnd->gt($end)) {
                $chunkEnd = $end->copy();
            }

            $chunks[] = [$cursor->copy(), $chunkEnd];
            $cursor = $chunkEnd->copy()->addDay();
        }

        return $chunks;
    }

    private function normalizeAnalyticsDate(string $value): string
    {
        if (preg_match('/^\d{8}$/', $value) === 1) {
            return Carbon::createFromFormat('Ymd', $value)->toDateString();
        }

        return Carbon::parse($value)->toDateString();
    }

    /**
     * @param  array<string, int|float|string>  $metrics
     */
    private function metricInteger(array $metrics, string $key): int
    {
        return (int) round((float) ($metrics[$key] ?? 0));
    }

    /**
     * @param  array<string, int|float|string>  $metrics
     */
    private function metricFloat(array $metrics, string $key): float
    {
        return (float) ($metrics[$key] ?? 0);
    }

    /**
     * @param  array<string, string>  $dimensions
     */
    private function labelFor(string $report, array $dimensions): string
    {
        return match ($report) {
            'acquisition' => $this->joinLabel([
                $dimensions['sessionDefaultChannelGroup'] ?? null,
                $dimensions['sessionSourceMedium'] ?? null,
                $dimensions['sessionCampaignName'] ?? null,
            ]),
            'content' => $this->contentLabel($dimensions),
            'geography' => $this->joinLabel([
                $dimensions['country'] ?? null,
                $dimensions['city'] ?? null,
            ]),
            'technology' => $this->joinLabel([
                $dimensions['deviceCategory'] ?? null,
                $dimensions['browser'] ?? null,
                $dimensions['operatingSystem'] ?? null,
            ]),
            'events' => $dimensions['eventName'] ?? '(not set)',
            default => '(not set)',
        };
    }

    /**
     * @param  array<int, string|null>  $parts
     */
    private function joinLabel(array $parts): string
    {
        $filtered = array_values(array_filter($parts, fn (?string $part): bool => filled($part) && $part !== '(not set)'));

        return $filtered !== [] ? implode(' / ', $filtered) : '(not set)';
    }

    /**
     * @param  array<string, string>  $dimensions
     */
    private function contentLabel(array $dimensions): string
    {
        $title = $dimensions['pageTitle'] ?? null;
        $path = $dimensions['pagePath'] ?? null;

        if (filled($title) && filled($path)) {
            return "{$title} ({$path})";
        }

        return $title ?: ($path ?: '(not set)');
    }
}
