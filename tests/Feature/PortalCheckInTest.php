<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\CheckIn;
use App\Models\Employee;
use App\Models\VisitorRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class PortalCheckInTest extends TestCase
{
    use RefreshDatabase;

    private function makeEmployee(): Employee
    {
        return Employee::create([
            'name' => 'Scanner Bob',
            'email' => 'bob@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    private function makeRegistration(): VisitorRegistration
    {
        return VisitorRegistration::create([
            'full_name' => 'Test Visitor',
            'email' => 'visitor@example.com',
            'phone' => '0555555555',
            'job_title' => 'Manager',
            'company_name' => 'Visitor Co',
            'heard_about' => 'social_media',
        ]);
    }

    private function signedBadgeUrl(int $registrationId): string
    {
        return URL::signedRoute('public.badge.show', [
            'type' => 'visitor',
            'registration' => $registrationId,
        ]);
    }

    public function test_guest_cannot_access_scan_page(): void
    {
        $this->get(route('portal.scan'))->assertRedirect(route('portal.login'));
    }

    public function test_valid_signed_qr_creates_a_check_in(): void
    {
        $employee = $this->makeEmployee();
        $registration = $this->makeRegistration();

        $response = $this->actingAs($employee, 'employee')
            ->postJson(route('portal.scan.store'), ['url' => $this->signedBadgeUrl($registration->id)]);

        $response->assertOk()->assertJson(['duplicate' => false]);

        $this->assertDatabaseHas('check_ins', [
            'registrant_type' => 'visitor',
            'registrant_id' => $registration->id,
            'employee_id' => $employee->id,
        ]);
    }

    public function test_tampered_qr_url_is_rejected_and_creates_no_check_in(): void
    {
        $employee = $this->makeEmployee();
        $registration = $this->makeRegistration();

        $signedUrl = $this->signedBadgeUrl($registration->id);
        $tamperedUrl = str_replace('/'.$registration->id.'?', '/'.($registration->id + 999).'?', $signedUrl);

        $response = $this->actingAs($employee, 'employee')
            ->postJson(route('portal.scan.store'), ['url' => $tamperedUrl]);

        $response->assertStatus(422);
        $this->assertDatabaseCount('check_ins', 0);
    }

    public function test_duplicate_scan_warns_then_confirms(): void
    {
        $employee = $this->makeEmployee();
        $registration = $this->makeRegistration();
        $signedUrl = $this->signedBadgeUrl($registration->id);

        $this->actingAs($employee, 'employee')
            ->postJson(route('portal.scan.store'), ['url' => $signedUrl])
            ->assertOk();

        $this->actingAs($employee, 'employee')
            ->postJson(route('portal.scan.store'), ['url' => $signedUrl])
            ->assertOk()
            ->assertJson(['duplicate' => true]);

        $this->assertDatabaseCount('check_ins', 1);

        $this->actingAs($employee, 'employee')
            ->postJson(route('portal.scan.store'), ['url' => $signedUrl, 'confirm' => true])
            ->assertOk()
            ->assertJson(['duplicate' => false]);

        $this->assertDatabaseCount('check_ins', 2);
    }

    public function test_admin_can_create_an_employee(): void
    {
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.employees.store'), [
                'name' => 'New Employee',
                'email' => 'new@example.com',
                'password' => 'password123',
            ])
            ->assertRedirect(route('admin.employees.index'));

        $this->assertDatabaseHas('employees', ['email' => 'new@example.com']);
    }

    public function test_admin_can_export_check_ins_csv(): void
    {
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password'),
        ]);

        $employee = $this->makeEmployee();
        $registration = $this->makeRegistration();

        CheckIn::create([
            'registrant_type' => 'visitor',
            'registrant_id' => $registration->id,
            'employee_id' => $employee->id,
            'scanned_at' => now(),
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.check-ins.export'))
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=utf-8');
    }
}
