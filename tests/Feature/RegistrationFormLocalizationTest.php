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
        $response->assertSee('message.textContent = form.dataset.loadingMessage || "Submitting your request...";', false);
        $response->assertSee('form.dataset.loadingButtonLabel || "Submitting..."', false);
        $response->assertDontSee('triggerPdfDownload(payload && payload.pdf_url, payload && payload.pdf_name);', false);
        $response->assertDontSee('function triggerPdfDownload', false);
    }

    public function test_arabic_landing_page_uses_form_specific_registration_messages(): void
    {
        $response = $this->get('/ar');

        $response->assertOk();
<<<<<<< HEAD
<<<<<<< HEAD
        $response->assertSee('data-success-title="'.e(__('registration.icon_plus.toast_title')).'"', false);
        $response->assertSee('data-success-message="'.e(__('registration.icon_plus.success')).'"', false);
        $response->assertSee('data-loading-message="'.e(__('registration.icon_plus.loading_message')).'"', false);
        $response->assertSee('data-loading-button-label="'.e(__('registration.icon_plus.loading_button')).'"', false);
        $response->assertSee('data-loading-message="'.e(__('registration.sponsor.loading_message')).'"', false);
        $response->assertSee('data-loading-button-label="'.e(__('registration.sponsor.loading_button')).'"', false);
        $response->assertSee('data-loading-message="'.e(__('registration.icon.loading_message')).'"', false);
        $response->assertSee('data-loading-button-label="'.e(__('registration.icon.loading_button')).'"', false);
    }

    public function test_arabic_landing_page_renders_clean_icon_plus_card_and_form_copy(): void
    {
        $response = $this->get('/ar');

        $response->assertOk();
        $response->assertSee('data-ar="أيكون بلس"', false);
        $response->assertSee('data-ar="تسجيل أيكون بلس"', false);
        $response->assertSee('data-ar="الاسم الكامل *"', false);
        $response->assertDontSee('data-ar="اضغط"', false);
    }

    public function test_arabic_landing_page_repairs_saved_icon_plus_mojibake_copy(): void
    {
        LandingSection::query()->create([
            'section' => 'registration',
            'content' => [
                'icon_plus_card' => [
                    'title' => [
                        'en' => 'Icon Plus',
                        'ar' => 'Ø£ÙŠÙƒÙˆÙ† Ø¨Ù„Ø³',
                    ],
                ],
                'icon_plus_form' => [
                    'title' => [
                        'en' => 'Icon Plus Registration',
                        'ar' => 'ØªØ³Ø¬ÙŠÙ„ Ø£ÙŠÙƒÙˆÙ† Ø¨Ù„Ø³',
                    ],
                ],
            ],
        ]);

        $response = $this->get('/ar');

        $response->assertOk();
        $response->assertSee('data-ar="أيكون بلس"', false);
        $response->assertSee('data-ar="تسجيل أيكون بلس"', false);
        $response->assertDontSee('data-ar="Ø£ÙŠÙƒÙˆÙ† Ø¨Ù„Ø³"', false);
=======
=======
>>>>>>> parent of 690a80d (added icon plus instead of visitor)
        $response->assertSee('data-success-title="تم استلام التسجيل"', false);
        $response->assertSee('data-success-message="شكرا لتسجيلك كزائر. سنتواصل معك قريبا."', false);
        $response->assertSee('data-loading-message="جاري إرسال تسجيل الزائر..."', false);
        $response->assertSee('data-loading-button-label="جاري إرسال تسجيل الزائر..."', false);
        $response->assertSee('data-loading-message="جاري إرسال طلب الرعاية..."', false);
        $response->assertSee('data-loading-button-label="جاري إرسال طلب الرعاية..."', false);
        $response->assertSee('data-loading-message="جاري إرسال طلب الأيكونز..."', false);
        $response->assertSee('data-loading-button-label="جاري إرسال طلب الأيكونز..."', false);
<<<<<<< HEAD
>>>>>>> parent of 690a80d (added icon plus instead of visitor)
=======
>>>>>>> parent of 690a80d (added icon plus instead of visitor)
    }
}
