<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Destination::with('country');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Filter by country
        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'featured');
        }

        $destinations = $query->orderBy('created_at', 'desc')->paginate(15);
        $countries = Country::where('is_active', true)->select(['id', 'name', 'iso_code', 'flag_image'])->orderBy('name')->get();

        return view('admin.destinations.index', [
            'destinations' => $destinations,
            'countries' => $countries,
            'filters' => $request->only(['search', 'country_id', 'status', 'featured'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::where('is_active', true)->select(['id', 'name', 'iso_code', 'flag_image'])->orderBy('name')->get();
        
        return view('admin.destinations.create', [
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Convert empty strings to null for latitude/longitude
        $request->merge([
            'latitude' => $request->input('latitude') === '' ? null : $request->input('latitude'),
            'longitude' => $request->input('longitude') === '' ? null : $request->input('longitude'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'best_time_to_visit' => 'nullable|string|max:255',
            'currency_code' => 'nullable|string|max:10',
            'language' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ], [
            'latitude.between' => 'Latitude must be between -90 and 90 degrees.',
            'longitude.between' => 'Longitude must be between -180 and 180 degrees.',
            'latitude.numeric' => 'Latitude must be a valid number.',
            'longitude.numeric' => 'Longitude must be a valid number.',
        ]);

        // Remove image from validated data as we handle it separately
        unset($validated['image']);
        
        // Generate slug
        $validated['slug'] = Str::slug($request->name);
        
        // Handle boolean values
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : false;
        $validated['is_featured'] = $request->has('is_featured') ? (bool) $request->is_featured : false;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('destinations', 'public');
            $validated['images'] = [$imagePath]; // Store as array
        }

        Destination::create($validated);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        $destination->load('country', 'destinationAttractions');
        
        return view('admin.destinations.show', [
            'destination' => $destination
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        $countries = Country::where('is_active', true)->select(['id', 'name', 'iso_code', 'flag_image'])->orderBy('name')->get();
        
        return view('admin.destinations.edit', [
            'destination' => $destination,
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        // Convert empty strings to null for latitude/longitude
        $request->merge([
            'latitude' => $request->input('latitude') === '' ? null : $request->input('latitude'),
            'longitude' => $request->input('longitude') === '' ? null : $request->input('longitude'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'best_time_to_visit' => 'nullable|string|max:255',
            'currency_code' => 'nullable|string|max:10',
            'language' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ], [
            'latitude.between' => 'Latitude must be between -90 and 90 degrees.',
            'longitude.between' => 'Longitude must be between -180 and 180 degrees.',
            'latitude.numeric' => 'Latitude must be a valid number.',
            'longitude.numeric' => 'Longitude must be a valid number.',
        ]);

        // Remove image from validated data as we handle it separately
        unset($validated['image']);
        
        // Generate slug
        $validated['slug'] = Str::slug($request->name);
        
        // Handle boolean values
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : false;
        $validated['is_featured'] = $request->has('is_featured') ? (bool) $request->is_featured : false;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old images
            if ($destination->images && is_array($destination->images)) {
                foreach ($destination->images as $oldImage) {
                    \Storage::disk('public')->delete($oldImage);
                }
            }
            $imagePath = $request->file('image')->store('destinations', 'public');
            $validated['images'] = [$imagePath]; // Store as array
        }

        $destination->update($validated);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        // Delete images
        if ($destination->images && is_array($destination->images)) {
            foreach ($destination->images as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $destination->delete();

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Destination $destination)
    {
        $destination->update(['is_active' => !$destination->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $destination->is_active
        ]);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Destination $destination)
    {
        $destination->update(['is_featured' => !$destination->is_featured]);

        return response()->json([
            'success' => true,
            'is_featured' => $destination->is_featured
        ]);
    }
}
