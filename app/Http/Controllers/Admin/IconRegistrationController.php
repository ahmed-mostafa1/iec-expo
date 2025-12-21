<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IconRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IconRegistrationController extends Controller
{
    public function __construct(
        protected RegistrationPdfService $pdfService
    ) {}

    public function index()
    {
        return view('admin.icon-registrations.index');
    }

    public function show(IconRegistration $registration)
    {
        return view('admin.icon-registrations.show', compact('registration'));
    }

    public function updateStatus(Request $request, IconRegistration $registration)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        $registration->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', __('Status updated.'));
    }

    public function downloadPdf(IconRegistration $registration)
    {
        if (! $registration->pdf_path) {
            abort(404);
        }

        $fullPath = storage_path('app/public/' . $registration->pdf_path);

        if (! file_exists($fullPath)) {
            abort(404);
        }

        return response()->download($fullPath, "icon-registration-{$registration->id}.pdf");
    }

    public function regeneratePdf(IconRegistration $registration)
    {
        $pdfPath = $this->pdfService->generateIconPdf($registration);
        $registration->update(['pdf_path' => $pdfPath]);

        return back()->with('success', __('PDF regenerated.'));
    }

    public function export(Request $request): StreamedResponse
    {
        $query = IconRegistration::query();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('organization', 'like', "%{$search}%")
                    ->orWhere('vat_number', 'like', "%{$search}%")
                    ->orWhere('cr_number', 'like', "%{$search}%");
            });
        }

        $fileName = 'icon_registrations_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID', 'Full Name', 'Email', 'Phone', 'Organization',
                'VAT', 'CR', 'Status', 'Created At',
            ]);

            $query->orderBy('created_at', 'desc')->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->id,
                        $row->full_name,
                        $row->email,
                        $row->phone,
                        $row->organization,
                        $row->vat_number,
                        $row->cr_number,
                        $row->status,
                        $row->created_at,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
