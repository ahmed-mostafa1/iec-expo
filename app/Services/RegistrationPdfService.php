<?php

namespace App\Services;

use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use App\Models\IconRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

class RegistrationPdfService
{
    public function generateSponsorPdf(SponsorRegistration $registration): string
    {
        $path = "registrations/sponsors/{$registration->id}.pdf";

        return $this->generateContractPdf([
            'organization' => (string) ($registration->organization ?? ''),
            'cr_number' => (string) ($registration->cr_number ?? ''),
            'full_name' => (string) ($registration->full_name ?? ''),
        ], $path);
    }

    public function generateVisitorPdf(VisitorRegistration $registration): string
    {
        $pdf = Pdf::loadView('pdf.visitor_registration', [
            'registration' => $registration,
        ]);

        $path = "registrations/visitors/{$registration->id}.pdf";

        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    public function generateIconPdf(IconRegistration $registration): string
    {
        $path = "registrations/icons/{$registration->id}.pdf";

        return $this->generateContractPdf([
            'organization' => (string) ($registration->organization ?? ''),
            'cr_number' => (string) ($registration->cr_number ?? ''),
            'full_name' => (string) ($registration->full_name ?? ''),
        ], $path);
    }

    private function generateContractPdf(array $values, string $destinationPath): string
    {
        $templatePath = public_path('contract.docx');

        if (! is_file($templatePath)) {
            throw new \RuntimeException('Contract template not found.');
        }

        $docxPath = $this->renderContractDocx($templatePath, $values);
        $pdfPath = $this->convertDocxToPdf($docxPath);

        Storage::disk('public')->put($destinationPath, file_get_contents($pdfPath));

        @unlink($docxPath);
        @unlink($pdfPath);

        return $destinationPath;
    }

    private function renderContractDocx(string $templatePath, array $values): string
    {
        $processor = new TemplateProcessor($templatePath);
        $processor->setMacroChars('{', '}');

        foreach ($values as $key => $value) {
            $processor->setValue($key, (string) $value);
        }

        $tempBase = tempnam(sys_get_temp_dir(), 'contract_');

        if ($tempBase === false) {
            throw new \RuntimeException('Unable to create a temporary contract file.');
        }

        $tempDocx = $tempBase . '.docx';
        @unlink($tempBase);
        $processor->saveAs($tempDocx);

        return $tempDocx;
    }

    private function convertDocxToPdf(string $docxPath): string
    {
        Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
        Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));

        $phpWord = IOFactory::load($docxPath);
        $tempBase = tempnam(sys_get_temp_dir(), 'contract_pdf_');

        if ($tempBase === false) {
            throw new \RuntimeException('Unable to create a temporary PDF file.');
        }

        $tempPdf = $tempBase . '.pdf';
        @unlink($tempBase);

        $writer = IOFactory::createWriter($phpWord, 'PDF');
        $writer->save($tempPdf);

        return $tempPdf;
    }
}
