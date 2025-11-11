<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadType;
use Illuminate\Http\Request;

class LeadTypeController extends Controller
{
    public function index()
    {
        $leadTypes = LeadType::orderBy('name')->get()->map(function ($type) {
            $type->leads_count = $type->leads()->count();
            return $type;
        });
        
        // Convert to paginated collection manually
        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $items = $leadTypes->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $leadTypes = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $leadTypes->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('lead-types.index', compact('leadTypes'));
    }

    public function create()
    {
        return view('lead-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:lead_types,name',
            'color_code' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Ensure color_code has # prefix if provided
        if (!empty($validated['color_code']) && !str_starts_with($validated['color_code'], '#')) {
            $validated['color_code'] = '#' . $validated['color_code'];
        }

        LeadType::create($validated);

        return redirect()->route('lead-types.index')->with('success', 'Lead type created successfully.');
    }

    public function show(LeadType $leadType)
    {
        $leads = $leadType->leads()->get();

        return view('lead-types.show', compact('leadType', 'leads'));
    }

    public function edit(LeadType $leadType)
    {
        return view('lead-types.edit', compact('leadType'));
    }

    public function update(Request $request, LeadType $leadType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:lead_types,name,' . $leadType->id,
            'color_code' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Ensure color_code has # prefix if provided
        if (!empty($validated['color_code']) && !str_starts_with($validated['color_code'], '#')) {
            $validated['color_code'] = '#' . $validated['color_code'];
        }
        
        $leadType->update($validated);

        return redirect()->route('lead-types.index')->with('success', 'Lead type updated successfully.');
    }

    public function destroy(LeadType $leadType)
    {
        // Check if there are leads using this type
        $leadsCount = Lead::where('lead_type', $leadType->name)->count();
        
        if ($leadsCount > 0) {
            return redirect()->route('lead-types.index')
                ->with('error', "Cannot delete lead type. There are {$leadsCount} leads using this type.");
        }

        $leadType->delete();

        return redirect()->route('lead-types.index')->with('success', 'Lead type deleted successfully.');
    }
}
