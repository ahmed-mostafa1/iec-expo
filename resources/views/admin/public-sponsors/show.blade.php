@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-lg font-semibold">{{ __('Sponsor details') }}</h1>
        <div class="flex items-center gap-2 text-s">
            <a href="{{ route('admin.public-sponsors.index') }}"
               class="inline-flex items-center rounded-lg border border-gray-200 px-3 py-1.5 text-gray-700 hover:bg-gray-50">
                {{ __('Back to list') }}
            </a>
            <a href="{{ route('admin.public-sponsors.edit', $sponsor) }}"
               class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 font-semibold text-white hover:bg-black">
                {{ __('Edit sponsor') }}
            </a>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,0.7fr)]">
        <div class="rounded-xl bg-white border border-gray-200 p-4 text-s">
            <h2 class="text-sm font-semibold mb-3">{{ __('General information') }}</h2>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-gray-500">{{ __('Name') }}</dt>
                    <dd class="text-gray-900">{{ $sponsor->name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">{{ __('Name (English)') }}</dt>
                    <dd class="text-gray-900">{{ $sponsor->name_en ?: '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">{{ __('Name (Arabic)') }}</dt>
                    <dd class="text-gray-900">{{ $sponsor->name_ar ?: '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">{{ __('Tier') }}</dt>
                    <dd class="text-gray-900">{{ $sponsor->tier ?: __('Not set') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">{{ __('Display order') }}</dt>
                    <dd class="text-gray-900">{{ $sponsor->display_order }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">{{ __('Active') }}</dt>
                    <dd class="text-gray-900">
                        {{ $sponsor->is_active ? __('Yes') : __('No') }}
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">{{ __('Created at') }}</dt>
                    <dd class="text-gray-900">{{ $sponsor->created_at->format('Y-m-d H:i') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">{{ __('Updated at') }}</dt>
                    <dd class="text-gray-900">{{ $sponsor->updated_at->format('Y-m-d H:i') }}</dd>
                </div>
            </dl>
        </div>

        <div class="rounded-xl bg-white border border-gray-200 p-4 text-s">
            <h2 class="text-sm font-semibold mb-3">{{ __('Brand assets') }}</h2>
            @if($sponsor->logo_path)
                <div class="rounded-lg border border-dashed border-gray-200 p-4 flex items-center justify-center">
                    <img src="{{ asset('storage/'.$sponsor->logo_path) }}"
                         alt="{{ $sponsor->name }}"
                         class="max-h-32 w-auto object-contain">
                </div>
            @else
                <div class="text-gray-500">{{ __('No logo uploaded.') }}</div>
            @endif
        </div>
    </div>
@endsection
