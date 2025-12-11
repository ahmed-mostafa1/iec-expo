<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Support\Carbon;

class ParticipantShowController extends Controller
{
    public function __invoke(string $participant)
    {
        $participantModel = null;

        try {
            $participantModel = Participant::find($participant);
        } catch (\Throwable $e) {
            report($e);
        }

        if (! $participantModel) {
            $demoParticipants = config('demo.participants', []);
            $demo = $demoParticipants[$participant] ?? $demoParticipants[(int) $participant] ?? null;

            if (! $demo) {
                abort(404);
            }

            $participantModel = new Participant($demo);
            $participantModel->id = $participant;
            $participantModel->exists = false;
            $participantModel->created_at = Carbon::now();
            $participantModel->updated_at = Carbon::now();
        }

        return view('public.participants.show', ['participant' => $participantModel]);
    }
}
