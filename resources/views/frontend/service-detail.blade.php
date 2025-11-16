@extends('layouts.frontend')

@section('content')
<!-- Service Detail Hero Section -->
<section class="page-hero" style="padding: 120px 0 80px; color: white; position: relative; overflow: hidden; background: url('{{ asset('assets/images/gradient-bg.jpg') }}') center center/cover no-repeat;">
    <!-- Overlay for better text readability -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(103, 70, 156, 0.8);"></div>
    <div style="position: relative; z-index: 2;">
        <div class="container">
            <div class="text-center">
                <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 20px;">{{ $service->title ?? 'Travel Service Details' }}</h1>
                <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">{{ $service->subtitle ?? 'Comprehensive travel solutions tailored to your needs' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Service Overview Section -->
<section class="service-overview-section light-bg" style="background: url('{{ asset('assets/images/gradient-bg.jpg') }}') center center/cover no-repeat; padding: 100px 0; position: relative;">
    <!-- Overlay for better text readability -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.9);"></div>
    <div style="position: relative; z-index: 2;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="heading">
                        <h3 style="font-size: 2.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">{{ $service->title ?? 'Premium Travel Service' }}</h3>
                        <p style="font-size: 22px; font-weight: 200; line-height: 30px; color: #292525; margin-bottom: 30px;">
                            {{ $service->description ?? 'Experience world-class travel services designed to make your journey seamless and memorable. Our expert team ensures every detail is perfectly planned and executed.' }}
                        </p>
                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                            <a href="{{ route('contact') }}" class="btn" style="background: #67469C; color: white; padding: 15px 30px; border-radius: 32px; text-decoration: none; font-weight: 600;">Get Quote</a>
                            <a href="tel:+917592010044" class="btn" style="background: transparent; color: #67469C; padding: 15px 30px; border: 2px solid #67469C; border-radius: 32px; text-decoration: none; font-weight: 600;">Call Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="img">
                        <img src="{{ $service->image ?? asset('assets/images/service-detail.jpg') }}" alt="{{ $service->title ?? 'Service Image' }}" style="width: 100%; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Features Section -->
<section class="service-features-section" style="padding: 100px 0;">
    <div class="container">
        <div class="heading text-center" style="margin-bottom: 80px;">
            <h3 style="font-size: 2.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">What's Included</h3>
            <p style="font-size: 22px; font-weight: 200; line-height: 30px; color: #292525; max-width: 600px; margin: 0 auto;">
                Comprehensive features and benefits that make our service stand out from the competition.
            </p>
        </div>
        
        <div class="row">
            <div class="col-md-4" style="margin-bottom: 40px;">
                <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%; text-align: center;">
                    <div style="background: #67469C; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                        <i class="fas fa-check-circle" style="color: white; font-size: 2rem;"></i>
                    </div>
                    <h4 style="font-size: 1.3rem; font-weight: 600; color: #3A3838; margin-bottom: 15px;">Quality Assurance</h4>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin: 0;">
                        Every service is carefully vetted and quality-checked to ensure the highest standards of excellence.
                    </p>
                </div>
            </div>
            <div class="col-md-4" style="margin-bottom: 40px;">
                <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%; text-align: center;">
                    <div style="background: #E8E127; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                        <i class="fas fa-clock" style="color: #3A3838; font-size: 2rem;"></i>
                    </div>
                    <h4 style="font-size: 1.3rem; font-weight: 600; color: #3A3838; margin-bottom: 15px;">24/7 Support</h4>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin: 0;">
                        Round-the-clock customer support to assist you at any time during your travel journey.
                    </p>
                </div>
            </div>
            <div class="col-md-4" style="margin-bottom: 40px;">
                <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%; text-align: center;">
                    <div style="background: #67469C; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                        <i class="fas fa-dollar-sign" style="color: white; font-size: 2rem;"></i>
                    </div>
                    <h4 style="font-size: 1.3rem; font-weight: 600; color: #3A3838; margin-bottom: 15px;">Best Price Guarantee</h4>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin: 0;">
                        We guarantee the best prices for all our services with transparent pricing and no hidden fees.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Process Section -->
