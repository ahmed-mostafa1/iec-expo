<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroMediaController extends Controller
{
    public function index()
    {
        $items = HeroMedia::orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.hero-media.index', compact('items'));
    }

    public function create()
    {
        return view('admin.hero-media.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en'   => ['nullable', 'string', 'max:255'],
            'title_ar'   => ['nullable', 'string', 'max:255'],
            'subtitle_en'=> ['nullable', 'string'],
            'subtitle_ar'=> ['nullable', 'string'],
            'video_type' => ['required', 'in:url,file'],
            'video_url'  => ['nullable', 'url', 'max:255'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,webm', 'max:10240'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $path = null;
        if ($data['video_type'] === 'file' && $request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('hero_media', 'public');
        }

        if ($request->boolean('is_active')) {
            HeroMedia::query()->update(['is_active' => false]);
        }

        HeroMedia::create([
            'title_en'    => $data['title_en'] ?? null,
            'title_ar'    => $data['title_ar'] ?? null,
            'subtitle_en' => $data['subtitle_en'] ?? null,
            'subtitle_ar' => $data['subtitle_ar'] ?? null,
            'video_type'  => $data['video_type'],
            'video_url'   => $data['video_type'] === 'url' ? ($data['video_url'] ?? null) : null,
            'video_path'  => $data['video_type'] === 'file' ? $path : null,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.hero-media.index')
            ->with('success', __('Hero media created.'));
    }

    public function edit(HeroMedia $heroMedium)
    {
        return view('admin.hero-media.edit', ['item' => $heroMedium]);
    }

    public function update(Request $request, HeroMedia $heroMedium)
    {
        $data = $request->validate([
            'title_en'   => ['nullable', 'string', 'max:255'],
            'title_ar'   => ['nullable', 'string', 'max:255'],
            'subtitle_en'=> ['nullable', 'string'],
            'subtitle_ar'=> ['nullable', 'string'],
            'video_type' => ['required', 'in:url,file'],
            'video_url'  => ['nullable', 'url', 'max:255'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,webm', 'max:10240'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $update = [
            'title_en'    => $data['title_en'] ?? null,
            'title_ar'    => $data['title_ar'] ?? null,
            'subtitle_en' => $data['subtitle_en'] ?? null,
            'subtitle_ar' => $data['subtitle_ar'] ?? null,
            'video_type'  => $data['video_type'],
            'is_active'   => $request->boolean('is_active'),
        ];

        if ($data['video_type'] === 'url') {
            $update['video_url']  = $data['video_url'] ?? null;
            $update['video_path'] = null;
        } else {
            if ($request->hasFile('video_file')) {
                if ($heroMedium->video_path) {
                    Storage::disk('public')->delete($heroMedium->video_path);
                }
                $update['video_path'] = $request->file('video_file')->store('hero_media', 'public');
            }
            $update['video_url'] = null;
        }

        if ($request->boolean('is_active')) {
            HeroMedia::where('id', '!=', $heroMedium->id)->update(['is_active' => false]);
        }

        $heroMedium->update($update);

        return redirect()->route('admin.hero-media.index')
            ->with('success', __('Hero media updated.'));
    }

    public function destroy(HeroMedia $heroMedium)
    {
        if ($heroMedium->video_path) {
            Storage::disk('public')->delete($heroMedium->video_path);
        }

        $heroMedium->delete();

        return redirect()->route('admin.hero-media.index')
            ->with('success', __('Hero media deleted.'));
    }
}
