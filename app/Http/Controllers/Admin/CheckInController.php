<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckIn;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CheckInController extends Controller
{
    public function index()
    {
        return view('admin.check-ins.index');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = CheckIn::query()->with(['employee', 'registrant']);

        if ($request->filled('type')) {
            $query->where('registrant_type', $request->string('type'));
        }

        if ($request->filled('employeeId')) {
            $query->where('employee_id', $request->integer('employeeId'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->whereHasMorph('registrant', array_keys(\App\Support\RegistrationTypes::TYPE_MODELS), function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('employee', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        $fileName = 'check_ins_'.now()->format('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Scan time', 'Employee', 'Registrant type', 'Full name', 'Email', 'Phone', 'Company/Organization',
            ]);

            $query->orderBy('scanned_at', 'desc')->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    $payload = $row->registrant?->qrPayload() ?? [];

                    fputcsv($handle, [
                        $row->scanned_at,
                        $row->employee?->name,
                        $row->registrant_type,
                        $payload['full_name'] ?? '',
                        $payload['email'] ?? '',
                        $payload['phone'] ?? '',
                        $payload['company_name'] ?? $payload['organization'] ?? '',
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
