<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HeroSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    public function rules(): array
    {
        if (! $this->isMethod('post')) {
            return [];
        }

        return [
            'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm', 'max:51200'],
            'poster_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'stats' => ['required', 'array', 'min:1'],
            'stats.*.id' => ['required', 'string'],
            'stats.*.value' => ['required', 'integer', 'min:0'],
            'stats.*.suffix' => ['nullable', 'string', 'max:8'],
            'stats.*.label.en' => ['required', 'string'],
            'stats.*.label.ar' => ['nullable', 'string'],
        ];
    }
}
