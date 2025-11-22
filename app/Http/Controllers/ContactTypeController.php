<?php

namespace App\Http\Controllers;

use App\Models\ContactType;
use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
    public function index()
    {
        $types = ContactType::ordered()->get();
        
        return view('admin.contact-types.index', [
            'types' => $types,
        ]);
    }

    public function create()
    {
        return view('admin.contact-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:contact_types,slug',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        ContactType::create($validated);

        return redirect()->route('contact-types.index')
            ->with('success', 'Contact type created successfully.');
    }

    public function edit(ContactType $contactType)
    {
        return view('admin.contact-types.edit', [
            'type' => $contactType,
        ]);
    }

    public function update(Request $request, ContactType $contactType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:contact_types,slug,' . $contactType->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $contactType->update($validated);

        return redirect()->route('contact-types.index')
            ->with('success', 'Contact type updated successfully.');
    }

    public function destroy(ContactType $contactType)
    {
        if ($contactType->contacts()->exists()) {
            return back()->with('error', 'Cannot delete contact type with associated contacts.');
        }

        $contactType->delete();

        return redirect()->route('contact-types.index')
            ->with('success', 'Contact type deleted successfully.');
    }
}

