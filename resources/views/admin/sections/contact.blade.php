@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">{{ __('Contact section') }}</h1>
                <p class="text-sm text-gray-500">{{ __('Control the message form, support cards, and map block exactly as they appear on the landing page.') }}</p>
            </div>
            <a href="{{ $previewUrl }}" target="_blank" rel="noopener"
                class="text-s inline-flex items-center gap-2 rounded-full border border-emerald-600 px-4 py-2 font-semibold text-emerald-700 hover:bg-emerald-50 transition">
                <span>{{ __('Preview on landing') }}</span>
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900 space-y-1">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        @php
            $title = old('title', $content['title'] ?? []);
            $description = old('description', $content['description'] ?? []);
            $formTitle = old('form_title', $content['form_title'] ?? []);
            $formButton = old('form_button', $content['form_button'] ?? []);
            $mapEmbed = old('map_embed', $content['map_embed'] ?? '');
            $locationTitle = old('location_title', $content['location_title'] ?? []);
            $locationAddress = old('location_address', $content['location_address'] ?? []);
            $supportCards = old('support_cards', $content['support_cards'] ?? []);
        @endphp

        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Section intro') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('Match the hero copy stacked above the contact grid.') }}</p>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (EN)') }}</label>
                        <input type="text" name="title[en]" value="{{ old('title.en', data_get($title, 'en')) }}"
                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                    </div>
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (AR)') }}</label>
                        <input type="text" name="title[ar]" value="{{ old('title.ar', data_get($title, 'ar')) }}"
                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (EN)') }}</label>
                        <textarea name="description[en]" rows="3" class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('description.en', data_get($description, 'en')) }}</textarea>
                    </div>
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Description (AR)') }}</label>
                        <textarea name="description[ar]" rows="3" class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('description.ar', data_get($description, 'ar')) }}</textarea>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <div class="grid gap-6 lg:grid-cols-[2fr,3fr]">
                    <div class="space-y-4 border border-emerald-100 rounded-2xl bg-emerald-50/40 p-4" data-node-group>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ __('Contact form block') }}</h3>
                                <p class="text-s text-gray-500">{{ __('Inputs sit where visitors type messages.') }}</p>
                            </div>
                            <button type="button" class="text-s font-semibold text-emerald-700" data-node-trigger="form-meta">
                                {{ __('Edit text') }}
                            </button>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-white p-4 space-y-3 hidden" data-node-panel="form-meta">
                            <div>
                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Form title (EN)') }}</label>
                                <input type="text" name="form_title[en]" value="{{ old('form_title.en', data_get($formTitle, 'en')) }}"
                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                            </div>
                            <div>
                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Form title (AR)') }}</label>
                                <input type="text" name="form_title[ar]" value="{{ old('form_title.ar', data_get($formTitle, 'ar')) }}"
                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                            </div>
                            <div>
                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Submit button (EN)') }}</label>
                                <input type="text" name="form_button[en]" value="{{ old('form_button.en', data_get($formButton, 'en')) }}"
                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                            </div>
                            <div>
                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Submit button (AR)') }}</label>
                                <input type="text" name="form_button[ar]" value="{{ old('form_button.ar', data_get($formButton, 'ar')) }}"
                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                            </div>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="font-semibold text-gray-900">{{ __('Support cards') }}</h3>
                            <button type="button"
                                class="inline-flex items-center gap-2 rounded-lg border border-emerald-200 bg-white px-3 py-1.5 text-sm font-semibold text-emerald-700 hover:bg-emerald-50 transition"
                                data-add-card>
                                <span class="text-base leading-none">+</span>
                                <span>{{ __('Add support card') }}</span>
                            </button>
                        </div>
                        <div class="space-y-5" data-support-cards data-card-count="{{ count($supportCards) }}">
                            @foreach ($supportCards as $cardIndex => $card)
                                <div class="rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-gray-50 p-4 space-y-4"
                                    data-node-group data-card-key="{{ $card['id'] ?? $cardIndex }}">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Card') }} #{{ $loop->iteration }}</p>
                                            <p class="text-base font-semibold text-gray-900">{{ data_get($card, 'title.en') }}</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button type="button" class="text-s font-semibold text-red-600"
                                                data-delete-card>
                                                {{ __('Delete card') }}
                                            </button>
                                            <button type="button" class="text-s font-semibold text-emerald-700"
                                                data-node-trigger="card-{{ $cardIndex }}">
                                                {{ __('Edit card') }}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="space-y-4 hidden" data-node-panel="card-{{ $cardIndex }}">
                                        <input type="hidden" name="support_cards[{{ $cardIndex }}][id]" value="{{ $card['id'] ?? ('card_' . $cardIndex) }}">
                                        <div class="grid gap-4 md:grid-cols-2">
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (EN)') }}</label>
                                                <input type="text" name="support_cards[{{ $cardIndex }}][title][en]"
                                                    value="{{ old("support_cards.$cardIndex.title.en", data_get($card, 'title.en')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                            <div>
                                                <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (AR)') }}</label>
                                                <input type="text" name="support_cards[{{ $cardIndex }}][title][ar]"
                                                    value="{{ old("support_cards.$cardIndex.title.ar", data_get($card, 'title.ar')) }}"
                                                    class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                            </div>
                                        </div>

                                        @foreach ($card['columns'] ?? [] as $columnIndex => $column)
                                            <div class="rounded-xl border border-gray-100 bg-white p-4 space-y-3">
                                                <div class="grid gap-4 md:grid-cols-2">
                                                    <div>
                                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Column heading (EN)') }}</label>
                                                        <input type="text" name="support_cards[{{ $cardIndex }}][columns][{{ $columnIndex }}][heading][en]"
                                                            value="{{ old("support_cards.$cardIndex.columns.$columnIndex.heading.en", data_get($column, 'heading.en')) }}"
                                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                                    </div>
                                                    <div>
                                                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Column heading (AR)') }}</label>
                                                        <input type="text" name="support_cards[{{ $cardIndex }}][columns][{{ $columnIndex }}][heading][ar]"
                                                            value="{{ old("support_cards.$cardIndex.columns.$columnIndex.heading.ar", data_get($column, 'heading.ar')) }}"
                                                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                                    </div>
                                                </div>
                                                <div class="space-y-3">
                                                    <div class="flex items-center justify-between">
                                                        <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Contacts') }}</p>
                                                        <button type="button" class="text-s font-semibold text-emerald-700"
                                                            data-add-contact="card{{ $cardIndex }}-col{{ $columnIndex }}"
                                                            data-name-prefix="support_cards[{{ $cardIndex }}][columns][{{ $columnIndex }}][contacts]"
                                                            data-target="card{{ $cardIndex }}-col{{ $columnIndex }}">
                                                            {{ __('Add contact') }}
                                                        </button>
                                                    </div>
                                                    <div class="space-y-2" data-contact-container="card{{ $cardIndex }}-col{{ $columnIndex }}">
                                                        @foreach ($column['contacts'] ?? [] as $contactIndex => $contact)
                                                            <div class="flex flex-col gap-2 md:flex-row md:items-center" data-contact-row>
                                                                <select name="support_cards[{{ $cardIndex }}][columns][{{ $columnIndex }}][contacts][{{ $contactIndex }}][type]"
                                                                    class="rounded-lg border-gray-200 text-sm md:w-32">
                                                                    <option value="phone" @if (($contact['type'] ?? '') === 'phone') selected @endif>{{ __('Phone') }}</option>
                                                                    <option value="email" @if (($contact['type'] ?? '') === 'email') selected @endif>{{ __('Email') }}</option>
                                                                </select>
                                                                <input type="text" name="support_cards[{{ $cardIndex }}][columns][{{ $columnIndex }}][contacts][{{ $contactIndex }}][value]"
                                                                    value="{{ old("support_cards.$cardIndex.columns.$columnIndex.contacts.$contactIndex.value", $contact['value'] ?? '') }}"
                                                                    class="flex-1 rounded-lg border-gray-200 text-sm" placeholder="+966..." />
                                                                <button type="button" class="text-xs font-semibold text-red-600 md:w-24"
                                                                    data-delete-contact>
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Map and location block') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('Keep the address, map embed, and optional photo in sync.') }}</p>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Location title (EN)') }}</label>
                        <input type="text" name="location_title[en]" value="{{ old('location_title.en', data_get($locationTitle, 'en')) }}"
                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                    </div>
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Location title (AR)') }}</label>
                        <input type="text" name="location_title[ar]" value="{{ old('location_title.ar', data_get($locationTitle, 'ar')) }}"
                            class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Address (EN)') }}</label>
                        <textarea name="location_address[en]" rows="3" class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('location_address.en', data_get($locationAddress, 'en')) }}</textarea>
                    </div>
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Address (AR)') }}</label>
                        <textarea name="location_address[ar]" rows="3" class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('location_address.ar', data_get($locationAddress, 'ar')) }}</textarea>
                    </div>
                </div>
                <div>
                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Google Maps embed URL') }}</label>
                    <textarea name="map_embed" rows="2" class="w-full mt-1 rounded-lg border-gray-200 text-sm">{{ old('map_embed', $mapEmbed) }}</textarea>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Location image preview') }}</label>
                        <div class="mt-2 aspect-video rounded-xl border border-dashed border-gray-300 bg-gray-100 flex items-center justify-center text-s text-gray-500">
                            {{ data_get($content, 'location_image') ? __('Custom image uploaded') : __('Fallback gradient in use') }}
                        </div>
                    </div>
                    <div>
                        <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Replace image (optional)') }}</label>
                        <input type="file" name="location_image" accept="image/png,image/jpeg,image/webp"
                            class="block w-full rounded-lg border-gray-200 text-sm file:me-4 file:rounded-md file:border-0 file:bg-emerald-600 file:px-4 file:py-2 file:text-white" />
                        <p class="mt-1 text-s text-gray-500">{{ __('Max 8MB, JPG/PNG/WEBP. Keeps the existing image when left blank.') }}</p>
                    </div>
                </div>
            </section>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 transition">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>{{ __('Save contact section') }}</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        (() => {
            const cardsContainer = document.querySelector('[data-support-cards]');
            const addCardButton = document.querySelector('[data-add-card]');
            let cardCounter = Number(cardsContainer?.getAttribute('data-card-count') || 0);

            const createContactRow = (prefix) => {
                const uniqueIndex = Date.now() + Math.floor(Math.random() * 1000);
                const row = document.createElement('div');
                row.className = 'flex flex-col gap-2 md:flex-row md:items-center';
                row.innerHTML = `
                    <select name="${prefix}[${uniqueIndex}][type]" class="rounded-lg border-gray-200 text-sm md:w-32">
                        <option value="phone">{{ __('Phone') }}</option>
                        <option value="email">{{ __('Email') }}</option>
                    </select>
                    <input type="text" name="${prefix}[${uniqueIndex}][value]" class="flex-1 rounded-lg border-gray-200 text-sm" placeholder="+966..." />
                    <button type="button" class="text-xs font-semibold text-red-600 md:w-24" data-delete-contact>
                        {{ __('Delete') }}
                    </button>
                `;
                return row;
            };

            const createColumnBlock = (cardKey, columnKey) => {
                const target = `card${cardKey}-col${columnKey}`;
                const prefix = `support_cards[${cardKey}][columns][${columnKey}][contacts]`;
                const wrapper = document.createElement('div');
                wrapper.className = 'rounded-xl border border-gray-100 bg-white p-4 space-y-3';
                wrapper.innerHTML = `
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Column heading (EN)') }}</label>
                            <input type="text" name="support_cards[${cardKey}][columns][${columnKey}][heading][en]"
                                class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                        </div>
                        <div>
                            <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Column heading (AR)') }}</label>
                            <input type="text" name="support_cards[${cardKey}][columns][${columnKey}][heading][ar]"
                                class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Contacts') }}</p>
                            <button type="button" class="text-s font-semibold text-emerald-700"
                                data-add-contact="${target}"
                                data-name-prefix="${prefix}"
                                data-target="${target}">
                                {{ __('Add contact') }}
                            </button>
                        </div>
                        <div class="space-y-2" data-contact-container="${target}"></div>
                    </div>
                `;

                const contactContainer = wrapper.querySelector('[data-contact-container]');
                if (contactContainer) {
                    contactContainer.appendChild(createContactRow(prefix));
                }

                return wrapper;
            };

            const createSupportCard = (cardKey) => {
                const panelId = `card-${cardKey}`;
                const columnKey = 0;
                const wrapper = document.createElement('div');
                wrapper.innerHTML = `
                    <div class="rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-gray-50 p-4 space-y-4"
                        data-node-group data-card-key="${cardKey}">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-s font-semibold text-gray-500 uppercase">{{ __('Card') }} #${cardKey}</p>
                                <p class="text-base font-semibold text-gray-900">{{ __('New support card') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" class="text-s font-semibold text-red-600" data-delete-card>
                                    {{ __('Delete card') }}
                                </button>
                                <button type="button" class="text-s font-semibold text-emerald-700" data-node-trigger="${panelId}">
                                    {{ __('Edit card') }}
                                </button>
                            </div>
                        </div>

                        <div class="space-y-4" data-node-panel="${panelId}">
                            <input type="hidden" name="support_cards[${cardKey}][id]" value="card_${cardKey}">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (EN)') }}</label>
                                    <input type="text" name="support_cards[${cardKey}][title][en]"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                                <div>
                                    <label class="text-s font-semibold text-gray-500 uppercase">{{ __('Title (AR)') }}</label>
                                    <input type="text" name="support_cards[${cardKey}][title][ar]"
                                        class="w-full mt-1 rounded-lg border-gray-200 text-sm" />
                                </div>
                            </div>
                            <div class="space-y-4" data-dynamic-columns></div>
                        </div>
                    </div>
                `;

                const card = wrapper.firstElementChild;
                const columnsWrapper = card?.querySelector('[data-dynamic-columns]');
                if (columnsWrapper) {
                    columnsWrapper.appendChild(createColumnBlock(cardKey, columnKey));
                }

                return card;
            };

            document.addEventListener('click', (event) => {
                const trigger = event.target.closest('[data-node-trigger]');
                if (trigger) {
                    const group = trigger.closest('[data-node-group]');
                    const target = trigger.getAttribute('data-node-trigger');
                    if (group && target) {
                        group.querySelectorAll('[data-node-panel]').forEach(panel => {
                            if (panel.getAttribute('data-node-panel') === target) {
                                panel.classList.toggle('hidden');
                            } else {
                                panel.classList.add('hidden');
                            }
                        });
                    }
                }

                const addContactButton = event.target.closest('[data-add-contact]');
                if (addContactButton) {
                    const target = addContactButton.getAttribute('data-target');
                    const prefix = addContactButton.getAttribute('data-name-prefix');
                    const container = target ? document.querySelector(`[data-contact-container="${target}"]`) : null;
                    if (container && prefix) {
                        container.appendChild(createContactRow(prefix));
                    }
                }

                const deleteCardButton = event.target.closest('[data-delete-card]');
                if (deleteCardButton) {
                    const card = deleteCardButton.closest('[data-card-key]');
                    if (card) {
                        card.remove();
                    }
                }

                const deleteContactButton = event.target.closest('[data-delete-contact]');
                if (deleteContactButton) {
                    const row = deleteContactButton.closest('[data-contact-row]');
                    if (row) {
                        row.remove();
                    }
                }
            });

            addCardButton?.addEventListener('click', () => {
                cardCounter += 1;
                const newCard = createSupportCard(cardCounter);
                if (cardsContainer && newCard) {
                    cardsContainer.appendChild(newCard);
                }
            });
        })();
    </script>
@endsection
