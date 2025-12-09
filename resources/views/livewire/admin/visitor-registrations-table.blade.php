<div class="space-y-4">
    <div class="flex flex-wrap items-end gap-3 justify-between">
        <div class="flex flex-wrap gap-3">
            <div>
                <label class="block text-[10px] font-medium text-gray-500 mb-1">
                    {{ __('Search') }}
                </label>
                <input type="text" wire:model.debounce.300ms="search"
                       class="w-48 rounded-lg border-gray-300 text-xs"
                       placeholder="{{ __('Name, email, phone, company') }}">
            </div>

            <div>
                <label class="block text-[10px] font-medium text-gray-500 mb-1">
                    {{ __('From date') }}
                </label>
                <input type="date" wire:model="dateFrom"
                       class="w-36 rounded-lg border-gray-300 text-xs">
            </div>

            <div>
                <label class="block text-[10px] font-medium text-gray-500 mb-1">
                    {{ __('To date') }}
                </label>
                <input type="date" wire:model="dateTo"
                       class="w-36 rounded-lg border-gray-300 text-xs">
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="button"
                wire:click="export"
                class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50"
            >
                {{ __('Export CSV') }}
            </button>
        </div>
    </div>

    <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl">
        <table class="min-w-full text-xs">
            <thead class="bg-gray-50 text-[10px] uppercase tracking-wide text-gray-500 border-b border-gray-200">
                <tr>
                    <th class="px-3 py-2 text-start">#</th>
                    <th class="px-3 py-2 text-start">{{ __('Name') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Company') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Heard about') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Created at') }}</th>
                    <th class="px-3 py-2 text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($registrations as $registration)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 align-top">{{ $registration->id }}</td>
                        <td class="px-3 py-2 align-top">
                            <div class="font-medium text-gray-900">{{ $registration->full_name }}</div>
                            <div class="text-[11px] text-gray-500">{{ $registration->email }}</div>
                            <div class="text-[11px] text-gray-500">{{ $registration->phone }}</div>
                        </td>
                        <td class="px-3 py-2 align-top text-gray-700">
                            {{ $registration->company_name }}
                        </td>
                        <td class="px-3 py-2 align-top text-gray-700">
                            {{ $registration->heard_about }}
                        </td>
                        <td class="px-3 py-2 align-top text-gray-500">
                            {{ $registration->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-3 py-2 align-top text-end">
                            <a href="{{ route('admin.visitors.show', $registration) }}"
                               class="text-[11px] font-medium text-emerald-700 hover:text-emerald-900">
                                {{ __('View') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-4 text-center text-xs text-gray-500">
                            {{ __('No registrations found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-3 py-2 border-t border-gray-100">
            {{ $registrations->links() }}
        </div>
    </div>
</div>
