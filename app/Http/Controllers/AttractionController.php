<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Country;
use App\Models\Destination;
use App\Http\Requests\StoreAttractionRequest;
use App\Http\Requests\UpdateAttractionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Attraction::with(['country', 'destination']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhereHas('country', function ($countryQuery) use ($search) {
                      $countryQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('destination', function ($destinationQuery) use ($search) {
                      $destinationQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->boolean('is_featured'));
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $attractions = $query->paginate(15);

        $countries = Country::active()->ordered()->select(['id', 'name', 'iso_code', 'flag_image'])->get();
        $destinations = Destination::active()->ordered()->select(['id', 'name', 'country_id', 'images', 'slug', 'latitude', 'longitude'])->get();
        $types = Attraction::select('type')
                          ->whereNotNull('type')
                          ->distinct()
                          ->pluck('type')
                          ->sort()
                          ->values();

        return view('admin.attractions.index', [
            'attractions' => $attractions,
            'countries' => $countries,
            'destinations' => $destinations,
            'types' => $types,
            'filters' => $request->only(['search', 'country_id', 'destination_id', 'type', 'is_active', 'is_featured', 'sort_by', 'sort_direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::active()->ordered()->select(['id', 'name', 'iso_code', 'flag_image'])->get();
        $destinations = Destination::active()->ordered()->select(['id', 'name', 'country_id', 'images', 'slug', 'latitude', 'longitude'])->get();
        
        return view('admin.attractions.create', [
            'countries' => $countries,
            'destinations' => $destinations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttractionRequest $request)
    {
        $data = $request->validated();
        
        // Handle images upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('attractions', 'public');
            }
            $data['images'] = $imagePaths;
        }

        Attraction::create($data);

        return redirect()->route('attractions.index')
                        ->with('success', 'Attraction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attraction $attraction)
    {
        $attraction->load(['country', 'destination']);
        
        return view('admin.attractions.show', [
            'attraction' => $attraction,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attraction $attraction)
    {
        $countries = Country::active()->ordered()->select(['id', 'name', 'iso_code', 'flag_image'])->get();
        $destinations = Destination::active()->ordered()->select(['id', 'name', 'country_id', 'images', 'slug', 'latitude', 'longitude'])->get();
        
        return view('admin.attractions.edit', [
            'attraction' => $attraction,
            'countries' => $countries,
            'destinations' => $destinations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttractionRequest $request, Attraction $attraction)
    {
        $data = $request->validated();
        
        // Handle images upload
        if ($request->hasFile('images')) {
            // Delete old images
            if ($attraction->images) {
                foreach ($attraction->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('attractions', 'public');
            }
            $data['images'] = $imagePaths;
        }

        $attraction->update($data);

        return redirect()->route('attractions.index')
                        ->with('success', 'Attraction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attraction $attraction)
    {
        // Delete images
        if ($attraction->images) {
            foreach ($attraction->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $attraction->delete();

        return redirect()->route('attractions.index')
                        ->with('success', 'Attraction deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Attraction $attraction)
    {
        $attraction->update(['is_active' => !$attraction->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $attraction->is_active,
        ]);
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Attraction $attraction)
    {
        $attraction->update(['is_featured' => !$attraction->is_featured]);

        return response()->json([
            'success' => true,
            'is_featured' => $attraction->is_featured,
        ]);
    }
}











