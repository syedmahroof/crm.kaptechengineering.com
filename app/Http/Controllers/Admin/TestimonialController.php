<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Testimonial::query();

        // Apply filters
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('verified')) {
            $query->where('verified', $request->verified === 'true');
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'true');
        }

        if ($request->filled('trip_type')) {
            $query->where('trip_type', $request->trip_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('review', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $testimonials = $query->paginate(12);

        // Transform testimonials to include image URLs
        $testimonials->getCollection()->transform(function ($testimonial) {
            $testimonial->image_url = $testimonial->image_url;
            return $testimonial;
        });

        $tripTypes = Testimonial::distinct()->pluck('trip_type')->filter()->sort()->values();

        return view('admin.testimonials.index', [
            'testimonials' => $testimonials,
            'tripTypes' => $tripTypes,
            'filters' => $request->only(['status', 'verified', 'featured', 'trip_type', 'search', 'sort_by', 'sort_direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tripTypes = [
            'Adventure Tour',
            'Cultural Tour',
            'Beach Holiday',
            'City Break',
            'Wildlife Safari',
            'Mountain Trek',
            'Cruise',
            'Business Trip',
            'Honeymoon',
            'Family Vacation',
            'Solo Travel',
            'Group Tour',
        ];

        return view('admin.testimonials.create', [
            'tripTypes' => $tripTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
            'trip_type' => 'required|string|max:255',
            'trip_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'verified' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->except(['_token', '_method']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        // Convert boolean strings to actual booleans
        $data['verified'] = filter_var($data['verified'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $data['is_featured'] = filter_var($data['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $data['is_active'] = filter_var($data['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN);

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')
                        ->with('success', 'Testimonial created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', [
            'testimonial' => $testimonial,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        $tripTypes = [
            'Adventure Tour',
            'Cultural Tour',
            'Beach Holiday',
            'City Break',
            'Wildlife Safari',
            'Mountain Trek',
            'Cruise',
            'Business Trip',
            'Honeymoon',
            'Family Vacation',
            'Solo Travel',
            'Group Tour',
        ];

        // Add image URL to the testimonial object
        $testimonial->image_url = $testimonial->image_url;

        return view('admin.testimonials.edit', [
            'testimonial' => $testimonial,
            'tripTypes' => $tripTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
            'trip_type' => 'required|string|max:255',
            'trip_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'verified' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->except(['_token', '_method']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        // Convert boolean strings to actual booleans
        $data['verified'] = filter_var($data['verified'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $data['is_featured'] = filter_var($data['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $data['is_active'] = filter_var($data['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN);

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')
                        ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Delete image
        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
                        ->with('success', 'Testimonial deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);

        return redirect()->back()->with('success', 'Testimonial status updated successfully.');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update(['is_featured' => !$testimonial->is_featured]);

        return redirect()->back()->with('success', 'Testimonial featured status updated successfully.');
    }

    /**
     * Toggle verified status.
     */
    public function toggleVerified(Testimonial $testimonial)
    {
        $testimonial->update(['verified' => !$testimonial->verified]);

        return redirect()->back()->with('success', 'Testimonial verification status updated successfully.');
    }
}
