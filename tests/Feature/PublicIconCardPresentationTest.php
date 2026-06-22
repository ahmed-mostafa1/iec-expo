<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicIconCardPresentationTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_places_icon_plus_card_before_icon_card(): void
    {
        $response = $this->get('/en');

        $response->assertOk();
        $response->assertSee('<div class="role-card" id="icon-plus-card" onclick="selectRole(\'icon-plus\')">', false);
        $response->assertSee('<div class="role-card guest-card" id="icon-card" onclick="selectRole(\'icon\')">', false);
        $response->assertSee("#icon-plus-card {\n        order: 3;", false);
        $response->assertSee("#icon-card {\n        order: 6;", false);
        $response->assertSee("iconPlusCard.style.order = '3';", false);
        $response->assertSee("iconCard.style.order = '6';", false);
    }

    public function test_hall_design_uses_gold_icon_plus_crown_marker(): void
    {
        $response = $this->get('/hall-design');

        $response->assertOk();
        $response->assertSee('stroke: #d4af37;', false);
        $response->assertSee('d: "m2 4 3 12h14l3-12-6 7-4-8-4 8-6-7Z"', false);
        $response->assertSee('d: "M5 20h14"', false);
    }
}
