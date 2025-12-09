<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorRegistration extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'company_name',
        'company_predefined',
        'company_is_other',
        'heard_about',
        'heard_about_other_text',
        'interests',
        'pdf_path',
    ];

    protected $casts = [
        'company_is_other' => 'boolean',
    ];
}
