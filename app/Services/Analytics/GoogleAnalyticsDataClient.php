<?php

namespace App\Services\Analytics;

use Carbon\CarbonInterface;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Auth\Credentials\ServiceAccountCredentials;
use RuntimeException;

class GoogleAnalyticsDataClient implements AnalyticsDataClient
{
    private ?BetaAnalyticsDataClient $client = null;

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
    ): array {
        $rows = [];
        $quota = [];
        $offset = 0;

        do {
            $request = (new RunReportRequest)
                ->setProperty('properties/'.$propertyId)
                ->setDateRanges([
                    new DateRange([
                        'start_date' => $dateFrom->toDateString(),
                        'end_date' => $dateTo->toDateString(),
                    ]),
                ])
                ->setDimensions(array_map(
                    fn (string $name): Dimension => new Dimension(['name' => $name]),
                    $dimensions
                ))
                ->setMetrics(array_map(
                    fn (string $name): Metric => new Metric(['name' => $name]),
                    $metrics
                ))
                ->setLimit($limit)
                ->setOffset($offset)
                ->setReturnPropertyQuota(true);

            $response = $this->client()->runReport($request);

            foreach ($response->getRows() as $row) {
                $rows[] = [
                    'dimensions' => $this->mapValues($dimensions, $row->getDimensionValues()),
                    'metrics' => $this->mapValues($metrics, $row->getMetricValues()),
                ];
            }

            if ($response->hasPropertyQuota()) {
                $quota = json_decode($response->getPropertyQuota()->serializeToJsonString(), true) ?: [];
            }

            $offset += $limit;
        } while ($response->getRowCount() > $offset);

        return [
            'rows' => $rows,
            'quota' => $quota,
        ];
    }

    private function client(): BetaAnalyticsDataClient
    {
        if ($this->client instanceof BetaAnalyticsDataClient) {
            return $this->client;
        }

        $credentialsPath = config('services.google_analytics.credentials_path');

        if (! is_string($credentialsPath) || $credentialsPath === '' || ! file_exists($credentialsPath)) {
            throw new RuntimeException('Google Analytics service-account credentials were not found.');
        }

        $credentials = new ServiceAccountCredentials(
            BetaAnalyticsDataClient::$serviceScopes,
            $credentialsPath
        );

        return $this->client = new BetaAnalyticsDataClient([
            'credentials' => $credentials,
            'transport' => 'rest',
        ]);
    }

    /**
     * @param  list<string>  $headers
     * @param  iterable<object>  $values
     * @return array<string, string>
     */
    private function mapValues(array $headers, iterable $values): array
    {
        $mapped = [];

        foreach ($values as $index => $value) {
            $mapped[$headers[$index] ?? (string) $index] = $value->getValue();
        }

        return $mapped;
    }
}
