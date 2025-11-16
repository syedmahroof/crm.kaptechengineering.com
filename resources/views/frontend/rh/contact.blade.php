@extends('layouts.rh')

@section('content')
    <section class="hero">
        <div class="container">
            <h1>Get in Touch with Our Expert Team</h1>
            <p>Request Quotes | Technical Support | Custom Solutions | Pan-India Delivery Available</p>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="contact-container">
                <div class="contact-form">
                    <h2>Send us a Message</h2>
                    <form id="contact-form" method="POST" action="#">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="text" id="company" name="company">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="product-inquiry">Product Inquiry</option>
                                <option value="quote-request">Quote Request</option>
                                <option value="technical-support">Technical Support</option>
                                <option value="partnership">Partnership Opportunity</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>

                <div class="contact-info">
                    <h2>Contact Information</h2>
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div>
                            <h4>Our Address</h4>
                            <p>No. 7/6, Silver Streak, Venkatappa Road, Tasker Town,<br> Bangalore North, Bangalore, Karnataka - 560051</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📧</div>
                        <div>
                            <h4>Email Us</h4>
                            <p>info@kaptechsolutions.com<br>sales@kaptechsolutions.com</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div>
                            <h4>Call Us</h4>
                            <p>+91-9744629000<br>+91-XXXXXXXXXX</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">🕒</div>
                        <div>
                            <h4>Business Hours</h4>
                            <p>Monday - Saturday<br>9:00 AM - 6:00 PM<br>Sunday: Closed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="products-section" style="background: #f5f5f5; padding: 60px 0;">
        <div class="container">
            <div class="section-title">
                <h2>Visit Our Location</h2>
            </div>
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div style="width: 100%; height: 400px; background: #e0e0e0; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                    <p style="color: #666;">Google Maps will be integrated here</p>
                </div>
            </div>
        </div>
    </section>

    <section class="products-section">
        <div class="container">
            <div class="features-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                <div class="feature-card">
                    <div class="feature-icon">💬</div>
                    <h3>Chat with Us</h3>
                    <p>Live chat support available during business hours</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>WhatsApp</h3>
                    <p>Quick responses via WhatsApp messaging</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h3>Request Catalog</h3>
                    <p>Download our complete product catalog</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Get a Quote</h3>
                    <p>Fast and competitive pricing for your needs</p>
                </div>
            </div>
        </div>
    </section>
@endsection

