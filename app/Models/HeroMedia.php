<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroMedia extends Model
{
    protected $fillable = [
        'title_en',
        'title_ar',
        'subtitle_en',
        'subtitle_ar',
        'video_type',
        'video_url',
        'video_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
