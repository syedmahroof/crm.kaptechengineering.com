<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = District::with(['state', 'country'])->orderBy('name');

        // Filter by country if provided
        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        // Filter by state if provided
        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $districts = $query->paginate(15);

        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $states = State::where('is_active', true)->orderBy('name')->get();

        return view('admin.districts.index', [
            'districts' => $districts,
            'countries' => $countries,
            'states' => $states,
            'filters' => $request->only(['search', 'country_id', 'state_id', 'is_active']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $states = State::where('is_active', true)->orderBy('name')->get();
        $selectedCountryId = $request->get('country_id');
        $selectedStateId = $request->get('state_id');

        return view('admin.districts.create', [
            'countries' => $countries,
            'states' => $states,
            'selectedCountryId' => $selectedCountryId,
            'selectedStateId' => $selectedStateId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'state_id' => 'nullable|exists:states,id',
            'country_id' => 'required|exists:countries,id',
            'is_active' => 'boolean',
        ]);

        District::create($validated);

        return redirect()->route('districts.index', [
            'country_id' => $validated['country_id'],
            'state_id' => $validated['state_id'] ?? null,
        ])->with('success', 'District/City created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(District $district)
    {
        $district->load(['state', 'country']);
        
        return view('admin.districts.show', [
            'district' => $district,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(District $district)
    {
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $states = State::where('is_active', true)->orderBy('name')->get();

        return view('admin.districts.edit', [
            'district' => $district,
            'countries' => $countries,
            'states' => $states,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'state_id' => 'nullable|exists:states,id',
            'country_id' => 'required|exists:countries,id',
            'is_active' => 'boolean',
        ]);

        $district->update($validated);

        return redirect()->route('districts.index', [
            'country_id' => $validated['country_id'],
            'state_id' => $validated['state_id'] ?? null,
        ])->with('success', 'District/City updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(District $district)
    {
        $countryId = $district->country_id;
        $stateId = $district->state_id;
        $district->delete();

        return redirect()->route('districts.index', [
            'country_id' => $countryId,
            'state_id' => $stateId,
        ])->with('success', 'District/City deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(District $district)
    {
        $district->update(['is_active' => !$district->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $district->is_active,
        ]);
    }
}

