<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view cities'), 403, 'Unauthorized action.');
        
        $query = City::with(['state.country']);

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->filled('country_id')) {
            $query->whereHas('state', function ($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        $cities = $query->orderBy('name')->paginate(15);
        $countries = Country::orderBy('name')->get();
        $states = State::orderBy('name')->get();

        return view('cities.index', compact('cities', 'countries', 'states'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create cities'), 403, 'Unauthorized action.');
        
        $countries = Country::orderBy('name')->get();
        $states = State::orderBy('name')->get();

        return view('cities.create', compact('countries', 'states'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create cities'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        City::create($validated);

        return redirect()->route('cities.index')->with('success', 'City created successfully.');
    }

    public function show(City $city)
    {
        $city->load(['state.country']);

        return view('cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        abort_unless(auth()->user()->can('edit cities'), 403, 'Unauthorized action.');
        
        $countries = Country::orderBy('name')->get();
        $states = State::orderBy('name')->get();

        return view('cities.edit', compact('city', 'countries', 'states'));
    }

    public function update(Request $request, City $city)
    {
        abort_unless(auth()->user()->can('edit cities'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $city->update($validated);

        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        abort_unless(auth()->user()->can('delete cities'), 403, 'Unauthorized action.');
        
        $city->delete();

        return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
    }
}
