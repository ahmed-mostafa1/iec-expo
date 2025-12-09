<p>New contact form submission:</p>

<ul>
    <li><strong>Name:</strong> {{ $name }}</li>
    <li><strong>Email:</strong> {{ $email }}</li>
    @if($phone)
        <li><strong>Phone:</strong> {{ $phone }}</li>
    @endif
</ul>

<p><strong>Message:</strong></p>
<p>{!! nl2br(e($messageBody)) !!}</p>
