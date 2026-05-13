<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IconRegistration extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'job_title',
        'organization',
        'location_selection',
        'vat_number',
        'vat_certificate_path',
        'national_address',
        'document_path',
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
}
