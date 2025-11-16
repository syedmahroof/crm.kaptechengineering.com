@extends('layouts.frontend')

@section('content')
<!-- Management Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="text-center">
            <h1>Our Leadership Team</h1>
            <p>Meet the visionaries driving Good Vacation forward</p>
        </div>
    </div>
</section>

<!-- Leadership Introduction -->
<section class="subpage-content">
    <div class="container">
        <div class="text-center" style="max-width: 800px; margin: 0 auto 50px;">
            <h3>Leading with Vision and Passion</h3>
            <p class="para-lg">
                Our leadership team brings together decades of experience in travel, hospitality, and business management. 
                They are committed to making Good Vacation the most trusted travel partner in India and beyond.
            </p>
        </div>
    </div>
</section>

<!-- Executive Team -->
<section class="subpage-content light-bg">
    <div class="container">
        <div class="text-center" style="margin-bottom: 50px;">
            <h3>Executive Leadership</h3>
        </div>

        <!-- CEO -->
        <div class="row align-items-center" style="margin-bottom: 60px;">
            <div class="col-md-4">
                <div class="img" style="border-radius: 8px; overflow: hidden;">
                    <img src="{{ asset('assets/images/team/ceo.jpg') }}" alt="Rajesh Kumar" style="width: 100%; height: auto; object-fit: cover;">
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <h4>Rajesh Kumar</h4>
                    <p style="color: #3498db; font-weight: 600; margin-bottom: 15px;">Chief Executive Officer & Founder</p>
                    <p>
                        Rajesh founded Good Vacation in 2010 with a vision to revolutionize the travel industry in India. 
                        With over 20 years of experience in the travel and hospitality sector, he has been instrumental in 
                        building strategic partnerships with leading airlines, hotels, and tour operators worldwide.
                    </p>
                    <p>
                        Under his leadership, Good Vacation has grown from a small startup to one of India's most respected 
                        travel companies, serving over 50,000 happy travelers. Rajesh holds an MBA from IIM Bangalore and is 
                        passionate about sustainable tourism and customer-centric innovation.
                    </p>
                    <p style="margin-top: 15px;">
                        <strong>Education:</strong> MBA, IIM Bangalore | B.Tech, NIT Calicut<br>
                        <strong>Email:</strong> <a href="mailto:rajesh@goodvacation.com">rajesh@goodvacation.com</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- COO -->
        <div class="row align-items-center" style="margin-bottom: 60px;">
            <div class="col-md-8 order-md-1 order-2">
                <div class="card">
                    <h4>Priya Sharma</h4>
                    <p style="color: #3498db; font-weight: 600; margin-bottom: 15px;">Chief Operating Officer</p>
                    <p>
                        Priya oversees all operational aspects of Good Vacation, ensuring seamless execution of travel packages 
                        and exceptional customer experiences. With 15 years of experience in operations management, she has 
                        optimized our processes to deliver consistent quality and efficiency.
                    </p>
                    <p>
                        Her expertise in supply chain management and vendor relations has been crucial in building our extensive 
                        network of trusted partners across the globe. Priya is committed to operational excellence and continuous 
                        improvement in all aspects of service delivery.
                    </p>
                    <p style="margin-top: 15px;">
                        <strong>Education:</strong> MBA in Operations, XLRI Jamshedpur | B.E., Anna University<br>
                        <strong>Email:</strong> <a href="mailto:priya@goodvacation.com">priya@goodvacation.com</a>
                    </p>
                </div>
            </div>
            <div class="col-md-4 order-md-2 order-1">
                <div class="img" style="border-radius: 8px; overflow: hidden;">
                    <img src="{{ asset('assets/images/team/coo.jpg') }}" alt="Priya Sharma" style="width: 100%; height: auto; object-fit: cover;">
                </div>
            </div>
        </div>

        <!-- CFO -->
        <div class="row align-items-center" style="margin-bottom: 60px;">
            <div class="col-md-4">
                <div class="img" style="border-radius: 8px; overflow: hidden;">
                    <img src="{{ asset('assets/images/team/cfo.jpg') }}" alt="Arun Menon" style="width: 100%; height: auto; object-fit: cover;">
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <h4>Arun Menon</h4>
                    <p style="color: #3498db; font-weight: 600; margin-bottom: 15px;">Chief Financial Officer</p>
                    <p>
                        Arun brings extensive financial expertise and strategic planning capabilities to Good Vacation. With a 
                        background in corporate finance and investment banking, he manages the company's financial operations, 
                        budgeting, and long-term financial strategy.
                    </p>
                    <p>
                        His analytical approach and financial acumen have been instrumental in driving sustainable growth and 
                        profitability. Arun is a Chartered Accountant with over 12 years of experience in finance leadership roles 
                        across various industries.
                    </p>
                    <p style="margin-top: 15px;">
                        <strong>Education:</strong> CA, ICAI | B.Com, University of Mumbai<br>
                        <strong>Email:</strong> <a href="mailto:arun@goodvacation.com">arun@goodvacation.com</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- CMO -->
        <div class="row align-items-center" style="margin-bottom: 60px;">
            <div class="col-md-8 order-md-1 order-2">
                <div class="card">
                    <h4>Ananya Reddy</h4>
                    <p style="color: #3498db; font-weight: 600; margin-bottom: 15px;">Chief Marketing Officer</p>
                    <p>
                        Ananya leads our marketing and brand strategy, driving customer acquisition and engagement through 
                        innovative campaigns and digital marketing initiatives. Her creative vision and data-driven approach 
                        have significantly enhanced our brand presence and market reach.
                    </p>
                    <p>
                        With 10 years of experience in marketing leadership, Ananya specializes in digital marketing, content 
                        strategy, and customer experience. She has successfully launched numerous award-winning campaigns that 
                        have positioned Good Vacation as a market leader.
                    </p>
                    <p style="margin-top: 15px;">
                        <strong>Education:</strong> MBA in Marketing, ISB Hyderabad | B.A., Delhi University<br>
                        <strong>Email:</strong> <a href="mailto:ananya@goodvacation.com">ananya@goodvacation.com</a>
                    </p>
                </div>
            </div>
            <div class="col-md-4 order-md-2 order-1">
                <div class="img" style="border-radius: 8px; overflow: hidden;">
                    <img src="{{ asset('assets/images/team/cmo.jpg') }}" alt="Ananya Reddy" style="width: 100%; height: auto; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Senior Management -->
