<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizerController extends Controller
{
    public function index()
    {
        $organizers = Organizer::orderBy('display_order')->get();

        return view('admin.organizers.index', compact('organizers'));
    }

    public function create()
    {
        return view('admin.organizers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'name_ar'        => ['nullable', 'string', 'max:255'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'url'            => ['nullable', 'url', 'max:255'],
            'display_order'  => ['nullable', 'integer'],
            'is_active'      => ['nullable', 'boolean'],
            'logo'           => ['nullable', 'image', 'max:2048'],
        ]);

        $path = $request->hasFile('logo')
            ? $request->file('logo')->store('logos/organizers', 'public')
            : null;

        Organizer::create([
            'name'           => $data['name'],
            'name_ar'        => $data['name_ar'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'description_ar' => $data['description_ar'] ?? null,
            'url'            => $data['url'] ?? null,
            'display_order'  => $data['display_order'] ?? 0,
            'is_active'      => $request->boolean('is_active'),
            'logo_path'      => $path,
        ]);

        return redirect()->route('admin.organizers.index')
            ->with('success', __('Organizer created.'));
    }

    public function show(Organizer $organizer)
    {
        return view('admin.organizers.show', compact('organizer'));
    }

    public function edit(Organizer $organizer)
    {
        return view('admin.organizers.edit', compact('organizer'));
    }

    public function update(Request $request, Organizer $organizer)
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'name_ar'        => ['nullable', 'string', 'max:255'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'url'            => ['nullable', 'url', 'max:255'],
            'display_order'  => ['nullable', 'integer'],
            'is_active'      => ['nullable', 'boolean'],
            'logo'           => ['nullable', 'image', 'max:2048'],
        ]);

        $update = [
            'name'           => $data['name'],
            'name_ar'        => $data['name_ar'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'description_ar' => $data['description_ar'] ?? null,
            'url'            => $data['url'] ?? null,
            'display_order'  => $data['display_order'] ?? 0,
            'is_active'      => $request->boolean('is_active'),
        ];

        if ($request->hasFile('logo')) {
            if ($organizer->logo_path) {
                Storage::disk('public')->delete($organizer->logo_path);
            }
            $update['logo_path'] = $request->file('logo')->store('logos/organizers', 'public');
        }

        $organizer->update($update);

        return redirect()->route('admin.organizers.index')
            ->with('success', __('Organizer updated.'));
    }

    public function destroy(Organizer $organizer)
    {
        if ($organizer->logo_path) {
            Storage::disk('public')->delete($organizer->logo_path);
        }

        $organizer->delete();

        return redirect()->route('admin.organizers.index')
            ->with('success', __('Organizer deleted.'));
    }
}
