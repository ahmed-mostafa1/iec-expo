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

        $sponsorTier = match ((string) ($registration->sponsor_tier ?? '')) {
            'strategic' => 'Strategic',
            'diamond' => 'Diamond',
            'government' => 'Government',
            'marketing' => 'Marketing',
            'media' => 'Media',
            'technology' => 'Technology',
            'safety-security' => 'Safety & Security',
            'gold' => 'Gold',
            'other' => 'Other',
            default => Str::headline((string) ($registration->sponsor_tier ?? '')),
        };

        return $this->generateContractPdf(public_path('sponsor-contract.docx'), [
            'organization' => (string) ($registration->organization ?? ''),
            'full_name' => (string) ($registration->full_name ?? ''),
            'sponsor_tier' => $sponsorTier,
            'cr_copy' => 'See attached file',
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

        return $this->generateContractPdf(public_path('contract-v2.docx'), [
            'organization' => (string) ($registration->organization ?? ''),
            'name' => (string) ($registration->full_name ?? ''),
            'cr_copy' => 'See attached file',
            'hall' => (string) ($registration->location_selection ?? ''),
        ], $path);
    }

    private function generateContractPdf(string $templatePath, array $values, string $destinationPath): string
    {
        $apiKey = config('services.cloudconvert.key');
        if (! $apiKey) {
            throw new \RuntimeException('CloudConvert API key is not configured.');
        }

        if (! is_file($templatePath)) {
            throw new \RuntimeException('Contract template not found.');
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
}
