<p>Hello {{ $registration->full_name }},</p>

<p>Thank you for registering for the ICON+ package at Tujjar Expo 3rd edition. Your registration is confirmed.</p>

<p><strong>Please keep this badge — you will need to present it at the entrance to be admitted to the expo.</strong></p>

@if($badgeCardPng)
    <p>
        <img src="{{ $message->embedData($badgeCardPng, 'icon-plus-badge.png', 'image/png') }}"
             alt="ICON+ badge" width="280">
    </p>
@endif
<p>Your registration details:</p>

<ul>
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

    <p>شكرا لتسجيلك في باقة ICON+ في معرض تجار النسخة الثالثة. تم تأكيد تسجيلك.</p>

    <p><strong>يرجى الاحتفاظ ببطاقة الدخول الموضحة أعلاه، حيث يجب إبرازها عند البوابة للسماح لك بدخول المعرض.</strong></p>

    <p>بيانات التسجيل:</p>

    <ul>
        <li><strong>الاسم:</strong> {{ $registration->full_name }}</li>
        <li><strong>البريد الإلكتروني:</strong> {{ $registration->email }}</li>
        <li><strong>رقم الجوال:</strong> {{ $registration->phone }}</li>
        <li><strong>المسمى الوظيفي:</strong> {{ $registration->job_title }}</li>
        <li><strong>جهة العمل:</strong> {{ $registration->organization }}</li>
        <li><strong>الموقع المحجوز:</strong> {{ $registration->location_selection }}</li>
    </ul>
</div>
