<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Country::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('capital', 'like', "%{$search}%")
                  ->orWhere('continent', 'like', "%{$search}%");
            });
        }

        if ($request->filled('continent')) {
            $query->where('continent', $request->continent);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $countries = $query->paginate(15);

        $continents = Country::select('continent')
                           ->whereNotNull('continent')
                           ->distinct()
                           ->pluck('continent')
                           ->sort()
                           ->values();

        return view('admin.countries.index', [
            'countries' => $countries,
            'continents' => $continents,
            'filters' => $request->only(['search', 'continent', 'is_active', 'sort_by', 'sort_direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request)
    {
        $data = $request->validated();
        
        // Handle flag image upload
        if ($request->hasFile('flag_image')) {
            $data['flag_image'] = $request->file('flag_image')->store('countries', 'public');
        }

        Country::create($data);

        return redirect()->route('countries.index')
                        ->with('success', 'Country created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        $destinationsCount = DB::table('destinations')->where('country_id', $country->id)->count();
        
        return view('admin.countries.show', [
            'country' => $country,
            'destinationsCount' => $destinationsCount,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit', [
            'country' => $country,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $data = $request->validated();
        
        // Handle flag image upload
        if ($request->hasFile('flag_image')) {
            // Delete old image
            if ($country->flag_image) {
                Storage::disk('public')->delete($country->flag_image);
            }
            $data['flag_image'] = $request->file('flag_image')->store('countries', 'public');
        }

        $country->update($data);

        return redirect()->route('countries.index')
                        ->with('success', 'Country updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        // Delete flag image
        if ($country->flag_image) {
            Storage::disk('public')->delete($country->flag_image);
        }

        $country->delete();

        return redirect()->route('countries.index')
                        ->with('success', 'Country deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Country $country)
    {
        $country->update(['is_active' => !$country->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $country->is_active,
        ]);
    }
}


