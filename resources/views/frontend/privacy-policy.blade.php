@extends('layouts.frontend')

@section('content')
<!-- Privacy Policy Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="text-center">
            <h1>Privacy Policy</h1>
            <p>Your privacy is important to us. Learn how we protect your personal information.</p>
        </div>
    </div>
</section>

<!-- Privacy Policy Content -->
<section class="subpage-content">
    <div class="container">
        <div class="terms-content">
            <div class="terms-intro">
                <p>
                    At Good Vacation, we are committed to protecting your privacy and ensuring the security of your personal information. 
                    This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website 
                    or use our services.
                </p>
                <p><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>
            </div>

            <div class="terms-section">
                <h3>1. Information We Collect</h3>
                <h4>1.1 Personal Information</h4>
                <p>We collect personal information that you voluntarily provide to us when you:</p>
                <ul>
                    <li>Register on our website</li>
                    <li>Make a booking or reservation</li>
                    <li>Subscribe to our newsletter</li>
                    <li>Contact us for customer support</li>
                    <li>Participate in surveys or promotions</li>
                </ul>
                <p>This information may include:</p>
                <ul>
                    <li>Full name</li>
                    <li>Email address</li>
                    <li>Phone number</li>
                    <li>Mailing address</li>
                    <li>Date of birth</li>
                    <li>Passport information (for international bookings)</li>
                    <li>Payment information (processed securely through third-party payment processors)</li>
                    <li>Travel preferences and special requirements</li>
                </ul>

                <h4>1.2 Automatically Collected Information</h4>
                <p>When you visit our website, we automatically collect certain information about your device and browsing behavior:</p>
                <ul>
                    <li>IP address</li>
                    <li>Browser type and version</li>
                    <li>Operating system</li>
                    <li>Pages visited and time spent on pages</li>
                    <li>Referring website addresses</li>
                    <li>Device information</li>
                    <li>Cookies and similar tracking technologies</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>2. How We Use Your Information</h3>
                <p>We use the information we collect for various purposes, including:</p>
                <ul>
                    <li><strong>Service Delivery:</strong> Processing bookings, reservations, and payments</li>
                    <li><strong>Communication:</strong> Sending booking confirmations, updates, and travel documents</li>
                    <li><strong>Customer Support:</strong> Responding to inquiries and resolving issues</li>
                    <li><strong>Marketing:</strong> Sending promotional offers, newsletters, and travel deals (with your consent)</li>
                    <li><strong>Personalization:</strong> Customizing your experience and providing relevant recommendations</li>
                    <li><strong>Analytics:</strong> Understanding how our website is used to improve our services</li>
                    <li><strong>Security:</strong> Detecting and preventing fraud, abuse, and security threats</li>
                    <li><strong>Legal Compliance:</strong> Meeting legal obligations and enforcing our terms</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>3. How We Share Your Information</h3>
                <p>We may share your information with third parties in the following circumstances:</p>
                
                <h4>3.1 Service Providers</h4>
                <p>
                    We share your information with trusted third-party service providers who assist us in operating our business, 
                    including airlines, hotels, tour operators, payment processors, and IT service providers. These parties are 
                    contractually obligated to protect your information and use it only for the purposes we specify.
                </p>

                <h4>3.2 Business Partners</h4>
                <p>
                    We may share your information with travel partners, including airlines, hotels, car rental companies, and 
                    insurance providers, to fulfill your bookings and provide you with travel services.
                </p>

                <h4>3.3 Legal Requirements</h4>
                <p>We may disclose your information if required to do so by law or in response to:</p>
                <ul>
                    <li>Valid legal processes (court orders, subpoenas, warrants)</li>
                    <li>Government or regulatory requests</li>
                    <li>Protection of our rights, property, or safety</li>
                    <li>Investigation of fraud or security issues</li>
                </ul>

                <h4>3.4 Business Transfers</h4>
                <p>
                    In the event of a merger, acquisition, or sale of assets, your information may be transferred to the 
                    acquiring entity. We will notify you of any such change in ownership.
                </p>
            </div>

            <div class="terms-section">
                <h3>4. Cookies and Tracking Technologies</h3>
                <p>
                    We use cookies and similar tracking technologies to enhance your experience on our website. Cookies are 
                    small text files stored on your device that help us:
                </p>
                <ul>
                    <li>Remember your preferences and settings</li>
                    <li>Understand how you use our website</li>
                    <li>Provide personalized content and recommendations</li>
                    <li>Analyze website performance and traffic</li>
                    <li>Deliver targeted advertising</li>
                </ul>
                <p>
                    You can control cookies through your browser settings. However, disabling cookies may affect the 
                    functionality of our website.
                </p>
            </div>

            <div class="terms-section">
                <h3>5. Data Security</h3>
                <p>
                    We implement appropriate technical and organizational security measures to protect your personal information 
                    from unauthorized access, disclosure, alteration, or destruction. These measures include:
                </p>
                <ul>
                    <li>SSL/TLS encryption for data transmission</li>
                    <li>Secure payment processing through PCI-DSS compliant providers</li>
                    <li>Regular security audits and vulnerability assessments</li>
                    <li>Access controls and authentication mechanisms</li>
                    <li>Employee training on data protection</li>
                    <li>Regular backups and disaster recovery procedures</li>
                </ul>
                <p>
                    While we strive to protect your information, no method of transmission over the internet or electronic 
                    storage is 100% secure. We cannot guarantee absolute security.
                </p>
            </div>

            <div class="terms-section">
                <h3>6. Your Rights and Choices</h3>
                <p>You have the following rights regarding your personal information:</p>
                
                <h4>6.1 Access and Correction</h4>
                <p>You have the right to access, review, and correct your personal information. You can update your account details by logging into your account or contacting us.</p>

                <h4>6.2 Data Portability</h4>
                <p>You have the right to request a copy of your personal information in a structured, machine-readable format.</p>

                <h4>6.3 Deletion</h4>
                <p>You have the right to request deletion of your personal information, subject to certain legal exceptions (e.g., records we must retain for legal or accounting purposes).</p>

                <h4>6.4 Marketing Communications</h4>
                <p>You can opt out of receiving marketing communications at any time by:</p>
                <ul>
                    <li>Clicking the "unsubscribe" link in our emails</li>
                    <li>Updating your communication preferences in your account settings</li>
                    <li>Contacting us directly</li>
                </ul>

                <h4>6.5 Do Not Track</h4>
                <p>Some browsers offer a "Do Not Track" feature. We currently do not respond to Do Not Track signals.</p>
            </div>

            <div class="terms-section">
                <h3>7. Data Retention</h3>
                <p>
                    We retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy, 
                    unless a longer retention period is required or permitted by law. Factors affecting retention periods include:
                </p>
                <ul>
                    <li>The nature of the information</li>
                    <li>Legal and regulatory requirements</li>
                    <li>Business and operational needs</li>
                    <li>Fraud prevention and security</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>8. Children's Privacy</h3>
                <p>
                    Our services are not directed to children under the age of 18. We do not knowingly collect personal information 
                    from children. If we become aware that we have collected information from a child without parental consent, we 
                    will take steps to delete that information.
                </p>
            </div>

            <div class="terms-section">
                <h3>9. International Data Transfers</h3>
                <p>
                    Your information may be transferred to and processed in countries other than your country of residence. These 
                    countries may have different data protection laws. When we transfer your information internationally, we take 
                    appropriate safeguards to ensure your information remains protected.
                </p>
            </div>

            <div class="terms-section">
                <h3>10. Third-Party Links</h3>
                <p>
                    Our website may contain links to third-party websites. We are not responsible for the privacy practices of these 
                    external sites. We encourage you to review their privacy policies before providing any personal information.
                </p>
            </div>

            <div class="terms-section">
                <h3>11. Changes to This Privacy Policy</h3>
                <p>
                    We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. 
                    We will notify you of any material changes by posting the updated policy on our website and updating the "Last 
                    Updated" date. Your continued use of our services after changes are posted constitutes acceptance of the updated policy.
                </p>
            </div>

            <div class="terms-section">
                <h3>12. Contact Us</h3>
                <p>
                    If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:
                </p>
                <div class="contact-info">
                    <p>
                        <strong>Good Vacation - Privacy Team</strong><br>
                        South Janatha Rd, Palarivattom<br>
                        Kochi, Kerala 682025<br>
                        India
                    </p>
                    <p>
                        <strong>Email:</strong> <a href="mailto:privacy@goodvacation.com">privacy@goodvacation.com</a><br>
                        <strong>Phone:</strong> +91 484 1234567<br>
                        <strong>Website:</strong> <a href="{{ route('home') }}">www.goodvacation.com</a>
                    </p>
                </div>
            </div>

            <div class="terms-footer">
                <p>
                    By using Good Vacation's services, you acknowledge that you have read and understood this Privacy Policy and 
                    agree to the collection, use, and disclosure of your information as described herein.
                </p>
                <p style="margin-top: 30px;">
                    <a href="{{ route('contact') }}" class="btn">Contact Us</a>
                    <a href="{{ route('terms-of-service') }}" class="btn" style="margin-left: 15px;">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Footer Caption -->
<section class="footer-caption light-bg">
    <div class="container">
        <div class="footer-caption-wrap">
            <h4>Your Privacy Matters to Us</h4>
            <p>We are committed to protecting your personal information and being transparent about our practices.</p>
            <a href="{{ route('packages') }}" class="btn">Explore Our Packages</a>
        </div>
    </div>
</section>
<!-- /.Footer Caption -->
@endsection

