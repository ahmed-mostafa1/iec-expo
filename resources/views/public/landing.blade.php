@extends('layouts.public')

@section('content')
    {{-- HERO --}}
    <section id="hero" class="grid gap-10 md:grid-cols-2 items-center">
        <div class="space-y-5">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900">
                {{ $currentLocale === 'ar'
                    ? 'عنوان جذاب للفعالية'
                    : 'A modern, clean registration portal for your event' }}
            </h1>
            <p class="text-sm md:text-base text-gray-600 leading-relaxed">
                {{ $currentLocale === 'ar'
                    ? 'وصف قصير للفعالية يوضح الهدف الرئيسي والفائدة للحضور والرعاة.'
                    : 'Centralize visitor and sponsor registrations in a single bilingual (AR/EN) experience, with PDFs and admin tools built in.' }}
            </p>
            <div class="flex flex-wrap items-center gap-3 mt-2">
                <a href="#register"
                   class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                    {{ __('Register Now') }}
                </a>
                <a href="#about" class="text-sm font-medium text-emerald-700 hover:text-emerald-900">
                    {{ __('Learn more') }} →
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                @if($hero && $hero->video_type === 'url' && $hero->video_url)
                    <div class="aspect-video">
                        <iframe
                            src="{{ $hero->video_url }}"
                            class="w-full h-full"
                            frameborder="0"
                            allowfullscreen
                        ></iframe>
                    </div>
                @elseif($hero && $hero->video_type === 'file' && $hero->video_path)
                    <video
                        class="w-full h-full"
                        controls
                        poster=""
                    >
                        <source src="{{ asset('storage/'.$hero->video_path) }}" type="video/mp4">
                    </video>
                @else
                    <div class="p-6 text-sm text-gray-500">
                        {{ __('Hero video coming soon.') }}
                    </div>
                @endif

                @if($hero)
                    <div class="px-5 py-4 border-t border-gray-100 space-y-1">
                        <div class="text-sm font-semibold text-gray-900">
                            {{ $currentLocale === 'ar' ? $hero->title_ar : $hero->title_en }}
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ $currentLocale === 'ar' ? $hero->subtitle_ar : $hero->subtitle_en }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- HIGHLIGHTS --}}
    <section class="mt-12" aria-label="Highlights">
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-2xl bg-white border border-gray-200 p-4 text-sm">
                <div class="text-xs text-gray-500">{{ __('Expected Visitors') }}</div>
                <div class="mt-1 text-xl font-semibold">500+</div>
            </div>
            <div class="rounded-2xl bg-white border border-gray-200 p-4 text-sm">
                <div class="text-xs text-gray-500">{{ __('Sponsors & Exhibitors') }}</div>
                <div class="mt-1 text-xl font-semibold">30+</div>
            </div>
            <div class="rounded-2xl bg-white border border-gray-200 p-4 text-sm">
                <div class="text-xs text-gray-500">{{ __('Location') }}</div>
                <div class="mt-1 text-xl font-semibold">{{ __('Riyadh, KSA') }}</div>
            </div>
            <div class="rounded-2xl bg-white border border-gray-200 p-4 text-sm">
                <div class="text-xs text-gray-500">{{ __('Why join?') }}</div>
                <div class="mt-1 text-xs text-gray-700">
                    {{ __('Network, discover opportunities, and showcase your brand.') }}
                </div>
            </div>
        </div>
    </section>

    {{-- REGISTRATION --}}
    <section id="register" class="mt-16" x-data="{ role: 'visitor' }">
        <h2 class="text-xl font-bold mb-4">{{ __('Registration') }}</h2>
        <p class="text-sm text-gray-600 mb-6">
            {{ __('Choose your role, then fill the form.') }}
        </p>

        {{-- Stepper --}}
        <div class="grid gap-4 md:grid-cols-2 mb-8">
            {{-- Visitor card --}}
            <button
                type="button"
                @click="role = 'visitor'"
                :class="role === 'visitor'
                    ? 'border-emerald-500 ring-2 ring-emerald-200'
                    : 'border-gray-200'"
                class="text-start rounded-2xl border bg-white p-5 transition hover:border-emerald-500"
            >
                <div class="text-xs font-semibold text-emerald-600 mb-1">{{ __('Step 1') }}</div>
                <div class="text-base font-semibold mb-1">{{ __('I am a Visitor / Client') }}</div>
                <p class="text-xs text-gray-600">
                    {{ __('Register as a visitor to attend, network and explore exhibitors.') }}
                </p>
            </button>

            {{-- Sponsor card --}}
            <button
                type="button"
                @click="role = 'sponsor'"
                :class="role === 'sponsor'
                    ? 'border-emerald-500 ring-2 ring-emerald-200'
                    : 'border-gray-200'"
                class="text-start rounded-2xl border bg-white p-5 transition hover:border-emerald-500"
            >
                <div class="text-xs font-semibold text-emerald-600 mb-1">{{ __('Step 1') }}</div>
                <div class="text-base font-semibold mb-1">{{ __('I am a Sponsor / Exhibitor') }}</div>
                <p class="text-xs text-gray-600">
                    {{ __('Register as a sponsor or exhibitor and our team will contact you for next steps.') }}
                </p>
            </button>
        </div>

        {{-- Step label --}}
        <div class="text-xs font-semibold text-gray-500 mb-2">
            {{ __('Step 2') }} ·
            <span x-text="role === 'visitor' ? '{{ __('Visitor information') }}' : '{{ __('Sponsor information') }}'"></span>
        </div>

        {{-- Forms container --}}
        <div class="grid gap-6 md:grid-cols-2 items-start">
            {{-- Visitor form --}}
            <div
                x-show="role === 'visitor'"
                x-transition
                class="rounded-2xl bg-white border border-gray-200 p-5"
            >
                <h3 class="text-sm font-semibold mb-3">{{ __('Visitor / Client Registration') }}</h3>

                <form method="POST" action="{{ route('public.register.visitor', ['locale' => $locale]) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('Full name') }}
                        </label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}"
                               class="block w-full rounded-lg border-gray-300 text-sm"
                               required>
                        @error('full_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                {{ __('Email') }}
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="block w-full rounded-lg border-gray-300 text-sm"
                                   required>
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                {{ __('Phone') }}
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="block w-full rounded-lg border-gray-300 text-sm"
                                   required>
                            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Company predefined / other --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('Company') }}
                        </label>
                        <select name="company_predefined" class="block w-full rounded-lg border-gray-300 text-sm">
                            <option value="">{{ __('Select company (optional)') }}</option>
                            <option value="Company A" @selected(old('company_predefined') === 'Company A')>Company A</option>
                            <option value="Company B" @selected(old('company_predefined') === 'Company B')>Company B</option>
                            <option value="other" @selected(old('company_predefined') === 'other')>{{ __('Other') }}</option>
                        </select>
                        @error('company_predefined') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('If Other, please specify') }}
                        </label>
                        <input type="text" name="company_other" value="{{ old('company_other') }}"
                               class="block w-full rounded-lg border-gray-300 text-sm">
                        @error('company_other') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Heard about --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('How did you hear about us?') }}
                        </label>
                        <select name="heard_about" class="block w-full rounded-lg border-gray-300 text-sm" required>
                            <option value="">{{ __('Select...') }}</option>
                            <option value="social_media" @selected(old('heard_about') === 'social_media')>{{ __('Social media') }}</option>
                            <option value="ads" @selected(old('heard_about') === 'ads')>{{ __('Ads') }}</option>
                            <option value="friends" @selected(old('heard_about') === 'friends')>{{ __('Friends / colleagues') }}</option>
                            <option value="other" @selected(old('heard_about') === 'other')>{{ __('Other') }}</option>
                        </select>
                        @error('heard_about') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('If Other, please specify') }}
                        </label>
                        <input type="text" name="heard_about_other_text" value="{{ old('heard_about_other_text') }}"
                               class="block w-full rounded-lg border-gray-300 text-sm">
                        @error('heard_about_other_text') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Interests --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('Interests') }}
                        </label>
                        <textarea name="interests" rows="3"
                                  class="block w-full rounded-lg border-gray-300 text-sm">{{ old('interests') }}</textarea>
                        @error('interests') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-700"
                        >
                            {{ __('Submit visitor registration') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Sponsor form --}}
            <div
                x-show="role === 'sponsor'"
                x-transition
                class="rounded-2xl bg-white border border-gray-200 p-5"
            >
                <h3 class="text-sm font-semibold mb-3">{{ __('Sponsor / Exhibitor Registration') }}</h3>

                @if (session('scroll_to_contact'))
                    <div class="mb-3 rounded-lg bg-amber-50 border border-amber-200 px-3 py-2 text-xs text-amber-900">
                        {{ __('We found an existing sponsor with this VAT or CR. Please use the contact form below to reach our team.') }}
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('public.register.sponsor', ['locale' => $locale]) }}"
                      enctype="multipart/form-data"
                      class="space-y-4"
                >
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('Full name') }}
                        </label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}"
                               class="block w-full rounded-lg border-gray-300 text-sm"
                               required>
                        @error('full_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                {{ __('Email') }}
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="block w-full rounded-lg border-gray-300 text-sm"
                                   required>
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                {{ __('Phone') }}
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="block w-full rounded-lg border-gray-300 text-sm"
                                   required>
                            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                {{ __('Job title') }}
                            </label>
                            <input type="text" name="job_title" value="{{ old('job_title') }}"
                                   class="block w-full rounded-lg border-gray-300 text-sm"
                                   required>
                            @error('job_title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                {{ __('Organization') }}
                            </label>
                            <input type="text" name="organization" value="{{ old('organization') }}"
                                   class="block w-full rounded-lg border-gray-300 text-sm"
                                   required>
                            @error('organization') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                {{ __('VAT number') }}
                            </label>
                            <input type="text" name="vat_number" value="{{ old('vat_number') }}"
                                   class="block w-full rounded-lg border-gray-300 text-sm"
                                   required>
                            @error('vat_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                {{ __('CR number') }}
                            </label>
                            <input type="text" name="cr_number" value="{{ old('cr_number') }}"
                                   class="block w-full rounded-lg border-gray-300 text-sm"
                                   required>
                            @error('cr_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('National address') }}
                        </label>
                        <textarea name="national_address" rows="3"
                                  class="block w-full rounded-lg border-gray-300 text-sm"
                                  required>{{ old('national_address') }}</textarea>
                        @error('national_address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('Optional document (PDF / Image)') }}
                        </label>
                        <input type="file" name="document"
                               class="block w-full text-xs text-gray-600">
                        @error('document') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-700"
                        >
                            {{ __('Submit sponsor registration') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- ABOUT --}}
    <section id="about" class="mt-16">
        <h2 class="text-xl font-bold mb-4">{{ __('About the event') }}</h2>

        @if ($about)
            <div class="grid gap-8 md:grid-cols-2">
                <div>
                    <h3 class="text-sm font-semibold mb-2">{{ __('Mission') }}</h3>
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $currentLocale === 'ar' ? $about->mission_ar : $about->mission_en }}
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-2">{{ __('Goals') }}</h3>
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $currentLocale === 'ar' ? $about->goals_ar : $about->goals_en }}
                    </p>
                </div>
            </div>
        @else
            <p class="text-sm text-gray-500">
                {{ __('About content will be added soon.') }}
            </p>
        @endif
    </section>

    {{-- SPONSORS --}}
    <section id="sponsors" class="mt-16">
        <h2 class="text-xl font-bold mb-4">{{ __('Sponsors') }}</h2>

        @if ($sponsors->isEmpty())
            <p class="text-sm text-gray-500">{{ __('Sponsors will be announced soon.') }}</p>
        @else
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($sponsors as $sponsor)
                    <div class="rounded-2xl bg-white border border-gray-200 p-4 flex flex-col items-center justify-center">
                        <div class="mb-2 text-[10px] uppercase tracking-wide text-emerald-600">
                            {{ $sponsor->tier ?? __('Sponsor') }}
                        </div>
                        <div class="h-16 flex items-center justify-center">
                            <img src="{{ asset('storage/'.$sponsor->logo_path) }}"
                                 alt="{{ $sponsor->name }}"
                                 class="max-h-16 max-w-full object-contain">
                        </div>
                        <div class="mt-2 text-xs font-medium text-gray-800 text-center">
                            {{ $sponsor->name }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- PARTICIPANTS --}}
    <section id="participants" class="mt-16">
        <h2 class="text-xl font-bold mb-4">{{ __('Participants') }}</h2>

        @if ($participants->isEmpty())
            <p class="text-sm text-gray-500">{{ __('Participants will be announced soon.') }}</p>
        @else
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($participants as $participant)
                    <a href="{{ $participant->url ?: '#' }}"
                       class="rounded-2xl bg-white border border-gray-200 p-4 flex flex-col hover:border-emerald-500 transition"
                       @if(!$participant->url) onclick="event.preventDefault();" @endif
                    >
                        @if($participant->logo_path)
                            <div class="h-16 mb-3 flex items-center justify-center">
                                <img src="{{ asset('storage/'.$participant->logo_path) }}"
                                     alt="{{ $participant->name }}"
                                     class="max-h-16 max-w-full object-contain">
                            </div>
                        @endif
                        <div class="text-sm font-semibold text-gray-900 mb-1">
                            {{ $participant->name }}
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ $currentLocale === 'ar' ? $participant->description_ar : $participant->description_en }}
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    {{-- CONTACT --}}
    <section id="contact" class="mt-16">
        <h2 class="text-xl font-bold mb-4">{{ __('Contact') }}</h2>

        <div class="grid gap-8 md:grid-cols-[minmax(0,2fr)_minmax(0,1.5fr)] items-start">
            {{-- Contact form --}}
            <div class="rounded-2xl bg-white border border-gray-200 p-5">
                <h3 class="text-sm font-semibold mb-3">{{ __('Send us a message') }}</h3>

                <form method="POST" action="{{ route('public.contact', ['locale' => $locale]) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('Name') }}
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="block w-full rounded-lg border-gray-300 text-sm"
                               required>
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                {{ __('Email') }}
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="block w-full rounded-lg border-gray-300 text-sm"
                                   required>
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                {{ __('Phone (optional)') }}
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="block w-full rounded-lg border-gray-300 text-sm">
                            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            {{ __('Message') }}
                        </label>
                        <textarea name="message" rows="4"
                                  class="block w-full rounded-lg border-gray-300 text-sm"
                                  required>{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-700"
                        >
                            {{ __('Send message') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Contact info --}}
            <div class="space-y-4">
                <div class="rounded-2xl bg-white border border-gray-200 p-5">
                    <h3 class="text-sm font-semibold mb-3">{{ __('Contact details') }}</h3>
                    @forelse ($contactInfos as $contact)
                        <div class="mb-3 last:mb-0">
                            <div class="text-xs font-semibold text-gray-800 flex items-center gap-2">
                                {{ $contact->label }}
                                @if($contact->is_primary)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-[10px] text-emerald-700">
                                        {{ __('Primary') }}
                                    </span>
                                @endif
                            </div>
                            <div class="mt-1 text-xs text-gray-600">
                                <div>{{ $contact->phone }}</div>
                                <div>{{ $contact->email }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500">{{ __('Contact details will be added soon.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
