@extends('layouts.frontend')

@section('content')
<!-- Careers Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="text-center">
            <h1>Join Our Team</h1>
            <p>Build your career with India's leading travel company</p>
        </div>
    </div>
</section>

<!-- Why Work With Us Section -->
<section class="subpage-content">
    <div class="container">
        <div class="text-center" style="max-width: 800px; margin: 0 auto 50px;">
            <h3>Why Work at Good Vacation?</h3>
            <p class="para-lg">
                At Good Vacation, we believe our employees are our greatest asset. We foster a culture of innovation, 
                collaboration, and growth, where every team member can thrive and make a meaningful impact.
            </p>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="text-align: center; padding: 30px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">🌍</div>
                    <h4>Travel Opportunities</h4>
                    <p>
                        Experience the destinations you help others discover. We offer travel perks, familiarization trips, 
                        and opportunities to explore the world.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="text-align: center; padding: 30px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">📈</div>
                    <h4>Career Growth</h4>
                    <p>
                        We invest in your development with training programs, mentorship opportunities, and clear 
                        career progression paths.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="text-align: center; padding: 30px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">🤝</div>
                    <h4>Great Culture</h4>
                    <p>
                        Join a diverse, inclusive team that values collaboration, creativity, and work-life balance 
                        in a supportive environment.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="subpage-content light-bg">
    <div class="container">
        <div class="text-center" style="margin-bottom: 50px;">
            <h3>Employee Benefits</h3>
            <p class="para-lg">We offer competitive benefits and perks to support your well-being and success</p>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <h4>💰 Competitive Compensation</h4>
                    <ul>
                        <li>Competitive salary packages</li>
                        <li>Performance-based bonuses</li>
                        <li>Annual increments and rewards</li>
                        <li>Referral bonuses</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h4>🏥 Health & Wellness</h4>
                    <ul>
                        <li>Comprehensive health insurance</li>
                        <li>Life and accident insurance</li>
                        <li>Annual health check-ups</li>
                        <li>Mental health support programs</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h4>⏰ Work-Life Balance</h4>
                    <ul>
                        <li>Flexible working hours</li>
                        <li>Paid time off and holidays</li>
                        <li>Maternity and paternity leave</li>
                        <li>Work from home options</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h4>🎓 Learning & Development</h4>
                    <ul>
                        <li>Professional training programs</li>
                        <li>Industry certifications support</li>
                        <li>Conference and seminar attendance</li>
                        <li>Continuous learning opportunities</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Open Positions Section -->
