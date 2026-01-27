<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentController extends Controller
{
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'organization' => ['required', 'string'],
            'cr_copy' => ['required', 'string'],
            'name' => ['required', 'string'],
            'hall' => ['required', 'string'],
        ]);

        $apiKey = config('services.cloudconvert.key');
        if (!$apiKey) {
            return response('CloudConvert API key is not configured.', 500);
        }

        $templatePath = public_path('contract-v2.docx');
        if (!file_exists($templatePath)) {
            return response('Template file not found: contract-v2.docx', 500);
        }

        Storage::disk('local')->makeDirectory('tmp_docs');
        $tempFileName = 'contract_' . Str::uuid()->toString() . '.docx';
        $tempDocxPath = storage_path('app/tmp_docs/' . $tempFileName);

        try {
            $template = new TemplateProcessor($templatePath);
            $template->setValue('organization', $validated['organization']);
            $template->setValue('cr_copy', $validated['cr_copy']);
            $template->setValue('name', $validated['name']);
            $template->setValue('hall', $validated['hall']);
            $template->saveAs($tempDocxPath);

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

            if (!$jobResponse->successful()) {
                Log::error('CloudConvert job creation failed.', [
                    'status' => $jobResponse->status(),
                    'body' => $jobResponse->body(),
                ]);

                return response('CloudConvert job creation failed.', 500);
            }

            $jobData = $jobResponse->json('data');
            $jobId = $jobData['id'] ?? null;
            $tasks = $this->normalizeTasks($jobData['tasks'] ?? []);
            $importTask = $this->findTaskByName($tasks, 'import-docx');
            $uploadForm = $importTask['result']['form'] ?? null;

            if (!$jobId || !$uploadForm || empty($uploadForm['url']) || empty($uploadForm['parameters'])) {
                Log::error('CloudConvert upload form missing.', ['job' => $jobData]);
                return response('CloudConvert upload form missing from job response.', 500);
            }

            $fileHandle = fopen($tempDocxPath, 'r');
            $uploadResponse = Http::attach('file', $fileHandle, basename($tempDocxPath))
                ->post($uploadForm['url'], $uploadForm['parameters']);
            if (is_resource($fileHandle)) {
                fclose($fileHandle);
            }

            if (!$uploadResponse->successful()) {
                Log::error('CloudConvert upload failed.', [
                    'status' => $uploadResponse->status(),
                    'body' => $uploadResponse->body(),
                ]);
                return response('CloudConvert upload failed.', 500);
            }

            $exportTask = null;
            $maxAttempts = 20;
            $delaySeconds = 2;
            for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
                $statusResponse = Http::withToken($apiKey)
                    ->acceptJson()
                    ->get("https://api.cloudconvert.com/v2/jobs/{$jobId}");

                if (!$statusResponse->successful()) {
                    Log::error('CloudConvert job status fetch failed.', [
                        'status' => $statusResponse->status(),
                        'body' => $statusResponse->body(),
                    ]);
                    return response('Failed to check CloudConvert job status.', 500);
                }

                $statusData = $statusResponse->json('data');
                $statusTasks = $this->normalizeTasks($statusData['tasks'] ?? []);
                $errorTask = $this->findTaskByStatus($statusTasks, 'error');
                if ($errorTask) {
                    $errorMessage = $this->extractTaskError($errorTask);
                    return response("CloudConvert task failed: {$errorMessage}", 500);
                }

                $exportTask = $this->findTaskByName($statusTasks, 'export-pdf');
                if ($exportTask && ($exportTask['status'] ?? null) === 'finished') {
                    break;
                }

                sleep($delaySeconds);
            }

            if (!$exportTask || ($exportTask['status'] ?? null) !== 'finished') {
                return response('CloudConvert conversion timed out before export was ready.', 500);
            }

            $pdfUrl = $exportTask['result']['files'][0]['url'] ?? null;
            if (!$pdfUrl) {
                return response('CloudConvert export URL missing.', 500);
            }

            $pdfResponse = Http::get($pdfUrl);
            if (!$pdfResponse->successful()) {
                Log::error('PDF download failed.', [
                    'status' => $pdfResponse->status(),
                    'body' => $pdfResponse->body(),
                ]);
                return response('Failed to download generated PDF.', 500);
            }

            return response($pdfResponse->body(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="generated.pdf"',
            ]);
        } catch (\Throwable $e) {
            Log::error('PDF generation failed.', [
                'exception' => $e,
            ]);

            return response('PDF generation failed: ' . $e->getMessage(), 500);
        } finally {
            if (isset($tempDocxPath) && file_exists($tempDocxPath)) {
                @unlink($tempDocxPath);
            }
        }
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
