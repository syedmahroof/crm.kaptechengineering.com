<?php

namespace App\Http\Controllers\Leads;

use App\Models\LeadSource;
use Illuminate\Http\Request;

class LeadSourceController 
{
    public function index()
    {
        $sources = LeadSource::orderBy('name')->get();
        
        return view('admin.lead-sources.index', [
            'leadSources' => $sources,
        ]);
    }

    public function create()
    {
        return view('admin.lead-sources.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        LeadSource::create($validated);

        return redirect()->route('lead-sources.index')
            ->with('success', 'Lead source created successfully.');
    }

    public function edit(LeadSource $leadSource)
    {
        return view('admin.lead-sources.edit', [
            'source' => $leadSource,
        ]);
    }

    public function update(Request $request, LeadSource $leadSource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $leadSource->update($validated);

        return redirect()->route('lead-sources.index')
            ->with('success', 'Lead source updated successfully.');
    }

    public function destroy(LeadSource $leadSource)
    {
        if ($leadSource->leads()->exists()) {
            return back()->with('error', 'Cannot delete source with associated leads.');
        }

        $leadSource->delete();

        return redirect()->route('lead-sources.index')
            ->with('success', 'Lead source deleted successfully.');
    }
}
