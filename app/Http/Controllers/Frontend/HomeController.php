<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
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


        // Get testimonials
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('frontend.home', compact(
            'banners',
            'testimonials'
        ));
    }


}