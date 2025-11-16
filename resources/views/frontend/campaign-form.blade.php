<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Win a Dream Trip - Good Vacation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .floating-icon {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .floating-icon:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .floating-icon:nth-child(2) { top: 20%; right: 15%; animation-delay: 1s; }
        .floating-icon:nth-child(3) { top: 60%; left: 5%; animation-delay: 2s; }
        .floating-icon:nth-child(4) { top: 70%; right: 10%; animation-delay: 3s; }
        .floating-icon:nth-child(5) { top: 40%; left: 20%; animation-delay: 4s; }
        .floating-icon:nth-child(6) { top: 30%; right: 25%; animation-delay: 5s; }
        
        .logo-section {
            text-align: center;
            padding: 10px 0;
            position: relative;
            z-index: 10;
           
        }
        
        .logo {
            width: 240px;
            height: 240px;
            animation: logoGlow 3s ease-in-out infinite alternate;
            filter: drop-shadow(0 4px 8px rgba(103, 70, 156, 0.3));
        }
        
        @keyframes logoGlow {
            0% { 
                filter: drop-shadow(0 0 10px rgba(103, 70, 156, 0.3)) drop-shadow(0 4px 8px rgba(103, 70, 156, 0.3));
                transform: scale(1);
            }
            100% { 
                filter: drop-shadow(0 0 20px rgba(103, 70, 156, 0.5)) drop-shadow(0 4px 8px rgba(103, 70, 156, 0.3));
                transform: scale(1.02);
            }
        }
        
        .logo-text {
            font-size: 1.4rem;
            color: #67469C;
            font-weight: 700;
            margin-top: 15px;
            text-shadow: 0 2px 4px rgba(103, 70, 156, 0.2);
        }
        
        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .content-wrapper {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .campaign-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .campaign-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 20px;
            background: rgba(103, 70, 156, 0.1);
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            color: #67469C;
            margin-bottom: 30px;
        }
        
        .campaign-title {
            font-size: 3.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .highlight-text {
            color: #67469C;
        }
        
        .campaign-description {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        .campaign-form-wrapper {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 25px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 15px;
        }
        
        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #67469C;
            background: white;
            box-shadow: 0 0 0 4px rgba(103, 70, 156, 0.1);
            transform: translateY(-1px);
        }
        
        .btn-submit {
            background: #67469C;
            color: white;
            border: none;
            padding: 18px 50px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
            min-width: 220px;
            box-shadow: 0 8px 25px rgba(103, 70, 156, 0.3);
        }
        
        .btn-submit:hover {
            background: #5a3d8a;
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(103, 70, 156, 0.4);
        }
        
        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        
        .form-check-input {
            accent-color: #67469C;
            margin-top: 4px;
            width: 18px;
            height: 18px;
        }
        
        .form-check-label {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            flex: 1;
        }
        
        .infographics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .infographic-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #67469C;
            margin-bottom: 10px;
            animation: countUp 2s ease-out;
        }
        
        .stat-label {
            font-size: 1rem;
            color: #666;
            font-weight: 500;
        }
        
        @keyframes countUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .travel-journey {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }
        
        .journey-path {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }
        
        .journey-step {
            text-align: center;
            flex: 1;
        }
        
        .step-icon {
            width: 60px;
            height: 60px;
            background: #67469C;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            animation: pulse 2s infinite;
        }
        
        .step-text {
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .journey-arrow {
            flex: 0 0 50px;
            text-align: center;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        
        .info-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }
        
        .terms-content {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        .terms-text {
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
            color: #555;
        }
        
        .terms-text h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 40px;
        }
        
        .terms-text h3 {
            font-size: 1.4rem;
            font-weight: 600;
            color: #67469C;
            margin-bottom: 15px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 1px solid #c3e6cb;
            font-size: 16px;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            font-weight: 500;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .floating-icon { display: none; }
            .campaign-title { font-size: 2.5rem !important; }
            .campaign-form-wrapper { padding: 30px 20px !important; margin: 20px 10px !important; }
            .form-row { grid-template-columns: 1fr !important; gap: 20px !important; }
            .infographics-grid { grid-template-columns: 1fr !important; gap: 15px !important; }
            .journey-path { flex-direction: column !important; gap: 15px !important; }
            .journey-arrow { transform: rotate(90deg) !important; flex: none !important; }
            .terms-content { padding: 30px 20px !important; }
            .btn-submit { width: 100%; min-width: auto; }
        }
        
        @media (max-width: 480px) {
            .campaign-title { font-size: 2rem !important; }
            .campaign-form-wrapper { padding: 25px 15px !important; }
            .terms-content { padding: 25px 15px !important; }
            .terms-text h2 { font-size: 1.8rem !important; }
            .terms-text h3 { font-size: 1.1rem !important; }
        }
    </style>
</head>
<body>
    <!-- Floating Travel Icons -->
    <div class="floating-elements">
        <div class="floating-icon"><i class="fas fa-plane" style="font-size: 3rem; color: #67469C;"></i></div>
        <div class="floating-icon"><i class="fas fa-map-marked-alt" style="font-size: 2.5rem; color: #67469C;"></i></div>
        <div class="floating-icon"><i class="fas fa-camera" style="font-size: 2rem; color: #67469C;"></i></div>
        <div class="floating-icon"><i class="fas fa-mountain" style="font-size: 2.8rem; color: #67469C;"></i></div>
        <div class="floating-icon"><i class="fas fa-sun" style="font-size: 2.2rem; color: #67469C;"></i></div>
        <div class="floating-icon"><i class="fas fa-compass" style="font-size: 2.5rem; color: #67469C;"></i></div>
    </div>

    <!-- Logo Section -->
    <div class="logo-section">
        <img src="https://gsx-poc.test/assets/images/good-vacation-logo.svg" alt="Good Vacation" class="logo" onerror="this.style.display='none'">
       
    </div>

    <!-- Campaign Form Section -->
    <section style="padding: 20px 0 80px 0; position: relative; z-index: 10;">
        <div class="container">
            <!-- Campaign Header -->
            <div class="campaign-header">
                <div class="campaign-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px;">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    @if(isset($campaignData) && $campaignData)
                        {{ $campaignData->name }}
                    @else
                        Win a Trip Campaign
                    @endif
                </div>
                <h1 class="campaign-title">
                    Enter to Win a <span class="highlight-text">Dream Trip</span>
                </h1>
                <p class="campaign-description">
                    @if(isset($campaignData) && $campaignData && $campaignData->description)
                        {{ $campaignData->description }}<br>
                        Fill out the form below to participate in this campaign!
                    @else
                        Fill out the form below with your campaign details and get a chance to win an amazing trip to your dream destination.<br>
                        One lucky winner will be selected and announced soon!
                    @endif
                </p>
            </div>

            <!-- Campaign Form -->
            <div class="campaign-form-wrapper">
                @if(session('success'))
                    <div class="alert-success">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                @endif

                <form id="campaignForm" method="POST" action="{{ route('campaign.submit') }}">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{ isset($campaignData) && $campaignData ? $campaignData->id : $campaignId }}">

                    <!-- Personal Information -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" 
                                   class="form-control @if(isset($errors) && $errors->has('name')) is-invalid @endif" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter your full name"
                                   required>
                        @if(isset($errors) && $errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" 
                                   class="form-control @if(isset($errors) && $errors->has('email')) is-invalid @endif" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter your email address"
                                   required>
@if(isset($errors) && $errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" 
                                   class="form-control @if(isset($errors) && $errors->has('phone')) is-invalid @endif" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="Enter your phone number"
                                   required>
@if(isset($errors) && $errors->has('phone'))
                            <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                        @endif
                        </div>

                        <div class="form-group">
                            <label for="age" class="form-label">Age *</label>
                            <input type="number" 
                                   class="form-control @if(isset($errors) && $errors->has('age')) is-invalid @endif" 
                                   id="age" 
                                   name="age" 
                                   value="{{ old('age') }}" 
                                   placeholder="Enter your age"
                                   min="18" 
                                   max="100"
                                   required>
@if(isset($errors) && $errors->has('age'))
                            <div class="invalid-feedback">{{ $errors->first('age') }}</div>
                        @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dream_destination" class="form-label">Your Dream Destination *</label>
                        <input type="text" 
                               class="form-control @if(isset($errors) && $errors->has('dream_destination')) is-invalid @endif" 
                               id="dream_destination" 
                               name="dream_destination" 
                               value="{{ old('dream_destination') }}" 
                               placeholder="e.g., Switzerland, Maldives, Japan..."
                               required>
                        @if(isset($errors) && $errors->has('dream_destination'))
                            <div class="invalid-feedback">{{ $errors->first('dream_destination') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="travel_experience" class="form-label">Tell us about your travel experience *</label>
                        <textarea class="form-control @if(isset($errors) && $errors->has('travel_experience')) is-invalid @endif" 
                                  id="travel_experience" 
                                  name="travel_experience" 
                                  rows="5" 
                                  placeholder="Share your most memorable travel experience or why you love to travel..."
                                  required>{{ old('travel_experience') }}</textarea>
                        @if(isset($errors) && $errors->has('travel_experience'))
                            <div class="invalid-feedback">{{ $errors->first('travel_experience') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="social_media" class="form-label">Social Media Handle (Optional)</label>
                        <input type="text" 
                               class="form-control @if(isset($errors) && $errors->has('social_media')) is-invalid @endif" 
                               id="social_media" 
                               name="social_media" 
                               value="{{ old('social_media') }}" 
                               placeholder="e.g., @yourusername">
                        @if(isset($errors) && $errors->has('social_media'))
                            <div class="invalid-feedback">{{ $errors->first('social_media') }}</div>
                        @endif
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input @if(isset($errors) && $errors->has('terms_accepted')) is-invalid @endif" 
                                   type="checkbox" 
                                   id="terms_accepted" 
                                   name="terms_accepted" 
                                   value="1" 
                                   required>
                            <label class="form-check-label" for="terms_accepted">
                                I agree to the Terms and Conditions and understand that I must be 18+ to participate.
                            </label>
                        </div>
                        @if(isset($errors) && $errors->has('terms_accepted'))
                            <div class="invalid-feedback">{{ $errors->first('terms_accepted') }}</div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div style="text-align: center; margin-top: 40px;">
                        <button type="submit" class="btn-submit">
                            Enter Campaign
                        </button>
                    </div>
                </form>
            </div>

            <!-- Travel Infographics Section -->
            <div class="content-wrapper" style="margin-top: 50px;">
               
                
                <div class="travel-journey">
                    <h3 style="text-align: center; font-size: 1.8rem; font-weight: 600; color: #333; margin-bottom: 30px;">Your Journey Awaits</h3>
                    <div class="journey-path">
                        <div class="journey-step">
                            <div class="step-icon">
                                <i class="fas fa-plane" style="color: white; font-size: 1.5rem;"></i>
                            </div>
                            <div class="step-text">Enter Campaign</div>
                        </div>
                        <div class="journey-arrow">
                            <i class="fas fa-arrow-right" style="color: #67469C; font-size: 1.5rem;"></i>
                        </div>
                        <div class="journey-step">
                            <div class="step-icon">
                                <i class="fas fa-trophy" style="color: white; font-size: 1.5rem;"></i>
                            </div>
                            <div class="step-text">Win Trip</div>
                        </div>
                        <div class="journey-arrow">
                            <i class="fas fa-arrow-right" style="color: #67469C; font-size: 1.5rem;"></i>
                        </div>
                        <div class="journey-step">
                            <div class="step-icon">
                                <i class="fas fa-heart" style="color: white; font-size: 1.5rem;"></i>
                            </div>
                            <div class="step-text">Create Memories</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campaign Info -->
            <div class="content-wrapper" style="margin-top: 30px;">
                <div class="info-grid">
                    <div class="info-card">
                        <div style="width: 60px; height: 60px; background: #67469C; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-gift" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <h5 style="font-size: 1.3rem; font-weight: 600; color: #333; margin-bottom: 12px;">Free Entry</h5>
                        <p style="color: #666; margin: 0; font-size: 15px; line-height: 1.5;">No purchase necessary. Simply fill out the form to enter and get a chance to win.</p>
                    </div>
                    <div class="info-card">
                        <div style="width: 60px; height: 60px; background: #67469C; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-shield-alt" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <h5 style="font-size: 1.3rem; font-weight: 600; color: #333; margin-bottom: 12px;">Fair Selection</h5>
                        <p style="color: #666; margin: 0; font-size: 15px; line-height: 1.5;">Winner will be selected randomly and announced publicly on our social media.</p>
                    </div>
                    <div class="info-card">
                        <div style="width: 60px; height: 60px; background: #67469C; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-calendar-check" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <h5 style="font-size: 1.3rem; font-weight: 600; color: #333; margin-bottom: 12px;">18+ Only</h5>
                        <p style="color: #666; margin: 0; font-size: 15px; line-height: 1.5;">Must be 18 years or older to participate in this campaign.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Terms and Conditions Section -->
    <section style="background: #f8f9fa; padding: 60px 0; position: relative; z-index: 10;">
        <div class="container">
            <div class="content-wrapper">
                <div class="terms-content">
                <h2>Terms and Conditions</h2>
                <div class="terms-text">
                    <div style="margin-bottom: 30px;">
                        <h3>Campaign Overview</h3>
                        <p>This "Win a Dream Trip" campaign is organized by Good Vacation. By participating in this campaign, you agree to be bound by these terms and conditions.</p>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h3>Eligibility</h3>
                        <ul style="margin-left: 20px;">
                            <li>Participants must be 18 years of age or older at the time of entry</li>
                            <li>Must be a legal resident of the country where the campaign is conducted</li>
                            <li>Employees of Good Vacation and their immediate family members are not eligible</li>
                            <li>One entry per person per campaign period</li>
                        </ul>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <h3>Prize Details</h3>
                        <ul style="margin-left: 20px;">
                            <li>One winner will be selected randomly from all valid entries</li>
                            <li>Prize includes a trip to the winner's dream destination (subject to availability)</li>
                            <li>Prize value and details will be confirmed upon winner selection</li>
                            <li>Prize is non-transferable and cannot be exchanged for cash</li>
                        </ul>
                    </div>

                    <div style="background: #f8f9fa; padding: 25px; border-radius: 15px; border-left: 4px solid #67469C; margin-top: 40px;">
                        <p style="margin: 0; font-weight: 500; color: #333; text-align: center;">
                            <strong>By participating in this campaign, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions.</strong>
                        </p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
</body>
</html>
