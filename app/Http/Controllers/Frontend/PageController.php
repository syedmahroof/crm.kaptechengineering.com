<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('frontend.about');
    }

    public function services()
    {
        return view('frontend.services');
    }

    public function serviceDetail($slug)
    {
        // For now, we'll use sample data. In a real application, you'd fetch from database
        $service = (object) [
            'title' => 'Premium Travel Service',
            'subtitle' => 'Comprehensive travel solutions tailored to your needs',
            'description' => 'Experience world-class travel services designed to make your journey seamless and memorable. Our expert team ensures every detail is perfectly planned and executed.',
            'image' => asset('assets/images/service-detail.jpg')
        ];
        
        return view('frontend.service-detail', compact('service'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function contactSubmit(Request $request)
    {
        // Basic validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'Your name is required.',
            'email.required' => 'Your email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'subject.required' => 'Please provide a subject for your message.',
            'message.required' => 'Please enter your message.',
            'message.max' => 'Your message is too long. Please keep it under 2000 characters.',
        ]);

        // Save contact message to database
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new',
            'priority' => 'medium',
        ]);
        
        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    public function packages(Request $request)
    {
        $type = $request->get('type', 'all');
        
        // Fetch published master itineraries from backend
        $itineraries = \App\Models\Itinerary::master()
            ->where('status', 'published')
            ->with(['destination', 'country', 'days'])
            ->when($type !== 'all', function($query) use ($type) {
                // Filter by package type if needed - you can customize this logic
                return $query->whereHas('destination', function($q) use ($type) {
                    $q->where('name', 'like', '%' . $type . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        
        return view('frontend.packages', compact('type', 'itineraries'));
    }

    public function itineraryDetail($id)
    {
        $itinerary = \App\Models\Itinerary::where('status', 'published')
            ->with(['destination', 'country', 'days.items'])
            ->findOrFail($id);

        // Collect all images from days for gallery
        $allImages = [];
        if($itinerary->days) {
            foreach($itinerary->days as $day) {
                if($day->images && is_array($day->images)) {
                    foreach($day->images as $image) {
                        if($image) {
                            $allImages[] = [
                                'url' => $image,
                                'day' => $day->day_number,
                                'title' => $day->title
                            ];
                        }
                    }
                }
            }
        }
        
        // Add cover image if exists
        if($itinerary->cover_image) {
            array_unshift($allImages, [
                'url' => $itinerary->cover_image,
                'day' => 0,
                'title' => 'Cover Image'
            ]);
        }

        // Get related itineraries (same destination or country)
        $relatedItineraries = \App\Models\Itinerary::master()
            ->where('status', 'published')
            ->where('id', '!=', $id)
            ->where(function($query) use ($itinerary) {
                if($itinerary->destination_id) {
                    $query->where('destination_id', $itinerary->destination_id);
                }
                if($itinerary->country_id) {
                    $query->orWhere('country_id', $itinerary->country_id);
                }
            })
            ->with(['destination', 'country'])
            ->limit(3)
            ->get();

        return view('frontend.itinerary-detail', compact('itinerary', 'relatedItineraries', 'allImages'));
    }

    public function blog(Request $request)
    {
        $query = Blog::published()->with(['author', 'category']);

        // Apply category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'published_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $posts = $query->paginate(9);

        // Get featured post
        $featuredPost = Blog::published()
                           ->featured()
                           ->with(['author', 'category'])
                           ->first();

        // Get categories for filter
        $categories = BlogCategory::active()
                                 ->get()
                                 ->pluck('name')
                                 ->toArray();

        return view('frontend.blog', compact('posts', 'featuredPost', 'categories'));
    }

    public function blogDetail($slug)
    {
        $post = Blog::published()
                   ->where('slug', $slug)
                   ->with(['author', 'category'])
                   ->firstOrFail();

        // Increment view count
        $post->increment('views');

        // Get related posts
        $relatedPosts = Blog::published()
                           ->where('id', '!=', $post->id)
                           ->where(function ($query) use ($post) {
                               $query->where('category_id', $post->category_id)
                                     ->orWhere('author_id', $post->author_id);
                           })
                           ->with(['author', 'category'])
                           ->limit(3)
                           ->get();

        return view('frontend.blog-detail', compact('post', 'relatedPosts'));
    }

    public function careers()
    {
        return view('frontend.careers');
    }

    public function management()
    {
        return view('frontend.management');
    }

    public function support()
    {
        return view('frontend.support');
    }

    public function privacyPolicy()
    {
        return view('frontend.privacy-policy');
    }

    public function termsOfService()
    {
        return view('frontend.terms-of-service');
    }

    public function travelGuide()
    {
        return view('frontend.travel-guide');
    }

    public function emiPackages()
    {
        return view('frontend.emi-packages');
    }
}