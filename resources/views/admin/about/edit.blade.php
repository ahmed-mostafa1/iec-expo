@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('About content') }}</h1>

    @if(session('success'))
        <div class="mb-3 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-2 text-s text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.about.update') }}"
          class="max-w-3xl space-y-5 bg-white border border-gray-200 rounded-xl p-4 text-s">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">
                    {{ __('Mission (EN)') }}
                </label>
                <textarea name="mission_en" rows="5"
                          class="w-full rounded-lg border-gray-300 text-s">{{ old('mission_en', $about->mission_en) }}</textarea>
                @error('mission_en') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">
                    {{ __('Mission (AR)') }}
                </label>
                <textarea name="mission_ar" rows="5"
                          class="w-full rounded-lg border-gray-300 text-s">{{ old('mission_ar', $about->mission_ar) }}</textarea>
                @error('mission_ar') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">
                    {{ __('Goals (EN)') }}
                </label>
                <textarea name="goals_en" rows="5"
                          class="w-full rounded-lg border-gray-300 text-s">{{ old('goals_en', $about->goals_en) }}</textarea>
                @error('goals_en') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">
                    {{ __('Goals (AR)') }}
                </label>
                <textarea name="goals_ar" rows="5"
                          class="w-full rounded-lg border-gray-300 text-s">{{ old('goals_ar', $about->goals_ar) }}</textarea>
                @error('goals_ar') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-1.5 text-s font-semibold text-white hover:bg-black">
                {{ __('Save changes') }}
            </button>
        </div>
    </form>
@endsection
