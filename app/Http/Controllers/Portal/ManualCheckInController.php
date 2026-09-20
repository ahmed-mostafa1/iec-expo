<?php

namespace App\Http\Controllers\Portal;

use App\Http\Requests\Concerns\HasSaudiPhoneValidation;
use App\Jobs\ProcessVisitorRegistrationSubmission;
use App\Models\VisitorRegistration;
use App\Support\RegistrationTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManualCheckInController extends \App\Http\Controllers\Controller
{
    use HasSaudiPhoneValidation;

    public function index()
    {
        return view('portal.checkin');
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $like = '%'.str_replace(['%', '_'], ['\\%', '\\_'], $q).'%';

        $results = [];

        foreach (RegistrationTypes::TYPE_MODELS as $type => $model) {
            $matches = $model::query()
                ->where(function ($query) use ($like) {
                    $query->where('full_name', 'like', $like)
                        ->orWhere('phone', 'like', $like)
                        ->orWhere('email', 'like', $like);
                })
                ->limit(10)
                ->get(['id', 'full_name', 'phone', 'email']);

            foreach ($matches as $match) {
                $results[] = [
                    'type' => $type,
                    'id' => $match->id,
                    'name' => $match->full_name,
                    'phone' => $match->phone,
                    'email' => $match->email,
                ];
            }
        }

        return response()->json(['results' => array_slice($results, 0, 20)]);
    }

    public function checkIn(Request $request, string $type, int $id)
    {
        if (! array_key_exists($type, RegistrationTypes::TYPE_MODELS)) {
            return response()->json(['error' => __('Invalid registration type.')], 422);
        }

        $registrant = RegistrationTypes::TYPE_MODELS[$type]::find($id);

        if (! $registrant) {
            Log::warning('portal.manual-checkin: registrant not found.', ['type' => $type, 'id' => $id]);

            return response()->json(['error' => __('Registration not found.')], 404);
        }

        return ScanController::checkIn($type, $registrant, $request->user('employee')->id, $request->boolean('confirm'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50', $this->saudiPhoneRule()],
            'job_title' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
        ], [
            'phone.regex' => $this->saudiPhoneMessage(),
        ]);

        $registration = VisitorRegistration::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'job_title' => $data['job_title'],
            'company_name' => $data['company_name'],
            'company_predefined' => null,
            'company_is_other' => false,
            'heard_about' => 'other',
            'heard_about_other_text' => 'Walk-in manual registration at check-in desk',
            'interests' => null,
        ]);

        ProcessVisitorRegistrationSubmission::dispatchAfterResponse($registration);

        return ScanController::checkIn('visitor', $registration, $request->user('employee')->id, false);
    }
}
