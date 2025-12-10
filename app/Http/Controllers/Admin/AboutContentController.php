<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use Illuminate\Http\Request;

class AboutContentController extends Controller
{
    public function edit()
    {
        $about = AboutContent::first();

        if (! $about) {
            $about = AboutContent::create([
                'mission_en' => '',
                'mission_ar' => '',
                'goals_en'   => '',
                'goals_ar'   => '',
            ]);
        }

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $about = AboutContent::firstOrFail();

        $data = $request->validate([
            'mission_en' => ['required', 'string'],
            'mission_ar' => ['required', 'string'],
            'goals_en'   => ['required', 'string'],
            'goals_ar'   => ['required', 'string'],
        ]);

        $about->update($data);

        return back()->with('success', __('About content updated.'));
    }
}
