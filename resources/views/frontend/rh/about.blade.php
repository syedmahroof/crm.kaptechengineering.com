@extends('layouts.rh')

@section('content')
    <section class="hero">
        <div class="container">
            <h1>Leading Manufacturer of Industrial Cable Management Solutions</h1>
            <p>Your Trusted Partner for Premium Cable Trays, Channels & Brackets Since 2013</p>
        </div>
    </section>

    <section class="about-content">
        <div class="container">
            <div class="about-intro">
                <h1>Engineering Excellence in Cable Management Systems</h1>
                <p style="max-width: 900px; margin: 0 auto; color: #6c757d; font-size: 18px;">With over a decade of proven expertise, we are committed to manufacturing and supplying world-class cable trays, channels, and brackets that meet international quality standards. Our products power critical infrastructure across HVAC, electrical, solar, and industrial sectors.</p>
            </div>

            <div class="about-sections">
                <div class="about-section">
                    <h2>Our Mission</h2>
                    <p>Our mission is to make and provide quality and precision products to the required industries by continuous improvements with the help of advanced technologies. Easy wire cable tray owns an advanced infrastructure equipped with sophisticated equipment/machinery having latest technology.</p>
                    <p>These machines are also updated from time to time to meet ever changing customer demands.</p>
                </div>

                <div class="about-section">
                    <h2>Quality Assurance</h2>
                    <p>We use high grade and superior quality sheets which are subject to quality checking right from the material procurement by our QA team to make our effectively designed and precision engineered products ensuring durability and high performance for the customer.</p>
                    <p>The finished product also undergoes a stringent quality checking before it is being released for dispatch to customer.</p>
                </div>

                <div class="about-section">
                    <h2>Our Track Record</h2>
                    <p>Having completed more than one decade in the field we are proud to put in record that our make Easy wire cable tray products have found well acceptance in the industry and has gained popularity amongst our clientele for maintaining consistent quality and meeting delivery schedules.</p>
                    <p>We strive to attain absolute customer satisfaction by offering customized product as per the specific requisites of the customers as and when need arises.</p>
                </div>

                <div class="about-section">
                    <h2>Why Choose Us</h2>
                    <p>We stand out in the industry for our commitment to excellence and customer satisfaction.</p>
                    <div class="why-us-list">
                        <div class="why-us-item">Wide Range of Products</div>
                        <div class="why-us-item">Competitive Prices</div>
                        <div class="why-us-item">High-Tech Manufacturing Facility</div>
                        <div class="why-us-item">On-Time Delivery</div>
                        <div class="why-us-item">Skilled/Experienced Professionals</div>
                        <div class="why-us-item">Customization as per Customer Needs</div>
                    </div>
                </div>

                <div class="about-section" style="background: linear-gradient(135deg, #027bc2 0%, #005a94 100%); color: white;">
                    <h2 style="color: white;">Our Commitment</h2>
                    <p style="color: rgba(255,255,255,0.9);">We are dedicated to continuous improvement and innovation, ensuring that our products meet the evolving needs of modern industries. Our team of experienced professionals works tirelessly to maintain the highest standards of quality and service.</p>
                    <p style="color: rgba(255,255,255,0.9);">With state-of-the-art manufacturing facilities and a customer-first approach, we have established ourselves as a trusted partner for industrial piping and cable management solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="products-section" style="background: #f5f5f5;">
        <div class="container" style="text-align: center;">
            <h2 style="margin-bottom: 20px;">Ready to Work With Us?</h2>
            <p style="margin-bottom: 30px; color: #666;">Get in touch with our team to discuss your requirements</p>
            <a href="{{ route('rh.contact') }}" class="btn btn-primary" style="margin-right: 15px;">Contact Us</a>
            <a href="{{ route('rh.products.index') }}" class="btn">View Products</a>
        </div>
    </section>
@endsection

