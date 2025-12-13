<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VisitorRegistrationController extends Controller
{
    public function __construct(
        protected RegistrationPdfService $pdfService
    ) {}

    public function index()
    {
        return view('admin.visitor-registrations.index');
    }

    public function show(VisitorRegistration $registration)
    {
        return view('admin.visitor-registrations.show', compact('registration'));
    }

    public function downloadPdf(VisitorRegistration $registration)
    {
        if (! $registration->pdf_path) {
            abort(404);
        }

        $fullPath = storage_path('app/public/' . $registration->pdf_path);

        if (! file_exists($fullPath)) {
            abort(404);
        }

        return response()->download($fullPath, "visitor-registration-{$registration->id}.pdf");
    }

    public function regeneratePdf(VisitorRegistration $registration)
    {
        $pdfPath = $this->pdfService->generateVisitorPdf($registration);
        $registration->update(['pdf_path' => $pdfPath]);

        return back()->with('success', __('PDF regenerated.'));
    }

    public function export(Request $request): StreamedResponse
    {
        $query = VisitorRegistration::query();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $fileName = 'visitor_registrations_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID', 'Full Name', 'Email', 'Phone', 'Job Title', 'Company',
                'Heard About', 'Created At',
            ]);

            $query->orderBy('created_at', 'desc')->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->id,
                        $row->full_name,
                        $row->email,
                        $row->phone,
                        $row->job_title,
                        $row->company_name,
                        $row->heard_about,
                        $row->created_at,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
