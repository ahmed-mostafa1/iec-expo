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
        'description_en',
        'description_ar',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getDescriptionForLocale(?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'ar' && $this->description_ar) {
            return $this->description_ar;
        }

        return $this->description_en;
    }
}
