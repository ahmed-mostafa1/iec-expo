<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\CheckIn;
use App\Support\RegistrationTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class ScanController extends Controller
{
    public function index()
    {
        return view('portal.scan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'url' => ['required', 'string'],
        ]);

        // Scanned URLs are validated by recomputing the expected signed URL
        // ourselves (via the same `route()`/APP_URL config the app already
        // trusts) rather than replaying the raw string through the router as
        // a synthetic Request — that approach breaks whenever the app is
        // served from a subdirectory (e.g. /iec360), because a manually
        // built Request has no way to know that prefix should be stripped
        // before route matching, and every scan fails as "invalid QR code".
        if (! preg_match('#/badge/([a-z0-9-]+)/(\d+)(?:[/?].*)?$#i', (string) $data['url'], $matches)) {
            Log::warning('portal.scan: URL did not match the expected /badge/{type}/{id} pattern.', [
                'url' => $data['url'],
            ]);

            return response()->json(['error' => __('Invalid QR code.')], 422);
        }

        $type = $matches[1];
        $registrationId = $matches[2];

        if (! array_key_exists($type, RegistrationTypes::TYPE_MODELS)) {
            Log::warning('portal.scan: unknown registration type in scanned URL.', [
                'url' => $data['url'],
                'type' => $type,
            ]);

            return response()->json(['error' => __('Invalid QR code.')], 422);
        }

        $expectedUrl = URL::signedRoute('public.badge.show', ['type' => $type, 'registration' => $registrationId]);

        $expectedSignature = [];
        parse_str((string) parse_url($expectedUrl, PHP_URL_QUERY), $expectedSignature);

        $submittedSignature = [];
        parse_str((string) parse_url($data['url'], PHP_URL_QUERY), $submittedSignature);

        if (
            empty($submittedSignature['signature'])
            || empty($expectedSignature['signature'])
            || ! hash_equals($expectedSignature['signature'], $submittedSignature['signature'])
        ) {
            Log::warning('portal.scan: signature mismatch.', [
                'submitted_url' => $data['url'],
                'expected_url' => $expectedUrl,
                'app_url' => config('app.url'),
            ]);

            return response()->json(['error' => __('Invalid or expired QR code.')], 422);
        }

        $registrant = RegistrationTypes::TYPE_MODELS[$type]::find($registrationId);

        if (! $registrant) {
            Log::warning('portal.scan: registrant not found.', [
                'type' => $type,
                'registration_id' => $registrationId,
            ]);

            return response()->json(['error' => __('Registration not found.')], 404);
        }

        $existing = CheckIn::where('registrant_type', $type)
            ->where('registrant_id', $registrationId)
            ->with('employee')
            ->latest('scanned_at')
            ->first();

        if ($existing && ! $request->boolean('confirm')) {
            return response()->json([
                'duplicate' => true,
                'employee' => $existing->employee->name,
                'scanned_at' => $existing->scanned_at->toDateTimeString(),
            ]);
        }

        CheckIn::create([
            'registrant_type' => $type,
            'registrant_id' => $registrationId,
            'employee_id' => $request->user('employee')->id,
            'scanned_at' => now(),
        ]);

        $typeLabel = match ($type) {
            'visitor' => 'VISITOR',
            'sponsor' => 'SPONSOR',
            default => 'ICON',
        };

        $badgeData = $registrant->badgeViewData($typeLabel);

        return response()->json([
            'duplicate' => false,
            'name' => $badgeData['name'],
            'company' => $badgeData['company'],
            'type_label' => $typeLabel,
        ]);
    }
}
