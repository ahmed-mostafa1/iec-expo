<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\IconPlusQuartetRegistration;
use App\Models\IconPlusRegistration;
use App\Models\IconQuartetRegistration;
use App\Models\IconRegistration;
use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use Illuminate\View\View;

class BadgeController extends Controller
{
    private const TYPE_MODELS = [
        'visitor' => VisitorRegistration::class,
        'sponsor' => SponsorRegistration::class,
        'icon' => IconRegistration::class,
        'icon-plus' => IconPlusRegistration::class,
        'icon-quartet' => IconQuartetRegistration::class,
        'icon-plus-quartet' => IconPlusQuartetRegistration::class,
    ];

    public function show(string $type, int $registration): View
    {
        abort_unless(array_key_exists($type, self::TYPE_MODELS), 404);

        $model = self::TYPE_MODELS[$type]::findOrFail($registration);

        $typeLabel = match ($type) {
            'visitor' => 'VISITOR',
            'sponsor' => 'SPONSOR',
            default => 'ICON',
        };

        return view('public.badge', $model->badgeViewData($typeLabel));
    }
}
