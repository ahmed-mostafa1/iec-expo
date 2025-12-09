<p>New sponsor registration received:</p>

<ul>
    <li><strong>Name:</strong> {{ $registration->full_name }}</li>
    <li><strong>Email:</strong> {{ $registration->email }}</li>
    <li><strong>Phone:</strong> {{ $registration->phone }}</li>
    <li><strong>Organization:</strong> {{ $registration->organization }}</li>
    <li><strong>VAT:</strong> {{ $registration->vat_number }}</li>
    <li><strong>CR:</strong> {{ $registration->cr_number }}</li>
</ul>

<p>A PDF copy of the registration is attached.</p>
