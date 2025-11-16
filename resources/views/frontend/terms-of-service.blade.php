@extends('layouts.frontend')

@section('content')
<!-- Terms of Service Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="text-center">
            <h1>Terms of Service</h1>
            <p>Please read these terms carefully before using our services</p>
        </div>
    </div>
</section>

<!-- Terms of Service Content -->
<section class="subpage-content">
    <div class="container">
        <div class="terms-content">
            <div class="terms-intro">
                <p>
                    Welcome to Good Vacation. These Terms of Service ("Terms") govern your use of our website and booking services. 
                    By accessing or using our services, you agree to be bound by these Terms. If you do not agree with any part of 
                    these Terms, please do not use our services.
                </p>
                <p><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>
            </div>

            <div class="terms-section">
                <h3>1. Service Description</h3>
                <p>
                    Good Vacation provides travel booking and planning services for domestic and international destinations. 
                    Our services include but are not limited to:
                </p>
                <ul>
                    <li>Flight ticket bookings</li>
                    <li>Hotel and accommodation reservations</li>
                    <li>Tour package arrangements</li>
                    <li>Travel insurance coordination</li>
                    <li>Visa assistance</li>
                    <li>Transportation services</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>2. Booking and Payment Terms</h3>
                <h4>2.1 Booking Confirmation</h4>
                <p>
                    All bookings are subject to availability and confirmation. A booking is only confirmed when you receive a 
                    written confirmation from Good Vacation via email or SMS. We reserve the right to decline any booking at our discretion.
                </p>
                
                <h4>2.2 Payment</h4>
                <p>
                    Payment terms vary depending on the service booked. Generally:
                </p>
                <ul>
                    <li>A non-refundable deposit is required at the time of booking</li>
                    <li>Full payment must be received at least 30 days before the travel date</li>
                    <li>Late bookings (within 30 days of travel) require full payment at the time of booking</li>
                    <li>All prices are quoted in Indian Rupees (INR) unless otherwise stated</li>
                </ul>

                <h4>2.3 Price Changes</h4>
                <p>
                    While we strive to maintain accurate pricing, prices may change due to factors beyond our control, including but 
                    not limited to currency fluctuations, fuel surcharges, taxes, and supplier price increases. We reserve the right 
                    to adjust prices before final payment is received.
                </p>
            </div>

            <div class="terms-section">
                <h3>3. Cancellation and Refund Policy</h3>
                <h4>3.1 Cancellation by Customer</h4>
                <p>
                    Cancellation charges apply as follows:
                </p>
                <ul>
                    <li>More than 45 days before departure: 25% of total booking value</li>
                    <li>30-45 days before departure: 50% of total booking value</li>
                    <li>15-29 days before departure: 75% of total booking value</li>
                    <li>Less than 15 days before departure: 100% of total booking value (no refund)</li>
                </ul>
                <p>
                    Please note that certain bookings, including promotional packages and special offers, may be non-refundable 
                    and non-transferable.
                </p>

                <h4>3.2 Cancellation by Good Vacation</h4>
                <p>
                    In the unlikely event that we need to cancel your booking due to circumstances beyond our control (force majeure, 
                    natural disasters, political unrest, etc.), we will offer you:
                </p>
                <ul>
                    <li>A full refund of all payments made, or</li>
                    <li>An alternative travel arrangement of equal or greater value, or</li>
                    <li>A credit voucher valid for 12 months</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>4. Travel Documents and Requirements</h3>
                <h4>4.1 Passport and Visa</h4>
                <p>
                    It is your responsibility to ensure that you have valid travel documents, including:
                </p>
                <ul>
                    <li>A valid passport with at least 6 months validity from the date of return</li>
                    <li>Appropriate visas for all destinations</li>
                    <li>Any required vaccination certificates</li>
                    <li>Travel insurance (highly recommended)</li>
                </ul>
                <p>
                    While we may provide visa assistance, it is ultimately your responsibility to obtain the necessary documentation. 
                    We are not liable for any denied boarding or entry due to inadequate documentation.
                </p>

                <h4>4.2 Health Requirements</h4>
                <p>
                    You are responsible for ensuring you are medically fit to travel and have obtained all required vaccinations. 
                    Please consult with your doctor and check government travel advisories before booking.
                </p>
            </div>

            <div class="terms-section">
                <h3>5. Liability and Insurance</h3>
                <h4>5.1 Limitation of Liability</h4>
                <p>
                    Good Vacation acts as an intermediary between you and travel service providers (airlines, hotels, transport 
                    companies, etc.). We are not liable for:
                </p>
                <ul>
                    <li>Acts or omissions of third-party service providers</li>
                    <li>Delays, cancellations, or changes to travel arrangements</li>
                    <li>Loss, damage, or theft of personal belongings</li>
                    <li>Personal injury or death</li>
                    <li>Force majeure events</li>
                </ul>

                <h4>5.2 Travel Insurance</h4>
                <p>
                    We strongly recommend purchasing comprehensive travel insurance that covers medical expenses, trip cancellations, 
                    lost luggage, and other potential issues. Good Vacation can assist with travel insurance arrangements but is not 
                    responsible for any claims or coverage issues.
                </p>
            </div>

            <div class="terms-section">
                <h3>6. Customer Responsibilities</h3>
                <p>As a customer, you agree to:</p>
                <ul>
                    <li>Provide accurate and complete information during booking</li>
                    <li>Comply with all laws and regulations of the countries you visit</li>
                    <li>Follow the instructions and guidelines provided by tour guides and service providers</li>
                    <li>Respect local customs, cultures, and environments</li>
                    <li>Arrive at meeting points and check-ins with adequate time</li>
                    <li>Inform us of any special requirements, medical conditions, or dietary restrictions</li>
                    <li>Behave respectfully toward other travelers and service providers</li>
                </ul>
                <p>
                    We reserve the right to refuse service or terminate your travel arrangements if you engage in behavior that is 
                    disruptive, dangerous, or illegal.
                </p>
            </div>

            <div class="terms-section">
                <h3>7. Changes and Modifications</h3>
                <p>
                    If you wish to make changes to your booking, please contact us as soon as possible. Changes are subject to:
                </p>
                <ul>
                    <li>Availability of alternative arrangements</li>
                    <li>Approval from service providers</li>
                    <li>Payment of any applicable change fees and fare differences</li>
                </ul>
                <p>
                    We cannot guarantee that changes will be possible, and some bookings may be non-changeable.
                </p>
            </div>

            <div class="terms-section">
                <h3>8. Complaints and Disputes</h3>
                <p>
                    If you have any complaints about our services, please notify us immediately during your trip so we can attempt 
                    to resolve the issue. For post-travel complaints, please contact us in writing within 30 days of your return.
                </p>
                <p>
                    We will investigate all complaints and respond within 14 business days. If we cannot resolve the matter to your 
                    satisfaction, you may pursue other remedies under Indian law.
                </p>
            </div>

            <div class="terms-section">
                <h3>9. Intellectual Property</h3>
                <p>
                    All content on the Good Vacation website, including text, images, logos, graphics, and software, is the property 
                    of Good Vacation or its licensors and is protected by copyright and other intellectual property laws. You may not 
                    reproduce, distribute, or create derivative works without our express written permission.
                </p>
            </div>

            <div class="terms-section">
                <h3>10. Privacy and Data Protection</h3>
                <p>
                    We are committed to protecting your personal information. Please review our 
                    <a href="{{ route('privacy-policy') }}">Privacy Policy</a> to understand how we collect, use, and protect your data.
                </p>
            </div>

            <div class="terms-section">
                <h3>11. Force Majeure</h3>
                <p>
                    Good Vacation shall not be liable for any failure or delay in performing our obligations due to circumstances 
                    beyond our reasonable control, including but not limited to:
                </p>
                <ul>
                    <li>Natural disasters (earthquakes, floods, hurricanes, etc.)</li>
                    <li>War, terrorism, or civil unrest</li>
                    <li>Pandemics or health emergencies</li>
                    <li>Government actions or travel restrictions</li>
                    <li>Strikes or labor disputes</li>
                    <li>Technical failures or cyber-attacks</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>12. Governing Law</h3>
                <p>
                    These Terms of Service are governed by the laws of India. Any disputes arising from these Terms or your use of 
                    our services shall be subject to the exclusive jurisdiction of the courts in Kochi, Kerala, India.
                </p>
            </div>

            <div class="terms-section">
                <h3>13. Changes to Terms</h3>
                <p>
                    We reserve the right to update or modify these Terms at any time without prior notice. Changes will be effective 
                    immediately upon posting to our website. Your continued use of our services after any changes constitutes acceptance 
                    of the new Terms.
                </p>
            </div>

            <div class="terms-section">
                <h3>14. Contact Information</h3>
                <p>
                    If you have any questions about these Terms of Service, please contact us:
                </p>
                <div class="contact-info">
                    <p>
                        <strong>Good Vacation</strong><br>
                        South Janatha Rd, Palarivattom<br>
                        Kochi, Kerala 682025<br>
                        India
                    </p>
                    <p>
                        <strong>Email:</strong> <a href="mailto:info@goodvacation.com">info@goodvacation.com</a><br>
                        <strong>Phone:</strong> +91 484 1234567<br>
                        <strong>Website:</strong> <a href="{{ route('home') }}">www.goodvacation.com</a>
                    </p>
                </div>
            </div>

            <div class="terms-footer">
                <p>
                    By using Good Vacation's services, you acknowledge that you have read, understood, and agree to be bound by 
                    these Terms of Service.
                </p>
                <p style="margin-top: 30px;">
                    <a href="{{ route('contact') }}" class="btn">Contact Us</a>
                    <a href="{{ route('privacy-policy') }}" class="btn" style="margin-left: 15px;">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Footer Caption -->
<section class="footer-caption light-bg">
    <div class="container">
        <div class="footer-caption-wrap">
            <h4>Ready to Start Your Journey?</h4>
            <p>Let us help you plan your next adventure with confidence and peace of mind.</p>
            <a href="{{ route('packages') }}" class="btn">View Our Packages</a>
        </div>
    </div>
</section>
<!-- /.Footer Caption -->
@endsection

