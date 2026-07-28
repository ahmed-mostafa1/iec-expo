<?php

namespace App\Models;

use App\Models\Concerns\HasQrTicket;
use Illuminate\Database\Eloquent\Model;

class VisitorRegistration extends Model
{
    use HasQrTicket;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'job_title',
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

    /**
     * Everything the visitor submitted — feeds the badge page's name/company fields.
     */
    public function qrPayload(): array
    {
        return array_filter([
            'id'                     => $this->id,
            'full_name'              => $this->full_name,
            'email'                  => $this->email,
            'phone'                  => $this->phone,
            'job_title'              => $this->job_title,
            'company_name'           => $this->company_name,
            'heard_about'            => $this->heard_about,
            'heard_about_other_text' => $this->heard_about_other_text,
            'registered_at'          => $this->created_at?->toDateTimeString(),
        ], fn ($value) => $value !== null && $value !== '');
    }

    public function badgeRouteType(): string
    {
        return 'visitor';
    }
}
