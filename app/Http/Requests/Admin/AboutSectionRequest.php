<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AboutSectionRequest extends FormRequest
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
            'title.en' => ['nullable', 'string'],
            'title.ar' => ['nullable', 'string'],
            'mission.title.en' => ['nullable', 'string'],
            'mission.title.ar' => ['nullable', 'string'],
            'mission.paragraphs' => ['nullable', 'array', 'min:1'],
            'mission.paragraphs.*.en' => ['nullable', 'string'],
            'mission.paragraphs.*.ar' => ['nullable', 'string'],
            'goals' => ['nullable', 'array', 'min:1'],
            'goals.*.title.en' => ['nullable', 'string'],
            'goals.*.title.ar' => ['nullable', 'string'],
            'goals.*.description.en' => ['nullable', 'string'],
            'goals.*.description.ar' => ['nullable', 'string'],
            'background_video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm', 'max:51200'],
        ];
    }
}

