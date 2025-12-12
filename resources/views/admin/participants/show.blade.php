@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-lg font-semibold">{{ __('Participant details') }}</h1>
        <div class="flex items-center gap-2 text-xs">
            <a href="{{ route('admin.participants.index') }}"
               class="inline-flex items-center rounded-lg border border-gray-200 px-3 py-1.5 text-gray-700 hover:bg-gray-50">
                {{ __('Back to list') }}
            </a>
            <a href="{{ route('admin.participants.edit', $participant) }}"
               class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 font-semibold text-white hover:bg-black">
                {{ __('Edit participant') }}
            </a>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,0.7fr)]">
        <div class="rounded-xl bg-white border border-gray-200 p-4 text-xs space-y-4">
            <div>
                <h2 class="text-sm font-semibold mb-2">{{ __('Overview') }}</h2>
                <dl class="space-y-3">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">{{ __('Name (English)') }}</dt>
                        <dd class="text-gray-900">{{ $participant->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">{{ __('Name (Arabic)') }}</dt>
                        <dd class="text-gray-900">{{ $participant->name_ar ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">{{ __('Website') }}</dt>
                        <dd class="text-gray-900">
                            @if($participant->url)
                                <a href="{{ $participant->url }}" class="text-emerald-700 hover:text-emerald-900" target="_blank" rel="noopener">
                                    {{ $participant->url }}
                                </a>
                            @else
                                {{ __('Not set') }}
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">{{ __('Display order') }}</dt>
                        <dd class="text-gray-900">{{ $participant->display_order }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">{{ __('Active') }}</dt>
                        <dd class="text-gray-900">
                            {{ $participant->is_active ? __('Yes') : __('No') }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">{{ __('Created at') }}</dt>
                        <dd class="text-gray-900">{{ $participant->created_at->format('Y-m-d H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">{{ __('Updated at') }}</dt>
                        <dd class="text-gray-900">{{ $participant->updated_at->format('Y-m-d H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <div>
                <h2 class="text-sm font-semibold mb-2">{{ __('Description (EN)') }}</h2>
                <p class="text-gray-700 whitespace-pre-line">
                    {{ $participant->description_en ?: __('No English description provided.') }}
                </p>
            </div>

            <div>
                <h2 class="text-sm font-semibold mb-2">{{ __('Description (AR)') }}</h2>
                <p class="text-gray-700 whitespace-pre-line">
                    {{ $participant->description_ar ?: __('No Arabic description provided.') }}
                </p>
            </div>
        </div>

        <div class="rounded-xl bg-white border border-gray-200 p-4 text-xs">
            <h2 class="text-sm font-semibold mb-3">{{ __('Brand assets') }}</h2>
            @if($participant->logo_path)
                <div class="rounded-lg border border-dashed border-gray-200 p-4 flex items-center justify-center">
                    <img src="{{ asset('storage/'.$participant->logo_path) }}"
                         alt="{{ $participant->name }}"
                         class="max-h-32 w-auto object-contain">
                </div>
            @else
                <div class="text-gray-500">{{ __('No logo uploaded.') }}</div>
            @endif
            @if($participant->url)
                <div class="mt-4">
                    <a href="{{ $participant->url }}" target="_blank" rel="noopener"
                       class="inline-flex items-center text-emerald-700 hover:text-emerald-900 font-medium">
                        {{ __('Visit website') }}
                        <svg class="icon icon-sm" style="margin-inline-start: 0.25rem;" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"/></svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
