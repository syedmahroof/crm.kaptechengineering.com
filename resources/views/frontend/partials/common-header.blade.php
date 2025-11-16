<!-- Common Header (Call Now + Topbar) -->
<header class="header">
    <!-- Call Now Bar -->
    <div class="callnow">
        <div class="call-now"> 
            <span>Call Now</span>
            <a href="tel:+91 7592010044">+91 7592010044</a>
        </div>
    </div>
    <!-- /.Call Now Bar -->

    <!-- Topbar -->
    <div class="topbar">	
        <div class="offcanvas-menu">
            <input type="checkbox" id="toogle-menu" />
            <label for="toogle-menu" class="toogle-open"><span></span><b>Menu</b></label>
            
            <nav>
                <div>
                    <label for="toogle-menu" class="toogle-close">
                        <span></span>
                    </label>
                </div>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('packages') }}">Packages</a></li>
                    <li><a href="{{ route('destinations') }}">Destinations</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <div class="overlay"></div>
                </ul>
            </nav>
        </div>	
        <div class="brand-logo">
            <a href="{{ route('home') }}"><img src="{{ asset('assets/images/good-vacation-logo.svg') }}" alt="Good Vacation Logo"></a>
        </div>
        <div class="brand-logo-dark">
            <a href="{{ route('home') }}"><img src="{{ asset('assets/images/good-vacation-logo.svg') }}" alt="Good Vacation Logo"></a>
        </div>
        <div class="topbar-right">
            <a class="our-dest dropdown" href="{{ route('destinations') }}">Our Destinations</a>
            <a class="login-btn" href="{{ route('contact') }}">Contact Us</a>
        </div>
    </div>
    <!-- /.Topbar -->
</header>
<!-- /.Common Header -->
