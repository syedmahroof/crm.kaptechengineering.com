<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index(Request $request)
    {
        $query = Testimonial::active()->verified();

        // Apply filters
        if ($request->filled('trip_type')) {
            $query->where('trip_type', $request->trip_type);
        }

        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
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

        $testimonials = $query->paginate(9);

        $tripTypes = Testimonial::active()->distinct()->pluck('trip_type')->filter()->sort()->values();

        return Inertia::render('Frontend/Testimonials', [
            'testimonials' => $testimonials,
            'tripTypes' => $tripTypes,
            'filters' => $request->only(['trip_type', 'rating', 'search', 'sort_by', 'sort_direction']),
        ]);
    }
}
