<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationFormLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_english_landing_page_uses_form_specific_registration_messages(): void
    {
        $response = $this->get('/en');

        $response->assertOk();
        $response->assertSee('data-success-title="Registration received"', false);
        $response->assertSee('data-success-message="Thank you for registering as a visitor. We will contact you shortly."', false);
        $response->assertSee('data-loading-message="Submitting your visitor registration..."', false);
        $response->assertSee('data-loading-button-label="Submitting visitor registration..."', false);
        $response->assertSee('data-loading-message="Submitting your sponsorship application..."', false);
        $response->assertSee('data-loading-button-label="Submitting sponsorship application..."', false);
        $response->assertSee('data-loading-message="Submitting your Icon application..."', false);
        $response->assertSee('data-loading-button-label="Submitting Icon application..."', false);
    }

    public function test_arabic_landing_page_uses_form_specific_registration_messages(): void
    {
        $response = $this->get('/ar');

        $response->assertOk();
        $response->assertSee('data-success-title="تم استلام التسجيل"', false);
        $response->assertSee('data-success-message="شكرا لتسجيلك كزائر. سنتواصل معك قريبا."', false);
        $response->assertSee('data-loading-message="جاري إرسال تسجيل الزائر..."', false);
        $response->assertSee('data-loading-button-label="جاري إرسال تسجيل الزائر..."', false);
        $response->assertSee('data-loading-message="جاري إرسال طلب الرعاية..."', false);
        $response->assertSee('data-loading-button-label="جاري إرسال طلب الرعاية..."', false);
        $response->assertSee('data-loading-message="جاري إرسال طلب الأيكونز..."', false);
        $response->assertSee('data-loading-button-label="جاري إرسال طلب الأيكونز..."', false);
    }
}
