@extends('layouts.frontend')

@section('content')
<!-- Contact Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="text-center">
            <h1>Contact Us</h1>
            <p>Get in touch with us for your next amazing vacation. We're here to help 24/7!</p>
        </div>
    </div>
</section>



<!-- Contact Form Section -->
<section class="contact-form-section subpage-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <h2>Send us a Message</h2>
                    <p class="para-lg">Fill out the form below and we'll get back to you within 2 hours with a personalized travel plan.
                    </p>

                    <form class="contact-form" action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject">Subject *</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="subject">Subject *</label>
                                    <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card contact-right">
                    <h4>Get in Touch</h4>
                    <p>We're here to help you plan the perfect vacation. Reach out to us anytime!</p>
                    
                    <div class="contact-box">
                        <div class="contact-box-head">
                            <!-- <div class="icon">
                                <i class="fas fa-map-marker-alt" style="color: white; font-size: 1.2rem;"></i>
                            </div> -->
                            <h5>Address</h5>
                        </div>
                        <p>
                            Good Vacation<br>
                            South Janatha Rd, Palarivattom<br>
                            Kochi, Kerala 682025<br>
                            India
                        </p>
                    </div>

                    <div class="contact-box">
                        <div class="contact-box-head">
                            <!-- <div class="icon">
                                <i class="fas fa-phone" style="color: #3A3838; font-size: 1.2rem;"></i>
                            </div> -->
                            <h5>Phone</h5>
                        </div>
                        <p>
                            <a href="tel:+917592010044" style="color: #67469C; text-decoration: none; font-weight: 500;">+91 7592010044</a><br>
                            <span style="font-size: 14px; color: #666;">Mon-Fri: 9AM-6PM | Sat: 9AM-4PM</span>
                        </p>
                    </div>

                    <div class="contact-box">
                        <div class="contact-box-head">
                            <!-- <div class="icon">
                                <i class="fas fa-envelope" style="color: white; font-size: 1.2rem;"></i>
                            </div> -->
                            <h5>Email</h5>
                        </div>
                        <p>
                            <a href="mailto:info@goodvacation.com" style="color: #67469C; text-decoration: none; font-weight: 500;">info@goodvacation.com</a><br>
                            <span style="font-size: 14px; color: #666;">We respond within 2 hours</span>
                        </p>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</section>

<!-- Footer Caption -->

<div class="map-section">
    <div class="loc-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3909.934715378653!2d76.74161822542088!3d11.484634754613202!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba8bf00783a4b0d%3A0xa6cd115a19ec846b!2sOoty%20Hidden%20Trekking%20Spot!5e0!3m2!1sen!2sin!4v1760128484936!5m2!1sen!2sin" width="600" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>


<!-- /.Footer Caption -->

<!-- Footer Caption -->
@include('frontend.partials.footer-caption')


@endsection