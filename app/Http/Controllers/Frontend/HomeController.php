<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Destination;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get banners for the homepage
        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        // Get trending destinations (international)
        $destinations = Destination::where('is_active', true)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        // Get Indian destinations
        $indianDestinations = Destination::where('type', 'indian')
            ->where('is_active', true)
            ->limit(6)
            ->get();

        // Get testimonials
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('frontend.home', compact(
            'banners',
            'destinations', 
            'indianDestinations',
            'testimonials'
        ));
    }

    public function search(Request $request)
    {
        $where = $request->get('where');
        $when = $request->get('when');
        $who = $request->get('who');

        // Here you would implement your search logic
        // For now, redirect to destinations page with search parameters
        return redirect()->route('destinations', [
            'search' => $where,
            'date' => $when,
            'travelers' => $who
        ]);
    }
}