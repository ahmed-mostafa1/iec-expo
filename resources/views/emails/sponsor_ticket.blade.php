<p>Hello {{ $registration->full_name }},</p>

<p>Thank you for registering as a sponsor for Tujjar Expo 3rd edition. Your registration is confirmed.</p>

<p><strong>Please keep this badge — you will need to present it at the entrance to be admitted to the expo.</strong></p>

@if($badgeCardPng)
    <p>
        <img src="{{ $message->embedData($badgeCardPng, 'sponsor-badge.png', 'image/png') }}"
             alt="Sponsor badge" width="280">
    </p>
@endif
<p>Your registration details:</p>

<ul>
    <li><strong>Name:</strong> {{ $registration->full_name }}</li>
    <li><strong>Email:</strong> {{ $registration->email }}</li>
    <li><strong>Phone:</strong> {{ $registration->phone }}</li>
    <li><strong>Job title:</strong> {{ $registration->job_title }}</li>
    <li><strong>Organization:</strong> {{ $registration->organization }}</li>
    <li><strong>Sponsor tier:</strong> {{ $registration->sponsor_tier }}</li>
</ul>

<hr>

<div dir="rtl" lang="ar">
    <p>مرحبا {{ $registration->full_name }}،</p>

    <p>شكرا لتسجيلك كراعي في معرض تجار النسخة الثالثة. تم تأكيد تسجيلك.</p>

    <p><strong>يرجى الاحتفاظ ببطاقة الدخول الموضحة أعلاه، حيث يجب إبرازها عند البوابة للسماح لك بدخول المعرض.</strong></p>

    <p>بيانات التسجيل:</p>

    <ul>
        <li><strong>الاسم:</strong> {{ $registration->full_name }}</li>
        <li><strong>البريد الإلكتروني:</strong> {{ $registration->email }}</li>
        <li><strong>رقم الجوال:</strong> {{ $registration->phone }}</li>
        <li><strong>المسمى الوظيفي:</strong> {{ $registration->job_title }}</li>
        <li><strong>جهة العمل:</strong> {{ $registration->organization }}</li>
        <li><strong>فئة الرعاية:</strong> {{ $registration->sponsor_tier }}</li>
    </ul>
</div>

<hr>

<p>
    Business Umbrella: <a href="https://umbrella.sa">https://umbrella.sa</a><br>
    Tujjar IEC360 Expo: <a href="https://umbrella.sa/iec360/">https://umbrella.sa/iec360/</a>
</p>
