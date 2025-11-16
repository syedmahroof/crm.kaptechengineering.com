@extends('layouts.frontend')

@section('content')
<!-- Support Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="text-center">
            <h1>Support</h1>
            <p>Get help with your travel needs</p>
        </div>
    </div>
</section>

<!-- Contact Options Section -->
<section class="subpage-content">
    <div class="container">
        <div class="row">
            <!-- Phone Support -->
            <div class="col-md-6">
                <div class="card" style="text-align: center; padding: 40px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">📞</div>
                    <h4>Call Us</h4>
                    <p style="font-size: 24px; font-weight: 600; color: #3498db; margin: 20px 0;">+91 484 1234567</p>
                    <p style="color: #666;">24/7 Support Available</p>
                </div>
            </div>

            <!-- Email Support -->
            <div class="col-md-6">
                <div class="card" style="text-align: center; padding: 40px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">✉️</div>
                    <h4>Email Us</h4>
                    <p style="font-size: 18px; font-weight: 600; color: #3498db; margin: 20px 0;">
                        <a href="mailto:support@goodvacation.com">support@goodvacation.com</a>
                    </p>
                    <p style="color: #666;">Response within 2-4 hours</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="subpage-content light-bg">
    <div class="container">
        <div class="text-center" style="margin-bottom: 50px;">
            <h3>Common Questions</h3>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div style="margin-bottom: 30px;">
                        <h5 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">How do I make a booking?</h5>
                        <p>Call us at +91 484 1234567 or email support@goodvacation.com. Our team will help you choose the perfect package.</p>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h5 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">What is your cancellation policy?</h5>
                        <p>Cancellation charges vary based on timing. Generally, cancellations more than 45 days before departure incur a 25% charge.</p>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h5 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">Do you help with visa applications?</h5>
                        <p>Yes, we provide visa assistance for most destinations. Our team will guide you through the requirements and documentation process.</p>
                    </div>

                    <div style="margin-bottom: 0;">
                        <h5 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">What if I have an emergency during my trip?</h5>
                        <p>Our 24/7 emergency helpline (+91 484 1234567) is always available for medical emergencies, lost documents, and urgent matters.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Office Locations -->
<section class="subpage-content">
    <div class="container">
        <div class="text-center" style="margin-bottom: 50px;">
            <h3>Our Offices</h3>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <h4>Kochi - Head Office</h4>
                    <p><strong>Phone:</strong> +91 484 1234567</p>
                    <p><strong>Email:</strong> <a href="mailto:kochi@goodvacation.com">kochi@goodvacation.com</a></p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <h4>Mumbai Office</h4>
                    <p><strong>Phone:</strong> +91 22 1234567</p>
                    <p><strong>Email:</strong> <a href="mailto:mumbai@goodvacation.com">mumbai@goodvacation.com</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Emergency Support -->
<section class="subpage-content light-bg">
    <div class="container">
        <div class="card" style="background: #e74c3c; color: white; padding: 40px; text-align: center;">
            <h3 style="color: white; margin-bottom: 20px;">Emergency Support</h3>
            <p style="font-size: 18px; margin-bottom: 20px;">24/7 Emergency Helpline</p>
            <p style="font-size: 28px; font-weight: 700;">+91 484 1234567</p>
        </div>
    </div>
</section>
@endsection

