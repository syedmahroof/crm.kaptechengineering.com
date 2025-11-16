<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = State::with('country')->orderBy('name');

        // Filter by country if provided
        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
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

        $states = $query->paginate(15);

        $countries = Country::where('is_active', true)->orderBy('name')->get();

        return view('admin.states.index', [
            'states' => $states,
            'countries' => $countries,
            'filters' => $request->only(['search', 'country_id', 'is_active']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $selectedCountryId = $request->get('country_id');

        return view('admin.states.create', [
            'countries' => $countries,
            'selectedCountryId' => $selectedCountryId,
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
            'country_id' => 'required|exists:countries,id',
            'is_active' => 'boolean',
        ]);

        State::create($validated);

        return redirect()->route('states.index', ['country_id' => $validated['country_id']])
                        ->with('success', 'State created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        $state->load('country');
        
        return view('admin.states.show', [
            'state' => $state,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(State $state)
    {
        $countries = Country::where('is_active', true)->orderBy('name')->get();

        return view('admin.states.edit', [
            'state' => $state,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, State $state)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'country_id' => 'required|exists:countries,id',
            'is_active' => 'boolean',
        ]);

        $state->update($validated);

        return redirect()->route('states.index', ['country_id' => $validated['country_id']])
                        ->with('success', 'State updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        $countryId = $state->country_id;
        $state->delete();

        return redirect()->route('states.index', ['country_id' => $countryId])
                        ->with('success', 'State deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(State $state)
    {
        $state->update(['is_active' => !$state->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $state->is_active,
        ]);
    }
}

