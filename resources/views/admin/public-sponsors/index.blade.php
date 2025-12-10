@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Public sponsors') }}</h1>

    @if(session('success'))
        <div class="mb-3 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-2 text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.public-sponsors.create') }}"
           class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-black">
            {{ __('Add sponsor') }}
        </a>
    </div>

    <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl text-xs">
        <table class="min-w-full">
            <thead class="bg-gray-50 text-[10px] uppercase tracking-wide text-gray-500 border-b border-gray-200">
                <tr>
                    <th class="px-3 py-2 text-start">#</th>
                    <th class="px-3 py-2 text-start">{{ __('Logo') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Name') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Tier') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Order') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Active') }}</th>
                    <th class="px-3 py-2 text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sponsors as $sponsor)
                    <tr>
                        <td class="px-3 py-2 align-top">{{ $sponsor->id }}</td>
                        <td class="px-3 py-2 align-top">
                            <img src="{{ asset('storage/'.$sponsor->logo_path) }}" alt="" class="h-8 w-auto object-contain">
                        </td>
                        <td class="px-3 py-2 align-top">{{ $sponsor->name }}</td>
                        <td class="px-3 py-2 align-top">{{ $sponsor->tier }}</td>
                        <td class="px-3 py-2 align-top">{{ $sponsor->display_order }}</td>
                        <td class="px-3 py-2 align-top">
                            {{ $sponsor->is_active ? __('Yes') : __('No') }}
                        </td>
                        <td class="px-3 py-2 align-top text-end">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.public-sponsors.show', $sponsor) }}"
                                   class="text-[11px] text-gray-600 hover:text-gray-800">
                                    {{ __('View') }}
                                </a>
                                <a href="{{ route('admin.public-sponsors.edit', $sponsor) }}"
                                   class="text-[11px] text-emerald-700 hover:text-emerald-900">
                                    {{ __('Edit') }}
                                </a>
                                <form action="{{ route('admin.public-sponsors.destroy', $sponsor) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('{{ __('Delete sponsor?') }}')">
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
                        <td colspan="7" class="px-3 py-3 text-center text-gray-500">
                            {{ __('No sponsors yet.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
