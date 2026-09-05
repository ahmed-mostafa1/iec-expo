<?php

namespace App\Services;

use App\Models\IconPlusQuartetRegistration;
use App\Models\IconPlusRegistration;
use App\Models\IconQuartetRegistration;
use App\Models\IconRegistration;
use App\Models\SponsorRegistration;
use App\Models\VisitorRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class RegistrationPdfService
{
    private const CLOUDCONVERT_ERROR_DETAIL_LIMIT = 1000;

    private const BADGE_CAPTURE_WIDTH = 265;

    private const BADGE_CAPTURE_HEIGHT = 447;

    // border-radius: 4mm on a 70mm-wide card (see resources/views/public/badge.blade.php .badge)
    private const BADGE_CORNER_RADIUS_RATIO = 4 / 70;

    public function generateSponsorPdf(SponsorRegistration $registration): string
    {
        $path = "registrations/sponsors/{$registration->id}.pdf";

        return $this->generateContractPdf(
            $this->resolveTemplatePath($this->sponsorTemplatePaths()),
            $this->sponsorContractValues($registration),
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

    public function generateVisitorBadgeCardPng(VisitorRegistration $registration): string
    {
        return $this->renderBadgeCardPng($registration, 'VISITOR');
    }

    public function generateIconBadgeCardPng(IconRegistration $registration): string
    {
        return $this->renderBadgeCardPng($registration, 'ICON');
    }

    public function generateIconPlusBadgeCardPng(IconPlusRegistration $registration): string
    {
        return $this->renderBadgeCardPng($registration, 'ICON');
    }

    public function generateIconQuartetBadgeCardPng(IconQuartetRegistration $registration): string
    {
        return $this->renderBadgeCardPng($registration, 'ICON');
    }

    public function generateIconPlusQuartetBadgeCardPng(IconPlusQuartetRegistration $registration): string
    {
        return $this->renderBadgeCardPng($registration, 'ICON');
    }

    public function generateSponsorBadgeCardPng(SponsorRegistration $registration): string
    {
        return $this->renderBadgeCardPng($registration, 'SPONSOR');
    }

    private function renderBadgeCardPng(object $registration, string $typeLabel): string
    {
        $apiKey = config('services.cloudconvert.key');
        if (! $apiKey) {
            throw new \RuntimeException('CloudConvert API key is not configured.');
        }

        $html = view('public.badge', [
            ...$registration->badgeViewData($typeLabel),
            'standalone' => true,
        ])->render();

        return $this->convertHtmlToPngViaCloudConvert($html, $apiKey);
    }

    public function generateIconPdf(IconRegistration $registration): string
    {
        $path = "registrations/icons/{$registration->id}.pdf";
        $isZoneSpace = (bool) preg_match('/^CZ\d+$/i', (string) ($registration->location_selection ?? ''));
        $templatePath = $this->resolveTemplatePath(
            $isZoneSpace ? $this->zoneTemplatePaths() : $this->sharedTemplatePaths()
        );

        return $this->generateContractPdf($templatePath, [
            'organization' => (string) ($registration->organization ?? ''),
            'name' => (string) ($registration->full_name ?? ''),
            'cr_copy' => (string) ($registration->cr_copy ?? ''),
            'hall' => (string) ($registration->location_selection ?? ''),
        ], $path);
    }

    public function generateIconPlusPdf(IconPlusRegistration $registration): string
    {
        $path = "registrations/icon-plus/{$registration->id}.pdf";
        $templatePath = $this->resolveTemplatePath($this->iconPlusTemplatePaths());

        return $this->generateContractPdf($templatePath, [
            'organization' => (string) ($registration->organization ?? ''),
            'name' => (string) ($registration->full_name ?? ''),
            'cr_copy' => (string) ($registration->cr_copy ?? ''),
            'hall' => (string) ($registration->location_selection ?? ''),
        ], $path);
    }

    public function generateIconQuartetPdf(IconQuartetRegistration $registration): string
    {
        $path = "registrations/icon-quartet/{$registration->id}.pdf";
        $templatePath = $this->resolveTemplatePath($this->iconQuartetTemplatePaths());

        return $this->generateContractPdf($templatePath, [
            'organization' => (string) ($registration->organization ?? ''),
            'name' => (string) ($registration->full_name ?? ''),
            'cr_copy' => (string) ($registration->cr_copy ?? ''),
            'hall' => (string) ($registration->location_selection ?? ''),
        ], $path);
    }

    public function generateIconPlusQuartetPdf(IconPlusQuartetRegistration $registration): string
    {
        $path = "registrations/icon-plus-quartet/{$registration->id}.pdf";
        $templatePath = $this->resolveTemplatePath($this->iconPlusQuartetTemplatePaths());

        return $this->generateContractPdf($templatePath, [
            'organization' => (string) ($registration->organization ?? ''),
            'name' => (string) ($registration->full_name ?? ''),
            'cr_copy' => (string) ($registration->cr_copy ?? ''),
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

            $unfilled = $template->getVariables();
            if ($unfilled !== []) {
                throw new \RuntimeException(
                    'Contract template has unfilled placeholders: '.implode(', ', $unfilled).' ('.basename($templatePath).')'
                );
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
            ->post('https://api.cloudconvert.com/v2/jobs', $this->cloudConvertDocxToPdfJobPayload($docxPath));

        if (! $jobResponse->successful()) {
            throw new \RuntimeException($this->cloudConvertResponseError(
                'CloudConvert job creation failed',
                $jobResponse
            ));
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
            throw new \RuntimeException($this->cloudConvertResponseError(
                'CloudConvert upload failed',
                $uploadResponse
            ));
        }

        $exportTask = $this->waitForCloudConvertExportTask($jobId, $apiKey, 'export-pdf');
        $pdfUrl = $exportTask['result']['files'][0]['url'] ?? null;
        if (! $pdfUrl) {
            throw new \RuntimeException('CloudConvert export URL missing.');
        }

        $pdfResponse = Http::get($pdfUrl);
        if (! $pdfResponse->successful()) {
            throw new \RuntimeException($this->cloudConvertResponseError(
                'Failed to download generated PDF',
                $pdfResponse
            ));
        }

        return $pdfResponse->body();
    }

    private function convertHtmlToPngViaCloudConvert(string $html, string $apiKey): string
    {
        $jobResponse = Http::withToken($apiKey)
            ->acceptJson()
            ->post('https://api.cloudconvert.com/v2/jobs', [
                'tasks' => [
                    'import-html' => [
                        'operation' => 'import/upload',
                    ],
                    'convert-html-to-png' => [
                        'operation' => 'convert',
                        'input' => 'import-html',
                        'input_format' => 'html',
                        'output_format' => 'png',
                        'engine' => 'chrome',
                        'zoom' => 2,
                        'screen_width' => self::BADGE_CAPTURE_WIDTH,
                        'screen_height' => self::BADGE_CAPTURE_HEIGHT,
                    ],
                    'export-png' => [
                        'operation' => 'export/url',
                        'input' => 'convert-html-to-png',
                    ],
                ],
            ]);

        if (! $jobResponse->successful()) {
            throw new \RuntimeException($this->cloudConvertResponseError(
                'CloudConvert job creation failed',
                $jobResponse
            ));
        }

        $jobData = $jobResponse->json('data');
        $jobId = $jobData['id'] ?? null;
        $tasks = $this->normalizeTasks($jobData['tasks'] ?? []);
        $importTask = $this->findTaskByName($tasks, 'import-html');
        $uploadForm = $importTask['result']['form'] ?? null;

        if (! $jobId || ! $uploadForm || empty($uploadForm['url']) || empty($uploadForm['parameters'])) {
            throw new \RuntimeException('CloudConvert upload form missing from job response.');
        }

        $uploadResponse = Http::attach('file', $html, 'badge.html')
            ->post($uploadForm['url'], $uploadForm['parameters']);

        if (! $uploadResponse->successful()) {
            throw new \RuntimeException($this->cloudConvertResponseError(
                'CloudConvert upload failed',
                $uploadResponse
            ));
        }

        $exportTask = $this->waitForCloudConvertExportTask($jobId, $apiKey, 'export-png');
        $pngUrl = $exportTask['result']['files'][0]['url'] ?? null;
        if (! $pngUrl) {
            throw new \RuntimeException('CloudConvert export URL missing.');
        }

        $pngResponse = Http::get($pngUrl);
        if (! $pngResponse->successful()) {
            throw new \RuntimeException($this->cloudConvertResponseError(
                'Failed to download generated PNG',
                $pngResponse
            ));
        }

        return $this->applyBadgeCornerTransparency($pngResponse->body());
    }

    /**
     * CloudConvert's Chrome renderer flattens the page onto an opaque background
     * regardless of the CSS `background: transparent` on the badge markup, which
     * leaves a solid-color square behind the badge's rounded corners. Punch the
     * corners back out to real alpha transparency so only the card is visible.
     */
    private function applyBadgeCornerTransparency(string $pngBinary): string
    {
        if (! function_exists('imagecreatefromstring')) {
            return $pngBinary;
        }

        $image = @imagecreatefromstring($pngBinary);
        if ($image === false) {
            return $pngBinary;
        }

        imagealphablending($image, false);
        imagesavealpha($image, true);

        $width = imagesx($image);
        $height = imagesy($image);
        $radius = max(1, (int) round($width * self::BADGE_CORNER_RADIUS_RATIO));
        $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);

        $corners = [
            [0, 0, 1, 1],
            [$width - $radius, 0, -1, 1],
            [0, $height - $radius, 1, -1],
            [$width - $radius, $height - $radius, -1, -1],
        ];

        foreach ($corners as [$originX, $originY, $dirX, $dirY]) {
            $centerX = $dirX > 0 ? $originX + $radius : $originX;
            $centerY = $dirY > 0 ? $originY + $radius : $originY;

            for ($y = $originY; $y < $originY + $radius; $y++) {
                for ($x = $originX; $x < $originX + $radius; $x++) {
                    if ((($x - $centerX) ** 2 + ($y - $centerY) ** 2) > $radius ** 2) {
                        imagesetpixel($image, $x, $y, $transparent);
                    }
                }
            }
        }

        ob_start();
        imagepng($image);
        $output = ob_get_clean();
        imagedestroy($image);

        return $output === false ? $pngBinary : $output;
    }

    private function waitForCloudConvertExportTask(string $jobId, string $apiKey, string $exportTaskName): array
    {
        $exportTask = null;
        $maxAttempts = 20;
        $delaySeconds = 2;
        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            $statusResponse = Http::withToken($apiKey)
                ->acceptJson()
                ->get("https://api.cloudconvert.com/v2/jobs/{$jobId}");

            if (! $statusResponse->successful()) {
                throw new \RuntimeException($this->cloudConvertResponseError(
                    'Failed to check CloudConvert job status',
                    $statusResponse
                ));
            }

            $statusData = $statusResponse->json('data');
            $statusTasks = $this->normalizeTasks($statusData['tasks'] ?? []);
            $errorTask = $this->findTaskByStatus($statusTasks, 'error');
            if ($errorTask) {
                $errorMessage = $this->extractTaskError($errorTask);
                throw new \RuntimeException("CloudConvert task failed: {$errorMessage}");
            }

            $exportTask = $this->findTaskByName($statusTasks, $exportTaskName);
            if ($exportTask && ($exportTask['status'] ?? null) === 'finished') {
                return $exportTask;
            }

            sleep($delaySeconds);
        }

        throw new \RuntimeException('CloudConvert conversion timed out before export was ready.');
    }

    private function cloudConvertDocxToPdfJobPayload(string $docxPath): array
    {
        $pdfFilename = pathinfo($docxPath, PATHINFO_FILENAME).'.pdf';

        return [
            'tasks' => [
                'import-docx' => [
                    'operation' => 'import/upload',
                ],
                'convert-docx-to-pdf' => [
                    'operation' => 'convert',
                    'input' => 'import-docx',
                    'input_format' => 'docx',
                    'output_format' => 'pdf',
                    'filename' => $pdfFilename,
                ],
                'export-pdf' => [
                    'operation' => 'export/url',
                    'input' => 'convert-docx-to-pdf',
                ],
            ],
        ];
    }

    private function cloudConvertResponseError(string $prefix, Response $response): string
    {
        return sprintf(
            '%s (%s): %s',
            $prefix,
            $response->status(),
            $this->cloudConvertResponseDetail($response),
        );
    }

    private function cloudConvertResponseDetail(Response $response): string
    {
        $json = $response->json();
        $details = [];

        if (is_array($json)) {
            $message = $json['message'] ?? $json['error'] ?? null;
            if (is_string($message) && $message !== '') {
                $details[] = $message;
            }

            $details = [
                ...$details,
                ...$this->flattenCloudConvertErrors($json['errors'] ?? []),
            ];
        }

        if ($details !== []) {
            return Str::limit(implode(' ', array_unique($details)), self::CLOUDCONVERT_ERROR_DETAIL_LIMIT);
        }

        $body = trim((string) $response->body());
        if ($body !== '') {
            return Str::limit(preg_replace('/\s+/', ' ', $body) ?? $body, self::CLOUDCONVERT_ERROR_DETAIL_LIMIT);
        }

        return 'No response body.';
    }

    private function flattenCloudConvertErrors(mixed $errors): array
    {
        if (is_string($errors) && $errors !== '') {
            return [$errors];
        }

        if (! is_array($errors)) {
            return [];
        }

        $messages = [];
        foreach ($errors as $error) {
            if (is_string($error) && $error !== '') {
                $messages[] = $error;

                continue;
            }

            if (! is_array($error)) {
                continue;
            }

            $message = $error['message'] ?? null;
            if (is_string($message) && $message !== '') {
                $messages[] = $message;

                continue;
            }

            $messages = [
                ...$messages,
                ...$this->flattenCloudConvertErrors($error),
            ];
        }

        return $messages;
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
            'innovation-entrepreneurship' => 'شريك الابتكار وريادة الاعمال',
            'government' => 'الحكومي',
            'marketing' => 'التسويقي',
            'media' => 'وكيل التسويق',
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
            ...$this->configuredTemplatePaths('sponsor'),
            ...$this->templatePathsFor('sponsor-contract.docx'),
            ...$this->sharedTemplatePaths(),
        ];
    }

    protected function sharedTemplatePaths(): array
    {
        return [
            ...$this->configuredTemplatePaths('shared'),
            ...$this->templatePathsFor('contract-v2.docx'),
        ];
    }

    protected function zoneTemplatePaths(): array
    {
        return [
            ...$this->configuredTemplatePaths('zone'),
            ...$this->templatePathsFor('zone-contract.docx'),
            ...$this->sharedTemplatePaths(),
        ];
    }

    protected function iconPlusTemplatePaths(): array
    {
        return [
            ...$this->configuredTemplatePaths('icon_plus'),
            ...$this->templatePathsFor('icon-plust-contract.docx'),
        ];
    }

    protected function iconQuartetTemplatePaths(): array
    {
        return [
            ...$this->configuredTemplatePaths('icon_quartet'),
            ...$this->sharedTemplatePaths(),
        ];
    }

    protected function iconPlusQuartetTemplatePaths(): array
    {
        return [
            ...$this->configuredTemplatePaths('icon_plus_quartet'),
            ...$this->sharedTemplatePaths(),
        ];
    }

    protected function sponsorContractValues(SponsorRegistration $registration): array
    {
        $pricing = $this->sponsorContractPricing((string) ($registration->sponsor_tier ?? ''));

        return [
            'organization' => (string) ($registration->organization ?? ''),
            'full_name' => (string) ($registration->full_name ?? ''),
            'name' => (string) ($registration->full_name ?? ''),
            'cr_copy' => (string) ($registration->cr_copy ?? ''),
            'hall' => (string) ($registration->location_selection ?? ''),
            'sponsor_tier' => $this->sponsorTierContractValue((string) ($registration->sponsor_tier ?? '')),
            'space' => $pricing['space'],
            'price' => $this->formatSaudiRiyalAmount($pricing['price']),
            'final_price_vat' => $this->formatSaudiRiyalAmount($pricing['final_price']),
            'final_price' => $this->arabicSaudiRiyalWords($pricing['final_price']),
        ];
    }

    protected function resolveTemplatePath(array $candidatePaths): string
    {
        $candidatePaths = $this->uniqueExistingPathCandidates($candidatePaths);

        foreach ($candidatePaths as $candidatePath) {
            if (is_file($candidatePath)) {
                return $candidatePath;
            }
        }

        $checkedTemplates = implode(', ', $candidatePaths);

        throw new \RuntimeException("Contract template not found. Checked: {$checkedTemplates}");
    }

    protected function templatePathsFor(string $filename): array
    {
        $paths = [
            public_path($filename),
            base_path("public/{$filename}"),
            resource_path("contracts/{$filename}"),
        ];

        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? null;
        if (is_string($documentRoot) && $documentRoot !== '') {
            $paths[] = rtrim($documentRoot, '\\/').DIRECTORY_SEPARATOR.$filename;
        }

        $paths[] = base_path("../public_html/{$filename}");

        return $this->uniqueExistingPathCandidates($paths);
    }

    protected function configuredTemplatePaths(string $template): array
    {
        $paths = config("services.contract_templates.{$template}", []);

        if (is_string($paths)) {
            $paths = [$paths];
        }

        if (! is_array($paths)) {
            return [];
        }

        return $this->uniqueExistingPathCandidates($paths);
    }

    protected function uniqueExistingPathCandidates(array $paths): array
    {
        $normalizedPaths = [];

        foreach ($paths as $path) {
            if (! is_string($path) || $path === '') {
                continue;
            }

            $normalizedPaths[] = $path;
        }

        return array_values(array_unique($normalizedPaths));
    }

    protected function sponsorContractPricing(string $tier): array
    {
        return match ($tier) {
            'strategic' => ['space' => '8×12 متر مربع', 'price' => 900000, 'final_price' => 1035000],
            'diamond' => ['space' => '8×8 متر مربع', 'price' => 450000, 'final_price' => 517500],
            'innovation-entrepreneurship' => ['space' => '8×12 متر مربع', 'price' => 900000, 'final_price' => 1035000],
            'government' => ['space' => '8×5 متر مربع', 'price' => 0, 'final_price' => 0],
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
        return $this->arabicNumberToWords($amount).' ريالاً سعودياً فقط لا غير';
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
