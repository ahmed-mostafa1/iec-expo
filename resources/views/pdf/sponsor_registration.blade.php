<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sponsor Registration #{{ $registration->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #111827; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        h2 { font-size: 14px; margin-top: 18px; margin-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        td { padding: 4px; vertical-align: top; }
        .label { width: 30%; font-weight: bold; }
        .header { border-bottom: 1px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <div>Sponsor Registration #{{ $registration->id }}</div>
        <div>Date: {{ $registration->created_at->format('Y-m-d H:i') }}</div>
    </div>

    <h2>Contact information</h2>
    <table>
        <tr>
            <td class="label">Full name</td>
            <td>{{ $registration->full_name }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>{{ $registration->email }}</td>
        </tr>
        <tr>
            <td class="label">Phone</td>
            <td>{{ $registration->phone }}</td>
        </tr>
        <tr>
            <td class="label">Job title</td>
            <td>{{ $registration->job_title }}</td>
        </tr>
        <tr>
            <td class="label">Organization</td>
            <td>{{ $registration->organization }}</td>
        </tr>
    </table>

    <h2>Company details</h2>
    <table>
        <tr>
            <td class="label">VAT number</td>
            <td>{{ $registration->vat_number }}</td>
        </tr>
        <tr>
            <td class="label">CR number</td>
            <td>{{ $registration->cr_number }}</td>
        </tr>
        <tr>
            <td class="label">National address</td>
            <td>{{ $registration->national_address }}</td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td>{{ ucfirst($registration->status) }}</td>
        </tr>
    </table>

    <h2>Uploaded documents</h2>
    <table>
        <tr>
            <td class="label">Corporate profile</td>
            <td>{{ $registration->document_path ? 'Attached in admin portal' : '—' }}</td>
        </tr>
        <tr>
            <td class="label">CR copy</td>
            <td>{{ $registration->cr_copy_path ? 'Attached in admin portal' : '—' }}</td>
        </tr>
        <tr>
            <td class="label">National address proof</td>
            <td>{{ $registration->national_address_doc_path ? 'Attached in admin portal' : '—' }}</td>
        </tr>
        <tr>
            <td class="label">Company logo</td>
            <td>{{ $registration->company_logo_path ? 'Attached in admin portal' : '—' }}</td>
        </tr>
    </table>
</body>
</html>
