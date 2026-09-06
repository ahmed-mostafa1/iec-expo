<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Support\RegistrationTypes;
use Illuminate\View\View;

class BadgeController extends Controller
{
    public function show(string $type, int $registration): View
    {
        abort_unless(array_key_exists($type, RegistrationTypes::TYPE_MODELS), 404);

        $model = RegistrationTypes::TYPE_MODELS[$type]::findOrFail($registration);

        $typeLabel = match ($type) {
            'visitor' => 'VISITOR',
            'sponsor' => 'SPONSOR',
            default => 'ICON',
        };

        return view('public.badge', $model->badgeViewData($typeLabel));
    }
}
