<p>New visitor registration received:</p>

<ul>
    <li><strong>Name:</strong> {{ $registration->full_name }}</li>
    <li><strong>Email:</strong> {{ $registration->email }}</li>
    <li><strong>Phone:</strong> {{ $registration->phone }}</li>
    <li><strong>Company:</strong> {{ $registration->company_name }}</li>
    <li><strong>Heard about us via:</strong> {{ $registration->heard_about }}</li>
</ul>

<p>A PDF copy of the registration is attached.</p>
