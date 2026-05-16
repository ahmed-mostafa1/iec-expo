<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AnalyticsSyncRun extends Model
{
    protected $fillable = [
        'status',
        'property_id',
        'date_from',
        'date_to',
        'force',
        'started_at',
        'finished_at',
        'reports',
        'quota',
        'error',
        'rows_imported',
    ];

    protected function casts(): array
    {
        return [
            'force' => 'boolean',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'reports' => 'array',
            'quota' => 'array',
            'rows_imported' => 'integer',
        ];
    }

    protected function dateFrom(): Attribute
    {
        return Attribute::make(
            get: fn (string $value): CarbonImmutable => CarbonImmutable::parse($value),
            set: fn (string $value): string => CarbonImmutable::parse($value)->toDateString(),
        );
    }

    protected function dateTo(): Attribute
    {
        return Attribute::make(
            get: fn (string $value): CarbonImmutable => CarbonImmutable::parse($value),
            set: fn (string $value): string => CarbonImmutable::parse($value)->toDateString(),
        );
    }
}
