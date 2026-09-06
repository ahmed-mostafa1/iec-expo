<?php

namespace App\Support;

use App\Models\IconPlusQuartetRegistration;
use App\Models\IconPlusRegistration;
use App\Models\IconQuartetRegistration;
use App\Models\IconRegistration;
use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;

class RegistrationTypes
{
    public const TYPE_MODELS = [
        'visitor' => VisitorRegistration::class,
        'sponsor' => SponsorRegistration::class,
        'icon' => IconRegistration::class,
        'icon-plus' => IconPlusRegistration::class,
        'icon-quartet' => IconQuartetRegistration::class,
        'icon-plus-quartet' => IconPlusQuartetRegistration::class,
    ];
}
