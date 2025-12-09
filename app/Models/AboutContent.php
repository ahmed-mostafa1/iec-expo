<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $fillable = [
        'mission_en',
        'mission_ar',
        'goals_en',
        'goals_ar',
    ];
}
