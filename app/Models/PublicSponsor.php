<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicSponsor extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'name_ar',
        'logo_path',
        'tier',
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

        if ($locale === 'en' && $this->name_en) {
            return $this->name_en;
        }

        return $locale === 'ar'
            ? ($this->name_ar ?: $this->name_en ?: $this->name)
            : ($this->name_en ?: $this->name_ar ?: $this->name);
    }

}
