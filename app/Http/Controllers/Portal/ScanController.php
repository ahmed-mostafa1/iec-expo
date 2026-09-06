<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\CheckIn;
use App\Support\RegistrationTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

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

        $signedRequest = Request::create($data['url']);

        try {
            $matched = Route::getRoutes()->match($signedRequest);
        } catch (ResourceNotFoundException) {
            return response()->json(['error' => __('Invalid QR code.')], 422);
        }

        if ($matched->getName() !== 'public.badge.show' || ! $signedRequest->hasValidSignature()) {
            return response()->json(['error' => __('Invalid or expired QR code.')], 422);
        }

        $type = $matched->parameter('type');
        $registrationId = $matched->parameter('registration');

        abort_unless(array_key_exists($type, RegistrationTypes::TYPE_MODELS), 422);

        $registrant = RegistrationTypes::TYPE_MODELS[$type]::find($registrationId);

        if (! $registrant) {
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
