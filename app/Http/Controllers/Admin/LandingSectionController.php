<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutSectionRequest;
use App\Http\Requests\Admin\ContactSectionRequest;
use App\Http\Requests\Admin\HeroSectionRequest;
use App\Http\Requests\Admin\RegistrationSectionRequest;
use App\Models\LandingSection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class LandingSectionController extends Controller
{
    public function hero(HeroSectionRequest $request)
    {
        [$section, $definition, $content] = $this->resolveSection('hero');

        if ($request->isMethod('post')) {
            $payload = $content;
            $payload['stats'] = $this->syncStats(
                $request->input('stats', []),
                $content['stats'] ?? []
            );

            if ($request->hasFile('video_file')) {
                $payload['video_path'] = $this->storeFile(
                    $request->file('video_file'),
                    'landing/hero/video',
                    $content['video_path'] ?? null
                );
            }

            if ($request->hasFile('poster_image')) {
                $payload['poster_image_path'] = $this->storeFile(
                    $request->file('poster_image'),
                    'landing/hero/posters',
                    $content['poster_image_path'] ?? null
                );
            }

            $section->saveContent($payload);

            return back()->with('success', __('Hero section updated.'));
        }

        return view('admin.sections.hero', [
            'content' => $content,
            'definition' => $definition,
            'previewUrl' => $this->previewUrl($definition),
        ]);
    }

    public function registration(RegistrationSectionRequest $request)
    {
        [$section, $definition, $content] = $this->resolveSection('registration');

        if ($request->isMethod('post')) {
            $payload = $content;
            $payload['title'] = $request->input('title');
            $payload['description'] = $request->input('description');
            $payload['visitor_card'] = $request->input('visitor_card');
            $payload['visitor_form'] = $this->syncFormConfig(
                $request->input('visitor_form'),
                $content['visitor_form'] ?? []
            );
            $payload['exhibitor_card'] = $request->input('exhibitor_card');
            $payload['exhibitor_form'] = $this->syncExhibitorForm(
                $request->input('exhibitor_form'),
                $content['exhibitor_form'] ?? []
            );
            $payload['icon_card'] = $request->input('icon_card');
            $payload['icon_form'] = $this->syncExhibitorForm(
                $request->input('icon_form'),
                $content['icon_form'] ?? []
            );

            $section->saveContent($payload);

            return back()->with('success', __('Registration section updated.'));
        }

        return view('admin.sections.registration', [
            'content' => $content,
            'definition' => $definition,
            'previewUrl' => $this->previewUrl($definition),
        ]);
    }

    public function about(AboutSectionRequest $request)
    {
        [$section, $definition, $content] = $this->resolveSection('about');

        if ($request->isMethod('post')) {
            $payload = $content;
            $payload['title'] = $request->input('title');
            $payload['mission'] = $request->input('mission');
            $payload['goals'] = array_values($request->input('goals', []));

            if ($request->hasFile('background_video_file')) {
                $payload['background_video'] = $this->storeFile(
                    $request->file('background_video_file'),
                    'landing/about/video',
                    $content['background_video'] ?? null
                );
            }

            $section->saveContent($payload);

            return back()->with('success', __('About section updated.'));
        }

        return view('admin.sections.about', [
            'content' => $content,
            'definition' => $definition,
            'previewUrl' => $this->previewUrl($definition),
        ]);
    }

    public function contact(ContactSectionRequest $request)
    {
        [$section, $definition, $content] = $this->resolveSection('contact');

        if ($request->isMethod('post')) {
            $payload = $content;
            $payload['title'] = $request->input('title');
            $payload['description'] = $request->input('description');
            $payload['form_title'] = $request->input('form_title');
            $payload['form_button'] = $request->input('form_button');
            $payload['map_embed'] = $request->input('map_embed');
            $payload['location_title'] = $request->input('location_title');
            $payload['location_address'] = $request->input('location_address');
            $payload['support_cards'] = $this->syncSupportCards(
                $request->input('support_cards', []),
                $content['support_cards'] ?? []
            );

            if ($request->hasFile('location_image')) {
                $payload['location_image'] = $this->storeFile(
                    $request->file('location_image'),
                    'landing/contact/location',
                    $content['location_image'] ?? null
                );
            }

            $section->saveContent($payload);

            return back()->with('success', __('Contact section updated.'));
        }

        return view('admin.sections.contact', [
            'content' => $content,
            'definition' => $definition,
            'previewUrl' => $this->previewUrl($definition),
        ]);
    }

    private function resolveSection(string $section): array
    {
        $definition = LandingSection::definition($section);
        $defaults = $definition['defaults'] ?? [];
        $record = LandingSection::getOrCreate($section, $defaults);

        return [$record, $definition, $record->mergeContent($defaults)];
    }

    private function previewUrl(array $definition): string
    {
        $anchor = Arr::get($definition, 'preview_anchor', '#');
        $locale = app()->getLocale() ?: 'en';

        return route('public.landing', ['locale' => $locale]) . $anchor;
    }

    private function syncStats(array $stats, array $existing): array
    {
        $existingById = collect($existing)->keyBy('id');

        return collect($stats)
            ->map(function ($stat, $key) use ($existingById) {
                $original = $existingById->get($stat['id'] ?? $key, []);
                return [
                    'id' => $stat['id'] ?? $original['id'] ?? $key,
                    'icon' => $original['icon'] ?? $stat['icon'] ?? 'fas fa-circle',
                    'value' => (int) ($stat['value'] ?? 0),
                    'suffix' => $stat['suffix'] ?? ($original['suffix'] ?? ''),
                    'label' => [
                        'en' => Arr::get($stat, 'label.en', ''),
                        'ar' => Arr::get($stat, 'label.ar', ''),
                    ],
                ];
            })
            ->values()
            ->all();
    }

    private function syncFormConfig(array $submitted, array $existing): array
    {
        $payload = $submitted;
        $payload['fields'] = $this->syncFields(
            Arr::get($submitted, 'fields', []),
            Arr::get($existing, 'fields', [])
        );

        return $payload;
    }

    private function syncExhibitorForm(array $submitted, array $existing): array
    {
        $payload = $submitted;
        $payload['fields_step_one'] = $this->syncFields(
            Arr::get($submitted, 'fields_step_one', []),
            Arr::get($existing, 'fields_step_one', [])
        );

        $payload['fields_step_two'] = $this->syncFields(
            Arr::get($submitted, 'fields_step_two', []),
            Arr::get($existing, 'fields_step_two', [])
        );

        return $payload;
    }

    private function syncFields(array $fields, array $existing): array
    {
        $existingByName = collect($existing)->keyBy('name');

        return collect($fields)
            ->map(function ($field, $index) use ($existingByName) {
                $original = $existingByName->get($field['name'] ?? $index, []);
                $options = collect($field['options'] ?? $original['options'] ?? [])
                    ->map(function ($option) {
                        return [
                            'value' => Arr::get($option, 'value'),
                            'en' => Arr::get($option, 'en', ''),
                            'ar' => Arr::get($option, 'ar', ''),
                        ];
                    })
                    ->values()
                    ->all();

                return [
                    'name' => $field['name'] ?? $original['name'] ?? 'field_' . $index,
                    'type' => $original['type'] ?? $field['type'] ?? 'text',
                    'label' => [
                        'en' => Arr::get($field, 'label.en', ''),
                        'ar' => Arr::get($field, 'label.ar', ''),
                    ],
                    'placeholder' => [
                        'en' => Arr::get($field, 'placeholder.en', ''),
                        'ar' => Arr::get($field, 'placeholder.ar', ''),
                    ],
                    'hint' => [
                        'en' => Arr::get($field, 'hint.en', ''),
                        'ar' => Arr::get($field, 'hint.ar', ''),
                    ],
                    'options' => $options,
                ];
            })
            ->values()
            ->all();
    }

    private function syncSupportCards(array $cards, array $existing): array
    {
        $existingById = collect($existing)->keyBy('id');

        return collect($cards)
            ->map(function ($card, $index) use ($existingById) {
                $original = $existingById->get($card['id'] ?? $index, []);
                $columns = collect($card['columns'] ?? [])
                    ->map(function ($column, $colIndex) use ($original) {
                        $existingColumns = collect($original['columns'] ?? [])->values();
                        $current = $existingColumns->get($colIndex, []);

                        return [
                            'heading' => [
                                'en' => Arr::get($column, 'heading.en', ''),
                                'ar' => Arr::get($column, 'heading.ar', ''),
                            ],
                            'contacts' => collect($column['contacts'] ?? [])
                                ->map(function ($contact) {
                                    return [
                                        'type' => Arr::get($contact, 'type', 'phone'),
                                        'value' => Arr::get($contact, 'value', ''),
                                    ];
                                })
                                ->values()
                                ->all(),
                        ];
                    })
                    ->values()
                    ->all();

                return [
                    'id' => $card['id'] ?? $original['id'] ?? 'support_' . $index,
                    'title' => [
                        'en' => Arr::get($card, 'title.en', ''),
                        'ar' => Arr::get($card, 'title.ar', ''),
                    ],
                    'columns' => $columns,
                ];
            })
            ->values()
            ->all();
    }

    private function storeFile(?UploadedFile $file, string $directory, ?string $currentPath = null): ?string
    {
        if (! $file) {
            return $currentPath;
        }

        $path = $file->store($directory, 'public');

        if ($currentPath && Storage::disk('public')->exists($currentPath)) {
            Storage::disk('public')->delete($currentPath);
        }

        return $path;
    }
}
