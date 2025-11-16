@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.rh')

@section('content')
    <section class="hero">
        <div class="container">
            <h1>Premium Industrial Cable Trays & Channels</h1>
            <p>Galvanized, Hot Dip & Powder Coated Solutions | HVAC, Electrical, Solar & Fire Protection Systems</p>
        </div>
    </section>

    <section class="products-section">
        <div class="container">
            <div class="section-title">
                <h2>Browse Our Products</h2>
                <p>Organized by category for easy navigation</p>
            </div>

            @forelse ($productCategories as $category)
                <div class="category-section" id="{{ $category['anchor'] ?? Str::slug($category['title']) }}">
                    <div class="category-header">
                        <span class="category-icon">{{ $category['icon'] ?? '🧰' }}</span>
                        <h2 class="category-title">{{ $category['title'] }}</h2>
                        <span class="category-count">{{ $category['count'] }} {{ Str::plural('Product', $category['count']) }}</span>
                    </div>
                    <div class="products-grid">
                        @foreach ($category['products'] as $product)
                            <div class="product-card">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-image" onerror="this.src='{{ asset('rh/assets/images/placeholder.svg') }}'">
                                <div class="product-info">
                                    <span class="product-category">{{ $product['category'] }}</span>
                                    <h3>{{ $product['name'] }}</h3>
                                    <p>{{ $product['short_description'] ?? 'High-quality product designed for industrial applications.' }}</p>
                                    <a href="{{ route('rh.products.show', $product['slug']) }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px;">
                    <h3>Products Coming Soon</h3>
                    <p style="color: #666;">We are updating our catalog. Please check back later.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection

