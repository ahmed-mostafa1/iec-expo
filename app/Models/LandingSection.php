<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandingSection extends Model
{
    protected $fillable = [
        'section',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public static function getOrCreate(string $section, array $defaults = []): self
    {
        return static::firstOrCreate(
            ['section' => $section],
            ['content' => $defaults]
        );
    }

    public static function definition(string $section): array
    {
        return config("landing-sections.sections.$section", []);
    }

    public static function defaults(string $section): array
    {
        return static::definition($section)['defaults'] ?? [];
    }

    public static function resolve(string $section): array
    {
        $definition = static::definition($section);
        $defaults = $definition['defaults'] ?? [];

        $record = static::firstWhere('section', $section);

        if (! $record) {
            return $defaults;
        }

        return $record->mergeContent($defaults);
    }

    public function mergeContent(array $defaults): array
    {
        return array_replace_recursive($defaults, $this->content ?? []);
    }

    public function saveContent(array $content): void
    {
        $this->content = $content;
        $this->save();
    }

<<<<<<< HEAD
    /**
     * @param  array<string, mixed>  $content
     * @param  array<string, mixed>  $defaults
     * @return array<string, mixed>
     */
    private function repairRegistrationIconPlusArabicCopy(array $content, array $defaults): array
    {
        foreach (['icon_plus_card', 'icon_plus_form'] as $key) {
            if (! isset($content[$key]) || ! is_array($content[$key])) {
                continue;
            }

            $content[$key] = $this->repairArabicMojibake(
                $content[$key],
                is_array($defaults[$key] ?? null) ? $defaults[$key] : []
            );
        }

        return $content;
    }

    /**
     * @param  array<string, mixed>  $content
     * @param  array<string, mixed>  $defaults
     * @return array<string, mixed>
     */
    private function repairArabicMojibake(array $content, array $defaults): array
    {
        foreach ($content as $key => $value) {
            if (is_array($value)) {
                $content[$key] = $this->repairArabicMojibake(
                    $value,
                    is_array($defaults[$key] ?? null) ? $defaults[$key] : []
                );

                continue;
            }

            if ($key !== 'ar' || ! is_string($value) || ! $this->looksLikeArabicMojibake($value)) {
                continue;
            }

            $content[$key] = is_string($defaults[$key] ?? null)
                ? $defaults[$key]
                : $this->decodeArabicMojibake($value);
        }

        return $content;
    }

    private function looksLikeArabicMojibake(string $value): bool
    {
        return preg_match('/[ØÙÃÂ]/u', $value) === 1
            && preg_match('/\p{Arabic}/u', $value) !== 1;
    }

    private function decodeArabicMojibake(string $value): string
    {
        $decoded = mb_convert_encoding($value, 'Windows-1252', 'UTF-8');

        return preg_match('/\p{Arabic}/u', $decoded) === 1 ? $decoded : $value;
    }

=======
>>>>>>> parent of 690a80d (added icon plus instead of visitor)
    public static function mediaUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        return asset($path);
    }
}
