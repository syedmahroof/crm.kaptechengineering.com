<?php

namespace App\Http\Controllers\Leads;

use App\Models\LeadType;
use Illuminate\Http\Request;

class LeadTypeController
{
    public function index()
    {
        $leadTypes = LeadType::ordered()->get();
        
        return view('admin.lead-types.index', [
            'leadTypes' => $leadTypes,
        ]);
    }

    public function create()
    {
        return view('admin.lead-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:lead_types,slug',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        LeadType::create($validated);

        return redirect()->route('lead-types.index')
            ->with('success', 'Lead type created successfully.');
    }

    public function edit(LeadType $leadType)
    {
        return view('admin.lead-types.edit', [
            'leadType' => $leadType,
        ]);
    }

    public function update(Request $request, LeadType $leadType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:lead_types,slug,' . $leadType->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $leadType->update($validated);

        return redirect()->route('lead-types.index')
            ->with('success', 'Lead type updated successfully.');
    }

    public function destroy(LeadType $leadType)
    {
        if ($leadType->leads()->exists()) {
            return back()->with('error', 'Cannot delete lead type with associated leads.');
        }

        $leadType->delete();

        return redirect()->route('lead-types.index')
            ->with('success', 'Lead type deleted successfully.');
    }
}
