<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts.
     */
    public function index(Request $request)
    {
        $query = Blog::published()->with(['author', 'category']);

        // Apply filters
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

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

        // Transform posts to include tags from meta_data
        $posts->getCollection()->transform(function ($post) {
            $post->tags = $post->meta_data['tags'] ?? [];
            return $post;
        });

        // Get featured post
        $featuredPost = Blog::published()
                           ->featured()
                           ->with(['author', 'category'])
                           ->first();

        // Transform featured post to include tags
        if ($featuredPost) {
            $featuredPost->tags = $featuredPost->meta_data['tags'] ?? [];
        }

        // Get categories for filter
        $categories = BlogCategory::active()
                                 ->ordered()
                                 ->get()
                                 ->pluck('name')
                                 ->toArray();

        return Inertia::render('Frontend/Blog', [
            'posts' => $posts,
            'featuredPost' => $featuredPost,
            'categories' => $categories,
            'filters' => $request->only(['category', 'search', 'sort_by', 'sort_direction']),
        ]);
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $post = Blog::published()
                   ->where('slug', $slug)
                   ->with(['author', 'category'])
                   ->firstOrFail();

        // Increment view count
        $post->increment('views');

        // Transform post to include tags from meta_data
        $post->tags = $post->meta_data['tags'] ?? [];

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

        // Transform related posts to include tags
        $relatedPosts->transform(function ($relatedPost) {
            $relatedPost->tags = $relatedPost->meta_data['tags'] ?? [];
            return $relatedPost;
        });

        return Inertia::render('Frontend/BlogDetail', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