<section class="subpage-content">
    <div class="container">
        <div class="text-center" style="margin-bottom: 50px;">
            <h3>Senior Management Team</h3>
            <p class="para-lg">Experienced leaders driving excellence across all departments</p>
        </div>

        <div class="row">
            <!-- Team Member -->
            <div class="col-md-4">
                <div class="card" style="text-align: center;">
                    <div class="img" style="border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                        <img src="{{ asset('assets/images/team/vp-sales.jpg') }}" alt="Vikram Singh" style="width: 100%; height: auto;">
                    </div>
                    <h4>Vikram Singh</h4>
                    <p style="color: #3498db; font-weight: 600;">VP of Sales</p>
                    <p>
                        Leading our sales teams across India with a focus on customer relationships and revenue growth. 
                        12+ years in travel sales.
                    </p>
                    <p><a href="mailto:vikram@goodvacation.com">vikram@goodvacation.com</a></p>
                </div>
            </div>

            <!-- Team Member -->
            <div class="col-md-4">
                <div class="card" style="text-align: center;">
                    <div class="img" style="border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                        <img src="{{ asset('assets/images/team/head-tech.jpg') }}" alt="Suresh Nair" style="width: 100%; height: auto;">
                    </div>
                    <h4>Suresh Nair</h4>
                    <p style="color: #3498db; font-weight: 600;">Head of Technology</p>
                    <p>
                        Driving technological innovation and digital transformation. Overseeing our booking platform and 
                        IT infrastructure. 15+ years in tech.
                    </p>
                    <p><a href="mailto:suresh@goodvacation.com">suresh@goodvacation.com</a></p>
                </div>
            </div>

            <!-- Team Member -->
            <div class="col-md-4">
                <div class="card" style="text-align: center;">
                    <div class="img" style="border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                        <img src="{{ asset('assets/images/team/head-hr.jpg') }}" alt="Meera Iyer" style="width: 100%; height: auto;">
                    </div>
                    <h4>Meera Iyer</h4>
                    <p style="color: #3498db; font-weight: 600;">Head of Human Resources</p>
                    <p>
                        Building and nurturing our talented workforce. Focused on employee development, culture, and 
                        organizational excellence. 10+ years in HR.
                    </p>
                    <p><a href="mailto:meera@goodvacation.com">meera@goodvacation.com</a></p>
                </div>
            </div>

            <!-- Team Member -->
            <div class="col-md-4">
                <div class="card" style="text-align: center;">
                    <div class="img" style="border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                        <img src="{{ asset('assets/images/team/head-cs.jpg') }}" alt="Deepa Thomas" style="width: 100%; height: auto;">
                    </div>
                    <h4>Deepa Thomas</h4>
                    <p style="color: #3498db; font-weight: 600;">Head of Customer Service</p>
                    <p>
                        Ensuring exceptional customer experiences at every touchpoint. Leading our customer support teams 
                        with empathy and efficiency. 8+ years experience.
                    </p>
                    <p><a href="mailto:deepa@goodvacation.com">deepa@goodvacation.com</a></p>
                </div>
            </div>

            <!-- Team Member -->
            <div class="col-md-4">
                <div class="card" style="text-align: center;">
                    <div class="img" style="border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                        <img src="{{ asset('assets/images/team/head-product.jpg') }}" alt="Rahul Verma" style="width: 100%; height: auto;">
                    </div>
                    <h4>Rahul Verma</h4>
                    <p style="color: #3498db; font-weight: 600;">Head of Product Development</p>
                    <p>
                        Designing innovative travel packages and experiences. Working closely with destinations to create 
                        unique offerings. 9+ years in product.
                    </p>
                    <p><a href="mailto:rahul@goodvacation.com">rahul@goodvacation.com</a></p>
                </div>
            </div>

            <!-- Team Member -->
            <div class="col-md-4">
                <div class="card" style="text-align: center;">
                    <div class="img" style="border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                        <img src="{{ asset('assets/images/team/head-legal.jpg') }}" alt="Kavita Patel" style="width: 100%; height: auto;">
                    </div>
                    <h4>Kavita Patel</h4>
                    <p style="color: #3498db; font-weight: 600;">Head of Legal & Compliance</p>
                    <p>
                        Managing legal affairs, contracts, and regulatory compliance. Ensuring our operations meet all 
                        legal requirements. 11+ years legal experience.
                    </p>
                    <p><a href="mailto:kavita@goodvacation.com">kavita@goodvacation.com</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Board of Advisors -->
