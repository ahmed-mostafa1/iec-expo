<p>New visitor registration received:</p>

<ul>
    <li><strong>Name:</strong> {{ $registration->full_name }}</li>
    <li><strong>Email:</strong> {{ $registration->email }}</li>
    <li><strong>Phone:</strong> {{ $registration->phone }}</li>
    <li><strong>Job title:</strong> {{ $registration->job_title }}</li>
    <li><strong>Company:</strong> {{ $registration->company_name }}</li>
    <li><strong>Heard about us via:</strong> {{ $registration->heard_about }}</li>
    @if($registration->heard_about === 'other')
        <li><strong>Other source:</strong> {{ $registration->heard_about_other_text }}</li>
    @endif
</ul>

<p>A PDF copy of the registration is attached.</p>
