@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Participants') }}</h1>

    @if(session('success'))
        <div class="mb-3 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-2 text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.participants.create') }}"
           class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-black">
            {{ __('Add participant') }}
        </a>
    </div>

    <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl text-xs">
        <table class="min-w-full">
            <thead class="bg-gray-50 text-[10px] uppercase tracking-wide text-gray-500 border-b border-gray-200">
                <tr>
                    <th class="px-3 py-2 text-start">#</th>
                    <th class="px-3 py-2 text-start">{{ __('Logo') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Name') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Order') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Active') }}</th>
                    <th class="px-3 py-2 text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($participants as $participant)
                    <tr>
                        <td class="px-3 py-2 align-top">{{ $participant->id }}</td>
                        <td class="px-3 py-2 align-top">
                            @if($participant->logo_path)
                                <img src="{{ asset('storage/'.$participant->logo_path) }}" alt="" class="h-8 w-auto object-contain">
                            @else
                                <span class="text-[11px] text-gray-400">{{ __('No logo') }}</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 align-top">
                            <div class="text-gray-900">{{ $participant->name }}</div>
                            @if($participant->url)
                                <div class="text-[11px] text-emerald-700">
                                    {{ $participant->url }}
                                </div>
                            @endif
                        </td>
                        <td class="px-3 py-2 align-top">{{ $participant->display_order }}</td>
                        <td class="px-3 py-2 align-top">
                            {{ $participant->is_active ? __('Yes') : __('No') }}
                        </td>
                        <td class="px-3 py-2 align-top text-end">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.participants.show', $participant) }}"
                                   class="text-[11px] text-gray-600 hover:text-gray-800">
                                    {{ __('View') }}
                                </a>
                                <a href="{{ route('admin.participants.edit', $participant) }}"
                                   class="text-[11px] text-emerald-700 hover:text-emerald-900">
                                    {{ __('Edit') }}
                                </a>
                                <form action="{{ route('admin.participants.destroy', $participant) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('{{ __('Delete participant?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-[11px] text-red-600 hover:text-red-800">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-3 text-center text-gray-500">
                            {{ __('No participants yet.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
