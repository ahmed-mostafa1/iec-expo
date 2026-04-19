<?php

namespace App\Services;

use App\Models\IconRegistration;
use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class RegistrationPdfService
{
    public function generateSponsorPdf(SponsorRegistration $registration): string
    {
        $path = "registrations/sponsors/{$registration->id}.pdf";
        $templatePath = $this->resolveTemplatePath($this->sponsorTemplatePaths());

        return $this->generateContractPdf(
            $templatePath,
            $this->sponsorContractValues($registration, $templatePath),
            $path,
        );
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

        return $this->generateContractPdf(public_path('contract-v2.docx'), [
            'organization' => (string) ($registration->organization ?? ''),
            'name' => (string) ($registration->full_name ?? ''),
            'cr_copy' => 'See attached file',
            'hall' => (string) ($registration->location_selection ?? ''),
        ], $path);
    }

    protected function generateContractPdf(string $templatePath, array $values, string $destinationPath): string
    {
        $apiKey = config('services.cloudconvert.key');
        if (! $apiKey) {
            throw new \RuntimeException('CloudConvert API key is not configured.');
        }

        Storage::disk('local')->makeDirectory('tmp_docs');
        $tempFileName = 'contract_'.Str::uuid()->toString().'.docx';
        $tempDocxPath = Storage::disk('local')->path('tmp_docs/'.$tempFileName);

        try {
            $template = new TemplateProcessor($templatePath);
            foreach ($values as $key => $value) {
                $template->setValue($key, (string) $value);
            }
            $template->saveAs($tempDocxPath);

            $pdfContent = $this->convertDocxToPdfViaCloudConvert($tempDocxPath, $apiKey);
            Storage::disk('public')->put($destinationPath, $pdfContent);
        } finally {
            if (isset($tempDocxPath) && is_file($tempDocxPath)) {
                @unlink($tempDocxPath);
            }
        }

        return $destinationPath;
    }

    private function convertDocxToPdfViaCloudConvert(string $docxPath, string $apiKey): string
    {
        $jobResponse = Http::withToken($apiKey)
            ->acceptJson()
            ->post('https://api.cloudconvert.com/v2/jobs', [
                'tasks' => [
                    'import-docx' => [
                        'operation' => 'import/upload',
                    ],
                    'convert-docx-to-pdf' => [
                        'operation' => 'convert',
                        'input' => ['import-docx'],
                        'output_format' => 'pdf',
                    ],
                    'export-pdf' => [
                        'operation' => 'export/url',
                        'input' => ['convert-docx-to-pdf'],
                    ],
                ],
            ]);

        if (! $jobResponse->successful()) {
            throw new \RuntimeException('CloudConvert job creation failed.');
        }

        $jobData = $jobResponse->json('data');
        $jobId = $jobData['id'] ?? null;
        $tasks = $this->normalizeTasks($jobData['tasks'] ?? []);
        $importTask = $this->findTaskByName($tasks, 'import-docx');
        $uploadForm = $importTask['result']['form'] ?? null;

        if (! $jobId || ! $uploadForm || empty($uploadForm['url']) || empty($uploadForm['parameters'])) {
            throw new \RuntimeException('CloudConvert upload form missing from job response.');
        }

        $fileHandle = fopen($docxPath, 'r');
        $uploadResponse = Http::attach('file', $fileHandle, basename($docxPath))
            ->post($uploadForm['url'], $uploadForm['parameters']);
        if (is_resource($fileHandle)) {
            fclose($fileHandle);
        }

        if (! $uploadResponse->successful()) {
            throw new \RuntimeException('CloudConvert upload failed.');
        }

        $exportTask = null;
        $maxAttempts = 20;
        $delaySeconds = 2;
        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            $statusResponse = Http::withToken($apiKey)
                ->acceptJson()
                ->get("https://api.cloudconvert.com/v2/jobs/{$jobId}");

            if (! $statusResponse->successful()) {
                throw new \RuntimeException('Failed to check CloudConvert job status.');
            }

            $statusData = $statusResponse->json('data');
            $statusTasks = $this->normalizeTasks($statusData['tasks'] ?? []);
            $errorTask = $this->findTaskByStatus($statusTasks, 'error');
            if ($errorTask) {
                $errorMessage = $this->extractTaskError($errorTask);
                throw new \RuntimeException("CloudConvert task failed: {$errorMessage}");
            }

            $exportTask = $this->findTaskByName($statusTasks, 'export-pdf');
            if ($exportTask && ($exportTask['status'] ?? null) === 'finished') {
                break;
            }

            sleep($delaySeconds);
        }

        if (! $exportTask || ($exportTask['status'] ?? null) !== 'finished') {
            throw new \RuntimeException('CloudConvert conversion timed out before export was ready.');
        }

        $pdfUrl = $exportTask['result']['files'][0]['url'] ?? null;
        if (! $pdfUrl) {
            throw new \RuntimeException('CloudConvert export URL missing.');
        }

        $pdfResponse = Http::get($pdfUrl);
        if (! $pdfResponse->successful()) {
            throw new \RuntimeException('Failed to download generated PDF.');
        }

        return $pdfResponse->body();
    }

    private function normalizeTasks(array $tasks): array
    {
        if (array_is_list($tasks)) {
            return $tasks;
        }

        return array_values($tasks);
    }

    private function findTaskByName(array $tasks, string $name): ?array
    {
        foreach ($tasks as $task) {
            if (($task['name'] ?? null) === $name) {
                return $task;
            }
        }

        return null;
    }

    private function findTaskByStatus(array $tasks, string $status): ?array
    {
        foreach ($tasks as $task) {
            if (($task['status'] ?? null) === $status) {
                return $task;
            }
        }

        return null;
    }

    private function extractTaskError(array $task): string
    {
        $message = $task['result']['message'] ?? null;
        if ($message) {
            return $message;
        }

        $message = $task['message'] ?? null;
        if ($message) {
            return $message;
        }

        $message = $task['error']['message'] ?? null;
        if ($message) {
            return $message;
        }

        $message = $task['errors'][0]['message'] ?? null;
        if ($message) {
            return $message;
        }

        return 'Unknown CloudConvert error.';
    }

    private function sponsorTierContractValue(string $tier): string
    {
        return match ($tier) {
            'strategic' => 'الاستراتيجي',
            'diamond' => 'الماسي',
            'government' => 'الحكومي',
            'marketing' => 'التسويقي',
            'media' => 'الإعلامي',
            'technology' => 'التقني',
            'safety-security' => 'السلامة والأمن',
            'gold' => 'الذهبي',
            'other' => 'أخرى',
            default => $tier,
        };
    }

    protected function sponsorTemplatePaths(): array
    {
        return [
            public_path('sponsor-contract.docx'),
            public_path('contract-v2.docx'),
        ];
    }

    protected function sponsorContractValues(SponsorRegistration $registration, string $templatePath): array
    {
        if (basename($templatePath) === 'sponsor-contract.docx') {
            $pricing = $this->sponsorContractPricing((string) ($registration->sponsor_tier ?? ''));

            return [
                'organization' => (string) ($registration->organization ?? ''),
                'full_name' => (string) ($registration->full_name ?? ''),
                'sponsor_tier' => $this->sponsorTierContractValue((string) ($registration->sponsor_tier ?? '')),
                'space' => $pricing['space'],
                'price' => $this->formatSaudiRiyalAmount($pricing['price']),
                'final_price_vat' => $this->formatSaudiRiyalAmount($pricing['final_price']),
                'final_price' => $this->arabicSaudiRiyalWords($pricing['final_price']),
            ];
        }

        return [
            'organization' => (string) ($registration->organization ?? ''),
            'name' => (string) ($registration->full_name ?? ''),
            'cr_copy' => 'مرفق نسخة السجل التجاري',
            'hall' => (string) ($registration->location_selection ?? ''),
        ];
    }

    protected function resolveTemplatePath(array $candidatePaths): string
    {
        foreach ($candidatePaths as $candidatePath) {
            if (is_file($candidatePath)) {
                return $candidatePath;
            }
        }

        $checkedTemplates = implode(', ', array_map(static fn (string $candidatePath): string => basename($candidatePath), $candidatePaths));

        throw new \RuntimeException("Contract template not found. Checked: {$checkedTemplates}");
    }

    protected function sponsorContractPricing(string $tier): array
    {
        return match ($tier) {
            'strategic' => ['space' => '8×12 متر مربع', 'price' => 900000, 'final_price' => 1035000],
            'government' => ['space' => '8×5 متر مربع', 'price' => 0, 'final_price' => 0],
            'diamond' => ['space' => '8×8 متر مربع', 'price' => 450000, 'final_price' => 517500],
            'gold' => ['space' => '8×5 متر مربع', 'price' => 200000, 'final_price' => 230000],
            'media' => ['space' => '-', 'price' => 0, 'final_price' => 0],
            'safety-security', 'marketing', 'technology', 'other' => ['space' => '0 متر مربع', 'price' => 200000, 'final_price' => 230000],
            default => ['space' => '0 متر مربع', 'price' => 200000, 'final_price' => 230000],
        };
    }

    protected function formatSaudiRiyalAmount(int $amount): string
    {
        return number_format($amount).' ريال';
    }

    protected function arabicSaudiRiyalWords(int $amount): string
    {
        return $this->arabicNumberToWords($amount).' ريال';
    }

    protected function arabicNumberToWords(int $amount): string
    {
        if ($amount === 0) {
            return 'صفر';
        }

        $parts = [];
        $millions = intdiv($amount, 1000000);
        $remainder = $amount % 1000000;

        if ($millions > 0) {
            $parts[] = match ($millions) {
                1 => 'مليون',
                2 => 'مليونان',
                default => $this->arabicNumberToWords($millions).' مليون',
            };
        }

        $thousands = intdiv($remainder, 1000);
        $remainder = $remainder % 1000;

        if ($thousands > 0) {
            $parts[] = match ($thousands) {
                1 => 'ألف',
                2 => 'ألفان',
                default => $this->arabicNumberToWords($thousands).' ألف',
            };
        }

        if ($remainder > 0) {
            $parts[] = $this->arabicNumberBelowOneThousandToWords($remainder);
        }

        return implode(' و', $parts);
    }

    protected function arabicNumberBelowOneThousandToWords(int $amount): string
    {
        $hundredsMap = [
            1 => 'مئة',
            2 => 'مئتان',
            3 => 'ثلاثمئة',
            4 => 'أربعمئة',
            5 => 'خمسمئة',
            6 => 'ستمئة',
            7 => 'سبعمئة',
            8 => 'ثمانمئة',
            9 => 'تسعمئة',
        ];

        $parts = [];
        $hundreds = intdiv($amount, 100);
        $remainder = $amount % 100;

        if ($hundreds > 0) {
            $parts[] = $hundredsMap[$hundreds];
        }

        if ($remainder > 0) {
            $parts[] = $this->arabicNumberBelowOneHundredToWords($remainder);
        }

        return implode(' و', $parts);
    }

    protected function arabicNumberBelowOneHundredToWords(int $amount): string
    {
        $unitsMap = [
            1 => 'واحد',
            2 => 'اثنان',
            3 => 'ثلاثة',
            4 => 'أربعة',
            5 => 'خمسة',
            6 => 'ستة',
            7 => 'سبعة',
            8 => 'ثمانية',
            9 => 'تسعة',
            10 => 'عشرة',
            11 => 'أحد عشر',
            12 => 'اثنا عشر',
            13 => 'ثلاثة عشر',
            14 => 'أربعة عشر',
            15 => 'خمسة عشر',
            16 => 'ستة عشر',
            17 => 'سبعة عشر',
            18 => 'ثمانية عشر',
            19 => 'تسعة عشر',
        ];

        $tensMap = [
            20 => 'عشرون',
            30 => 'ثلاثون',
            40 => 'أربعون',
            50 => 'خمسون',
            60 => 'ستون',
            70 => 'سبعون',
            80 => 'ثمانون',
            90 => 'تسعون',
        ];

        if ($amount < 20) {
            return $unitsMap[$amount];
        }

        $tens = intdiv($amount, 10) * 10;
        $units = $amount % 10;

        if ($units === 0) {
            return $tensMap[$tens];
        }

        return $unitsMap[$units].' و'.$tensMap[$tens];
    }
}
