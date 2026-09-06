@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Edit employee') }}</h1>

    <form method="POST"
          action="{{ route('admin.employees.update', $employee) }}"
          class="max-w-xl space-y-4 bg-white border border-gray-200 rounded-xl p-4 text-s">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Name') }}</label>
            <input type="text" name="name" class="w-full rounded-lg border-gray-300 text-s"
                   value="{{ old('name', $employee->name) }}" required>
            @error('name') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
            <input type="email" name="email" class="w-full rounded-lg border-gray-300 text-s"
                   value="{{ old('email', $employee->email) }}" required>
            @error('email') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
            <input type="password" name="password" class="w-full rounded-lg border-gray-300 text-s"
                   placeholder="{{ __('Leave blank to keep current password') }}">
            @error('password') <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-s font-semibold text-white hover:bg-black">
                {{ __('Save') }}
            </button>
        </div>
    </form>
@endsection
