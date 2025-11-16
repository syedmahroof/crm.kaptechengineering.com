@extends('layouts.frontend')

@section('content')
<!-- Services Hero Section -->
<section class="page-hero" style="padding: 120px 0 80px; color: white; position: relative; overflow: hidden; background: url('{{ asset('assets/images/gradient-bg.jpg') }}') center center/cover no-repeat;">
    <!-- Overlay for better text readability -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(103, 70, 156, 0.8);"></div>
    <div style="position: relative; z-index: 2;">
        <div class="container">
            <div class="text-center">
                <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 20px;">Our Travel Services</h1>
                <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Comprehensive travel solutions designed to make your journey unforgettable</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview Section -->
<section class="services-overview-section light-bg" style="background: url('{{ asset('assets/images/gradient-bg.jpg') }}') center center/cover no-repeat; padding: 100px 0; position: relative;">
    <!-- Overlay for better text readability -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.9);"></div>
    <div style="position: relative; z-index: 2;">
        <div class="container">
            <div class="heading text-center" style="margin-bottom: 80px;">
                <h3 style="font-size: 2.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">Why Choose Our Services?</h3>
                <p style="font-size: 22px; font-weight: 200; line-height: 30px; color: #292525; max-width: 600px; margin: 0 auto;">
                    We offer a complete range of travel services to ensure your journey is seamless, memorable, and perfectly tailored to your needs.
                </p>
            </div>
            <div class="row">
                <div class="col-md-4" style="margin-bottom: 50px;">
                    <div style="background: white; padding: 50px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%; text-align: center;">
                        <div style="background: #67469C; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                            <i class="fas fa-plane" style="color: white; font-size: 2.5rem;"></i>
                        </div>
                        <h4 style="font-size: 1.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">Flight Bookings</h4>
                        <p style="font-size: 16px; font-weight: 200; line-height: 24px; color: #292525; margin-bottom: 20px;">
                            Get the best flight deals with our extensive network of airline partners. We ensure comfortable and affordable air travel.
                        </p>
                        <ul style="text-align: left; color: #292525; font-size: 14px;">
                            <li>Domestic & International flights</li>
                            <li>Group bookings & corporate travel</li>
                            <li>24/7 flight support</li>
                            <li>Best price guarantee</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4" style="margin-bottom: 50px;">
                    <div style="background: white; padding: 50px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%; text-align: center;">
                        <div style="background: #E8E127; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                            <i class="fas fa-bed" style="color: #3A3838; font-size: 2.5rem;"></i>
                        </div>
                        <h4 style="font-size: 1.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">Hotel Reservations</h4>
                        <p style="font-size: 16px; font-weight: 200; line-height: 24px; color: #292525; margin-bottom: 20px;">
                            Stay in comfort with our carefully selected accommodations ranging from luxury resorts to budget-friendly hotels.
                        </p>
                        <ul style="text-align: left; color: #292525; font-size: 14px;">
                            <li>Luxury & budget accommodations</li>
                            <li>Verified hotel partners</li>
                            <li>Free cancellation options</li>
                            <li>Special group rates</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4" style="margin-bottom: 50px;">
                    <div style="background: white; padding: 50px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%; text-align: center;">
                        <div style="background: #67469C; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                            <i class="fas fa-route" style="color: white; font-size: 2.5rem;"></i>
                        </div>
                        <h4 style="font-size: 1.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">Tour Packages</h4>
                        <p style="font-size: 16px; font-weight: 200; line-height: 24px; color: #292525; margin-bottom: 20px;">
                            Explore the world with our expertly crafted tour packages that showcase the best of each destination.
                        </p>
                        <ul style="text-align: left; color: #292525; font-size: 14px;">
                            <li>Customized itineraries</li>
                            <li>Local expert guides</li>
                            <li>All-inclusive packages</li>
                            <li>Cultural experiences</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Detailed Services Section -->
