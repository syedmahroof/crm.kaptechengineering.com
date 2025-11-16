@extends('layouts.frontend')

@section('content')
<!-- Blog Hero Section -->
<section class="page-hero" style="padding: 120px 0 80px; color: white;">
    <div class="container">
        <div class="text-center">
            <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 20px;">Travel Blog</h1>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Discover amazing travel stories, tips, and insights from around the world</p>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="blog-content" style="padding: 80px 0;">
    <div class="container">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
            <strong>✓</strong> {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
            <strong>✗</strong> {{ session('error') }}
        </div>
        @endif

        <!-- Featured Post -->
        @if($featuredPost)
        <div class="featured-post" style="margin-bottom: 60px;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="featured-image" style="height: 400px; border-radius: 15px; overflow: hidden; position: relative;">
                        @if($featuredPost->featured_image && file_exists(public_path('storage/' . $featuredPost->featured_image)))
                            <img src="{{ asset('storage/' . $featuredPost->featured_image) }}" 
                                 alt="{{ $featuredPost->title }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; position: relative;">
                                <div style="text-align: center; color: white; padding: 40px;">
                                    <div style="font-size: 80px; margin-bottom: 20px; opacity: 0.8;">📰</div>
                                    <h3 style="color: white; font-size: 1.5rem; opacity: 0.9; line-height: 1.3;">{{ $featuredPost->title }}</h3>
                                </div>
                                <!-- Decorative elements -->
                                <div style="position: absolute; top: 20px; right: 20px; width: 30px; height: 30px; background: rgba(255, 255, 255, 0.2); border-radius: 50%;"></div>
                                <div style="position: absolute; bottom: 20px; left: 20px; width: 25px; height: 25px; background: rgba(255, 255, 255, 0.3); border-radius: 50%;"></div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="featured-content" style="padding: 40px;">
                        <div class="post-meta" style="margin-bottom: 15px;">
                            <span class="category" style="background: #66469C; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                {{ $featuredPost->category->name ?? 'Travel' }}
                            </span>
                            <span class="date" style="color: #666; margin-left: 15px; font-size: 14px;">
                                {{ $featuredPost->published_at->format('M d, Y') }}
                            </span>
                        </div>
                        <h2 style="font-size: 2.2rem; font-weight: 700; color: #333; margin-bottom: 20px; line-height: 1.3;">
                            {{ $featuredPost->title }}
                        </h2>
                        <p style="color: #666; margin-bottom: 25px; line-height: 1.6; font-size: 1.1rem;">
                            {{ $featuredPost->excerpt }}
                        </p>
                        <div class="post-footer" style="display: flex; align-items: center; justify-content: space-between;">
                            <div class="author-info" style="display: flex; align-items: center;">
                                <div class="author-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #66469C; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                    <span style="color: white; font-weight: 600; font-size: 16px;">
                                        {{ substr($featuredPost->author->name ?? 'Admin', 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: #333; font-size: 14px;">{{ $featuredPost->author->name ?? 'Admin' }}</div>
                                    <div style="color: #666; font-size: 12px;">{{ $featuredPost->read_time ?? 5 }} min read</div>
                                </div>
                            </div>
                            <a href="{{ route('blog.detail', $featuredPost->slug) }}" 
                               style="background: #66469C; color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600; transition: background 0.3s ease;">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Blog Filter -->
        <div class="blog-filters" style="text-align: center; margin-bottom: 50px;">
            <div class="filter-buttons" style="display: inline-flex; gap: 15px; background: #f8f9fa; padding: 10px; border-radius: 25px; flex-wrap: wrap; justify-content: center;">
                <a href="{{ route('blog') }}" 
                   class="filter-btn {{ request('category') == '' ? 'active' : '' }}" 
                   style="padding: 10px 20px; border-radius: 20px; text-decoration: none; color: #333; transition: all 0.3s ease; {{ request('category') == '' ? 'background: #66469C; color: white;' : '' }}">
                   All Posts
                </a>
                @foreach($categories as $category)
                <a href="{{ route('blog', ['category' => $category]) }}" 
                   class="filter-btn {{ request('category') == $category ? 'active' : '' }}" 
                   style="padding: 10px 20px; border-radius: 20px; text-decoration: none; color: #333; transition: all 0.3s ease; {{ request('category') == $category ? 'background: #66469C; color: white;' : '' }}">
                   {{ $category }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- Blog Posts Grid -->
        <div class="row">
            @forelse($posts as $post)
            <div class="col-md-4" style="margin-bottom: 40px;">
                <div class="blog-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease; height: 100%;">
                    <div class="blog-image" style="height: 250px; overflow: hidden; position: relative;">
                        @if($post->featured_image && file_exists(public_path('storage/' . $post->featured_image)))
                            <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                 alt="{{ $post->title }}" 
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, {{ ['#667eea 0%, #764ba2 100%', '#f093fb 0%, #f5576c 100%', '#4facfe 0%, #00f2fe 100%', '#43e97b 0%, #38f9d7 100%', '#fa709a 0%, #fee140 100%'][($loop->index) % 5] }}); display: flex; align-items: center; justify-content: center; position: relative;">
                                <div style="text-align: center; color: white; padding: 20px;">
                                    <div style="font-size: 60px; margin-bottom: 10px; opacity: 0.8;">✈️</div>
                                    <p style="color: white; font-weight: 600; font-size: 14px; margin: 0; opacity: 0.9; line-height: 1.3;">{{ Str::limit($post->title, 40) }}</p>
                                </div>
                                <!-- Decorative elements -->
                                <div style="position: absolute; top: 15px; right: 15px; width: 25px; height: 25px; background: rgba(255, 255, 255, 0.2); border-radius: 50%;"></div>
                                <div style="position: absolute; bottom: 15px; left: 15px; width: 20px; height: 20px; background: rgba(255, 255, 255, 0.3); border-radius: 50%;"></div>
                            </div>
                        @endif
                    </div>
                    <div class="blog-content" style="padding: 25px; display: flex; flex-direction: column; flex-grow: 1;">
                        <div class="post-meta" style="margin-bottom: 15px;">
                            <span class="category" style="background: #66469C; color: white; padding: 4px 12px; border-radius: 15px; font-size: 11px; font-weight: 600; text-transform: uppercase;">
                                {{ $post->category->name ?? 'Travel' }}
                            </span>
                            <span class="date" style="color: #666; margin-left: 10px; font-size: 12px;">
                                {{ $post->published_at->format('M d, Y') }}
                            </span>
                        </div>
                        <h3 style="font-size: 1.4rem; font-weight: 700; color: #333; margin-bottom: 15px; line-height: 1.4; flex-grow: 1;">
                            <a href="{{ route('blog.detail', $post->slug) }}" style="color: inherit; text-decoration: none;">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p style="color: #666; margin-bottom: 20px; line-height: 1.6; font-size: 14px;">
                            {{ Str::limit($post->excerpt, 120) }}
                        </p>
                        <div class="post-footer" style="display: flex; align-items: center; justify-content: space-between; margin-top: auto;">
                            <div class="author-info" style="display: flex; align-items: center;">
                                <div class="author-avatar" style="width: 30px; height: 30px; border-radius: 50%; background: #66469C; display: flex; align-items: center; justify-content: center; margin-right: 8px;">
                                    <span style="color: white; font-weight: 600; font-size: 12px;">
                                        {{ substr($post->author->name ?? 'Admin', 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: #333; font-size: 12px;">{{ $post->author->name ?? 'Admin' }}</div>
                                    <div style="color: #666; font-size: 11px;">{{ $post->read_time ?? 5 }} min</div>
                                </div>
                            </div>
                            <a href="{{ route('blog.detail', $post->slug) }}" 
                               style="color: #66469C; text-decoration: none; font-weight: 600; font-size: 14px; transition: color 0.3s ease;">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center" style="padding: 60px 20px;">
                    <div style="font-size: 4rem; color: #ddd; margin-bottom: 20px;">📝</div>
                    <h3 style="color: #666; margin-bottom: 15px;">No blog posts found</h3>
                    <p style="color: #999;">Check back later for new travel stories and tips!</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="pagination-wrapper" style="text-align: center; margin-top: 60px;">
            <nav aria-label="Blog pagination">
                <ul class="pagination justify-content-center" style="gap: 10px; list-style: none; padding: 0; display: flex; flex-wrap: wrap;">
                    {{-- Previous Page Link --}}
                    @if($posts->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link" style="border: none; background: #f8f9fa; color: #ccc; padding: 10px 15px; border-radius: 8px; cursor: not-allowed;">← Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $posts->previousPageUrl() }}" style="border: none; background: #f8f9fa; color: #66469C; padding: 10px 15px; border-radius: 8px; text-decoration: none; transition: background 0.3s ease;">← Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if($page == $posts->currentPage())
                            <li class="page-item active">
                                <span class="page-link" style="background: #66469C; border: none; color: white; padding: 10px 15px; border-radius: 8px; min-width: 45px; text-align: center; font-weight: 600;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}" style="border: none; background: #f8f9fa; color: #66469C; padding: 10px 15px; border-radius: 8px; text-decoration: none; min-width: 45px; text-align: center; transition: background 0.3s ease;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if($posts->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $posts->nextPageUrl() }}" style="border: none; background: #f8f9fa; color: #66469C; padding: 10px 15px; border-radius: 8px; text-decoration: none; transition: background 0.3s ease;">Next →</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link" style="border: none; background: #f8f9fa; color: #ccc; padding: 10px 15px; border-radius: 8px; cursor: not-allowed;">Next →</span>
                        </li>
                    @endif
                </ul>
            </nav>
            
            {{-- Pagination Info --}}
            <div style="margin-top: 20px; color: #666; font-size: 14px;">
                Showing {{ $posts->firstItem() ?? 0 }} to {{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} posts
            </div>
        </div>
        @elseif($posts->total() > 0)
        <div class="pagination-wrapper" style="text-align: center; margin-top: 60px;">
            <div style="color: #666; font-size: 14px;">
                Showing all {{ $posts->total() }} posts
            </div>
        </div>
        @endif

    </div>
</section>

<!-- Footer Caption -->
@include('frontend.partials.footer-caption')

<style>
.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

.blog-card:hover .blog-image img {
    transform: scale(1.05);
}

.filter-btn:hover {
    background: #66469C !important;
    color: white !important;
}

.page-link:hover {
    background: #66469C !important;
    color: white !important;
}

.page-item.active .page-link {
    box-shadow: 0 4px 10px rgba(102, 70, 156, 0.3);
}

@media (max-width: 768px) {
    .featured-post .row {
        flex-direction: column-reverse;
    }
    
    .featured-content {
        padding: 20px !important;
    }
    
    .filter-buttons {
        flex-direction: column !important;
        align-items: center !important;
    }
    
    .filter-btn {
        width: 200px !important;
        text-align: center !important;
    }
    
    .pagination {
        justify-content: center !important;
        flex-wrap: wrap !important;
    }
    
    .page-link {
        font-size: 14px !important;
        padding: 8px 12px !important;
    }
}
</style>
@endsection
