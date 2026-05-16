<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AnalyticsDailyStat extends Model
{
    protected $fillable = [
        'date',
        'active_users',
        'new_users',
        'sessions',
        'screen_page_views',
        'event_count',
        'key_events',
        'average_session_duration',
        'engagement_rate',
        'sponsor_registrations',
        'icon_registrations',
        'visitor_registrations',
    ];

    protected function casts(): array
    {
        return [
            'active_users' => 'integer',
            'new_users' => 'integer',
            'sessions' => 'integer',
            'screen_page_views' => 'integer',
            'event_count' => 'integer',
            'key_events' => 'float',
            'average_session_duration' => 'float',
            'engagement_rate' => 'float',
            'sponsor_registrations' => 'integer',
            'icon_registrations' => 'integer',
            'visitor_registrations' => 'integer',
        ];
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn (string $value): CarbonImmutable => CarbonImmutable::parse($value),
            set: fn (string $value): string => CarbonImmutable::parse($value)->toDateString(),
        );
    }
}