<section class="subpage-content">
    <div class="container">
        <div class="text-center" style="margin-bottom: 50px;">
            <h3>Current Openings</h3>
            <p class="para-lg">Explore exciting career opportunities across various departments</p>
        </div>

        <!-- Job Listing -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 style="margin-bottom: 10px;">Travel Consultant</h4>
                    <p style="margin-bottom: 10px;">
                        <strong>Department:</strong> Sales & Customer Service | 
                        <strong>Location:</strong> Kochi, Kerala | 
                        <strong>Type:</strong> Full-time
                    </p>
                    <p>
                        We're looking for passionate travel consultants to help clients plan their dream vacations. 
                        Ideal candidates have excellent communication skills, sales experience, and a love for travel.
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('contact') }}" class="btn">Apply Now</a>
                </div>
            </div>
        </div>

        <!-- Job Listing -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 style="margin-bottom: 10px;">Digital Marketing Manager</h4>
                    <p style="margin-bottom: 10px;">
                        <strong>Department:</strong> Marketing | 
                        <strong>Location:</strong> Kochi, Kerala | 
                        <strong>Type:</strong> Full-time
                    </p>
                    <p>
                        Lead our digital marketing initiatives including SEO, social media, content marketing, and 
                        paid advertising. 3+ years of experience in digital marketing required.
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('contact') }}" class="btn">Apply Now</a>
                </div>
            </div>
        </div>

        <!-- Job Listing -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 style="margin-bottom: 10px;">Tour Operations Manager</h4>
                    <p style="margin-bottom: 10px;">
                        <strong>Department:</strong> Operations | 
                        <strong>Location:</strong> Kochi, Kerala | 
                        <strong>Type:</strong> Full-time
                    </p>
                    <p>
                        Manage end-to-end tour operations, coordinate with vendors, and ensure seamless travel 
                        experiences. 5+ years of experience in tour operations preferred.
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('contact') }}" class="btn">Apply Now</a>
                </div>
            </div>
        </div>

        <!-- Job Listing -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 style="margin-bottom: 10px;">Full Stack Developer</h4>
                    <p style="margin-bottom: 10px;">
                        <strong>Department:</strong> Technology | 
                        <strong>Location:</strong> Kochi, Kerala | 
                        <strong>Type:</strong> Full-time
                    </p>
                    <p>
                        Build and maintain our booking platform and internal systems. Experience with Laravel, React, 
                        and modern web technologies required.
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('contact') }}" class="btn">Apply Now</a>
                </div>
            </div>
        </div>

        <!-- Job Listing -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 style="margin-bottom: 10px;">Customer Service Representative</h4>
                    <p style="margin-bottom: 10px;">
                        <strong>Department:</strong> Customer Service | 
                        <strong>Location:</strong> Kochi, Kerala | 
                        <strong>Type:</strong> Full-time
                    </p>
                    <p>
                        Provide exceptional customer support via phone, email, and chat. Help travelers with 
                        inquiries, bookings, and issue resolution. Freshers welcome.
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('contact') }}" class="btn">Apply Now</a>
                </div>
            </div>
        </div>

        <!-- Job Listing -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 style="margin-bottom: 10px;">Content Writer</h4>
                    <p style="margin-bottom: 10px;">
                        <strong>Department:</strong> Marketing | 
                        <strong>Location:</strong> Kochi, Kerala | 
                        <strong>Type:</strong> Full-time
                    </p>
                    <p>
                        Create engaging travel content for our website, blog, and social media. Passion for travel 
                        writing and storytelling essential. 2+ years of experience preferred.
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('contact') }}" class="btn">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hiring Process Section -->
<section class="subpage-content light-bg">
    <div class="container">
        <div class="text-center" style="margin-bottom: 50px;">
            <h3>Our Hiring Process</h3>
            <p class="para-lg">What to expect when you apply</p>
        </div>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="text-align: center; padding: 25px;">
                    <div style="font-size: 36px; color: #3498db; margin-bottom: 15px;">1</div>
                    <h4>Apply Online</h4>
                    <p>Submit your application through our website or email your resume to careers@goodvacation.com</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="text-align: center; padding: 25px;">
                    <div style="font-size: 36px; color: #3498db; margin-bottom: 15px;">2</div>
                    <h4>Initial Screening</h4>
                    <p>Our HR team will review your application and contact shortlisted candidates within 1-2 weeks</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="text-align: center; padding: 25px;">
                    <div style="font-size: 36px; color: #3498db; margin-bottom: 15px;">3</div>
                    <h4>Interviews</h4>
                    <p>Participate in 2-3 rounds of interviews with team members and department heads</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="text-align: center; padding: 25px;">
                    <div style="font-size: 36px; color: #3498db; margin-bottom: 15px;">4</div>
                    <h4>Offer & Onboarding</h4>
                    <p>Receive your offer and join our comprehensive onboarding program</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Don't See a Fit Section -->
<section class="subpage-content">
    <div class="container">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 50px; text-align: center;">
            <h3 style="color: white; margin-bottom: 20px;">Don't See the Right Position?</h3>
            <p style="font-size: 18px; margin-bottom: 30px;">
                We're always looking for talented individuals to join our team. Send us your resume and we'll 
                keep you in mind for future opportunities that match your skills and interests.
            </p>
            <a href="{{ route('contact') }}" class="btn" style="background: white; color: #667eea;">Send Your Resume</a>
        </div>
    </div>
</section>

<!-- Footer Caption -->
<section class="footer-caption light-bg">
    <div class="container">
        <div class="footer-caption-wrap">
            <h4>Ready to Join Our Team?</h4>
            <p>Take the first step towards an exciting career in the travel industry.</p>
            <a href="{{ route('contact') }}" class="btn">Apply Now</a>
        </div>
    </div>
</section>
<!-- /.Footer Caption -->
@endsection