<section class="detailed-services-section" style="padding: 100px 0;">
    <div class="container">
        <div class="heading text-center" style="margin-bottom: 80px;">
            <h3 style="font-size: 2.5rem; font-weight: 600; color: #3A3838; margin-bottom: 20px;">Comprehensive Travel Solutions</h3>
            <p style="font-size: 22px; font-weight: 200; line-height: 30px; color: #292525; max-width: 600px; margin: 0 auto;">
                From planning to execution, we handle every aspect of your travel needs with precision and care.
            </p>
        </div>
        
        <!-- Service Categories -->
        <div class="row">
            <!-- Transportation Services -->
            <div class="col-md-6" style="margin-bottom: 50px;">
                <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%;">
                    <div style="display: flex; align-items: center; margin-bottom: 25px;">
                        <div style="background: #67469C; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                            <i class="fas fa-car" style="color: white; font-size: 1.8rem;"></i>
                        </div>
                        <h4 style="font-size: 1.5rem; font-weight: 600; color: #3A3838; margin: 0;">Transportation</h4>
                    </div>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin-bottom: 20px;">
                        Complete transportation solutions for all your travel needs, from airport transfers to city tours.
                    </p>
                    <ul style="color: #292525; font-size: 14px; line-height: 24px;">
                        <li>Airport transfers & pickups</li>
                        <li>Car rentals & chauffeur services</li>
                        <li>Bus & train bookings</li>
                        <li>Private tour vehicles</li>
                        <li>24/7 transportation support</li>
                    </ul>
                    <a href="{{ route('contact') }}" style="color: #67469C; text-decoration: none; font-weight: 600; margin-top: 15px; display: inline-block;">Learn More →</a>
                </div>
            </div>

            <!-- Visa & Documentation -->
            <div class="col-md-6" style="margin-bottom: 50px;">
                <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%;">
                    <div style="display: flex; align-items: center; margin-bottom: 25px;">
                        <div style="background: #E8E127; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                            <i class="fas fa-passport" style="color: #3A3838; font-size: 1.8rem;"></i>
                        </div>
                        <h4 style="font-size: 1.5rem; font-weight: 600; color: #3A3838; margin: 0;">Visa & Documentation</h4>
                    </div>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin-bottom: 20px;">
                        Hassle-free visa processing and documentation services to ensure smooth international travel.
                    </p>
                    <ul style="color: #292525; font-size: 14px; line-height: 24px;">
                        <li>Visa application assistance</li>
                        <li>Document verification</li>
                        <li>Travel insurance</li>
                        <li>Passport renewal support</li>
                        <li>Emergency documentation</li>
                    </ul>
                    <a href="{{ route('contact') }}" style="color: #67469C; text-decoration: none; font-weight: 600; margin-top: 15px; display: inline-block;">Learn More →</a>
                </div>
            </div>

            <!-- Travel Insurance -->
            <div class="col-md-6" style="margin-bottom: 50px;">
                <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%;">
                    <div style="display: flex; align-items: center; margin-bottom: 25px;">
                        <div style="background: #67469C; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                            <i class="fas fa-shield-alt" style="color: white; font-size: 1.8rem;"></i>
                        </div>
                        <h4 style="font-size: 1.5rem; font-weight: 600; color: #3A3838; margin: 0;">Travel Insurance</h4>
                    </div>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin-bottom: 20px;">
                        Comprehensive travel insurance coverage to protect you and your investment during your journey.
                    </p>
                    <ul style="color: #292525; font-size: 14px; line-height: 24px;">
                        <li>Medical coverage</li>
                        <li>Trip cancellation protection</li>
                        <li>Baggage insurance</li>
                        <li>Emergency assistance</li>
                        <li>24/7 support hotline</li>
                    </ul>
                    <a href="{{ route('contact') }}" style="color: #67469C; text-decoration: none; font-weight: 600; margin-top: 15px; display: inline-block;">Learn More →</a>
                </div>
            </div>

            <!-- Corporate Travel -->
            <div class="col-md-6" style="margin-bottom: 50px;">
                <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); height: 100%;">
                    <div style="display: flex; align-items: center; margin-bottom: 25px;">
                        <div style="background: #E8E127; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                            <i class="fas fa-briefcase" style="color: #3A3838; font-size: 1.8rem;"></i>
                        </div>
                        <h4 style="font-size: 1.5rem; font-weight: 600; color: #3A3838; margin: 0;">Corporate Travel</h4>
                    </div>
                    <p style="color: #292525; font-size: 16px; font-weight: 200; line-height: 24px; margin-bottom: 20px;">
                        Specialized business travel solutions designed for corporate clients and business travelers.
                    </p>
                    <ul style="color: #292525; font-size: 14px; line-height: 24px;">
                        <li>Business class bookings</li>
                        <li>Corporate hotel rates</li>
                        <li>Meeting arrangements</li>
                        <li>Expense management</li>
                        <li>Dedicated account manager</li>
                    </ul>
                    <a href="{{ route('contact') }}" style="color: #67469C; text-decoration: none; font-weight: 600; margin-top: 15px; display: inline-block;">Learn More →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Statistics Section -->
<section class="service-statistics-section" style="background: #67469C url('{{ asset('assets/images/logo-pattern.png') }}') center center/200px repeat; padding: 100px 0; color: white; position: relative;">
    <!-- Overlay for better text readability -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(103, 70, 156, 0.8);"></div>
    <div style="position: relative; z-index: 2;">
        <div class="container">
            <div class="heading text-center" style="margin-bottom: 80px;">
                <h3 style="font-size: 2.5rem; font-weight: 600; margin-bottom: 20px;">Our Service Excellence</h3>
                <p style="font-size: 22px; font-weight: 200; line-height: 30px; opacity: 0.9; max-width: 600px; margin: 0 auto;">
                    Numbers that reflect our commitment to providing exceptional travel services.
                </p>
            </div>
            <div class="row text-center">
                <div class="col-md-3" style="margin-bottom: 40px;">
                    <div class="stat-item">
                        <h3 style="font-size: 4rem; font-weight: 700; margin-bottom: 15px; color: white;">500+</h3>
                        <p style="font-size: 18px; font-weight: 200; opacity: 0.9; margin: 0;">Service Partners</p>
                    </div>
                </div>
                <div class="col-md-3" style="margin-bottom: 40px;">
                    <div class="stat-item">
                        <h3 style="font-size: 4rem; font-weight: 700; margin-bottom: 15px; color: white;">98%</h3>
                        <p style="font-size: 18px; font-weight: 200; opacity: 0.9; margin: 0;">Customer Satisfaction</p>
                    </div>
                </div>
                <div class="col-md-3" style="margin-bottom: 40px;">
                    <div class="stat-item">
                        <h3 style="font-size: 4rem; font-weight: 700; margin-bottom: 15px; color: white;">24/7</h3>
                        <p style="font-size: 18px; font-weight: 200; opacity: 0.9; margin: 0;">Customer Support</p>
                    </div>
                </div>
                <div class="col-md-3" style="margin-bottom: 40px;">
                    <div class="stat-item">
                        <h3 style="font-size: 4rem; font-weight: 700; margin-bottom: 15px; color: white;">15+</h3>
                        <p style="font-size: 18px; font-weight: 200; opacity: 0.9; margin: 0;">Service Categories</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Caption -->
@include('frontend.partials.footer-caption')
@endsection
