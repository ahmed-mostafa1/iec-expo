@extends('layouts.public')

@section('content')
@php
    $locale = $currentLocale ?? app()->getLocale();

    $heroSlides = [
        [
            'title' => $locale === 'ar' ? 'منصة عالمية للابتكار' : 'A global stage for innovation',
            'caption' => $locale === 'ar' ? 'جلسات ملهمة، تجارب تفاعلية، وشبكات أعمال عالية التأثير.' : 'Immersive sessions, interactive showcases, and high-impact networking.',
            'bg' => 'bg-gradient-to-br from-emerald-500 via-green-400 to-sky-500',
        ],
        [
            'title' => $locale === 'ar' ? 'فرص رعاية مميزة' : 'Premium sponsorship opportunities',
            'caption' => $locale === 'ar' ? 'ارفع حضور علامتك التجارية وسط نخبة من القيادات.' : 'Elevate your brand presence among senior decision-makers.',
            'bg' => 'bg-gradient-to-br from-purple-500 via-violet-500 to-fuchsia-500',
        ],
        [
            'title' => $locale === 'ar' ? 'تجارب غامرة للحضور' : 'Immersive attendee journeys',
            'caption' => $locale === 'ar' ? 'زيارات منظمة، جولات أعمال، وحلول مستقبلية.' : 'Curated visits, business tours, and future-ready solutions.',
            'bg' => 'bg-gradient-to-br from-amber-500 via-orange-500 to-rose-500',
        ],
    ];

    $highlights = [
        [
            'label_en' => 'Expected Visitors',
            'label_ar' => 'عدد الزوار المتوقع',
            'value' => 8500,
            'suffix' => '+',
            'description_en' => 'From across MENA & beyond',
            'description_ar' => 'من مختلف أنحاء الشرق الأوسط والعالم',
        ],
        [
            'label_en' => 'Visionary Speakers',
            'label_ar' => 'متحدثون ملهمون',
            'value' => 65,
            'suffix' => '+',
            'description_en' => 'Keynotes, fireside chats, and labs',
            'description_ar' => 'جلسات رئيسية وحوارات ملهمة وورش تفاعلية',
        ],
        [
            'label_en' => 'Partner Brands',
            'label_ar' => 'العلامات الشريكة',
            'value' => 120,
            'suffix' => '+',
            'description_en' => 'Investors, sponsors, exhibitors',
            'description_ar' => 'المستثمرون والرعاة والعارضون',
        ],
        [
            'label_en' => 'Workshops & Labs',
            'label_ar' => 'ورش العمل والمعامل',
            'value' => 35,
            'suffix' => '+',
            'description_en' => 'Hands-on skill building',
            'description_ar' => 'جلسات عملية لصقل المهارات',
        ],
    ];
