@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Hero media') }}</h1>

    @if(session('success'))
        <div class="mb-3 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-2 text-s text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.hero-media.create') }}"
           class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-s font-semibold text-white hover:bg-black">
            {{ __('Add hero media') }}
        </a>
    </div>

    <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl text-s">
        <table class="min-w-full">
            <thead class="bg-gray-50 text-[10px] uppercase tracking-wide text-gray-500 border-b border-gray-200">
                <tr>
                    <th class="px-3 py-2 text-start">#</th>
                    <th class="px-3 py-2 text-start">{{ __('Title (EN)') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Type') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Active') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Created at') }}</th>
                    <th class="px-3 py-2 text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($items as $item)
                    <tr>
                        <td class="px-3 py-2 align-top">{{ $item->id }}</td>
                        <td class="px-3 py-2 align-top">
                            {{ $item->title_en ?: '—' }}
                        </td>
                        <td class="px-3 py-2 align-top">
                            {{ $item->video_type }}
                        </td>
                        <td class="px-3 py-2 align-top">
                            {{ $item->is_active ? __('Yes') : __('No') }}
                        </td>
                        <td class="px-3 py-2 align-top">
                            {{ $item->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-3 py-2 align-top text-end space-x-2">
                            <a href="{{ route('admin.hero-media.edit', $item) }}"
                               class="text-[11px] text-emerald-700 hover:text-emerald-900">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.hero-media.destroy', $item) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-[11px] text-red-600 hover:text-red-800"
                                        onclick="return confirm('{{ __('Delete hero media?') }}')">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-3 text-center text-gray-500">
                            {{ __('No hero media yet.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
