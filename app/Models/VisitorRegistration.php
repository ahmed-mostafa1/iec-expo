<?php

namespace App\Models;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Illuminate\Database\Eloquent\Model;

class VisitorRegistration extends Model
{
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
     * Everything the visitor submitted — this is what the QR code carries verbatim.
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

    public function qrPng(): string
    {
        return $this->qrResult()->getString();
    }

    public function qrPngDataUri(): string
    {
        return $this->qrResult()->getDataUri();
    }

    private function qrResult(): ResultInterface
    {
        // ponytail: unescaped unicode keeps Arabic values at 2 bytes instead of 6, which
        // keeps the QR a few versions smaller and easier to scan.
        $json = json_encode(
            $this->qrPayload(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        return (new PngWriter())->write(new QrCode(
            data: $json,
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: 320,
        ));
    }
}
