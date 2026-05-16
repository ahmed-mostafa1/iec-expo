<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AnalyticsReportRow extends Model
{
    protected $fillable = [
        'report',
        'date',
        'dimension_hash',
        'dimensions',
        'label',
        'active_users',
        'sessions',
        'screen_page_views',
        'event_count',
        'key_events',
    ];

    protected function casts(): array
    {
        return [
            'dimensions' => 'array',
            'active_users' => 'integer',
            'sessions' => 'integer',
            'screen_page_views' => 'integer',
            'event_count' => 'integer',
            'key_events' => 'float',
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
