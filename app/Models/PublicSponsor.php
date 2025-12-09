<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicSponsor extends Model
{
    protected $fillable = [
        'name',
        'logo_path',
        'tier',
        'url',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
