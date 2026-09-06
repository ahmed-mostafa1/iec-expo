<p>Hello {{ $registration->full_name }},</p>

<p>Thank you for registering as a visitor for Tujjar Expo 3rd edition. Your registration is confirmed.</p>

<p><strong>Please keep this badge — you will need to present it at the entrance to be admitted to the expo.</strong></p>

@if($badgeCardPng)
    <p>
        <img src="{{ $message->embedData($badgeCardPng, 'visitor-badge.png', 'image/png') }}"
             alt="Visitor badge" width="560">
    </p>
@endif
<p>Your registration details:</p>

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

<hr>

<div dir="rtl" lang="ar">
    <p>مرحبا {{ $registration->full_name }}،</p>

    <p>شكرا لتسجيلك كزائر في معرض تجار النسخة الثالثة. تم تأكيد تسجيلك.</p>

    <p><strong>يرجى الاحتفاظ ببطاقة الدخول الموضحة أعلاه، حيث يجب إبرازها عند البوابة للسماح لك بدخول المعرض.</strong></p>

    <p>بيانات التسجيل:</p>

    <ul>
        <li><strong>الاسم:</strong> {{ $registration->full_name }}</li>
        <li><strong>البريد الإلكتروني:</strong> {{ $registration->email }}</li>
        <li><strong>رقم الجوال:</strong> {{ $registration->phone }}</li>
        <li><strong>المسمى الوظيفي:</strong> {{ $registration->job_title }}</li>
        <li><strong>جهة العمل:</strong> {{ $registration->company_name }}</li>
        <li><strong>كيف سمعت عنا:</strong> {{ $registration->heard_about }}</li>
        @if($registration->heard_about === 'other')
            <li><strong>مصدر آخر:</strong> {{ $registration->heard_about_other_text }}</li>
        @endif
    </ul>
</div>

<hr>

<p>
    Business Umbrella: <a href="https://umbrella.sa">https://umbrella.sa</a><br>
    Tujjar IEC360 Expo: <a href="https://umbrella.sa/iec360/">https://umbrella.sa/iec360/</a>
</p>
