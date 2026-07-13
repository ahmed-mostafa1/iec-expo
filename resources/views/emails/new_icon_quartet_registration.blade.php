<p>New Icon Quartet registration received:</p>

<ul>
    <li><strong>Name:</strong> {{ $registration->full_name }}</li>
    <li><strong>Email:</strong> {{ $registration->email }}</li>
    <li><strong>Phone:</strong> {{ $registration->phone }}</li>
    <li><strong>Job title:</strong> {{ $registration->job_title }}</li>
    <li><strong>Organization:</strong> {{ $registration->organization }}</li>
    <li><strong>Booked location:</strong> {{ $registration->location_selection }}</li>
    <li><strong>VAT:</strong> {{ $registration->vat_certificate_path ? 'File uploaded' : 'Not provided' }}</li>
</ul>

<p>A PDF copy of the registration is attached. You can review uploaded documents inside the admin portal.</p>
