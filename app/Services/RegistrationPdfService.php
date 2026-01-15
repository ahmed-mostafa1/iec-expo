<?php

namespace App\Services;

use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use App\Models\IconRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use Mpdf\Output\Destination as MpdfDestination;
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
            'icon-location-selection' => (string) ($registration->location_selection ?? ''),
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
            'icon-location-selection' => (string) ($registration->location_selection ?? ''),
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
        
        // Set document properties for RTL
        $properties = $phpWord->getDocInfo();
        $properties->setTitle('Contract');
        $properties->setSubject('Contract Document');
        
        $tempBase = tempnam(sys_get_temp_dir(), 'contract_pdf_');

        if ($tempBase === false) {
            throw new \RuntimeException('Unable to create a temporary PDF file.');
        }

        // Use HTML conversion for better RTL control
        // PHPWord's native PDF writer doesn't properly respect RTL settings
        $tempPdf = $this->convertViaHtml($phpWord, $tempBase);

        return $tempPdf;
    }
    
    private function convertViaHtml($phpWord, $tempBase): string
    {
        $tempPdf = $tempBase . '.pdf';
        $tempHtml = $tempBase . '.html';
        
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        $htmlWriter->save($tempHtml);

        // Read the HTML file with explicit UTF-8 encoding
        $html = file_get_contents($tempHtml);
        @unlink($tempHtml);

        // Ensure the HTML string is properly UTF-8 encoded
        if (!mb_check_encoding($html, 'UTF-8')) {
            $html = mb_convert_encoding($html, 'UTF-8', mb_detect_encoding($html, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true));
        }

        $html = $this->normalizeContractHtml($html);

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'default_font' => 'dejavusans',
            'directionality' => 'rtl',
            'margin_left' => 20,
            'margin_right' => 20,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'default_font_size' => 11,
        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetDirectionality('rtl');
        $mpdf->WriteHTML($this->injectRtlStyles($html));
        $mpdf->Output($tempPdf, MpdfDestination::FILE);
        
        return $tempPdf;
    }

    private function injectRtlStyles(?string $html): string
    {
        $styleBlock = '<style>
            @page {
                margin: 2cm;
            }
            * { 
                font-family: "DejaVu Sans", sans-serif !important; 
                direction: rtl !important; 
                unicode-bidi: embed !important;
                text-align: right !important;
            }
            html {
                direction: rtl !important;
                text-align: right !important;
            }
            body {
                direction: rtl !important;
                text-align: right !important;
                margin: 0;
                padding: 0;
                font-size: 11pt;
                line-height: 1.5;
            }
            p {
                direction: rtl !important;
                text-align: right !important;
                text-align-last: right !important;
                margin: 0.3em 0;
                line-height: 1.5;
            }
            div {
                direction: rtl !important;
                text-align: right !important;
            }
            span {
                direction: rtl !important;
                text-align: right !important;
            }
            h1, h2, h3, h4, h5, h6 {
                direction: rtl !important;
                text-align: right !important;
                text-align-last: right !important;
                font-weight: bold;
                margin: 0.5em 0;
            }
            h1 { font-size: 16pt; }
            h2 { font-size: 14pt; }
            h3 { font-size: 13pt; }
            h4 { font-size: 12pt; }
            table {
                direction: rtl !important;
                width: 100%;
            }
            table td, table th {
                direction: rtl !important;
                text-align: right !important;
                padding: 5px;
            }
            li {
                direction: rtl !important;
                text-align: right !important;
            }
            ul, ol {
                direction: rtl !important;
                text-align: right !important;
            }
            /* Force override any inline styles */
            [style] {
                direction: rtl !important;
                text-align: right !important;
            }
            /* Ensure consistent formatting across all pages */
            div[style*="page-break"] {
                direction: rtl !important;
                text-align: right !important;
            }
        </style>';
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

    private function normalizeContractHtml(?string $html): string
    {
        if (! $html) {
            return '';
        }

        // Ensure the HTML is treated as UTF-8
        // PHPWord's HTML writer outputs UTF-8, so we preserve it as-is
        // Do NOT use utf8_decode() as it converts to Latin-1 and breaks Arabic text

        // Remove ALL text-align and direction inline styles to let CSS take over
        $html = preg_replace('/text-align:\s*[^;"\'>]+\s*;?/i', '', $html);
        $html = preg_replace('/direction:\s*[^;"\'>]+\s*;?/i', '', $html);
        
        // Remove float styles that might interfere with RTL
        $html = preg_replace('/float:\s*[^;"\'>]+\s*;?/i', '', $html);
        
        // Remove empty style attributes
        $html = preg_replace('/style="\s*"/i', '', $html);
        $html = preg_replace('/style=\'\s*\'/i', '', $html);
        $html = preg_replace('/style="\s*;+\s*"/i', '', $html);

        // Convert <br> tags to proper paragraph breaks for better structure
        // This helps maintain the original document's paragraph structure
        $html = preg_replace('/<br\s*\/?>/i', '</p><p>', $html);
        
        // Clean up any empty paragraphs that might have been created
        $html = preg_replace('/<p>\s*<\/p>/i', '', $html);
        
        // Add RTL attributes to body and main containers
        $html = preg_replace('/<body([^>]*)>/i', '<body$1 dir="rtl">', $html);
        $html = preg_replace('/<div([^>]*)>/i', '<div$1 dir="rtl">', $html);

        // Prevent mPDF from exploding page count on Word page styles.
        $html = preg_replace('/@page\s+page\d+\s*\{[^}]*\}/i', '', $html);
        $html = preg_replace('/page:\s*page\d+;?/i', '', $html);
        $html = preg_replace('/body\s*>\s*div\s*\+\s*div\s*\{[^}]*\}/i', '', $html);
        
        // Keep page breaks but ensure they don't interfere with RTL
        // $html = preg_replace('/page-break-before:\s*always;?/i', '', $html);

        return $html;
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
