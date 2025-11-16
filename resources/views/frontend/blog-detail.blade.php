@extends('layouts.frontend')

@section('content')
<!-- Blog Detail Hero Section -->
<section class="blog-detail-hero" style="padding: 120px 0 60px; background: linear-gradient(135deg, #66469C 0%, #8B5CF6 100%); color: white; position: relative; overflow: hidden;">
    <!-- Background Elements -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1;">
        <div style="position: absolute; top: -50px; left: -50px; width: 200px; height: 200px; background: white; border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -100px; right: -100px; width: 300px; height: 300px; background: white; border-radius: 50%;"></div>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100px; height: 100px; background: white; border-radius: 50%;"></div>
    </div>
    
    <div class="container" style="position: relative; z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="blog-header text-center">
                    <div class="post-meta" style="margin-bottom: 20px;">
                        <span class="category" style="background: rgba(255, 255, 255, 0.2); color: white; padding: 8px 20px; border-radius: 25px; font-size: 14px; font-weight: 600; text-transform: uppercase; backdrop-filter: blur(10px);">
                            {{ $post->category->name ?? 'Travel' }}
                        </span>
                        <span class="date" style="color: rgba(255, 255, 255, 0.8); margin-left: 20px; font-size: 16px;">
                            {{ $post->published_at->format('F d, Y') }}
                        </span>
                    </div>
                    <h1 style="font-size: 3rem; font-weight: 700; color: white; margin-bottom: 25px; line-height: 1.2; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        {{ $post->title }}
                    </h1>
                    <p style="font-size: 1.3rem; color: rgba(255, 255, 255, 0.9); margin-bottom: 30px; line-height: 1.6;">
                        {{ $post->excerpt }}
                    </p>
                    <div class="author-info" style="display: flex; align-items: center; justify-content: center; gap: 20px; flex-wrap: wrap;">
                        <div class="author-details" style="display: flex; align-items: center;">
                            <div class="author-avatar" style="width: 50px; height: 50px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; margin-right: 15px; backdrop-filter: blur(10px);">
                                <span style="color: white; font-weight: 600; font-size: 18px;">
                                    {{ substr($post->author->name ?? 'Admin', 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: white; font-size: 16px;">{{ $post->author->name ?? 'Admin' }}</div>
                                <div style="color: rgba(255, 255, 255, 0.8); font-size: 14px;">Travel Writer</div>
                            </div>
                        </div>
                        <div class="post-stats" style="display: flex; align-items: center; gap: 20px; color: rgba(255, 255, 255, 0.8); font-size: 14px;">
                            <span><i class="fas fa-clock" style="margin-right: 5px;"></i>{{ $post->read_time ?? 5 }} min read</span>
                            <span><i class="fas fa-eye" style="margin-right: 5px;"></i>{{ $post->views ?? 0 }} views</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Image -->
@if($post->featured_image)
<section class="featured-image-section" style="padding: 40px 0 80px; background: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="featured-image" style="height: 500px; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); position: relative;">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         alt="{{ $post->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                    <!-- Overlay for better text readability if needed -->
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; background: linear-gradient(transparent, rgba(0, 0, 0, 0.3));"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Blog Content -->
<section class="blog-content" style="padding: 60px 0 80px; background: white;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="blog-body" style="font-size: 1.1rem; line-height: 1.8; color: #333; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);">
                    {!! $post->content !!}
                </div>

                <!-- Tags -->
                @if(isset($post->meta_data['tags']) && count($post->meta_data['tags']) > 0)
                <div class="post-tags" style="margin-top: 50px; padding-top: 30px; border-top: 1px solid #eee;">
                    <h5 style="color: #333; margin-bottom: 15px; font-weight: 600;">Tags:</h5>
                    <div class="tags-list" style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @foreach($post->meta_data['tags'] as $tag)
                        <span style="background: #f8f9fa; color: #66469C; padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                            #{{ $tag }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Social Share -->
                <div class="social-share" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #eee;">
                    <h5 style="color: #333; margin-bottom: 20px; font-weight: 600;">Share this post:</h5>
                    <div class="share-buttons" style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           style="background: #3b5998; color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; font-size: 14px; font-weight: 500; transition: transform 0.3s ease;">
                            <i class="fab fa-facebook-f" style="margin-right: 8px;"></i>Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                           target="_blank" 
                           style="background: #1da1f2; color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; font-size: 14px; font-weight: 500; transition: transform 0.3s ease;">
                            <i class="fab fa-twitter" style="margin-right: 8px;"></i>Twitter
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           style="background: #0077b5; color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; font-size: 14px; font-weight: 500; transition: transform 0.3s ease;">
                            <i class="fab fa-linkedin-in" style="margin-right: 8px;"></i>LinkedIn
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}" 
                           target="_blank" 
                           style="background: #25d366; color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; font-size: 14px; font-weight: 500; transition: transform 0.3s ease;">
                            <i class="fab fa-whatsapp" style="margin-right: 8px;"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Posts -->
@if($relatedPosts && count($relatedPosts) > 0)
<section class="related-posts" style="padding: 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h3 style="text-align: center; font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 50px; position: relative;">
                    Related Posts
                    <div style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 60px; height: 4px; background: linear-gradient(135deg, #66469C 0%, #8B5CF6 100%); border-radius: 2px;"></div>
                </h3>
                <div class="row">
                    @foreach($relatedPosts as $relatedPost)
                    <div class="col-md-4" style="margin-bottom: 30px;">
                        <div class="related-post-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease; height: 100%;">
                            <div class="related-post-image" style="height: 200px; overflow: hidden; position: relative;">
                                @if($relatedPost->featured_image && file_exists(public_path('storage/' . $relatedPost->featured_image)))
                                    <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                                         alt="{{ $relatedPost->title }}" 
                                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, {{ ['#667eea 0%, #764ba2 100%', '#f093fb 0%, #f5576c 100%', '#4facfe 0%, #00f2fe 100%', '#43e97b 0%, #38f9d7 100%', '#fa709a 0%, #fee140 100%'][($loop->iteration - 1) % 5] }}); display: flex; align-items: center; justify-content: center; position: relative;">
                                        <div style="text-align: center; color: white; padding: 20px;">
                                            <div style="font-size: 48px; margin-bottom: 10px; opacity: 0.8;">✈️</div>
                                            <div style="font-size: 14px; font-weight: 600; opacity: 0.9; line-height: 1.3;">
                                                {{ Str::limit($relatedPost->title, 30) }}
                                            </div>
                                        </div>
                                        <!-- Decorative elements -->
                                        <div style="position: absolute; top: 10px; right: 10px; width: 20px; height: 20px; background: rgba(255, 255, 255, 0.2); border-radius: 50%;"></div>
                                        <div style="position: absolute; bottom: 10px; left: 10px; width: 15px; height: 15px; background: rgba(255, 255, 255, 0.3); border-radius: 50%;"></div>
                                    </div>
                                @endif
                            </div>
                            <div class="related-post-content" style="padding: 20px;">
                                <div class="post-meta" style="margin-bottom: 10px;">
                                    <span class="category" style="background: #66469C; color: white; padding: 3px 10px; border-radius: 12px; font-size: 10px; font-weight: 600; text-transform: uppercase;">
                                        {{ $relatedPost->category->name ?? 'Travel' }}
                                    </span>
                                    <span class="date" style="color: #666; margin-left: 8px; font-size: 11px;">
                                        {{ $relatedPost->published_at->format('M d, Y') }}
                                    </span>
                                </div>
                                <h4 style="font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 10px; line-height: 1.4;">
                                    <a href="{{ route('blog.detail', $relatedPost->slug) }}" style="color: inherit; text-decoration: none;">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h4>
                                <p style="color: #666; margin-bottom: 15px; line-height: 1.5; font-size: 13px;">
                                    {{ Str::limit($relatedPost->excerpt, 100) }}
                                </p>
                                <div class="post-footer" style="display: flex; align-items: center; justify-content: space-between;">
                                    <div class="author-info" style="display: flex; align-items: center;">
                                        <div class="author-avatar" style="width: 25px; height: 25px; border-radius: 50%; background: #66469C; display: flex; align-items: center; justify-content: center; margin-right: 6px;">
                                            <span style="color: white; font-weight: 600; font-size: 10px;">
                                                {{ substr($relatedPost->author->name ?? 'Admin', 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600; color: #333; font-size: 11px;">{{ $relatedPost->author->name ?? 'Admin' }}</div>
                                            <div style="color: #666; font-size: 10px;">{{ $relatedPost->read_time ?? 5 }} min</div>
                                        </div>
                                    </div>
                                    <a href="{{ route('blog.detail', $relatedPost->slug) }}" 
                                       style="color: #66469C; text-decoration: none; font-weight: 600; font-size: 12px;">
                                        Read →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

Route [lead-agents.show] not defined.

<!-- Footer Caption -->
@include('frontend.partials.footer-caption')

<style>
.related-post-card:hover {
    transform: translateY(-5px);
}

.related-post-card:hover .related-post-image img {
    transform: scale(1.05);
}

.share-buttons a:hover {
    transform: translateY(-2px);
}

.featured-image:hover img {
    transform: scale(1.02);
}

.blog-detail-hero {
    background-attachment: fixed;
}

@media (max-width: 768px) {
    .blog-detail-hero h1 {
        font-size: 2.2rem !important;
    }
    
    .author-info {
        flex-direction: column !important;
        gap: 15px !important;
    }
    
    .share-buttons {
        justify-content: center !important;
    }
    
    .share-buttons a {
        flex: 1 !important;
        text-align: center !important;
        min-width: 120px !important;
    }
}

/* Blog content styling */
.blog-body h1, .blog-body h2, .blog-body h3, .blog-body h4, .blog-body h5, .blog-body h6 {
    color: #333;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.blog-body h1 { font-size: 2.5rem; }
.blog-body h2 { font-size: 2rem; }
.blog-body h3 { font-size: 1.75rem; }
.blog-body h4 { font-size: 1.5rem; }
.blog-body h5 { font-size: 1.25rem; }
.blog-body h6 { font-size: 1.1rem; }

.blog-body p {
    margin-bottom: 1.5rem;
}

.blog-body ul, .blog-body ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.blog-body li {
    margin-bottom: 0.5rem;
}

.blog-body blockquote {
    border-left: 4px solid #66469C;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #666;
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
}

.blog-body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 2rem 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.blog-body a {
    color: #66469C;
    text-decoration: none;
    font-weight: 500;
}

.blog-body a:hover {
    text-decoration: underline;
}
</style>
@endsection
