<?php

namespace Tests\Feature;

use App\Models\AnalyticsDailyStat;
use App\Models\AnalyticsReportRow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_public_analytics_page_renders_for_english_and_arabic(): void
    {
        $this->seedAnalyticsRows();

        $this->get('/en/analytics?date_from=2026-01-01&date_to=2026-01-02')
            ->assertOk()
            ->assertSee('Google Analytics Workspace')
            ->assertSee('Search / Organic');

        $this->get('/ar/analytics?date_from=2026-01-01&date_to=2026-01-02')
            ->assertOk()
            ->assertSee('Google Analytics Workspace');
    }

    public function test_public_analytics_export_returns_aggregate_csv(): void
    {
        $this->seedAnalyticsRows();

        $response = $this->get('/en/analytics/export?report=daily&date_from=2026-01-01&date_to=2026-01-02');

        $response->assertOk();

        $csv = $response->streamedContent();

        $this->assertStringContainsString('date,active_users,new_users,sessions', $csv);
        $this->assertStringContainsString('2026-01-01', $csv);
        $this->assertStringContainsString(',25,9,35', $csv);
        $this->assertStringNotContainsString('client_email', $csv);
    }

    private function seedAnalyticsRows(): void
    {
        AnalyticsDailyStat::create([
            'date' => '2026-01-01',
            'active_users' => 25,
            'new_users' => 9,
            'sessions' => 35,
            'screen_page_views' => 120,
            'event_count' => 44,
            'key_events' => 5,
            'average_session_duration' => 71.5,
            'engagement_rate' => 0.62,
            'sponsor_registrations' => 1,
            'icon_registrations' => 2,
            'visitor_registrations' => 3,
        ]);

        AnalyticsDailyStat::create([
            'date' => '2026-01-02',
            'active_users' => 10,
            'new_users' => 4,
            'sessions' => 15,
            'screen_page_views' => 40,
            'event_count' => 11,
            'key_events' => 1,
            'average_session_duration' => 45,
            'engagement_rate' => 0.5,
        ]);

        AnalyticsReportRow::create([
            'report' => 'acquisition',
            'date' => '2026-01-01',
            'dimension_hash' => sha1('organic'),
            'dimensions' => [
                'sessionDefaultChannelGroup' => 'Organic Search',
                'sessionSourceMedium' => 'google / organic',
                'sessionCampaignName' => '(not set)',
            ],
            'label' => 'Search / Organic',
            'active_users' => 20,
            'sessions' => 30,
            'screen_page_views' => 100,
            'event_count' => 20,
            'key_events' => 2,
        ]);
    }
}
