<?php

namespace Tests\Feature;

use App\Models\PublicSponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_arabic_landing_page_has_targeted_seo_metadata_and_visible_copy(): void
    {
        $response = $this->get('/ar');

        $response->assertOk();
        $response->assertSee('<title>'.config('seo.pages.landing.ar.title').'</title>', false);
        $response->assertSee('name="description" content="'.config('seo.pages.landing.ar.description').'"', false);
        $response->assertSee('rel="canonical" href="'.route('public.landing', ['locale' => 'ar']).'"', false);
        $response->assertSee('type="application/ld+json"', false);

        foreach (config('seo.keywords.ar') as $keyword) {
            $response->assertSee($keyword, false);
        }

        $response->assertSee(config('seo.visible_focus.ar.body'), false);
    }

    public function test_landing_page_exposes_language_alternates(): void
    {
        $response = $this->get('/en');

        $response->assertOk();
        $response->assertSee('rel="alternate" hreflang="en" href="'.route('public.landing', ['locale' => 'en']).'"', false);
        $response->assertSee('rel="alternate" hreflang="ar" href="'.route('public.landing', ['locale' => 'ar']).'"', false);
        $response->assertSee('rel="alternate" hreflang="x-default" href="'.route('public.landing', ['locale' => 'en']).'"', false);
    }

    public function test_sitemap_lists_public_localized_pages_and_active_sponsors(): void
    {
        $sponsor = PublicSponsor::create([
            'name' => 'Finance Partner',
            'name_en' => 'Finance Partner',
            'name_ar' => 'شريك التمويل',
            'logo_path' => 'sponsors/finance-partner.png',
            'tier' => 'gold',
            'is_active' => true,
            'display_order' => 1,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', false);
        $response->assertSee('<loc>'.route('public.landing', ['locale' => 'en']).'</loc>', false);
        $response->assertSee('<loc>'.route('public.landing', ['locale' => 'ar']).'</loc>', false);
        $response->assertSee('<loc>'.route('public.ed', ['locale' => 'ar']).'</loc>', false);
        $response->assertSee('<loc>'.route('public.sponsors.show', ['locale' => 'ar', 'sponsor' => $sponsor]).'</loc>', false);
    }

    public function test_robots_txt_references_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertSee('User-agent: *', false);
        $response->assertSee('Sitemap: '.url('/sitemap.xml'), false);
    }
}
