@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Add participant') }}</h1>

    <form method="POST"
          action="{{ route('admin.participants.store') }}"
          enctype="multipart/form-data"
          class="max-w-xl space-y-4 bg-white border border-gray-200 rounded-xl p-4 text-xs">
        @csrf

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Name') }}</label>
            <input type="text" name="name" class="w-full rounded-lg border-gray-300 text-xs"
                   value="{{ old('name') }}" required>
            @error('name') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Website URL') }}</label>
                <input type="url" name="url" class="w-full rounded-lg border-gray-300 text-xs"
                       value="{{ old('url') }}">
                @error('url') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center gap-2 mt-5">
                <input type="checkbox" name="is_active" value="1"
                       class="rounded border-gray-300"
                       @checked(old('is_active', true))>
                <span class="text-[11px] text-gray-700">{{ __('Active') }}</span>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Display order') }}</label>
            <input type="number" name="display_order" class="w-full rounded-lg border-gray-300 text-xs"
                   value="{{ old('display_order', 0) }}">
            @error('display_order') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Description (EN)') }}</label>
            <textarea name="description_en" rows="3"
                      class="w-full rounded-lg border-gray-300 text-xs">{{ old('description_en') }}</textarea>
            @error('description_en') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Description (AR)') }}</label>
            <textarea name="description_ar" rows="3"
                      class="w-full rounded-lg border-gray-300 text-xs">{{ old('description_ar') }}</textarea>
            @error('description_ar') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Logo (optional)') }}</label>
            <input type="file" name="logo" class="w-full text-[11px]">
            @error('logo') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-black">
                {{ __('Save') }}
            </button>
        </div>
    </form>
@endsection
