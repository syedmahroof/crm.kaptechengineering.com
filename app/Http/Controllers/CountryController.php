<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('view countries'), 403, 'Unauthorized action.');
        
        $countries = Country::withCount('states')->orderBy('name')->paginate(15);

        return view('countries.index', compact('countries'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create countries'), 403, 'Unauthorized action.');
        
        return view('countries.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create countries'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:3|unique:countries,code',
            'phone_code' => 'nullable|string|max:5',
            'is_active' => 'boolean',
        ]);

        Country::create($validated);

        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    public function show(Country $country)
    {
        $country->load('states.cities');

        return view('countries.show', compact('country'));
    }

    public function edit(Country $country)
    {
        abort_unless(auth()->user()->can('edit countries'), 403, 'Unauthorized action.');
        
        return view('countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        abort_unless(auth()->user()->can('edit countries'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:3|unique:countries,code,' . $country->id,
            'phone_code' => 'nullable|string|max:5',
            'is_active' => 'boolean',
        ]);

        $country->update($validated);

        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        abort_unless(auth()->user()->can('delete countries'), 403, 'Unauthorized action.');
        
        $country->delete();

        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
