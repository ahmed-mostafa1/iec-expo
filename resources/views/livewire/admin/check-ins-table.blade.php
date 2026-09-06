<div class="space-y-4">
    <div class="flex flex-wrap items-end gap-3 justify-between">
        <div class="flex flex-wrap gap-3">
            <div>
                <label class="block text-[10px] font-medium text-gray-500 mb-1">
                    {{ __('Search') }}
                </label>
                <input type="text" wire:model.live.debounce.300ms="search"
                       class="w-48 rounded-lg border-gray-300 text-s"
                       placeholder="{{ __('Name, email, employee') }}">
            </div>

            <div>
                <label class="block text-[10px] font-medium text-gray-500 mb-1">
                    {{ __('Type') }}
                </label>
                <select wire:model.live="type" class="w-40 rounded-lg border-gray-300 text-s">
                    <option value="">{{ __('All types') }}</option>
                    @foreach(array_keys(\App\Support\RegistrationTypes::TYPE_MODELS) as $typeKey)
                        <option value="{{ $typeKey }}">{{ ucwords(str_replace('-', ' ', $typeKey)) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-medium text-gray-500 mb-1">
                    {{ __('Employee') }}
                </label>
                <select wire:model.live="employeeId" class="w-40 rounded-lg border-gray-300 text-s">
                    <option value="">{{ __('All employees') }}</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
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
                    <th class="px-3 py-2 text-start">{{ __('Scanned at') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Employee') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Type') }}</th>
                    <th class="px-3 py-2 text-start">{{ __('Registrant') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($checkIns as $checkIn)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 align-top text-gray-500">
                            {{ $checkIn->scanned_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-3 py-2 align-top text-gray-700">
                            {{ $checkIn->employee->name ?? '—' }}
                        </td>
                        <td class="px-3 py-2 align-top text-gray-700">
                            {{ ucwords(str_replace('-', ' ', $checkIn->registrant_type)) }}
                        </td>
                        <td class="px-3 py-2 align-top">
                            @if($checkIn->registrant)
                                <div class="font-medium text-gray-900">{{ $checkIn->registrant->full_name }}</div>
                                <div class="text-[11px] text-gray-500">{{ $checkIn->registrant->email }}</div>
                                <div class="text-[11px] text-gray-500">
                                    {{ $checkIn->registrant->company_name ?? $checkIn->registrant->organization ?? '' }}
                                </div>
                            @else
                                <span class="text-[11px] text-gray-400">{{ __('Registration deleted') }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-3 py-4 text-center text-s text-gray-500">
                            {{ __('No check-ins found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-3 py-2 border-t border-gray-100">
            {{ $checkIns->links() }}
        </div>
    </div>
</div>
