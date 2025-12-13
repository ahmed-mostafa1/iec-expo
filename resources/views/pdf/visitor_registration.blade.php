<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Visitor Registration #{{ $registration->id }}</title>
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
        <div>Visitor Registration #{{ $registration->id }}</div>
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
    </table>

    <h2>Registration details</h2>
    <table>
        <tr>
            <td class="label">Company</td>
            <td>{{ $registration->company_name }}</td>
        </tr>
        <tr>
            <td class="label">Heard about via</td>
            <td>{{ $registration->heard_about }}</td>
        </tr>
        @if($registration->heard_about === 'other')
            <tr>
                <td class="label">Other (source)</td>
                <td>{{ $registration->heard_about_other_text }}</td>
            </tr>
        @endif
    </table>
</body>
</html>
