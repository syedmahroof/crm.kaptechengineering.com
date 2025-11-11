<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::withCount('states')->orderBy('name')->paginate(15);

        return view('countries.index', compact('countries'));
    }

    public function create()
    {
        return view('countries.create');
    }

    public function store(Request $request)
    {
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
        return view('countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
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
        $country->delete();

        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
