<div class="space-y-4">
    <div class="flex flex-wrap items-end gap-3 justify-between">
        <div class="flex flex-wrap gap-3">
            <div>
                <label class="block text-[10px] font-medium text-gray-500 mb-1">
                    {{ __('Search') }}
                </label>
                <input type="text" wire:model.debounce.300ms="search"
                       class="w-48 rounded-lg border-gray-300 text-s"
                       placeholder="{{ __('Name, email, organization, VAT, CR') }}">
            </div>

            <div>
                <label class="block text-[10px] font-medium text-gray-500 mb-1">
                    {{ __('Status') }}
                </label>
                <select wire:model="status" class="w-32 rounded-lg border-gray-300 text-s">
                    <option value="">{{ __('All') }}</option>
                    <option value="pending">{{ __('Pending') }}</option>
                    <option value="approved">{{ __('Approved') }}</option>
                    <option value="rejected">{{ __('Rejected') }}</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-medium text-gray-500 mb-1">
                    {{ __('From date') }}
                </label>
                <input type="date" wire:model="dateFrom"
                       class="w-36 rounded-lg border-gray-300 text-s">
            </div>

            <div>
                <label class="block text-[10px] font-medium text-gray-500 mb-1">
                    {{ __('To date') }}
                </label>
                <input type="date" wire:model="dateTo"
                       class="w-36 rounded-lg border-gray-300 text-s">
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="button"
                wire:click="export"
                class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-1.5 text-s font-medium text-gray-700 hover:bg-gray-50"
            >
                {{ __('Export CSV') }}
            </button>
        </div>
    </div>

    <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl">
        <table class="min-w-full text-s">
            <thead class="bg-gray-50 text-[10px] uppercase tracking-wide text-gray-500 border-b border-gray-200">
                <tr>
                    <th class="px-3 py-2 text-start">#</th>
                    <th class="px-3 py-2 text-start">{{ __('Name') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Organization') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('VAT') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('CR') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Status') }}</th>
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
                        </td>
                        <td class="px-3 py-2 align-top text-gray-700">
                            {{ $registration->organization }}
                        </td>
                        <td class="px-3 py-2 align-top text-gray-700">
                            {{ $registration->vat_number }}
                        </td>
                        <td class="px-3 py-2 align-top text-gray-700">
                            {{ $registration->cr_number }}
                        </td>
                        <td class="px-3 py-2 align-top">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium
                                @class([
                                    'bg-yellow-50 text-yellow-700 border border-yellow-200' => $registration->status === 'pending',
                                    'bg-emerald-50 text-emerald-700 border border-emerald-200' => $registration->status === 'approved',
                                    'bg-red-50 text-red-700 border border-red-200' => $registration->status === 'rejected',
                                ])
                            ">
                                {{ ucfirst($registration->status) }}
                            </span>
                        </td>
                        <td class="px-3 py-2 align-top text-gray-500">
                            {{ $registration->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-3 py-2 align-top text-end">
                            <a href="{{ route('admin.icons.show', $registration) }}"
                               class="text-[11px] font-medium text-emerald-700 hover:text-emerald-900">
                                {{ __('View') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-3 py-4 text-center text-s text-gray-500">
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
