@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">
        {{ __('Edit contact') }} #{{ $contact->id }}
    </h1>

    <form method="POST"
          action="{{ route('admin.contact-infos.update', $contact) }}"
          class="max-w-xl space-y-4 bg-white border border-gray-200 rounded-xl p-4 text-s">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Label') }}</label>
            <input type="text" name="label" class="w-full rounded-lg border-gray-300 text-s"
                   value="{{ old('label', $contact->label) }}" required>
            @error('label') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Phone') }}</label>
                <input type="text" name="phone" class="w-full rounded-lg border-gray-300 text-s"
                       value="{{ old('phone', $contact->phone) }}" required>
                @error('phone') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
                <input type="email" name="email" class="w-full rounded-lg border-gray-300 text-s"
                       value="{{ old('email', $contact->email) }}" required>
                @error('email') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Display order') }}</label>
                <input type="number" name="display_order" class="w-full rounded-lg border-gray-300 text-s"
                       value="{{ old('display_order', $contact->display_order) }}">
                @error('display_order') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center gap-2 mt-5">
                <input type="checkbox" name="is_primary" value="1"
                       class="rounded border-gray-300"
                       @checked(old('is_primary', $contact->is_primary))>
                <span class="text-[11px] text-gray-700">{{ __('Primary contact') }}</span>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-s font-semibold text-white hover:bg-black">
                {{ __('Update') }}
            </button>
        </div>
    </form>
@endsection
