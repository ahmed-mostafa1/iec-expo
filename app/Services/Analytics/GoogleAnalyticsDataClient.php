<?php

namespace App\Services\Analytics;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GoogleAnalyticsDataClient implements AnalyticsDataClient
{
    private ?object $client = null;

    private ?string $accessToken = null;

    private int $accessTokenExpiresAt = 0;

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
        if ($this->canUseGoogleClient()) {
            return $this->runReportWithGoogleClient($propertyId, $dimensions, $metrics, $dateFrom, $dateTo, $limit);
        }

        return $this->runReportWithRest($propertyId, $dimensions, $metrics, $dateFrom, $dateTo, $limit);
    }

    /**
     * @param  list<string>  $dimensions
     * @param  list<string>  $metrics
     * @return array{rows: list<array{dimensions: array<string, string>, metrics: array<string, int|float|string>}>, quota: array<string, mixed>}
     */
    private function runReportWithGoogleClient(
        string $propertyId,
        array $dimensions,
        array $metrics,
        CarbonInterface $dateFrom,
        CarbonInterface $dateTo,
        int $limit
    ): array {
        $dateRangeClass = '\Google\Analytics\Data\V1beta\DateRange';
        $dimensionClass = '\Google\Analytics\Data\V1beta\Dimension';
        $metricClass = '\Google\Analytics\Data\V1beta\Metric';
        $requestClass = '\Google\Analytics\Data\V1beta\RunReportRequest';
        $rows = [];
        $quota = [];
        $offset = 0;

        do {
            $request = (new $requestClass)
                ->setProperty('properties/'.$propertyId)
                ->setDateRanges([
                    new $dateRangeClass([
                        'start_date' => $dateFrom->toDateString(),
                        'end_date' => $dateTo->toDateString(),
                    ]),
                ])
                ->setDimensions(array_map(
                    fn (string $name): object => new $dimensionClass(['name' => $name]),
                    $dimensions
                ))
                ->setMetrics(array_map(
                    fn (string $name): object => new $metricClass(['name' => $name]),
                    $metrics
                ))
                ->setLimit($limit)
                ->setOffset($offset)
                ->setReturnPropertyQuota(true);

            $response = $this->client()->runReport($request);

            foreach ($response->getRows() as $row) {
                $rows[] = [
                    'dimensions' => $this->mapObjectValues($dimensions, $row->getDimensionValues()),
                    'metrics' => $this->mapObjectValues($metrics, $row->getMetricValues()),
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

    /**
     * @param  list<string>  $dimensions
     * @param  list<string>  $metrics
     * @return array{rows: list<array{dimensions: array<string, string>, metrics: array<string, int|float|string>}>, quota: array<string, mixed>}
     */
    private function runReportWithRest(
        string $propertyId,
        array $dimensions,
        array $metrics,
        CarbonInterface $dateFrom,
        CarbonInterface $dateTo,
        int $limit
    ): array {
        $rows = [];
        $quota = [];
        $offset = 0;

        do {
            $response = Http::withToken($this->accessToken())
                ->acceptJson()
                ->post("https://analyticsdata.googleapis.com/v1beta/properties/{$propertyId}:runReport", [
                    'dateRanges' => [[
                        'startDate' => $dateFrom->toDateString(),
                        'endDate' => $dateTo->toDateString(),
                    ]],
                    'dimensions' => array_map(fn (string $name): array => ['name' => $name], $dimensions),
                    'metrics' => array_map(fn (string $name): array => ['name' => $name], $metrics),
                    'limit' => $limit,
                    'offset' => $offset,
                    'returnPropertyQuota' => true,
                ]);

            if ($response->failed()) {
                throw new RuntimeException('Google Analytics Data API request failed: '.$response->body());
            }

            $payload = $response->json();

            foreach ($payload['rows'] ?? [] as $row) {
                $rows[] = [
                    'dimensions' => $this->mapArrayValues($dimensions, $row['dimensionValues'] ?? []),
                    'metrics' => $this->mapArrayValues($metrics, $row['metricValues'] ?? []),
                ];
            }

            $quota = $payload['propertyQuota'] ?? $quota;
            $rowCount = (int) ($payload['rowCount'] ?? count($payload['rows'] ?? []));
            $offset += $limit;
        } while ($rowCount > $offset);

        return [
            'rows' => $rows,
            'quota' => $quota,
        ];
    }

    private function canUseGoogleClient(): bool
    {
        return class_exists('\Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient')
            && class_exists('\Google\Analytics\Data\V1beta\RunReportRequest')
            && class_exists('\Google\Analytics\Data\V1beta\DateRange')
            && class_exists('\Google\Analytics\Data\V1beta\Dimension')
            && class_exists('\Google\Analytics\Data\V1beta\Metric')
            && class_exists('\Google\Auth\Credentials\ServiceAccountCredentials');
    }

    private function client(): object
    {
        if ($this->client !== null) {
            return $this->client;
        }

        $clientClass = '\Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient';
        $credentialsClass = '\Google\Auth\Credentials\ServiceAccountCredentials';
        $credentials = new $credentialsClass(
            $clientClass::$serviceScopes,
            $this->credentialsPath()
        );

        return $this->client = new $clientClass([
            'credentials' => $credentials,
            'transport' => 'rest',
        ]);
    }

    private function accessToken(): string
    {
        if ($this->accessToken !== null && $this->accessTokenExpiresAt > time() + 60) {
            return $this->accessToken;
        }

        $credentials = $this->credentials();
        $issuedAt = time();
        $expiresAt = $issuedAt + 3600;
        $assertion = $this->base64UrlEncode(json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT',
        ], JSON_THROW_ON_ERROR)).'.'.$this->base64UrlEncode(json_encode([
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/analytics.readonly',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $issuedAt,
            'exp' => $expiresAt,
        ], JSON_THROW_ON_ERROR));

        if (! openssl_sign($assertion, $signature, $credentials['private_key'], OPENSSL_ALGO_SHA256)) {
            throw new RuntimeException('Unable to sign the Google Analytics service-account assertion.');
        }

        $response = Http::asForm()
            ->acceptJson()
            ->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $assertion.'.'.$this->base64UrlEncode($signature),
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Google service-account token request failed: '.$response->body());
        }

        $payload = $response->json();
        $this->accessToken = $payload['access_token'] ?? null;
        $this->accessTokenExpiresAt = time() + (int) ($payload['expires_in'] ?? 3600);

        if (! is_string($this->accessToken) || $this->accessToken === '') {
            throw new RuntimeException('Google service-account token response did not include an access token.');
        }

        return $this->accessToken;
    }

    /**
     * @return array{client_email: string, private_key: string}
     */
    private function credentials(): array
    {
        $contents = file_get_contents($this->credentialsPath());
        $credentials = json_decode((string) $contents, true);

        if (! is_array($credentials)
            || ! isset($credentials['client_email'], $credentials['private_key'])
            || ! is_string($credentials['client_email'])
            || ! is_string($credentials['private_key'])
        ) {
            throw new RuntimeException('Google Analytics service-account credentials are invalid.');
        }

        return [
            'client_email' => $credentials['client_email'],
            'private_key' => $credentials['private_key'],
        ];
    }

    private function credentialsPath(): string
    {
        $credentialsPath = config('services.google_analytics.credentials_path');

        if (! is_string($credentialsPath) || $credentialsPath === '' || ! file_exists($credentialsPath)) {
            throw new RuntimeException('Google Analytics service-account credentials were not found.');
        }

        return $credentialsPath;
    }

    /**
     * @param  list<string>  $headers
     * @param  iterable<object>  $values
     * @return array<string, string>
     */
    private function mapObjectValues(array $headers, iterable $values): array
    {
        $mapped = [];

        foreach ($values as $index => $value) {
            $mapped[$headers[$index] ?? (string) $index] = $value->getValue();
        }

        return $mapped;
    }

    /**
     * @param  list<string>  $headers
     * @param  list<array{value?: string}>  $values
     * @return array<string, string>
     */
    private function mapArrayValues(array $headers, array $values): array
    {
        $mapped = [];

        foreach ($values as $index => $value) {
            $mapped[$headers[$index] ?? (string) $index] = $value['value'] ?? '';
        }

        return $mapped;
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
