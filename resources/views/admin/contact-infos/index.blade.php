@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Contact info') }}</h1>

    @if(session('success'))
        <div class="mb-3 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-2 text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.contact-infos.create') }}"
           class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-black">
            {{ __('Add contact') }}
        </a>
    </div>

    <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl text-xs">
        <table class="min-w-full">
            <thead class="bg-gray-50 text-[10px] uppercase tracking-wide text-gray-500 border-b border-gray-200">
                <tr>
                    <th class="px-3 py-2 text-start">#</th>
                    <th class="px-3 py-2 text-start">{{ __('Label') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Phone') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Email') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Order') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Primary') }}</th>
                    <th class="px-3 py-2 text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($contacts as $contact)
                    <tr>
                        <td class="px-3 py-2 align-top">{{ $contact->id }}</td>
                        <td class="px-3 py-2 align-top">
                            {{ $contact->label }}
                        </td>
                        <td class="px-3 py-2 align-top">
                            {{ $contact->phone }}
                        </td>
                        <td class="px-3 py-2 align-top">
                            {{ $contact->email }}
                        </td>
                        <td class="px-3 py-2 align-top">
                            {{ $contact->display_order }}
                        </td>
                        <td class="px-3 py-2 align-top">
                            @if($contact->is_primary)
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-medium text-emerald-700 border border-emerald-200">
                                    {{ __('Primary') }}
                                </span>
                            @else
                                <span class="text-[11px] text-gray-400">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 align-top text-end space-x-2">
                            <a href="{{ route('admin.contact-infos.edit', $contact) }}"
                               class="text-[11px] text-emerald-700 hover:text-emerald-900">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.contact-infos.destroy', $contact) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-[11px] text-red-600 hover:text-red-800"
                                        onclick="return confirm('{{ __('Delete contact?') }}')">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-3 py-3 text-center text-gray-500">
                            {{ __('No contacts yet.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
