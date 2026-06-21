<?php

namespace Tests\Feature;

use App\Mail\ContractConfirmationMail;
use App\Mail\NewIconPlusRegistrationMail;
use App\Models\Admin;
use App\Models\HallSpaceBooking;
use App\Models\IconPlusRegistration;
use App\Models\IconRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;
use Tests\TestCase;

class IconPlusRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private array $adminEmails = [
        'iec360@umbrella.sa',
        'mo.faour@gmail.com',
        'aomar@umbrella.sa',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        config(['admin.emails' => $this->adminEmails]);
        Storage::fake('public');

        $this->app->instance(RegistrationPdfService::class, new class extends RegistrationPdfService
        {
            public function generateIconPlusPdf(IconPlusRegistration $registration): string
            {
                return "registrations/icon-plus/{$registration->id}.pdf";
            }

            public function generateIconPdf(IconRegistration $registration): string
            {
                return "registrations/icons/{$registration->id}.pdf";
            }
        });
    }

    public function test_icon_plus_registration_stores_uploads_generates_pdf_and_notifies_recipients(): void
    {
        Mail::fake();

        $response = $this->postJson(
            route('public.register.icon-plus', ['locale' => 'en']),
            $this->registrationPayload(['location_selection' => 'L.W.1'])
        );

        $response->assertCreated()
            ->assertJsonPath('message', __('registration.icon_plus.success_pdf_pending'))
            ->assertJsonPath('toast_title', __('registration.icon_plus.toast_title'));

        $registration = IconPlusRegistration::query()->sole();

        $this->assertSame('Icon Plus Co', $registration->organization);
        $this->assertSame('L.W.1', $registration->location_selection);
        $this->assertSame('generated', $registration->pdf_status);
        $this->assertSame('registrations/icon-plus/1.pdf', $registration->pdf_path);
        $this->assertNotNull($registration->pdf_generated_at);

        Storage::disk('public')->assertExists($registration->vat_certificate_path);
        Storage::disk('public')->assertExists($registration->cr_copy_path);
        Storage::disk('public')->assertExists($registration->national_address_doc_path);
        Storage::disk('public')->assertExists($registration->company_logo_path);

        Mail::assertSent(ContractConfirmationMail::class, fn (ContractConfirmationMail $mail) => $mail->hasTo('icon-plus@example.com'));
        Mail::assertSent(NewIconPlusRegistrationMail::class, count($this->adminEmails));

        foreach ($this->adminEmails as $adminEmail) {
            Mail::assertSent(NewIconPlusRegistrationMail::class, fn (NewIconPlusRegistrationMail $mail) => $mail->hasTo($adminEmail));
        }
    }

    #[DataProvider('validIconPlusSpacesProvider')]
    public function test_icon_plus_accepts_reserved_icon_plus_spaces(string $space): void
    {
        Mail::fake();

        $response = $this->postJson(
            route('public.register.icon-plus', ['locale' => 'en']),
            $this->registrationPayload(['location_selection' => $space])
        );

        $response->assertCreated();

        $this->assertDatabaseHas('icon_plus_registrations', [
            'location_selection' => $space,
        ]);
    }

    #[DataProvider('invalidIconPlusSpacesProvider')]
    public function test_icon_plus_rejects_non_icon_plus_spaces(string $space): void
    {
        $response = $this->postJson(
            route('public.register.icon-plus', ['locale' => 'en']),
            $this->registrationPayload(['location_selection' => $space])
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['location_selection']);
    }

    #[DataProvider('validIconPlusSpacesProvider')]
    public function test_icon_rejects_icon_plus_reserved_spaces(string $space): void
    {
        $response = $this->postJson(
            route('public.register.icon', ['locale' => 'en']),
            $this->iconPayload(['location_selection' => $space])
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['location_selection']);
    }

    public function test_icon_plus_and_icon_reject_manual_or_registration_occupied_spaces(): void
    {
        HallSpaceBooking::query()->create(['space' => 'L.W.1']);
        IconRegistration::query()->create([
            'full_name' => 'Existing Icon',
            'email' => 'existing-icon@example.com',
            'phone' => '+966512345678',
            'job_title' => 'Lead',
            'organization' => 'Existing Icon Co',
            'location_selection' => 'A01',
            'status' => 'pending',
        ]);

        $this->postJson(
            route('public.register.icon-plus', ['locale' => 'en']),
            $this->registrationPayload(['location_selection' => 'L.W.1'])
        )->assertStatus(422)->assertJsonValidationErrors(['location_selection']);

        $this->postJson(
            route('public.register.icon', ['locale' => 'en']),
            $this->iconPayload(['location_selection' => 'A01'])
        )->assertStatus(422)->assertJsonValidationErrors(['location_selection']);
    }

    public function test_hall_design_styles_selectable_icon_plus_spaces_with_gold_border(): void
    {
        $response = $this->get('/hall-design?target=icon-plus');

        $response->assertOk();
        $response->assertSee('.hitbox.icon-plus-space', false);
        $response->assertSee('classes.push("icon-plus-space");', false);
        $response->assertSee("bookingTarget === 'icon-plus'", false);
    }

    public function test_icon_plus_pdf_generation_uses_icon_plus_contract_template(): void
    {
        $registration = new IconPlusRegistration([
            'full_name' => 'Icon Plus User',
            'organization' => 'Icon Plus Co',
            'location_selection' => 'R.W.28',
        ]);
        $registration->id = 9;

        $service = new class extends RegistrationPdfService
        {
            public string $usedTemplatePath = '';

            public array $usedValues = [];

            protected function iconPlusTemplatePaths(): array
            {
                return [
                    public_path('missing-contract-icon-plus.docx'),
                    public_path('contract-icon-plus.docx'),
                ];
            }

            protected function generateContractPdf(string $templatePath, array $values, string $destinationPath): string
            {
                $this->usedTemplatePath = $templatePath;
                $this->usedValues = $values;

                return $destinationPath;
            }
        };

        $generatedPath = $service->generateIconPlusPdf($registration);

        $this->assertSame('registrations/icon-plus/9.pdf', $generatedPath);
        $this->assertSame(public_path('contract-icon-plus.docx'), $service->usedTemplatePath);
        $this->assertSame([
            'organization' => 'Icon Plus Co',
            'name' => 'Icon Plus User',
            'cr_copy' => 'See attached file',
            'hall' => 'R.W.28',
        ], $service->usedValues);
    }

    public function test_admin_can_view_export_update_and_regenerate_icon_plus_registrations(): void
    {
        $admin = Admin::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $registration = IconPlusRegistration::query()->create([
            'full_name' => 'Icon Plus User',
            'email' => 'icon-plus@example.com',
            'phone' => '+966512345678',
            'job_title' => 'Lead',
            'organization' => 'Icon Plus Co',
            'location_selection' => 'R.W.28',
            'pdf_status' => 'pending',
            'status' => 'pending',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.icon-plus.index'))
            ->assertOk()
            ->assertSee('Icon Plus registrations');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.icon-plus.show', $registration))
            ->assertOk()
            ->assertSee('Icon Plus User');

        $this->actingAs($admin, 'admin')
            ->post(route('admin.icon-plus.update-status', $registration), ['status' => 'approved'])
            ->assertRedirect();

        $this->assertSame('approved', $registration->refresh()->status);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.icon-plus.export'))
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=utf-8');

        $this->actingAs($admin, 'admin')
            ->post(route('admin.icon-plus.regenerate-pdf', $registration))
            ->assertRedirect();

        $this->assertSame('generated', $registration->refresh()->pdf_status);
        $this->assertSame('registrations/icon-plus/1.pdf', $registration->pdf_path);
    }

    public function test_admin_regenerate_icon_plus_pdf_marks_registration_failed_when_generation_fails(): void
    {
        $admin = Admin::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $registration = IconPlusRegistration::query()->create([
            'full_name' => 'Icon Plus User',
            'email' => 'icon-plus@example.com',
            'phone' => '+966512345678',
            'job_title' => 'Lead',
            'organization' => 'Icon Plus Co',
            'location_selection' => 'R.W.28',
            'pdf_status' => 'pending',
            'status' => 'pending',
        ]);

        $this->app->instance(RegistrationPdfService::class, new class extends RegistrationPdfService
        {
            public function generateIconPlusPdf(IconPlusRegistration $registration): string
            {
                throw new RuntimeException('CloudConvert job creation failed.');
            }
        });

        $this->actingAs($admin, 'admin')
            ->from(route('admin.icon-plus.show', $registration))
            ->post(route('admin.icon-plus.regenerate-pdf', $registration))
            ->assertRedirect(route('admin.icon-plus.show', $registration))
            ->assertSessionHas('error', __('PDF regeneration failed. The team can review the error details below.'));

        $this->assertSame('failed', $registration->refresh()->pdf_status);
        $this->assertSame('CloudConvert job creation failed.', $registration->pdf_error);
    }

    public static function validIconPlusSpacesProvider(): array
    {
        return [
            ['L.W.1'],
            ['L.W.28'],
            ['R.W.1'],
            ['R.W.28'],
        ];
    }

    public static function invalidIconPlusSpacesProvider(): array
    {
        return [
            ['L.W.29'],
            ['R.W.29'],
            ['CZ1'],
            ['A01'],
        ];
    }

    private function registrationPayload(array $overrides = []): array
    {
        return array_merge([
            'form_identifier' => 'icon-plus',
            'full_name' => 'Icon Plus User',
            'email' => 'icon-plus@example.com',
            'phone' => '+966512345678',
            'job_title' => 'Lead',
            'organization' => 'Icon Plus Co',
            'location_selection' => 'L.W.1',
            'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
            'cr_copy' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
            'national_address_document' => UploadedFile::fake()->create('address.pdf', 100, 'application/pdf'),
            'company_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
            'privacy_policy' => '1',
        ], $overrides);
    }

    private function iconPayload(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'Icon User',
            'email' => 'icon@example.com',
            'phone' => '+966512345678',
            'job_title' => 'Lead',
            'organization' => 'Icon Co',
            'location_selection' => 'A01',
            'vat_number' => UploadedFile::fake()->create('vat.pdf', 100, 'application/pdf'),
            'cr_copy' => UploadedFile::fake()->create('cr.pdf', 100, 'application/pdf'),
            'national_address_document' => UploadedFile::fake()->create('address.pdf', 100, 'application/pdf'),
            'company_logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
            'privacy_policy' => '1',
        ], $overrides);
    }
}
