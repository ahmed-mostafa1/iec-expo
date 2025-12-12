<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'logo_path',
        'description_en',
        'description_ar',
        'url',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getLocalizedName(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'ar' && $this->name_ar) {
            return $this->name_ar;
        }

        return $this->name;
    }

    public function getDescriptionForLocale(?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'ar' && $this->description_ar) {
            return $this->description_ar;
        }

        return $this->description_en;
    }
}
