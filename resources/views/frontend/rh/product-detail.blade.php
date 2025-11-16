@extends('layouts.rh')

@section('content')
    <section class="product-details" id="product-detail">
        <div class="container">
            <div style="margin-bottom: 20px;">
                <a href="{{ route('rh.products.index') }}" style="color: #027bc2; text-decoration: none;">← Back to Products</a>
            </div>

            <div class="product-detail-container">
                <div class="product-detail-image">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" onerror="this.src='{{ asset('rh/assets/images/placeholder.svg') }}'">
                </div>

                <div class="product-detail-info">
                    <span class="product-category">{{ $product['category'] ?? 'Product' }}</span>
                    <h1>{{ $product['name'] }}</h1>
                    <p>{!! nl2br(e($product['description'] ?? 'High-quality product designed for industrial applications.')) !!}</p>

                    <div class="product-specs">
                        <h3>Technical Specifications</h3>
                        <div>
                            @forelse ($product['specifications'] as $label => $value)
                                <div class="spec-item">
                                    <span class="spec-label">{{ ucfirst(str_replace('_', ' ', $label)) }}:</span>
                                    <span class="spec-value">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                                </div>
                            @empty
                                <p style="color: #666;">Specifications will be updated shortly. Contact our team for detailed information.</p>
                            @endforelse
                        </div>
                    </div>

                    <div style="margin-top: 30px; display: flex; gap: 15px; flex-wrap: wrap;">
                        <a href="{{ route('rh.contact') }}" class="btn btn-primary">Request Quote</a>
                        <a href="{{ route('rh.contact') }}" class="btn">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Product Features</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">✓</div>
                    <h3>Quality Assured</h3>
                    <p>Stringent quality checking from material procurement to finished product</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💪</div>
                    <h3>High Durability</h3>
                    <p>Made from superior quality materials for long-lasting performance</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔧</div>
                    <h3>Easy Installation</h3>
                    <p>Designed for smooth and fast installation with complete accessories</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏭</div>
                    <h3>Industrial Grade</h3>
                    <p>Suitable for heavy-duty applications in various industries</p>
                </div>
            </div>
        </div>
    </section>

    @if ($relatedProducts->isNotEmpty())
        <section class="products-section" style="background: #f5f5f5;">
            <div class="container">
                <div class="section-title">
                    <h2>Related Products</h2>
                    <p>You may also be interested in</p>
                </div>
                <div class="products-grid">
                    @foreach ($relatedProducts as $related)
                        <div class="product-card">
                            <img src="{{ $related['image'] }}" alt="{{ $related['name'] }}" class="product-image" onerror="this.src='{{ asset('rh/assets/images/placeholder.svg') }}'">
                            <div class="product-info">
                                <span class="product-category">{{ $related['category'] }}</span>
                                <h3>{{ $related['name'] }}</h3>
                                <p>{{ $related['short_description'] ?? 'High-quality product designed for industrial applications.' }}</p>
                                <a href="{{ route('rh.products.show', $related['slug']) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="products-section">
        <div class="container" style="text-align: center;">
            <h2 style="margin-bottom: 20px; color: #027bc2;">Need Custom Solutions?</h2>
            <p style="margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto; color: #666;">
                We offer customization as per your specific requirements. Contact our team to discuss your project needs.
            </p>
            <a href="{{ route('rh.contact') }}" class="btn btn-primary">Get in Touch</a>
        </div>
    </section>
@endsection

