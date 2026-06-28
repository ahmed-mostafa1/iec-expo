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
