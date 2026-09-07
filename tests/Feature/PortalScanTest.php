<?php

namespace Tests\Feature;

use App\Models\CheckIn;
use App\Models\Employee;
use App\Models\VisitorRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class PortalScanTest extends TestCase
{
    use RefreshDatabase;

    private function employee(): Employee
    {
        return Employee::create([
            'name' => 'Gate Staff',
            'email' => 'gate@example.com',
            'password' => bcrypt('secret'),
        ]);
    }

    private function visitor(): VisitorRegistration
    {
        return VisitorRegistration::create([
            'full_name' => 'Scanned Visitor',
            'email' => 'visitor@example.com',
            'phone' => '0555555555',
            'company_name' => 'Visitor Co',
            'heard_about' => 'social_media',
        ]);
    }

    public function test_scanning_a_valid_qr_code_checks_in_the_visitor(): void
    {
        $employee = $this->employee();
        $visitor = $this->visitor();

        $decodedUrl = (new \Zxing\QrReader($visitor->qrPng(), \Zxing\QrReader::SOURCE_TYPE_BLOB))->text();

        $response = $this->actingAs($employee, 'employee')
            ->postJson(route('portal.scan'), ['url' => $decodedUrl]);

        $response->assertOk();
        $response->assertJson([
            'duplicate' => false,
            'name' => 'Scanned Visitor',
        ]);

        $this->assertDatabaseHas('check_ins', [
            'registrant_type' => 'visitor',
            'registrant_id' => $visitor->id,
            'employee_id' => $employee->id,
        ]);
    }

    public function test_scanning_still_works_when_the_app_is_hosted_under_a_subdirectory(): void
    {
        // Reproduces the production layout (https://umbrella.sa/iec360/...),
        // where APP_URL includes a subdirectory prefix that is stripped by
        // the web server's document root before Laravel ever sees the
        // request — so the prefix appears in every generated absolute URL
        // (QR codes, signed links) but never in the routed request path.
        URL::forceRootUrl('https://umbrella.sa/iec360');

        $employee = $this->employee();
        $visitor = $this->visitor();

        $decodedUrl = (new \Zxing\QrReader($visitor->qrPng(), \Zxing\QrReader::SOURCE_TYPE_BLOB))->text();

        $this->assertStringContainsString('umbrella.sa/iec360/badge/visitor/', $decodedUrl);

        $this->actingAs($employee, 'employee');

        // Dispatched via a manually built Request (bypassing the test
        // client's own `url()`-based helper) so the request path matches
        // what the real web server would forward: no /iec360 prefix, even
        // though URL generation (above) is still forced to include one.
        $request = \Illuminate\Http\Request::create(
            'http://localhost/portal/scan',
            'POST',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode(['url' => $decodedUrl])
        );

        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode(), $response->getContent());
        $this->assertStringContainsString('"duplicate":false', $response->getContent());
    }

    public function test_scanning_the_same_code_twice_reports_a_duplicate(): void
    {
        $employee = $this->employee();
        $visitor = $this->visitor();

        $decodedUrl = (new \Zxing\QrReader($visitor->qrPng(), \Zxing\QrReader::SOURCE_TYPE_BLOB))->text();

        $this->actingAs($employee, 'employee')
            ->postJson(route('portal.scan'), ['url' => $decodedUrl])
            ->assertOk();

        $response = $this->actingAs($employee, 'employee')
            ->postJson(route('portal.scan'), ['url' => $decodedUrl]);

        $response->assertOk();
        $response->assertJson(['duplicate' => true]);

        $this->assertSame(1, CheckIn::count());
    }

    public function test_a_tampered_url_is_rejected(): void
    {
        $employee = $this->employee();
        $visitor = $this->visitor();

        $decodedUrl = (new \Zxing\QrReader($visitor->qrPng(), \Zxing\QrReader::SOURCE_TYPE_BLOB))->text();
        $tampered = preg_replace('/\/badge\/visitor\/\d+/', '/badge/visitor/999999', $decodedUrl);

        $response = $this->actingAs($employee, 'employee')
            ->postJson(route('portal.scan'), ['url' => $tampered]);

        $response->assertStatus(422);
    }
}
