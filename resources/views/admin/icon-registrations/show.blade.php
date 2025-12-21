@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">
        {{ __('Icon registration') }} #{{ $registration->id }}
    </h1>

    @if(session('success'))
        <div class="mb-3 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-2 text-s text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 lg:grid-cols-[minmax(0,2fr)_minmax(0,1.2fr)]">
        <div class="space-y-4">
            <div class="rounded-xl bg-white border border-gray-200 p-4 text-s">
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
                    <div>
                        <div class="text-[10px] text-gray-500">{{ __('Job title') }}</div>
                        <div class="text-gray-900">{{ $registration->job_title }}</div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white border border-gray-200 p-4 text-s">
                <h2 class="text-sm font-semibold mb-2">{{ __('Company details') }}</h2>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <div class="text-[10px] text-gray-500">{{ __('Organization') }}</div>
                        <div class="text-gray-900">{{ $registration->organization }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-500">{{ __('VAT number') }}</div>
                        <div class="text-gray-900">{{ $registration->vat_number }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-gray-500">{{ __('CR number') }}</div>
                        <div class="text-gray-900">{{ $registration->cr_number }}</div>
                    </div>
                    <div class="col-span-2">
                        <div class="text-[10px] text-gray-500">{{ __('National address') }}</div>
                        <div class="text-gray-900 whitespace-pre-line">{{ $registration->national_address }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-xl bg-white border border-gray-200 p-4 text-s">
                <h2 class="text-sm font-semibold mb-3">{{ __('Status & actions') }}</h2>

                <div class="mb-3">
                    <div class="text-[10px] text-gray-500 mb-1">{{ __('Current status') }}</div>
                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium
                        @class([
                            'bg-yellow-50 text-yellow-700 border border-yellow-200' => $registration->status === 'pending',
                            'bg-emerald-50 text-emerald-700 border border-emerald-200' => $registration->status === 'approved',
                            'bg-red-50 text-red-700 border border-red-200' => $registration->status === 'rejected',
                        ])
                    ">
                        {{ ucfirst($registration->status) }}
                    </span>
                </div>

                <form method="POST" action="{{ route('admin.icons.update-status', $registration) }}" class="space-y-2">
                    @csrf
                    <label class="block text-[10px] text-gray-500">
                        {{ __('Change status') }}
                    </label>
                    <select name="status" class="w-full rounded-lg border-gray-300 text-s mb-2">
                        <option value="pending" @selected($registration->status === 'pending')>{{ __('Pending') }}</option>
                        <option value="approved" @selected($registration->status === 'approved')>{{ __('Approved') }}</option>
                        <option value="rejected" @selected($registration->status === 'rejected')>{{ __('Rejected') }}</option>
                    </select>
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-s font-semibold text-white hover:bg-black"
                    >
                        {{ __('Update status') }}
                    </button>
                </form>
            </div>

            <div class="rounded-xl bg-white border border-gray-200 p-4 text-s">
                <h2 class="text-sm font-semibold mb-3">{{ __('Files') }}</h2>

                <div class="space-y-3">
                    @if($registration->document_path)
                        <div>
                            <div class="text-[10px] text-gray-500 mb-1">{{ __('Corporate profile') }}</div>
                            <a href="{{ asset('storage/'.$registration->document_path) }}"
                               target="_blank"
                               class="text-[11px] text-emerald-700 hover:text-emerald-900">
                                {{ __('View file') }}
                            </a>
                        </div>
                    @endif

                    @if($registration->cr_copy_path)
                        <div>
                            <div class="text-[10px] text-gray-500 mb-1">{{ __('CR copy') }}</div>
                            <a href="{{ asset('storage/'.$registration->cr_copy_path) }}"
                               target="_blank"
                               class="text-[11px] text-emerald-700 hover:text-emerald-900">
                                {{ __('View file') }}
                            </a>
                        </div>
                    @endif

                    @if($registration->national_address_doc_path)
                        <div>
                            <div class="text-[10px] text-gray-500 mb-1">{{ __('National address proof') }}</div>
                            <a href="{{ asset('storage/'.$registration->national_address_doc_path) }}"
                               target="_blank"
                               class="text-[11px] text-emerald-700 hover:text-emerald-900">
                                {{ __('View file') }}
                            </a>
                        </div>
                    @endif

                    @if($registration->company_logo_path)
                        <div>
                            <div class="text-[10px] text-gray-500 mb-1">{{ __('Company logo') }}</div>
                            <a href="{{ asset('storage/'.$registration->company_logo_path) }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 text-[11px] text-emerald-700 hover:text-emerald-900">
                                {{ __('Preview logo') }}
                            </a>
                            <div class="mt-2 rounded border border-gray-200 bg-gray-50 p-2">
                                <img src="{{ asset('storage/'.$registration->company_logo_path) }}"
                                    alt="{{ $registration->organization }}"
                                    class="max-h-32 object-contain mx-auto">
                            </div>
                        </div>
                    @endif

                    <div>
                        <div class="text-[10px] text-gray-500 mb-1">{{ __('Registration PDF') }}</div>
                        @if($registration->pdf_path)
                            <a href="{{ route('admin.icons.download-pdf', $registration) }}"
                               class="text-[11px] text-emerald-700 hover:text-emerald-900">
                                {{ __('Download PDF') }}
                            </a>
                        @else
                            <div class="text-[11px] text-gray-500">{{ __('No PDF generated yet.') }}</div>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('admin.icons.regenerate-pdf', $registration) }}">
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
    </div>
@endsection