@endphp

    <style>[x-cloak]{display:none !important;}</style>

    {{-- HERO --}}
    <section
        id="hero"
        class="grid gap-10 lg:grid-cols-2 items-center py-10"
    >
        <div
            x-data="scrollReveal()"
            x-init="init()"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
            class="space-y-6 transition duration-700"
        >
            <span class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                {{ $locale === 'ar' ? '24-22 أكتوبر · مركز الرياض للمعارض' : '22–24 October · Riyadh Exhibition Center' }}
            </span>
            <h1 class="text-3xl md:text-5xl font-bold leading-tight text-gray-900">
                {{ $locale === 'ar'
                    ? 'ملتقى دولي للابتكار، التقنية، والشراكات الواعدة'
                    : 'The international expo for innovation, tech, and bold partnerships' }}
            </h1>
            <p class="text-base md:text-lg text-gray-600">
                {{ $locale === 'ar'
                    ? 'تجربة ثنائية اللغة تجمع الزوّار، العملاء، الرعاة، والمشاركين في رحلة واحدة انسيابية.'
                    : 'A bilingual experience that unifies visitors, clients, sponsors, and participants in one seamless journey.' }}
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a
                    href="#register"
                    class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/30 transition hover:-translate-y-0.5 hover:bg-emerald-700"
                >
                    {{ $locale === 'ar' ? 'سجّل الآن' : 'Register Now' }}
                </a>
                <a
                    href="#about"
                    class="inline-flex items-center text-sm font-semibold text-emerald-700 transition hover:text-emerald-900"
                >
                    {{ $locale === 'ar' ? 'اعرف المزيد' : 'Learn more' }}
                    <span class="text-lg ms-1">{{ $locale === 'ar' ? '↓' : '↓' }}</span>
                </a>
            </div>
        </div>

        <div
            x-data="heroSlider({ slides: @js($heroSlides) })"
            x-init="init()"
            class="relative"
        >
            <div class="rounded-3xl border border-gray-100 bg-white shadow-xl shadow-emerald-500/10 overflow-hidden">
                <div class="relative h-72 sm:h-80">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div
                            x-show="current === index"
                            x-transition:enter="transition duration-500"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition duration-500"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute inset-0"
                        >
                            <div class="absolute inset-0 rounded-3xl" :class="slide.bg"></div>
                            <div class="absolute inset-0 bg-[radial-gradient(circle,rgba(255,255,255,0.25)_0%,rgba(255,255,255,0)_70%)]"></div>
                            <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                                <p class="text-sm uppercase tracking-wide text-white/80">
                                    {{ $locale === 'ar' ? 'شريحة' : 'Slide' }} <span x-text="index + 1"></span> / <span x-text="slides.length"></span>
                                </p>
                                <h3 class="mt-2 text-2xl font-semibold" x-text="slide.title"></h3>
                                <p class="mt-1 text-sm text-white/80" x-text="slide.caption"></p>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            @click="prev()"
                            class="h-10 w-10 rounded-full border border-gray-200 text-gray-600 hover:border-emerald-500 hover:text-emerald-600 transition flex items-center justify-center"
                            aria-label="{{ $locale === 'ar' ? 'السابق' : 'Previous slide' }}"
                        >
                            <span aria-hidden="true">{{ $locale === 'ar' ? '‹' : '‹' }}</span>
                        </button>
                        <button
                            type="button"
                            @click="next()"
                            class="h-10 w-10 rounded-full border border-gray-200 text-gray-600 hover:border-emerald-500 hover:text-emerald-600 transition flex items-center justify-center"
                            aria-label="{{ $locale === 'ar' ? 'التالي' : 'Next slide' }}"
                        >
                            <span aria-hidden="true">{{ $locale === 'ar' ? '›' : '›' }}</span>
                        </button>
                    </div>
                    <div class="flex items-center gap-2">
                        <template x-for="(slide, index) in slides" :key="'dot-' + index">
                            <button
                                type="button"
                                class="h-2.5 rounded-full transition"
                                :class="current === index ? 'w-6 bg-emerald-500' : 'w-2.5 bg-gray-300'"
                                @click="go(index)"
                                aria-label="Slide indicator"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- HIGHLIGHTS --}}
    <section
        class="mt-16"
        x-data="scrollReveal()"
        x-init="init()"
        :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
        aria-label="{{ $locale === 'ar' ? 'أهم المؤشرات' : 'Event highlights' }}"
    >
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($highlights as $highlight)
                <div
                    x-data="countUpCard({ target: {{ $highlight['value'] }}, suffix: @js($highlight['suffix']), locale: @js($locale) })"
                    class="rounded-2xl border border-gray-100 bg-white/80 p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md hover:border-emerald-200"
                >
                    <div class="text-xs uppercase tracking-wide text-gray-500">
                        {{ $locale === 'ar' ? $highlight['label_ar'] : $highlight['label_en'] }}
                    </div>
                    <div class="mt-2 text-3xl font-semibold text-gray-900">
                        <span x-text="formatted()"></span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500 leading-snug">
                        {{ $locale === 'ar' ? $highlight['description_ar'] : $highlight['description_en'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- REGISTRATION --}}
    <section
        id="register"
        class="mt-24 space-y-10"
        x-data="registrationSection()"
    >
        <div class="space-y-3 max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-widest text-emerald-600">
                {{ $locale === 'ar' ? 'كن جزءاً من التجربة' : 'Be part of the experience' }}
            </p>
            <div class="flex flex-col gap-2">
                <h2 class="text-3xl font-bold text-gray-900">{{ $locale === 'ar' ? 'التسجيل' : 'Registration' }}</h2>
                <p class="text-base text-gray-600">
                    {{ $locale === 'ar'
                        ? 'اختر دورك كزائر/عميل أو كعارض/راعٍ، وسيظهر النموذج المناسب مع تجربة انتقال سلسة.'
                        : 'Choose whether you are joining as a visitor/client or an exhibitor/sponsor and watch the tailored form glide right into place.' }}
                </p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-4">
            {{-- Visitor card --}}
            <article
                @click="selectRole('visitor')"
                class="cursor-pointer rounded-3xl border-2 bg-white/90 p-6 shadow transition hover:-translate-y-1 hover:border-emerald-500 hover:shadow-lg"
                :class="[
                    activeRole === 'visitor' ? 'border-emerald-500 lg:col-start-3' : 'border-gray-100 lg:col-start-1',
                    'lg:col-span-2'
                ]"
            >
                <div class="flex items-center justify-between text-xs font-semibold text-gray-500">
                    <span>{{ $locale === 'ar' ? 'زائر / عميل' : 'Visitor / Client' }}</span>
                    <span class="text-emerald-600">{{ $locale === 'ar' ? 'اخترني' : 'Pick me' }}</span>
                </div>
                <h3 class="mt-3 text-2xl font-semibold text-gray-900">
                    {{ $locale === 'ar' ? 'تجارب غامرة للزوّار' : 'Immersive visitor journeys' }}
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $locale === 'ar'
                        ? 'خطط الزيارات، الجولات الميدانية، والوصول إلى المحتوى الحصري لحاملي التذاكر.'
                        : 'Curated schedules, guided tours, and exclusive content tailored to your profile.' }}
                </p>
                <ul class="mt-4 space-y-2 text-sm text-gray-700">
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-500">•</span>
                        {{ $locale === 'ar' ? 'شبكات أعمال ذكية' : 'Smart networking lounges' }}
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-500">•</span>
                        {{ $locale === 'ar' ? 'جلسات متخصصة حسب الاهتمامات' : 'Interest-based sessions' }}
                    </li>
                </ul>
            </article>

            {{-- Sponsor card --}}
            <article
                @click="selectRole('sponsor')"
                class="cursor-pointer rounded-3xl border-2 bg-white/90 p-6 shadow transition hover:-translate-y-1 hover:border-emerald-500 hover:shadow-lg"
                :class="[
                    activeRole === 'sponsor' ? 'border-emerald-500 lg:col-start-1' : 'border-gray-100 lg:col-start-3',
                    'lg:col-span-2'
                ]"
            >
                <div class="flex items-center justify-between text-xs font-semibold text-gray-500">
                    <span>{{ $locale === 'ar' ? 'عارض / راعٍ' : 'Exhibitor / Sponsor' }}</span>
                    <span class="text-emerald-600">{{ $locale === 'ar' ? 'اخترني' : 'Pick me' }}</span>
                </div>
                <h3 class="mt-3 text-2xl font-semibold text-gray-900">
                    {{ $locale === 'ar' ? 'حزم رعاية مرنة' : 'Flexible sponsorship suites' }}
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $locale === 'ar'
                        ? 'خيارات متعددة لتوسيع نطاق علامتك التجارية مع دعم شخصي من فريقنا.'
                        : 'Multiple tiers to amplify your brand with one-on-one support from our team.' }}
                </p>
                <ul class="mt-4 space-y-2 text-sm text-gray-700">
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-500">•</span>
                        {{ $locale === 'ar' ? 'حجوزات مساحات مخصصة' : 'Custom booth layouts' }}
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-500">•</span>
                        {{ $locale === 'ar' ? 'رعاية المحتوى والفعاليات' : 'Content & experience takeovers' }}
                    </li>
                </ul>
            </article>

            {{-- Visitor form --}}
            <div
                x-show="activeRole === 'visitor'"
                x-cloak
                x-transition
                class="rounded-3xl border border-emerald-100 bg-white/90 p-6 shadow-lg lg:col-span-2 lg:col-start-1"
            >
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ $locale === 'ar' ? 'نموذج تسجيل الزوار' : 'Visitor registration form' }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $locale === 'ar'
                        ? 'املأ التفاصيل التالية لنتأكد من تخصيص تجربتك.'
                        : 'Tell us a little about yourself so we can personalize your visit.' }}
                </p>
                <form
                    method="POST"
                    action="{{ route('public.register.visitor', ['locale' => $locale]) }}"
                    class="mt-6 grid gap-4"
                >
                    @csrf
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'الاسم الكامل' : 'Full name' }}
                            </label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" required
                                   class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'البريد الإلكتروني' : 'Email address' }}
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'رقم الجوال' : 'Phone number' }}
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                   class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'شركة أو جهة' : 'Company or entity' }}
                            </label>
                            <select
                                name="company_predefined"
                                class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                            >
                                <option value="">{{ $locale === 'ar' ? 'اختر (اختياري)' : 'Select (optional)' }}</option>
                                <option value="Future Ventures" @selected(old('company_predefined') === 'Future Ventures')>Future Ventures</option>
                                <option value="Smart City Labs" @selected(old('company_predefined') === 'Smart City Labs')>Smart City Labs</option>
                                <option value="other" @selected(old('company_predefined') === 'other')>{{ $locale === 'ar' ? 'أخرى' : 'Other' }}</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                            {{ $locale === 'ar' ? 'في حال اخترت أخرى' : 'If you chose other' }}
                        </label>
                        <input type="text" name="company_other" value="{{ old('company_other') }}"
                               class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'كيف سمعت عنا؟' : 'How did you hear about us?' }}
                            </label>
                            <select
                                name="heard_about"
                                class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                            >
                                <option value="">{{ $locale === 'ar' ? 'اختر' : 'Select' }}</option>
                                <option value="social_media">{{ $locale === 'ar' ? 'وسائل التواصل' : 'Social media' }}</option>
                                <option value="ads">{{ $locale === 'ar' ? 'إعلانات' : 'Advertisements' }}</option>
                                <option value="friends">{{ $locale === 'ar' ? 'الأصدقاء/الزملاء' : 'Friends / peers' }}</option>
                                <option value="other">{{ $locale === 'ar' ? 'أخرى' : 'Other' }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'شارك تفاصيل أكثر' : 'Share more details' }}
                            </label>
                            <input type="text" name="heard_about_other_text" value="{{ old('heard_about_other_text') }}"
                                   class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                            {{ $locale === 'ar' ? 'الاهتمامات' : 'Interests' }}
                        </label>
                        <textarea
                            name="interests"
                            rows="3"
                            class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                        >{{ old('interests') }}</textarea>
                    </div>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-md shadow-emerald-500/40 transition hover:-translate-y-0.5 hover:bg-emerald-700"
                    >
                        {{ $locale === 'ar' ? 'إرسال الطلب' : 'Submit request' }}
                    </button>
                </form>
            </div>

            {{-- Sponsor form --}}
            <div
                x-show="activeRole === 'sponsor'"
                x-cloak
                x-transition
                class="rounded-3xl border border-emerald-100 bg-white/90 p-6 shadow-lg lg:col-span-2 lg:col-start-3"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $locale === 'ar' ? 'نموذج الرعاة والعارضين' : 'Exhibitor & sponsor form' }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ $locale === 'ar'
                                ? 'املأ الخطوتين التاليـتـين لنعود إليك بحزمة مخصصة.'
                                : 'Complete the two steps below and we will tailor a package for you.' }}
                        </p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600">
                        {{ $locale === 'ar' ? 'الخطوة' : 'Step' }}
                        <span x-text="sponsorStep"></span>
                        {{ $locale === 'ar' ? 'من 2' : 'of 2' }}
                    </span>
                </div>

                <form
                    method="POST"
                    action="{{ route('public.register.sponsor', ['locale' => $locale]) }}"
                    enctype="multipart/form-data"
                    class="mt-6 space-y-5"
                >
                    @csrf
                    <div x-show="sponsorStep === 1" x-transition x-cloak class="space-y-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    {{ $locale === 'ar' ? 'الاسم الكامل' : 'Full name' }}
                                </label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" required
                                       class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    {{ $locale === 'ar' ? 'المسمّى الوظيفي' : 'Job title' }}
                                </label>
                                <input type="text" name="job_title" value="{{ old('job_title') }}"
                                       class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    {{ $locale === 'ar' ? 'البريد الإلكتروني' : 'Email address' }}
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    {{ $locale === 'ar' ? 'رقم الجوال' : 'Phone number' }}
                                </label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                       class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'اسم الجهة' : 'Organization' }}
                            </label>
                            <input type="text" name="organization" value="{{ old('organization') }}" required
                                   class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div x-show="sponsorStep === 2" x-transition x-cloak class="space-y-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    {{ $locale === 'ar' ? 'الرقم الضريبي (VAT)' : 'VAT number' }}
                                </label>
                                <input type="text" name="vat_number" value="{{ old('vat_number') }}"
                                       class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    {{ $locale === 'ar' ? 'رقم السجل التجاري' : 'Commercial registration number' }}
                                </label>
                                <input type="text" name="cr_number" value="{{ old('cr_number') }}"
                                       class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'العنوان الوطني' : 'National address' }}
                            </label>
                            <input type="text" name="national_address" value="{{ old('national_address') }}"
                                   class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'مرفقات (اختياري)' : 'Supporting document (optional)' }}
                            </label>
                            <input
                                type="file"
                                name="proposal_file"
                                class="w-full rounded-2xl border border-dashed border-gray-200 text-sm file:me-4 file:rounded-full file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-emerald-700"
                            >
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $locale === 'ar' ? 'PDF, DOCX أو ZIP حتى 10 ميغابايت.' : 'PDF, DOCX or ZIP up to 10MB.' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button
                            type="button"
                            x-show="sponsorStep === 2"
                            x-cloak
                            @click="prevStep()"
                            class="inline-flex items-center rounded-full border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:border-emerald-400 hover:text-emerald-600"
                        >
                            {{ $locale === 'ar' ? 'عودة' : 'Back' }}
                        </button>
                        <button
                            type="button"
                            x-show="sponsorStep === 1"
                            x-cloak
                            @click="nextStep()"
                            class="inline-flex items-center rounded-full bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            {{ $locale === 'ar' ? 'التالي' : 'Next' }}
                        </button>
                        <button
                            type="submit"
                            x-show="sponsorStep === 2"
                            x-cloak
                            class="inline-flex items-center rounded-full bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-md shadow-emerald-500/40 transition hover:-translate-y-0.5 hover:bg-emerald-700"
                        >
                            {{ $locale === 'ar' ? 'إرسال الطلب' : 'Submit registration' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- ABOUT --}}
    <section
        id="about"
        class="mt-24"
        x-data="scrollReveal()"
        x-init="init()"
        :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
    >
        <div class="flex flex-col gap-3 mb-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-emerald-600">
                {{ $locale === 'ar' ? 'عن الحدث' : 'About the expo' }}
            </p>
            <h2 class="text-3xl font-bold text-gray-900">{{ $locale === 'ar' ? 'الرؤية والأهداف' : 'Vision & goals' }}</h2>
        </div>

        @if ($about)
            <div class="grid gap-6 md:grid-cols-2">
                <div class="rounded-3xl border border-gray-100 bg-white/80 p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $locale === 'ar' ? 'الرسالة' : 'Mission' }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $locale === 'ar' ? $about->mission_ar : $about->mission_en }}
                    </p>
                </div>
                <div class="rounded-3xl border border-gray-100 bg-white/80 p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $locale === 'ar' ? 'الأهداف' : 'Goals' }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $locale === 'ar' ? $about->goals_ar : $about->goals_en }}
                    </p>
                </div>
            </div>
        @else
            <div class="rounded-3xl border border-dashed border-gray-200 bg-white/60 p-8 text-center text-gray-500">
                {{ $locale === 'ar' ? 'سيتم تحديث هذه الفقرة قريباً.' : 'This section will be updated very soon.' }}
            </div>
        @endif
    </section>

    {{-- SPONSORS --}}
    <section
        id="sponsors"
        class="mt-24"
        x-data="scrollReveal()"
        x-init="init()"
        :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
    >
        <div class="flex flex-col gap-3 mb-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-emerald-600">
                {{ $locale === 'ar' ? 'الرعاة' : 'Sponsors' }}
            </p>
            <h2 class="text-3xl font-bold text-gray-900">{{ $locale === 'ar' ? 'شركاؤنا الاستراتيجيون' : 'Strategic partners' }}</h2>
        </div>

        @if ($sponsors->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($sponsors as $sponsor)
                    <div
                        class="group rounded-3xl border border-gray-100 bg-white/80 p-6 text-center shadow-sm transition hover:-translate-y-1 hover:border-emerald-500 hover:shadow-lg"
                    >
                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            {{ ucfirst($sponsor->tier ?? ($locale === 'ar' ? 'عام' : 'General')) }}
                        </span>
                        <div class="mt-4 flex h-24 items-center justify-center">
                            @if ($sponsor->logo_path)
                                <img
                                    src="{{ asset('storage/'.$sponsor->logo_path) }}"
                                    alt="{{ $sponsor->name }}"
                                    class="max-h-20 object-contain transition duration-300 group-hover:scale-105"
                                >
                            @else
                                <div class="text-gray-400 text-sm">{{ $sponsor->name }}</div>
                            @endif
                        </div>
                        <p class="mt-3 text-sm font-semibold text-gray-900">{{ $sponsor->name }}</p>
                        @if ($sponsor->url)
                            <a
                                href="{{ $sponsor->url }}"
                                target="_blank"
                                rel="noopener"
                                class="mt-2 inline-flex items-center text-xs font-semibold text-emerald-600 hover:text-emerald-800"
                            >
                                {{ $locale === 'ar' ? 'الموقع الإلكتروني' : 'Visit website' }}
                                <span class="ms-1">↗</span>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-3xl border border-dashed border-gray-200 bg-white/60 p-8 text-center text-gray-500">
                {{ $locale === 'ar' ? 'سيتم الإعلان عن الرعاة قريباً.' : 'Sponsor lineup will be announced soon.' }}
            </div>
        @endif
    </section>

    {{-- PARTICIPANTS --}}
    <section
        id="participants"
        class="mt-24"
        x-data="scrollReveal()"
        x-init="init()"
        :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
    >
        <div class="flex flex-col gap-3 mb-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-emerald-600">
                {{ $locale === 'ar' ? 'المشاركون' : 'Participants' }}
            </p>
            <h2 class="text-3xl font-bold text-gray-900">{{ $locale === 'ar' ? 'منصات تعرض المستقبل' : 'Platforms showcasing the future' }}</h2>
        </div>

        @if ($participants->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($participants as $participant)
                    @php
                        $participantContent = $locale === 'ar'
                            ? ($participant->description_ar ?: '')
                            : ($participant->description_en ?: '');
                    @endphp
                    @php $cardClasses = 'h-full rounded-3xl border border-gray-100 bg-white/80 p-6 shadow-sm transition group hover:-translate-y-1 hover:border-emerald-500 hover:shadow-lg'; @endphp
                    @if ($participant->url)
                        <a href="{{ $participant->url }}" target="_blank" rel="noopener" class="block {{ $cardClasses }}">
                    @else
                        <div class="{{ $cardClasses }}">
                    @endif
                            <div class="flex h-16 items-center justify-center">
                                @if ($participant->logo_path)
                                    <img
                                        src="{{ asset('storage/'.$participant->logo_path) }}"
                                        alt="{{ $participant->name }}"
                                        class="max-h-16 object-contain transition duration-300 group-hover:scale-105"
                                    >
                                @else
                                    <span class="text-gray-400 text-sm">{{ $participant->name }}</span>
                                @endif
                            </div>
                            <div class="mt-4 text-lg font-semibold text-gray-900">{{ $participant->name }}</div>
                            <p class="mt-1 text-sm text-gray-600 leading-relaxed">{{ $participantContent }}</p>
                    @if ($participant->url)
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="rounded-3xl border border-dashed border-gray-200 bg-white/60 p-8 text-center text-gray-500">
                {{ $locale === 'ar' ? 'قائمة المشاركين ستظهر قريباً.' : 'Participant list will go live soon.' }}
            </div>
        @endif
    </section>

    {{-- CONTACT --}}
    <section
        id="contact"
        class="mt-24"
        x-data="scrollReveal()"
        x-init="init()"
        :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
    >
        <div class="flex flex-col gap-3 mb-6">
            <p class="text-sm font-semibold uppercase tracking-widest text-emerald-600">
                {{ $locale === 'ar' ? 'تواصل معنا' : 'Contact us' }}
            </p>
            <h2 class="text-3xl font-bold text-gray-900">{{ $locale === 'ar' ? 'دعنا نبسط تجربتك' : 'Let’s make your journey seamless' }}</h2>
        </div>

        @if (($scrollToContact ?? false) || session('contact_alert'))
            <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                {{ session('contact_alert') ?: ($locale === 'ar'
                    ? 'لقد رصدنا بيانات مكررة. برجاء التواصل معنا لاستكمال الطلب.'
                    : 'We detected duplicate data. Please reach out so we can finalize your submission.') }}
            </div>
        @endif

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="rounded-3xl border border-gray-100 bg-white/90 p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">{{ $locale === 'ar' ? 'أرسل رسالة' : 'Send us a message' }}</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $locale === 'ar'
                        ? 'فريقنا جاهز للإجابة على الأسئلة حول الرعاية، الجداول، أو الدعم اللوجستي.'
                        : 'Our team is ready to answer questions about sponsorships, schedules, or logistics.' }}
                </p>
                <form
                    method="POST"
                    action="{{ route('public.contact', ['locale' => $locale]) }}"
                    class="mt-6 space-y-4"
                >
                    @csrf
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'الاسم الكامل' : 'Full name' }}
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $locale === 'ar' ? 'البريد الإلكتروني' : 'Email' }}
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                            {{ $locale === 'ar' ? 'رقم الجوال (اختياري)' : 'Phone (optional)' }}
                        </label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                            {{ $locale === 'ar' ? 'الرسالة' : 'Message' }}
                        </label>
                        <textarea
                            name="message"
                            rows="4"
                            class="w-full rounded-2xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                        >{{ old('message') }}</textarea>
                    </div>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-md shadow-emerald-500/40 transition hover:-translate-y-0.5 hover:bg-emerald-700"
                    >
                        {{ $locale === 'ar' ? 'إرسال' : 'Send message' }}
                    </button>
                </form>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-gray-900/95 p-6 text-white shadow-lg shadow-gray-900/30">
                <h3 class="text-lg font-semibold">{{ $locale === 'ar' ? 'معلومات التواصل المباشر' : 'Direct contact information' }}</h3>
                <p class="mt-1 text-sm text-white/70">
                    {{ $locale === 'ar'
                        ? 'حدد الشخص المناسب وتواصل معه فوراً عبر البريد أو الهاتف.'
                        : 'Choose the right contact and reach out instantly via email or phone.' }}
                </p>
                <div class="mt-6 space-y-4">
                    @forelse ($contactInfos as $info)
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                            <div class="flex items-center justify-between text-xs uppercase tracking-widest {{ $info->is_primary ? 'text-emerald-300' : 'text-white/60' }}">
                                <span>{{ $info->label }}</span>
                                @if ($info->is_primary)
                                    <span>{{ $locale === 'ar' ? 'أساسي' : 'Primary' }}</span>
                                @endif
                            </div>
                            <div class="mt-2 text-base font-semibold">
                                <a href="tel:{{ $info->phone }}" class="text-white hover:text-emerald-200">{{ $info->phone }}</a>
                            </div>
                            <div class="text-sm text-white/70">
                                <a href="mailto:{{ $info->email }}" class="hover:text-emerald-200">{{ $info->email }}</a>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-white/20 px-4 py-6 text-center text-white/60">
                            {{ $locale === 'ar' ? 'سيتم تحديث بيانات التواصل قريباً.' : 'Contact information will be published soon.' }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <script>
        const registerLandingComponents = () => {
            if (!window.Alpine) {
                return;
            }

            Alpine.data('heroSlider', (config = {}) => ({
                slides: config.slides || [],
                current: 0,
                interval: null,
                delay: config.delay || 5000,
                init() {
                    if (this.slides.length > 1) {
                        this.start();
                    }
                },
                start() {
                    this.stop();
                    this.interval = setInterval(() => this.next(), this.delay);
                },
                stop() {
                    if (this.interval) {
                        clearInterval(this.interval);
                        this.interval = null;
                    }
                },
                next() {
                    this.current = (this.current + 1) % this.slides.length;
                },
                prev() {
                    this.current = (this.current - 1 + this.slides.length) % this.slides.length;
                },
                go(index) {
                    this.current = index;
                    this.start();
                },
            }));

            Alpine.data('countUpCard', (config = {}) => ({
                display: 0,
                started: false,
                target: config.target || 0,
                duration: config.duration || 1500,
                suffix: config.suffix || '',
                locale: config.locale || 'en',
                observer: null,
                formatter: null,
                init() {
                    this.formatter = new Intl.NumberFormat(this.locale);
                    this.observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting && !this.started) {
                                this.started = true;
                                this.animate();
                                this.observer.disconnect();
                            }
                        });
                    }, { threshold: 0.5 });
                    this.observer.observe(this.$el);
                },
                animate() {
                    const start = performance.now();
                    const step = (now) => {
                        const progress = Math.min((now - start) / this.duration, 1);
                        this.display = Math.floor(progress * this.target);
                        if (progress < 1) {
                            requestAnimationFrame(step);
                        }
                    };
                    requestAnimationFrame(step);
                },
                formatted() {
                    return `${this.formatter.format(this.display)}${this.suffix}`;
                },
            }));

            Alpine.data('scrollReveal', () => ({
                visible: false,
                observer: null,
                init() {
                    this.observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                this.visible = true;
                                this.observer.disconnect();
                            }
                        });
                    }, { threshold: 0.2 });
                    this.observer.observe(this.$el);
                },
            }));

            Alpine.data('registrationSection', () => ({
                activeRole: null,
                sponsorStep: 1,
                selectRole(role) {
                    this.activeRole = this.activeRole === role ? null : role;
                    if (role === 'sponsor') {
                        this.sponsorStep = 1;
                    }
                },
                nextStep() {
                    if (this.sponsorStep < 2) {
                        this.sponsorStep++;
                    }
                },
                prevStep() {
                    if (this.sponsorStep > 1) {
                        this.sponsorStep--;
                    }
                },
            }));
        };

        if (window.Alpine) {
            registerLandingComponents();
        } else {
            document.addEventListener('alpine:init', registerLandingComponents, { once: true });
        }
    </script>
@endsection
