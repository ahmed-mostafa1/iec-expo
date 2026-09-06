@extends('layouts.admin')

@section('content')
    <h1 class="text-lg font-semibold mb-4">{{ __('Employees') }}</h1>

    @if(session('success'))
        <div class="mb-3 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-2 text-s text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.employees.create') }}"
           class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-1.5 text-s font-semibold text-white hover:bg-black">
            {{ __('Add employee') }}
        </a>
    </div>

    <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl text-s">
        <table class="min-w-full">
            <thead class="bg-gray-50 text-[10px] uppercase tracking-wide text-gray-500 border-b border-gray-200">
                <tr>
                    <th class="px-3 py-2 text-start">#</th>
                    <th class="px-3 py-2 text-start">{{ __('Name') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Email') }}</th>
                    <th class="px-3 py-2 text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($employees as $employee)
                    <tr>
                        <td class="px-3 py-2 align-top">{{ $employee->id }}</td>
                        <td class="px-3 py-2 align-top text-gray-900 font-semibold">{{ $employee->name }}</td>
                        <td class="px-3 py-2 align-top">{{ $employee->email }}</td>
                        <td class="px-3 py-2 align-top text-end">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.employees.edit', $employee) }}"
                                   class="text-[11px] text-emerald-700 hover:text-emerald-900">
                                    {{ __('Edit') }}
                                </a>
                                <form action="{{ route('admin.employees.destroy', $employee) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('{{ __('Delete employee?') }}')">
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
                        <td colspan="4" class="px-3 py-3 text-center text-gray-500">
                            {{ __('No employees yet.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
