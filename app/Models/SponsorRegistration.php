<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SponsorRegistration extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'job_title',
        'organization',
        'location_selection',
        'vat_number',
        'cr_number',
        'national_address',
        'document_path',
        'cr_copy_path',
        'national_address_doc_path',
        'company_logo_path',
        'pdf_path',
        'status',
    ];
}
