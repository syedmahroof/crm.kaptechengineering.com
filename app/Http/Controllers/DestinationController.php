<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Country;
use App\Http\Requests\Destination\StoreDestinationRequest;
use App\Http\Requests\Destination\UpdateDestinationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Destination::with(['country']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('state_province', 'like', "%{$search}%")
                  ->orWhereHas('country', function ($countryQuery) use ($search) {
                      $countryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
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

        $destinations = $query->paginate(15);

        $countries = Country::active()->ordered()->select(['id', 'name', 'iso_code', 'flag_image'])->get();
        $types = Destination::select('type')
                           ->whereNotNull('type')
                           ->distinct()
                           ->pluck('type')
                           ->sort()
                           ->values();

        return view('admin.destinations-public.index', [
            'destinations' => $destinations,
            'countries' => $countries,
            'types' => $types,
            'filters' => $request->only(['search', 'country_id', 'type', 'is_active', 'is_featured', 'sort_by', 'sort_direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::active()->ordered()->select(['id', 'name', 'iso_code', 'flag_image'])->get();
        
        return view('admin.destinations-public.create', [
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDestinationRequest $request)
    {
        $data = $request->validated();
        
        // Handle images upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('destinations', 'public');
            }
            $data['images'] = $imagePaths;
        }

        Destination::create($data);

        return redirect()->route('destinations.index')
                        ->with('success', 'Destination created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        $destination->load(['country', 'destinationAttractions', 'destinationHotels']);
        
        return view('admin.destinations-public.show', [
            'destination' => $destination,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        $countries = Country::active()->ordered()->select(['id', 'name', 'iso_code', 'flag_image'])->get();
        
        return view('admin.destinations-public.edit', [
            'destination' => $destination,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDestinationRequest $request, Destination $destination)
    {
        $data = $request->validated();
        
        // Handle images upload
        if ($request->hasFile('images')) {
            // Delete old images
            if ($destination->images) {
                foreach ($destination->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('destinations', 'public');
            }
            $data['images'] = $imagePaths;
        }

        $destination->update($data);

        return redirect()->route('destinations.index')
                        ->with('success', 'Destination updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        // Delete images
        if ($destination->images) {
            foreach ($destination->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $destination->delete();

        return redirect()->route('destinations.index')
                        ->with('success', 'Destination deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Destination $destination)
    {
        $destination->update(['is_active' => !$destination->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $destination->is_active,
        ]);
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Destination $destination)
    {
        $destination->update(['is_featured' => !$destination->is_featured]);

        return response()->json([
            'success' => true,
            'is_featured' => $destination->is_featured,
        ]);
    }
}











