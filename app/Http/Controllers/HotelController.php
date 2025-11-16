<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Country;
use App\Models\Destination;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Http\Requests\Hotel\UpdateHotelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Hotel::with(['country', 'destination']);

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

        if ($request->filled('star_rating')) {
            $query->where('star_rating', $request->star_rating);
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

        $hotels = $query->paginate(15);

        $countries = Country::active()->ordered()->select(['id', 'name', 'iso_code', 'flag_image'])->get();
        $destinations = Destination::active()->ordered()->select(['id', 'name', 'country_id', 'images', 'slug', 'latitude', 'longitude'])->get();
        $types = Hotel::select('type')
                     ->whereNotNull('type')
                     ->distinct()
                     ->pluck('type')
                     ->sort()
                     ->values();

        return view('admin.hotels.index', [
            'hotels' => $hotels,
            'countries' => $countries,
            'destinations' => $destinations,
            'types' => $types,
            'filters' => $request->only(['search', 'country_id', 'destination_id', 'type', 'star_rating', 'is_active', 'is_featured', 'sort_by', 'sort_direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::active()->ordered()->select(['id', 'name', 'iso_code', 'flag_image'])->get();
        $destinations = Destination::active()->ordered()->select(['id', 'name', 'country_id', 'images', 'slug', 'latitude', 'longitude'])->get();
        
        return view('admin.hotels.create', [
            'countries' => $countries,
            'destinations' => $destinations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {
        $data = $request->validated();
        
        // Handle images upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('hotels', 'public');
            }
            $data['images'] = $imagePaths;
        }

        Hotel::create($data);

        return redirect()->route('hotels.index')
                        ->with('success', 'Hotel created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        $hotel->load(['country', 'destination']);
        
        return view('admin.hotels.show', [
            'hotel' => $hotel,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        $countries = Country::active()->ordered()->select(['id', 'name', 'iso_code', 'flag_image'])->get();
        $destinations = Destination::active()->ordered()->select(['id', 'name', 'country_id', 'images', 'slug', 'latitude', 'longitude'])->get();
        
        return view('admin.hotels.edit', [
            'hotel' => $hotel,
            'countries' => $countries,
            'destinations' => $destinations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        $data = $request->validated();
        
        // Handle images upload
        if ($request->hasFile('images')) {
            // Delete old images
            if ($hotel->images) {
                foreach ($hotel->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('hotels', 'public');
            }
            $data['images'] = $imagePaths;
        }

        $hotel->update($data);

        return redirect()->route('hotels.index')
                        ->with('success', 'Hotel updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        // Delete images
        if ($hotel->images) {
            foreach ($hotel->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $hotel->delete();

        return redirect()->route('hotels.index')
                        ->with('success', 'Hotel deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Hotel $hotel)
    {
        $hotel->update(['is_active' => !$hotel->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $hotel->is_active,
        ]);
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Hotel $hotel)
    {
        $hotel->update(['is_featured' => !$hotel->is_featured]);

        return response()->json([
            'success' => true,
            'is_featured' => $hotel->is_featured,
        ]);
    }
}











