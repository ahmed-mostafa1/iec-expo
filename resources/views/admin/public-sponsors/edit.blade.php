@extends('layouts.admin')

@section('content')
<h1 class="text-lg font-semibold mb-4">{{ __('Edit sponsor') }}</h1>

<form method="POST"
    action="{{ route('admin.public-sponsors.update', $sponsor)}}"
    enctype="multipart/form-data"
    class="max-w-lg space-y-4 bg-white border border-gray-200 rounded-xl p-4 text-s">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 gap-3">
        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Name (English)') }}</label>
            <input type="text" name="name_en" class="w-full rounded-lg border-gray-300 text-s"
                value="{{ old('name_en', $sponsor->name_en ?? $sponsor->name) }}" required>
            @error('name_en') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Name (Arabic)') }}</label>
            <input type="text" name="name_ar" class="w-full rounded-lg border-gray-300 text-s"
                value="{{ old('name_ar', $sponsor->name_ar) }}">
            @error('name_ar') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Tier') }}</label>
        <select name="tier" class="w-full rounded-lg border-gray-300 text-s">
            <option value="">{{ __('Select tier') }}</option>
            @foreach($tierOptions as $value => $label)
                <option value="{{ $value }}" @selected(old('tier', $sponsor->tier) === $value)>{{ __($label) }}</option>
            @endforeach
        </select>
        @error('tier') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Display order') }}</label>
            <input type="number" name="display_order" class="w-full rounded-lg border-gray-300 text-s"
                value="{{ old('display_order', $sponsor->display_order) }}">
            @error('display_order') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="flex items-center gap-2 mt-5">
            <input type="checkbox" name="is_active" value="1"
                class="rounded border-gray-300"
                @checked(old('is_active', $sponsor->is_active))>
            <span class="text-[11px] text-gray-700">{{ __('Active') }}</span>
        </div>
    </div>

    <div>
        <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Logo') }}</label>
        <input type="file" name="logo" class="w-full text-[11px]">
        @error('logo') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="pt-2">
        <button type="submit"
            class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-s font-semibold text-white hover:bg-black">
            {{ __('Save') }}
        </button>
    </div>
</form>
@endsection