<section class="subpage-content light-bg">
    <div class="container">
        <div class="text-center" style="margin-bottom: 50px;">
            <h3>Advisory Board</h3>
            <p class="para-lg">Industry veterans providing strategic guidance and expertise</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <h4>Dr. Sanjay Kapoor</h4>
                    <p style="color: #3498db; font-weight: 600;">Tourism Industry Expert</p>
                    <p>
                        Former Secretary of Tourism, Government of India. Over 30 years of experience in tourism policy 
                        and development. Advises on industry trends and government relations.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <h4>Sarah Johnson</h4>
                    <p style="color: #3498db; font-weight: 600;">International Travel Consultant</p>
                    <p>
                        Former VP at leading global travel company. Expert in international markets and cross-border 
                        partnerships. Helps us expand our global footprint.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <h4>Prof. Ravi Krishnan</h4>
                    <p style="color: #3498db; font-weight: 600;">Digital Transformation Advisor</p>
                    <p>
                        Professor of Business Technology at IIT Madras. Specializes in digital innovation and e-commerce. 
                        Guides our technology strategy and digital initiatives.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Leadership -->
<section class="subpage-content">
    <div class="container">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 50px; text-align: center;">
            <h3 style="color: white; margin-bottom: 20px;">Get in Touch with Our Leadership</h3>
            <p style="font-size: 18px; margin-bottom: 30px;">
                Have questions, partnership proposals, or media inquiries? Our leadership team is here to help.
            </p>
            <a href="{{ route('contact') }}" class="btn" style="background: white; color: #667eea;">Contact Us</a>
        </div>
    </div>
</section>

<!-- Footer Caption -->
<section class="footer-caption light-bg">
    <div class="container">
        <div class="footer-caption-wrap">
            <h4>Guided by Vision, Driven by Passion</h4>
            <p>Our leadership team is committed to making every journey exceptional.</p>
            <a href="{{ route('about') }}" class="btn">Learn More About Us</a>
        </div>
    </div>
</section>
<!-- /.Footer Caption -->
@endsection

