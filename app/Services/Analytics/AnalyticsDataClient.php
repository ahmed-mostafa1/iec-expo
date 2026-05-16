<?php

namespace App\Services\Analytics;

use Carbon\CarbonInterface;

interface AnalyticsDataClient
{
    /**
     * @param  list<string>  $dimensions
     * @param  list<string>  $metrics
     * @return array{rows: list<array{dimensions: array<string, string>, metrics: array<string, int|float|string>}>, quota: array<string, mixed>}
     */
    public function runReport(
        string $propertyId,
        array $dimensions,
        array $metrics,
        CarbonInterface $dateFrom,
        CarbonInterface $dateTo,
        int $limit = 10000
    ): array;
}
