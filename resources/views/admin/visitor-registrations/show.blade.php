@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">
        {{ __('Visitor registration') }} #{{ $registration->id }}
    </h1>

    @if(session('success'))
        <div class="mb-3 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-2 text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 lg:grid-cols-[minmax(0,2fr)_minmax(0,1.2fr)]">
        <div class="space-y-4">
            <div class="rounded-xl bg-white border border-gray-200 p-4 text-xs">
                <h2 class="text-sm font-semibold mb-2">{{ __('Contact info') }}</h2>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <div class="text-[10px] text-gray-500">{{ __('Full name') }}</div>
                        <div class="text-gray-900">{{ $registration->full_name }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-500">{{ __('Email') }}</div>
                        <div class="text-gray-900">{{ $registration->email }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-500">{{ __('Phone') }}</div>
                        <div class="text-gray-900">{{ $registration->phone }}</div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white border border-gray-200 p-4 text-xs">
                <h2 class="text-sm font-semibold mb-2">{{ __('Registration details') }}</h2>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <div class="text-[10px] text-gray-500">{{ __('Company') }}</div>
                        <div class="text-gray-900">{{ $registration->company_name }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-500">{{ __('Heard about via') }}</div>
                        <div class="text-gray-900">{{ $registration->heard_about }}</div>
                    </div>
                    <div class="col-span-2">
                        <div class="text-[10px] text-gray-500">{{ __('Other source') }}</div>
                        <div class="text-gray-900">{{ $registration->heard_about_other_text }}</div>
                    </div>
                    <div class="col-span-2">
                        <div class="text-[10px] text-gray-500">{{ __('Interests') }}</div>
                        <div class="text-gray-900 whitespace-pre-line">{{ $registration->interests }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-xl bg-white border border-gray-200 p-4 text-xs">
                <h2 class="text-sm font-semibold mb-3">{{ __('Files') }}</h2>

                <div>
                    <div class="text-[10px] text-gray-500 mb-1">{{ __('Registration PDF') }}</div>
                    @if($registration->pdf_path)
                        <a href="{{ route('admin.visitors.download-pdf', $registration) }}"
                           class="text-[11px] text-emerald-700 hover:text-emerald-900">
                            {{ __('Download PDF') }}
                        </a>
                    @else
                        <div class="text-[11px] text-gray-500">{{ __('No PDF generated yet.') }}</div>
                    @endif
                </div>

                <form method="POST" action="{{ route('admin.visitors.regenerate-pdf', $registration) }}">
                    @csrf
                    <button
                        type="submit"
                        class="mt-2 inline-flex items-center rounded-lg border border-gray-300 px-3 py-1.5 text-[11px] font-medium text-gray-700 hover:bg-gray-50"
                    >
                        {{ __('Regenerate PDF') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
