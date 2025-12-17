<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::orderBy('display_order')->get();

        return view('admin.participants.index', compact('participants'));
    }

    public function create()
    {
        return view('admin.participants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'name_ar'        => ['nullable', 'string', 'max:255'],
            'url'            => ['nullable', 'url', 'max:255'],
            'display_order'  => ['nullable', 'integer'],
            'is_active'      => ['nullable', 'boolean'],
            'logo'           => ['nullable', 'image', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos/participants', 'public');
        }

        Participant::create([
            'name'           => $data['name'],
            'name_ar'        => $data['name_ar'] ?? null,
            'url'            => $data['url'] ?? null,
            'display_order'  => $data['display_order'] ?? 0,
            'is_active'      => $request->boolean('is_active'),
            'logo_path'      => $path,
        ]);

        return redirect()->route('admin.participants.index')
            ->with('success', __('Participant created.'));
    }

    public function show(Participant $participant)
    {
        return view('admin.participants.show', compact('participant'));
    }

    public function edit(Participant $participant)
    {
        return view('admin.participants.edit', compact('participant'));
    }

    public function update(Request $request, Participant $participant)
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'name_ar'        => ['nullable', 'string', 'max:255'],
            'url'            => ['nullable', 'url', 'max:255'],
            'display_order'  => ['nullable', 'integer'],
            'is_active'      => ['nullable', 'boolean'],
            'logo'           => ['nullable', 'image', 'max:2048'],
        ]);

        $update = [
            'name'           => $data['name'],
            'name_ar'        => $data['name_ar'] ?? null,
            'url'            => $data['url'] ?? null,
            'display_order'  => $data['display_order'] ?? 0,
            'is_active'      => $request->boolean('is_active'),
        ];

        if ($request->hasFile('logo')) {
            if ($participant->logo_path) {
                Storage::disk('public')->delete($participant->logo_path);
            }
            $update['logo_path'] = $request->file('logo')->store('logos/participants', 'public');
        }

        $participant->update($update);

        return redirect()->route('admin.participants.index')
            ->with('success', __('Participant updated.'));
    }

    public function destroy(Participant $participant)
    {
        if ($participant->logo_path) {
            Storage::disk('public')->delete($participant->logo_path);
        }

        $participant->delete();

        return redirect()->route('admin.participants.index')
            ->with('success', __('Participant deleted.'));
    }
}
