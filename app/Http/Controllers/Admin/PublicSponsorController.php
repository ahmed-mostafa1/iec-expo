<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicSponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicSponsorController extends Controller
{
    protected array $availableTiers = [
        'strategic' => 'Strategic Sponsor',
        'business' => 'Business Sponsor',
        'marketing' => 'Marketing Sponsor',
        'other' => 'Other Sponsor',
    ];

    public function index()
    {
        $sponsors = PublicSponsor::orderBy('display_order')->get();

        return view('admin.public-sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        return view('admin.public-sponsors.create', [
            'tierOptions' => $this->availableTiers,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['nullable', 'string', 'max:255'],
            'name_en'       => ['required', 'string', 'max:255'],
            'name_ar'       => ['nullable', 'string', 'max:255'],
            'tier'          => ['nullable', 'string', 'max:50', 'in:'.implode(',', array_keys($this->availableTiers))],
            'display_order' => ['nullable', 'integer'],
            'is_active'     => ['nullable', 'boolean'],
            'logo'          => ['required', 'image', 'max:2048'],
        ]);

        $path = $request->file('logo')->store('logos/sponsors', 'public');

        PublicSponsor::create([
            'name'          => $data['name'] ?? $data['name_en'],
            'name_en'       => $data['name_en'],
            'name_ar'       => $data['name_ar'] ?? null,
            'tier'          => $data['tier'] ?? null,
            'display_order' => $data['display_order'] ?? 0,
            'is_active'     => $request->boolean('is_active'),
            'logo_path'     => $path,
        ]);

        return redirect()->route('admin.public-sponsors.index')
            ->with('success', __('Sponsor created.'));
    }

    public function show(PublicSponsor $publicSponsor)
    {
        return view('admin.public-sponsors.show', ['sponsor' => $publicSponsor]);
    }

    public function edit(PublicSponsor $publicSponsor)
    {
        return view('admin.public-sponsors.edit', [
            'sponsor' => $publicSponsor,
            'tierOptions' => $this->availableTiers,
        ]);
    }

    public function update(Request $request, PublicSponsor $publicSponsor)
    {
        $data = $request->validate([
            'name'          => ['nullable', 'string', 'max:255'],
            'name_en'       => ['required', 'string', 'max:255'],
            'name_ar'       => ['nullable', 'string', 'max:255'],
            'tier'          => ['nullable', 'string', 'max:50', 'in:'.implode(',', array_keys($this->availableTiers))],
            'display_order' => ['nullable', 'integer'],
            'is_active'     => ['nullable', 'boolean'],
            'logo'          => ['nullable', 'image', 'max:2048'],
        ]);

        $update = [
            'name'          => $data['name'] ?? $data['name_en'],
            'name_en'       => $data['name_en'],
            'name_ar'       => $data['name_ar'] ?? null,
            'tier'          => $data['tier'] ?? null,
            'display_order' => $data['display_order'] ?? 0,
            'is_active'     => $request->boolean('is_active'),
        ];

        if ($request->hasFile('logo')) {
            if ($publicSponsor->logo_path) {
                Storage::disk('public')->delete($publicSponsor->logo_path);
            }
            $update['logo_path'] = $request->file('logo')->store('logos/sponsors', 'public');
        }

        $publicSponsor->update($update);

        return redirect()->route('admin.public-sponsors.index')
            ->with('success', __('Sponsor updated.'));
    }

    public function destroy(PublicSponsor $publicSponsor)
    {
        if ($publicSponsor->logo_path) {
            Storage::disk('public')->delete($publicSponsor->logo_path);
        }

        $publicSponsor->delete();

        return redirect()->route('admin.public-sponsors.index')
            ->with('success', __('Sponsor deleted.'));
    }
}
