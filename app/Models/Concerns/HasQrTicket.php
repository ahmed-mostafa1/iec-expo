<?php

namespace App\Models\Concerns;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Illuminate\Support\Facades\URL;
use Throwable;
use Zxing\QrReader;

trait HasQrTicket
{
    /**
     * Some size/error-correction combinations produce a PNG that a subset of QR
     * readers (including our own decode-on-generate check below) fail to read back —
     * a rendering quirk in the underlying writer, not a content problem. Trying a
     * short list of alternates and verifying each one guarantees every QR that
     * actually reaches an email or the dashboard is provably scannable.
     */
    private const QR_ERROR_CORRECTION_LEVELS = [
        ErrorCorrectionLevel::High,
        ErrorCorrectionLevel::Quartile,
        ErrorCorrectionLevel::Medium,
    ];

    private const QR_SIZES = [320, 324, 328, 332, 336, 340];

    abstract public function qrPayload(): array;

    abstract public function badgeRouteType(): string;

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
        $url = URL::signedRoute('public.badge.show', [
            'type' => $this->badgeRouteType(),
            'registration' => $this->id,
        ]);

        $lastResult = null;

        foreach (self::QR_ERROR_CORRECTION_LEVELS as $level) {
            foreach (self::QR_SIZES as $size) {
                $result = (new PngWriter())->write(new QrCode(
                    data: $url,
                    errorCorrectionLevel: $level,
                    size: $size,
                ));

                if ($this->qrPngDecodesTo($result->getString(), $url)) {
                    return $result;
                }

                $lastResult = $result;
            }
        }

        // Exhausted every combination — extremely unlikely given the size of the
        // search space, but return the last attempt rather than throw.
        return $lastResult;
    }

    private function qrPngDecodesTo(string $png, string $expected): bool
    {
        try {
            return (new QrReader($png, QrReader::SOURCE_TYPE_BLOB))->text() === $expected;
        } catch (Throwable) {
            return false;
        }
    }
}
