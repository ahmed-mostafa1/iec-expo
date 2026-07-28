<?php

namespace App\Models;

use App\Models\Concerns\HasQrTicket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class IconRegistration extends Model
{
    use HasQrTicket;

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
        'cr_copy',
        'national_address_doc_path',
        'company_logo_path',
        'pdf_path',
        'pdf_status',
        'pdf_error',
        'pdf_generated_at',
        'status',
        'ticket_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'pdf_generated_at' => 'datetime',
            'ticket_sent_at' => 'datetime',
        ];
    }

    public function qrPayload(): array
    {
        return array_filter([
            'id'                 => $this->id,
            'type'               => 'icon',
            'full_name'          => $this->full_name,
            'email'              => $this->email,
            'phone'              => $this->phone,
            'job_title'          => $this->job_title,
            'organization'       => $this->organization,
            'location_selection' => $this->location_selection,
            'registered_at'      => $this->created_at?->toDateTimeString(),
        ], fn ($value) => $value !== null && $value !== '');
    }

    public function badgeRouteType(): string
    {
        return 'icon';
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
