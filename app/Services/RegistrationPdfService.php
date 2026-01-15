<?php

namespace App\Services;

use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use App\Models\IconRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

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
        $tempBase = tempnam(sys_get_temp_dir(), 'contract_');

        if ($tempBase === false) {
            throw new \RuntimeException('Unable to create a temporary contract file.');
        }

        $tempDocx = $tempBase . '.docx';
        @unlink($tempBase);

        if (! copy($templatePath, $tempDocx)) {
            throw new \RuntimeException('Unable to copy contract template.');
        }

        $zip = new \ZipArchive();
        if ($zip->open($tempDocx) !== true) {
            throw new \RuntimeException('Unable to open contract template.');
        }

        foreach ($this->getContractXmlParts($zip) as $part) {
            $xml = $zip->getFromName($part);
            if ($xml === false) {
                continue;
            }

            $updatedXml = $this->replaceWordXmlPlaceholders($xml, $values);
            if ($updatedXml !== $xml) {
                $zip->addFromString($part, $updatedXml);
            }
        }

        $zip->close();

        return $tempDocx;
    }

    private function convertDocxToPdf(string $docxPath): string
    {
        Settings::setDefaultRtl(true);
        Settings::setDefaultFontName('DejaVu Sans');
        Settings::setDefaultAsianFontName('DejaVu Sans');

        $phpWord = IOFactory::load($docxPath);
        $tempBase = tempnam(sys_get_temp_dir(), 'contract_pdf_');

        if ($tempBase === false) {
            throw new \RuntimeException('Unable to create a temporary PDF file.');
        }

        $tempPdf = $tempBase . '.pdf';
        @unlink($tempBase);

        $tempHtml = $tempBase . '.html';
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        $htmlWriter->save($tempHtml);

        $html = file_get_contents($tempHtml);
        @unlink($tempHtml);

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($this->injectRtlStyles($html), 'UTF-8');
        $dompdf->render();

        file_put_contents($tempPdf, $dompdf->output());

        return $tempPdf;
    }

    private function injectRtlStyles(?string $html): string
    {
        $styleBlock = '<style>body, * { font-family: "DejaVu Sans" !important; direction: rtl; unicode-bidi: embed; }</style>';
        $charset = '<meta charset="UTF-8">';

        if (! $html) {
            return '<html><head>' . $charset . $styleBlock . '</head><body></body></html>';
        }

        if (stripos($html, '<head>') !== false) {
            return preg_replace(
                '/<head>/i',
                '<head>' . $charset . $styleBlock,
                $html,
                1
            );
        }

        return $charset . $styleBlock . $html;
    }

    private function getContractXmlParts(\ZipArchive $zip): array
    {
        $parts = [];

        for ($index = 0; $index < $zip->numFiles; $index++) {
            $name = $zip->getNameIndex($index);
            if ($name === 'word/document.xml' || preg_match('/^word\\/(header|footer)\\d+\\.xml$/', $name)) {
                $parts[] = $name;
            }
        }

        return $parts;
    }

    private function replaceWordXmlPlaceholders(string $xml, array $values): string
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        $document->preserveWhiteSpace = true;
        $document->formatOutput = false;

        $previousSetting = libxml_use_internal_errors(true);
        $loaded = $document->loadXML($xml);
        libxml_use_internal_errors($previousSetting);
        libxml_clear_errors();

        if (! $loaded) {
            return $xml;
        }

        $xpath = new \DOMXPath($document);
        $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

        foreach ($values as $key => $value) {
            $replacement = (string) $value;
            $this->replacePlaceholderInXml($xpath, '{' . $key . '}', $replacement);
            $this->replacePlaceholderInXml($xpath, (string) $key, $replacement);
        }

        return $document->saveXML();
    }

    private function replacePlaceholderInXml(\DOMXPath $xpath, string $placeholder, string $replacement): void
    {
        if ($placeholder === '') {
            return;
        }

        $placeholderLength = mb_strlen($placeholder, 'UTF-8');

        while (true) {
            $nodes = $xpath->query('//w:t');
            if ($nodes === false || $nodes->length === 0) {
                return;
            }

            $parts = [];
            $fullText = '';

            foreach ($nodes as $node) {
                $text = $node->nodeValue ?? '';
                $start = mb_strlen($fullText, 'UTF-8');
                $length = mb_strlen($text, 'UTF-8');
                $parts[] = [
                    'node' => $node,
                    'start' => $start,
                    'length' => $length,
                ];
                $fullText .= $text;
            }

            $position = mb_strpos($fullText, $placeholder, 0, 'UTF-8');
            if ($position === false) {
                return;
            }

            $endPosition = $position + $placeholderLength;
            $replaced = false;

            foreach ($parts as $part) {
                $partStart = $part['start'];
                $partEnd = $partStart + $part['length'];

                if ($partEnd <= $position || $partStart >= $endPosition) {
                    continue;
                }

                $node = $part['node'];
                $nodeText = $node->nodeValue ?? '';
                $localStart = max(0, $position - $partStart);
                $localEnd = min($part['length'], $endPosition - $partStart);
                $before = mb_substr($nodeText, 0, $localStart, 'UTF-8');
                $after = mb_substr($nodeText, $localEnd, null, 'UTF-8');

                if (! $replaced) {
                    $node->nodeValue = $before . $replacement . $after;
                    $replaced = true;
                } else {
                    $node->nodeValue = $before . $after;
                }
            }
        }
    }
}
