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
            ->assertSee('Visitor analytics dashboard')
            ->assertSee('Analytics command center')
            ->assertSee('Overview')
            ->assertSee('Traffic')
            ->assertSee('Dark mode')
            ->assertSee('data-analytics-theme-toggle', false)
            ->assertSee('data-chart-status', false)
            ->assertSee('Preparing chart...')
            ->assertSee('is-scroll-hidden')
            ->assertSee('Open reports workspace')
            ->assertSee('Search / Organic')
            ->assertSee('Rank')
            ->assertSee('#1')
            ->assertSee('Top result')
            ->assertSee('IEC-logo-nav.png')
            ->assertSee('role="tablist"', false)
            ->assertSee('id="tab-acquisition"', false)
            ->assertSee('aria-selected="true"', false)
            ->assertSee('id="report-content"', false)
            ->assertSee('data-report-panel="content"', false)
            ->assertDontSee('Registration mix')
            ->assertSee(e(route('public.analytics.export', [
                'locale' => 'en',
                'date_from' => '2026-01-01',
                'date_to' => '2026-01-02',
                'report' => 'content',
            ])), false)
            ->assertSee(e(route('public.analytics', [
                'locale' => 'ar',
                'date_from' => '2026-01-01',
                'date_to' => '2026-01-02',
            ])), false);

        $this->get('/ar/analytics?date_from=2026-01-01&date_to=2026-01-02')
            ->assertOk()
            ->assertSee('لوحة تحليلات زوار المعرض')
            ->assertSee('مركز قيادة التحليلات')
            ->assertSee('نظرة عامة')
            ->assertSee('الزيارات')
            ->assertSee('الوضع الداكن')
            ->assertSee('المستخدمون النشطون')
            ->assertSee('role="tablist"', false)
            ->assertSee('id="tab-acquisition"', false)
            ->assertSee('aria-controls="panel-content"', false)
            ->assertDontSee('توزيع التسجيلات')
            ->assertSee(e(route('public.analytics', [
                'locale' => 'en',
                'date_from' => '2026-01-01',
                'date_to' => '2026-01-02',
            ])), false);
    }

    public function test_public_analytics_defaults_to_arabic(): void
    {
        $this->get('/analytics')
            ->assertRedirect('/ar/analytics');

        $this->get('/analytics?date_from=2026-01-01&date_to=2026-01-02')
            ->assertRedirect('/ar/analytics?date_from=2026-01-01&date_to=2026-01-02');
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
