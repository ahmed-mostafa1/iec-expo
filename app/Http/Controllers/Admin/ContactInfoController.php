<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contacts = ContactInfo::orderByDesc('is_primary')
            ->orderBy('display_order')
            ->get();

        return view('admin.contact-infos.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contact-infos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label'         => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255'],
            'display_order' => ['nullable', 'integer'],
            'is_primary'    => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('is_primary')) {
            ContactInfo::query()->update(['is_primary' => false]);
        }

        ContactInfo::create([
            'label'         => $data['label'],
            'phone'         => $data['phone'],
            'email'         => $data['email'],
            'display_order' => $data['display_order'] ?? 0,
            'is_primary'    => $request->boolean('is_primary'),
        ]);

        return redirect()->route('admin.contact-infos.index')
            ->with('success', __('Contact created.'));
    }

    public function edit(ContactInfo $contactInfo)
    {
        return view('admin.contact-infos.edit', ['contact' => $contactInfo]);
    }

    public function update(Request $request, ContactInfo $contactInfo)
    {
        $data = $request->validate([
            'label'         => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255'],
            'display_order' => ['nullable', 'integer'],
            'is_primary'    => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('is_primary')) {
            ContactInfo::where('id', '!=', $contactInfo->id)->update(['is_primary' => false]);
        }

        $contactInfo->update([
            'label'         => $data['label'],
            'phone'         => $data['phone'],
            'email'         => $data['email'],
            'display_order' => $data['display_order'] ?? 0,
            'is_primary'    => $request->boolean('is_primary'),
        ]);

        return redirect()->route('admin.contact-infos.index')
            ->with('success', __('Contact updated.'));
    }

    public function destroy(ContactInfo $contactInfo)
    {
        $contactInfo->delete();

        return redirect()->route('admin.contact-infos.index')
            ->with('success', __('Contact deleted.'));
    }
}