<section class="service-process-section light-bg" style="background: url('{{ asset('assets/images/gradient-bg.jpg') }}') center center/cover no-repeat; padding: 100px 0; position: relative;">
    <!-- Overlay for better text readability -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.9);"></div>
    <div style="position: relative; z-index: 2;">
        <div class="container">
            <div class="heading text-center" style="margin-bottom: 80px;">
                <h3 style="font-size: 2.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">How It Works</h3>
                <p style="font-size: 22px; font-weight: 200; line-height: 30px; color: #292525; max-width: 600px; margin: 0 auto;">
                    Simple steps to get started with our premium travel service.
                </p>
            </div>
            
            <div class="row">
                <div class="col-md-3" style="text-align: center; margin-bottom: 40px;">
                    <div style="background: #67469C; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; position: relative;">
                        <span style="color: white; font-size: 1.5rem; font-weight: 700;">1</span>
                    </div>
                    <h4 style="font-size: 1.3rem; font-weight: 600; color: #3A3838; margin-bottom: 15px;">Contact Us</h4>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin: 0;">
                        Reach out to us with your travel requirements and preferences.
                    </p>
                </div>
                <div class="col-md-3" style="text-align: center; margin-bottom: 40px;">
                    <div style="background: #E8E127; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; position: relative;">
                        <span style="color: #3A3838; font-size: 1.5rem; font-weight: 700;">2</span>
                    </div>
                    <h4 style="font-size: 1.3rem; font-weight: 600; color: #3A3838; margin-bottom: 15px;">Custom Planning</h4>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin: 0;">
                        Our experts create a personalized travel plan just for you.
                    </p>
                </div>
                <div class="col-md-3" style="text-align: center; margin-bottom: 40px;">
                    <div style="background: #67469C; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; position: relative;">
                        <span style="color: white; font-size: 1.5rem; font-weight: 700;">3</span>
                    </div>
                    <h4 style="font-size: 1.3rem; font-weight: 600; color: #3A3838; margin-bottom: 15px;">Booking & Confirmation</h4>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin: 0;">
                        We handle all bookings and provide you with confirmations.
                    </p>
                </div>
                <div class="col-md-3" style="text-align: center; margin-bottom: 40px;">
                    <div style="background: #E8E127; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; position: relative;">
                        <span style="color: #3A3838; font-size: 1.5rem; font-weight: 700;">4</span>
                    </div>
                    <h4 style="font-size: 1.3rem; font-weight: 600; color: #3A3838; margin-bottom: 15px;">Enjoy Your Trip</h4>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin: 0;">
                        Relax and enjoy your perfectly planned travel experience.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="pricing-section" style="padding: 100px 0;">
    <div class="container">
        <div class="heading text-center" style="margin-bottom: 80px;">
            <h3 style="font-size: 2.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">Service Pricing</h3>
            <p style="font-size: 22px; font-weight: 200; line-height: 30px; color: #292525; max-width: 600px; margin: 0 auto;">
                Transparent pricing with no hidden fees. Choose the package that best fits your needs.
            </p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-4" style="margin-bottom: 40px;">
                <div style="background: white; padding: 50px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%; text-align: center; position: relative;">
                    <h4 style="font-size: 1.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">Basic Package</h4>
                    <div style="font-size: 3rem; font-weight: 700; color: #67469C; margin-bottom: 30px;">₹15,000</div>
                    <ul style="text-align: left; color: #292525; font-size: 16px; line-height: 30px; margin-bottom: 30px;">
                        <li>Flight bookings</li>
                        <li>Hotel reservations</li>
                        <li>Basic travel insurance</li>
                        <li>Email support</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn" style="background: #67469C; color: white; padding: 15px 30px; border-radius: 32px; text-decoration: none; font-weight: 600; width: 100%; display: block;">Choose Plan</a>
                </div>
            </div>
            <div class="col-md-4" style="margin-bottom: 40px;">
                <div style="background: white; padding: 50px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%; text-align: center; position: relative; border: 3px solid #67469C;">
                    <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: #67469C; color: white; padding: 8px 20px; border-radius: 20px; font-size: 14px; font-weight: 600;">POPULAR</div>
                    <h4 style="font-size: 1.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">Premium Package</h4>
                    <div style="font-size: 3rem; font-weight: 700; color: #67469C; margin-bottom: 30px;">₹25,000</div>
                    <ul style="text-align: left; color: #292525; font-size: 16px; line-height: 30px; margin-bottom: 30px;">
                        <li>Everything in Basic</li>
                        <li>Tour packages</li>
                        <li>Comprehensive insurance</li>
                        <li>24/7 phone support</li>
                        <li>Visa assistance</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn" style="background: #67469C; color: white; padding: 15px 30px; border-radius: 32px; text-decoration: none; font-weight: 600; width: 100%; display: block;">Choose Plan</a>
                </div>
            </div>
            <div class="col-md-4" style="margin-bottom: 40px;">
                <div style="background: white; padding: 50px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%; text-align: center; position: relative;">
                    <h4 style="font-size: 1.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">Luxury Package</h4>
                    <div style="font-size: 3rem; font-weight: 700; color: #67469C; margin-bottom: 30px;">₹50,000</div>
                    <ul style="text-align: left; color: #292525; font-size: 16px; line-height: 30px; margin-bottom: 30px;">
                        <li>Everything in Premium</li>
                        <li>Luxury accommodations</li>
                        <li>Private transfers</li>
                        <li>Personal travel concierge</li>
                        <li>Priority support</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn" style="background: #67469C; color: white; padding: 15px 30px; border-radius: 32px; text-decoration: none; font-weight: 600; width: 100%; display: block;">Choose Plan</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Caption -->
@include('frontend.partials.footer-caption')
@endsection
