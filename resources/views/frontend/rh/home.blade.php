@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.rh')

@section('content')
    <section class="hero">
        <div class="container">
            <h1>The Complete Piping Solution for Modern Industries</h1>
            <p>Premium Cable Trays, Channels & Brackets | Engineered for Excellence | Trusted by Leading Industries Across India</p>
            <a href="{{ route('rh.products.index') }}" class="btn">Explore Our Products</a>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Us</h2>
                <p>Excellence in every aspect of our service</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Extensive Product Range</h3>
                    <p>Comprehensive selection of ladder & perforated cable trays, slotted channels, strut channels, and all types of industrial brackets</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💎</div>
                    <h3>Competitive Factory Prices</h3>
                    <p>Direct manufacturer pricing with no middlemen. Best value for premium quality galvanized, HDG, and powder coated products</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏭</div>
                    <h3>Advanced Manufacturing</h3>
                    <p>State-of-the-art infrastructure with CNC machinery, automated processes, and latest technology for precision engineering</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🚚</div>
                    <h3>Pan-India Delivery</h3>
                    <p>Guaranteed on-time delivery across India. Reliable logistics with real-time tracking and secure packaging</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">✓</div>
                    <h3>Quality Certified</h3>
                    <p>ISO certified processes with stringent QA/QC at every stage. Premium materials ensuring 10+ years durability</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚙️</div>
                    <h3>Custom Solutions</h3>
                    <p>Bespoke designs and non-standard sizes available. Expert engineering support for unique project requirements</p>
                </div>
            </div>
        </div>
    </section>

    <section class="products-section">
        <div class="container">
            <div class="section-title">
                <h2>Industry-Leading Cable Tray & Channel Manufacturer</h2>
                <p>Over a decade of engineering excellence and innovation</p>
            </div>
            <div class="about-section">
                <p><strong>Our mission</strong> is to manufacture and supply precision-engineered industrial piping solutions that meet the highest quality standards. With state-of-the-art infrastructure and cutting-edge technology, we deliver products that ensure durability, performance, and reliability for critical industrial applications.</p>
                <p>We utilize <strong>premium-grade galvanized steel</strong> and implement rigorous quality control protocols at every stage - from raw material procurement to final product dispatch. Our QA team ensures that each cable tray, channel, and bracket meets international standards for strength, corrosion resistance, and longevity.</p>
                <p>With <strong>10+ years of proven expertise</strong> in the field, our products are trusted by leading industries across India for their consistent quality, competitive pricing, and timely delivery. We specialize in both standard and customized solutions for HVAC, electrical, plumbing, solar, and fire protection systems.</p>
                <a href="{{ route('rh.about') }}" class="btn btn-primary">Discover Our Story</a>
            </div>
        </div>
    </section>

    <section class="products-section" style="background: #f5f5f5;">
        <div class="container">
            <div class="section-title">
                <h2>Product Categories</h2>
                <p>Explore our comprehensive range of industrial solutions</p>
            </div>
            <div class="products-grid">
                @forelse ($categorySummaries as $category)
                    <div class="product-card">
                        <img src="{{ asset('rh/assets/images/placeholder.svg') }}" alt="{{ $category['title'] }}" class="product-image" onerror="this.src='{{ asset('rh/assets/images/placeholder.svg') }}'">
                        <div class="product-info">
                            <span class="product-category">{{ $category['count'] }} {{ Str::plural('Product', $category['count']) }}</span>
                            <h3>{{ $category['icon'] ?? '' }} {{ $category['title'] }}</h3>
                            <p>{{ $category['description'] }}</p>
                            <a href="{{ route('rh.products.index') }}#{{ $category['anchor'] ?? Str::slug($category['title']) }}" class="btn btn-primary">Explore Category</a>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 30px;">
                        <p style="color: #666;">Products will be available soon. Please check back later.</p>
                    </div>
                @endforelse
            </div>
            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ route('rh.products.index') }}" class="btn btn-primary">View All {{ $totalProductCount }} Products</a>
            </div>
        </div>
    </section>
@endsection

