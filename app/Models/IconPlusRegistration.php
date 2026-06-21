<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class IconPlusRegistration extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'job_title',
        'organization',
        'location_selection',
        'vat_certificate_path',
        'cr_copy_path',
        'national_address_doc_path',
        'company_logo_path',
        'pdf_path',
        'pdf_status',
        'pdf_error',
        'pdf_generated_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'pdf_generated_at' => 'datetime',
        ];
    }

    public static function filterPersistableAttributes(array $attributes): array
    {
        $model = new static;

        return array_intersect_key(
            $attributes,
            array_flip(Schema::getColumnListing($model->getTable()))
        );
    }

    public function updatePersistableAttributes(array $attributes): bool
    {
        return $this->update(static::filterPersistableAttributes($attributes));
    }
}
