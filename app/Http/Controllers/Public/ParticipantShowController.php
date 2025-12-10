<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Participant;

class ParticipantShowController extends Controller
{
    public function __invoke(Participant $participant)
    {
        return view('public.participants.show', compact('participant'));
    }
}
