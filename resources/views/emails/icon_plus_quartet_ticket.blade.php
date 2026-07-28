<p>Hello {{ $registration->full_name }},</p>

<p>Thank you for registering for the ICON+ Quartet package at IEC 360°. Your registration is confirmed.</p>

<p><strong>Please keep this QR code — you will need to present it at the entrance to be admitted to the expo.</strong></p>

<p>
    <img src="{{ $message->embedData($registration->qrPng(), 'icon-plus-quartet-qr.png', 'image/png') }}"
         alt="ICON+ Quartet entry QR code" width="320" height="320">
</p>

<p>Your registration details:</p>

<ul>
    <li><strong>Registration number:</strong> {{ $registration->id }}</li>
    <li><strong>Name:</strong> {{ $registration->full_name }}</li>
    <li><strong>Email:</strong> {{ $registration->email }}</li>
    <li><strong>Phone:</strong> {{ $registration->phone }}</li>
    <li><strong>Job title:</strong> {{ $registration->job_title }}</li>
    <li><strong>Organization:</strong> {{ $registration->organization }}</li>
    <li><strong>Booked location:</strong> {{ $registration->location_selection }}</li>
</ul>

<hr>

<div dir="rtl" lang="ar">
    <p>مرحبا {{ $registration->full_name }}،</p>

    <p>شكرا لتسجيلك في باقة ICON+ Quartet في IEC 360°. تم تأكيد تسجيلك.</p>

    <p><strong>يرجى الاحتفاظ برمز الاستجابة السريعة (QR) الموضح أعلاه، حيث يجب إبرازه عند البوابة للسماح لك بدخول المعرض.</strong></p>

    <p>بيانات التسجيل:</p>

    <ul>
        <li><strong>رقم التسجيل:</strong> {{ $registration->id }}</li>
        <li><strong>الاسم:</strong> {{ $registration->full_name }}</li>
        <li><strong>البريد الإلكتروني:</strong> {{ $registration->email }}</li>
        <li><strong>رقم الجوال:</strong> {{ $registration->phone }}</li>
        <li><strong>المسمى الوظيفي:</strong> {{ $registration->job_title }}</li>
        <li><strong>جهة العمل:</strong> {{ $registration->organization }}</li>
        <li><strong>الموقع المحجوز:</strong> {{ $registration->location_selection }}</li>
    </ul>
</div>
