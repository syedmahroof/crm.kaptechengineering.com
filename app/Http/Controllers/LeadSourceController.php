<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadSource;
use Illuminate\Http\Request;

class LeadSourceController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('view lead-sources'), 403, 'Unauthorized action.');
        
        $leadSources = LeadSource::orderBy('name')->get()->map(function ($source) {
            $source->leads_count = $source->leads()->count();
            return $source;
        });
        
        // Convert to paginated collection manually
        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $items = $leadSources->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $leadSources = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $leadSources->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('lead-sources.index', compact('leadSources'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create lead-sources'), 403, 'Unauthorized action.');
        
        return view('lead-sources.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create lead-sources'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:lead_sources,name',
            'color_code' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Ensure color_code has # prefix if provided
        if (!empty($validated['color_code']) && !str_starts_with($validated['color_code'], '#')) {
            $validated['color_code'] = '#' . $validated['color_code'];
        }

        LeadSource::create($validated);

        return redirect()->route('lead-sources.index')->with('success', 'Lead source created successfully.');
    }

    public function show(LeadSource $leadSource)
    {
        $leads = $leadSource->leads()->get();

        return view('lead-sources.show', compact('leadSource', 'leads'));
    }

    public function edit(LeadSource $leadSource)
    {
        abort_unless(auth()->user()->can('edit lead-sources'), 403, 'Unauthorized action.');
        
        return view('lead-sources.edit', compact('leadSource'));
    }

    public function update(Request $request, LeadSource $leadSource)
    {
        abort_unless(auth()->user()->can('edit lead-sources'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:lead_sources,name,' . $leadSource->id,
            'color_code' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Ensure color_code has # prefix if provided
        if (!empty($validated['color_code']) && !str_starts_with($validated['color_code'], '#')) {
            $validated['color_code'] = '#' . $validated['color_code'];
        }
        
        $leadSource->update($validated);

        return redirect()->route('lead-sources.index')->with('success', 'Lead source updated successfully.');
    }

    public function destroy(LeadSource $leadSource)
    {
        abort_unless(auth()->user()->can('delete lead-sources'), 403, 'Unauthorized action.');
        
        // Check if there are leads using this source
        $leadsCount = Lead::where('source', $leadSource->name)->count();
        
        if ($leadsCount > 0) {
            return redirect()->route('lead-sources.index')
                ->with('error', "Cannot delete lead source. There are {$leadsCount} leads using this source.");
        }

        $leadSource->delete();

        return redirect()->route('lead-sources.index')->with('success', 'Lead source deleted successfully.');
    }
}
