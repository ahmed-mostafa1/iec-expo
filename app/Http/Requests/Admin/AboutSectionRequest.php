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
            'title.en' => ['required', 'string'],
            'title.ar' => ['required', 'string'],
            'mission.title.en' => ['required', 'string'],
            'mission.title.ar' => ['required', 'string'],
            'mission.paragraphs' => ['required', 'array', 'min:1'],
            'mission.paragraphs.*.en' => ['required', 'string'],
            'mission.paragraphs.*.ar' => ['required', 'string'],
            'goals' => ['required', 'array', 'min:1'],
            'goals.*.title.en' => ['required', 'string'],
            'goals.*.title.ar' => ['required', 'string'],
            'goals.*.description.en' => ['required', 'string'],
            'goals.*.description.ar' => ['required', 'string'],
            'background_video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm', 'max:51200'],
        ];
    }
}
