@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Add hero media') }}</h1>

    <form method="POST"
          action="{{ route('admin.hero-media.store') }}"
          enctype="multipart/form-data"
          class="max-w-xl space-y-4 bg-white border border-gray-200 rounded-xl p-4 text-xs">
        @csrf

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Title (EN)') }}</label>
                <input type="text" name="title_en" class="w-full rounded-lg border-gray-300 text-xs"
                       value="{{ old('title_en') }}">
                @error('title_en') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Title (AR)') }}</label>
                <input type="text" name="title_ar" class="w-full rounded-lg border-gray-300 text-xs"
                       value="{{ old('title_ar') }}">
                @error('title_ar') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Subtitle (EN)') }}</label>
            <textarea name="subtitle_en" rows="2"
                      class="w-full rounded-lg border-gray-300 text-xs">{{ old('subtitle_en') }}</textarea>
            @error('subtitle_en') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Subtitle (AR)') }}</label>
            <textarea name="subtitle_ar" rows="2"
                      class="w-full rounded-lg border-gray-300 text-xs">{{ old('subtitle_ar') }}</textarea>
            @error('subtitle_ar') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Video type') }}</label>
                <select name="video_type" class="w-full rounded-lg border-gray-300 text-xs">
                    <option value="url" @selected(old('video_type') === 'url')>URL</option>
                    <option value="file" @selected(old('video_type') === 'file')>File</option>
                </select>
                @error('video_type') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center gap-2 mt-5">
                <input type="checkbox" name="is_active" value="1"
                       class="rounded border-gray-300"
                       @checked(old('is_active', true))>
                <span class="text-[11px] text-gray-700">{{ __('Set as active') }}</span>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Video URL (if type is URL)') }}</label>
            <input type="url" name="video_url" class="w-full rounded-lg border-gray-300 text-xs"
                   value="{{ old('video_url') }}">
            @error('video_url') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Video file (if type is File)') }}</label>
            <input type="file" name="video_file" class="w-full text-[11px]">
            @error('video_file') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-black">
                {{ __('Save') }}
            </button>
        </div>
    </form>
@endsection
