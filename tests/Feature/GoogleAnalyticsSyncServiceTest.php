<?php

namespace Tests\Feature;

use App\Models\AnalyticsDailyStat;
use App\Models\AnalyticsReportRow;
use App\Models\AnalyticsSyncRun;
use App\Models\IconRegistration;
use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use App\Services\Analytics\AnalyticsDataClient;
use App\Services\Analytics\GoogleAnalyticsSyncService;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleAnalyticsSyncServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_sync_service_maps_google_rows_and_local_conversions(): void
    {
        config(['services.google_analytics.property_id' => '123456']);

        $fakeClient = new FakeAnalyticsDataClient;
        $this->app->instance(AnalyticsDataClient::class, $fakeClient);

        $this->seedRegistrations();

        app(GoogleAnalyticsSyncService::class)->sync(
            CarbonImmutable::parse('2026-01-01'),
            CarbonImmutable::parse('2026-01-01'),
            true
        );

        $dailyStat = AnalyticsDailyStat::firstOrFail();

        $this->assertSame('2026-01-01', $dailyStat->date->toDateString());
        $this->assertSame(42, $dailyStat->active_users);
        $this->assertSame(12, $dailyStat->new_users);
        $this->assertSame(55, $dailyStat->sessions);
        $this->assertSame(180, $dailyStat->screen_page_views);
        $this->assertSame(70, $dailyStat->event_count);
        $this->assertSame(1, $dailyStat->sponsor_registrations);
        $this->assertSame(1, $dailyStat->icon_registrations);
        $this->assertSame(1, $dailyStat->visitor_registrations);

        $this->assertDatabaseHas('analytics_report_rows', [
            'report' => 'acquisition',
            'date' => '2026-01-01',
            'label' => 'Organic Search / google / organic',
            'sessions' => 22,
        ]);

        $this->assertSame(5, AnalyticsReportRow::count());
        $this->assertSame('succeeded', AnalyticsSyncRun::first()?->status);
        $this->assertNotEmpty($fakeClient->calls);
    }

    public function test_sync_command_records_failed_run_when_configuration_is_missing(): void
    {
        config(['services.google_analytics.property_id' => null]);

        $this->artisan('analytics:sync --from=2026-01-01 --to=2026-01-01')
            ->assertFailed();

        $this->assertDatabaseHas('analytics_sync_runs', [
            'status' => 'failed',
            'date_from' => '2026-01-01',
            'date_to' => '2026-01-01',
        ]);
    }

    public function test_sync_command_is_idempotent_for_report_rows(): void
    {
        config(['services.google_analytics.property_id' => '123456']);

        $this->app->instance(AnalyticsDataClient::class, new FakeAnalyticsDataClient);

        $command = 'analytics:sync --from=2026-01-01 --to=2026-01-01 --force';

        $this->artisan($command)->assertSuccessful();
        $this->artisan($command)->assertSuccessful();

        $this->assertSame(5, AnalyticsReportRow::count());
        $this->assertSame(2, AnalyticsSyncRun::where('status', 'succeeded')->count());
    }

    private function seedRegistrations(): void
    {
        SponsorRegistration::forceCreate([
            'full_name' => 'Sponsor User',
            'email' => 'sponsor@example.com',
            'phone' => '0555555555',
            'job_title' => 'Director',
            'organization' => 'Sponsor Co',
            'national_address' => 'Riyadh',
            'created_at' => '2026-01-01 09:00:00',
            'updated_at' => '2026-01-01 09:00:00',
        ]);

        IconRegistration::forceCreate([
            'full_name' => 'Icon User',
            'email' => 'icon@example.com',
            'phone' => '0555555556',
            'job_title' => 'Founder',
            'organization' => 'Icon Co',
            'created_at' => '2026-01-01 10:00:00',
            'updated_at' => '2026-01-01 10:00:00',
        ]);

        VisitorRegistration::forceCreate([
            'full_name' => 'Visitor User',
            'email' => 'visitor@example.com',
            'phone' => '0555555557',
            'company_name' => 'Visitor Co',
            'heard_about' => 'social_media',
            'created_at' => '2026-01-01 11:00:00',
            'updated_at' => '2026-01-01 11:00:00',
        ]);
    }
}

class FakeAnalyticsDataClient implements AnalyticsDataClient
{
    /**
     * @var list<array<string, mixed>>
     */
    public array $calls = [];

    public function runReport(
        string $propertyId,
        array $dimensions,
        array $metrics,
        CarbonInterface $dateFrom,
        CarbonInterface $dateTo,
        int $limit = 10000
    ): array {
        $this->calls[] = compact('propertyId', 'dimensions', 'metrics');

        return [
            'rows' => $this->rowsFor($dimensions),
            'quota' => [
                'tokensPerDay' => [
                    'remaining' => 199999,
                ],
            ],
        ];
    }

    /**
     * @param  list<string>  $dimensions
     * @return list<array{dimensions: array<string, string>, metrics: array<string, int|float|string>}>
     */
    private function rowsFor(array $dimensions): array
    {
        if ($dimensions === ['date']) {
            return [[
                'dimensions' => ['date' => '20260101'],
                'metrics' => [
                    'activeUsers' => 42,
                    'newUsers' => 12,
                    'sessions' => 55,
                    'screenPageViews' => 180,
                    'eventCount' => 70,
                    'keyEvents' => 8,
                    'averageSessionDuration' => 68.4,
                    'engagementRate' => 0.71,
                ],
            ]];
        }

        if (in_array('sessionDefaultChannelGroup', $dimensions, true)) {
            return [$this->dimensionRow([
                'sessionDefaultChannelGroup' => 'Organic Search',
                'sessionSourceMedium' => 'google / organic',
                'sessionCampaignName' => '(not set)',
            ], ['sessions' => 22])];
        }

        if (in_array('pagePath', $dimensions, true)) {
            return [$this->dimensionRow([
                'pagePath' => '/en',
                'pageTitle' => 'Tujjar Expo',
            ], ['screenPageViews' => 90])];
        }

        if (in_array('country', $dimensions, true)) {
            return [$this->dimensionRow([
                'country' => 'Saudi Arabia',
                'city' => 'Riyadh',
            ], ['activeUsers' => 30])];
        }

        if (in_array('deviceCategory', $dimensions, true)) {
            return [$this->dimensionRow([
                'deviceCategory' => 'mobile',
                'browser' => 'Chrome',
                'operatingSystem' => 'Android',
            ], ['sessions' => 25])];
        }

        if (in_array('eventName', $dimensions, true)) {
            return [$this->dimensionRow([
                'eventName' => 'form_submit',
            ], ['eventCount' => 9])];
        }

        return [];
    }

    /**
     * @param  array<string, string>  $dimensions
     * @param  array<string, int>  $overrides
     * @return array{dimensions: array<string, string>, metrics: array<string, int|float|string>}
     */
    private function dimensionRow(array $dimensions, array $overrides = []): array
    {
        return [
            'dimensions' => ['date' => '20260101'] + $dimensions,
            'metrics' => [
                'activeUsers' => $overrides['activeUsers'] ?? 7,
                'sessions' => $overrides['sessions'] ?? 11,
                'screenPageViews' => $overrides['screenPageViews'] ?? 15,
                'eventCount' => $overrides['eventCount'] ?? 4,
                'keyEvents' => 1,
            ],
        ];
    }
}
