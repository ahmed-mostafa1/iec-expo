<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsorRegistration;
use App\Services\RegistrationPdfService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class SponsorRegistrationController extends Controller
{
    public function __construct(
        protected RegistrationPdfService $pdfService
    ) {}

    public function index()
    {
        return view('admin.sponsor-registrations.index');
    }

    public function show(SponsorRegistration $registration)
    {
        return view('admin.sponsor-registrations.show', compact('registration'));
    }

    public function updateStatus(Request $request, SponsorRegistration $registration)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        $registration->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', __('Status updated.'));
    }

    public function downloadPdf(SponsorRegistration $registration)
    {
        if (! $registration->pdf_path) {
            abort(404);
        }

        $fullPath = storage_path('app/public/'.$registration->pdf_path);

        if (! file_exists($fullPath)) {
            abort(404);
        }

        return response()->download($fullPath, "sponsor-registration-{$registration->id}.pdf");
    }

    public function regeneratePdf(SponsorRegistration $registration)
    {
        try {
            $pdfPath = $this->pdfService->generateSponsorPdf($registration);
            $registration->update([
                'pdf_path' => $pdfPath,
                'pdf_status' => 'generated',
                'pdf_error' => null,
                'pdf_generated_at' => now(),
            ]);

            return back()->with('success', __('PDF regenerated.'));
        } catch (Throwable $exception) {
            report($exception);

            $registration->update([
                'pdf_status' => 'failed',
                'pdf_error' => $exception->getMessage(),
                'pdf_generated_at' => null,
            ]);

            return back()->with('error', __('PDF regeneration failed. The team can review the error details below.'));
        }
    }

    public function export(Request $request): StreamedResponse
    {
        $query = SponsorRegistration::query();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('organization', 'like', "%{$search}%")
                    ->orWhere('sponsor_tier', 'like', "%{$search}%")
                    ->orWhere('vat_number', 'like', "%{$search}%");
            });
        }

        $fileName = 'sponsor_registrations_'.now()->format('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID', 'Full Name', 'Email', 'Phone', 'Organization', 'Sponsor Tier', 'Booked Location',
                'Status', 'Created At',
            ]);

            $query->orderBy('created_at', 'desc')->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->id,
                        $row->full_name,
                        $row->email,
                        $row->phone,
                        $row->organization,
                        $row->sponsor_tier,
                        $row->location_selection,
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
