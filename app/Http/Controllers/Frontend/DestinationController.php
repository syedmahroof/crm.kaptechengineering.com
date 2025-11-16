<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::where('is_active', true);

        // Filter by type (international/indian)
        if ($request->has('type')) {
            $query->where('type', $request->get('type'));
        }

        // Search functionality
        if ($request->has('search') && $request->get('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $destinations = $query->paginate(12);

        // Get featured destinations (top 3 destinations with most packages or random if no packages data)
        $featuredDestinations = Destination::where('is_active', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('frontend.destinations', compact('destinations', 'featuredDestinations'));
    }

    public function show($slug)
    {
        $destination = Destination::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related destinations
        $relatedDestinations = Destination::where('type', $destination->type)
            ->where('id', '!=', $destination->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('frontend.destination-detail', compact('destination', 'relatedDestinations'));
    }
}