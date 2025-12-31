@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">{{ __('Hall bookings') }}</h1>
                <p class="text-sm text-gray-500">{{ __('View booked spaces and manage manual holds for the hall design map.') }}</p>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900 space-y-1">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-xl bg-white border border-gray-200 p-4">
                <div class="text-s text-gray-500">{{ __('Total booked (all sources)') }}</div>
                <div class="mt-2 text-2xl font-semibold text-gray-900">{{ count($bookedSpaces) }}</div>
            </div>
            <div class="rounded-xl bg-white border border-gray-200 p-4">
                <div class="text-s text-gray-500">{{ __('Booked by registrations') }}</div>
                <div class="mt-2 text-2xl font-semibold text-gray-900">{{ count($registrationSpaces) }}</div>
            </div>
            <div class="rounded-xl bg-white border border-gray-200 p-4">
                <div class="text-s text-gray-500">{{ __('Manual holds') }}</div>
                <div class="mt-2 text-2xl font-semibold text-gray-900">{{ $manualBookings->count() }}</div>
            </div>
        </div>

        <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Book a space manually') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('Blocks a booth on the hall map immediately.') }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.hall-spaces.store') }}" class="grid gap-4 md:grid-cols-4 md:items-end">
                @csrf
                <div class="md:col-span-2">
                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Space code') }}</label>
                    <input type="text" name="space" value="{{ old('space') }}" placeholder="L.W.12"
                        class="mt-1 w-full rounded-lg border-gray-200 text-sm uppercase"
                        pattern="(L\.W\.\d+|R\.W\.\d+)" required>
                    <p class="text-xs text-gray-400 mt-1">{{ __('Format: L.W.{number} or R.W.{number}') }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Note (optional)') }}</label>
                    <input type="text" name="note" value="{{ old('note') }}"
                        class="mt-1 w-full rounded-lg border-gray-200 text-sm" placeholder="{{ __('Reserved for...') }}">
                </div>
                <div>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>{{ __('Book space') }}</span>
                    </button>
                </div>
            </form>
        </section>

        <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-3">
            <div class="flex flex-col gap-1">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Currently booked spaces') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Includes registrations and manual holds. This list is what visitors see as unavailable.') }}</p>
            </div>
            @if (count($bookedSpaces))
                <div class="flex flex-wrap gap-2">
                    @foreach ($bookedSpaces as $space)
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                            {{ $space }}
                        </span>
                    @endforeach
                </div>
            @else
                <div class="text-sm text-gray-500">{{ __('No spaces are currently blocked.') }}</div>
            @endif
        </section>

        <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Manual bookings list') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('Remove a manual hold to free up the space.') }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('Space') }}</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('Note') }}</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($manualBookings as $booking)
                            <tr>
                                <td class="px-4 py-3 font-semibold text-gray-900">{{ $booking->space }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $booking->note ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('admin.hall-spaces.destroy', $booking) }}"
                                        onsubmit="return confirm('{{ __('Unbook this space?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100 transition">
                                            {{ __('Unbook') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500 text-sm">
                                    {{ __('No manual bookings yet.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
