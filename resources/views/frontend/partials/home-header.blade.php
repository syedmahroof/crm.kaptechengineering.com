<!-- Home Page Header (includes banner, caption, search form) -->
<header class="header home-header">
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

    <!-- Home Caption -->
    <!-- <div class="home-caption">
        <div class="home-caption-in">
            <h1>Explore the Beautiful Places Around the World</h1>
            <p>Hand-picked manor houses, stately homes and large holiday homes for weddings, parties and family getaways.</p>
        </div>
    </div> -->
    <!-- /.Home Caption -->

    

    <!-- Banner Slider -->
    <div class="banner-wrap">
        <div class="slider-mask"></div>
        @if(isset($banners) && $banners->count() > 0)
            <div class="banner-carousel owl-carousel owl-theme">
                @foreach($banners as $banner)
                    <div class="item">
                        @php
                            // Try different ways to get the image
                            $imageUrl = null;
                            if ($banner->desktop_image) {
                                $imageUrl = asset('storage/' . $banner->desktop_image);
                            } elseif ($banner->image) {
                                $imageUrl = asset('storage/' . $banner->image);
                            } else {
                                $imageUrl = asset('assets/images/banner-01.jpg');
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $banner->alt_tag ?? $banner->title }}" onerror="this.src='{{ asset('assets/images/banner-01.jpg') }}'">
                        @if($banner->title ?? false)
                            <div class="caption-banner">
                                <h2></h2>
                                @if($banner->description)
                                    <p></p>
                                @endif
                                @if($banner->button_text && $banner->link)
                                    <a href="{{ $banner->link }}" class="btn">{{ $banner->button_text }}</a>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <!-- Default banner if no banners in database -->
            <div class="banner-carousel owl-carousel owl-theme">
                <div class="item">
                    <img src="{{ asset('assets/images/banner-01.jpg') }}" alt="Banner 1">
                    <div class="caption-banner">
                        <h2>Explore the World</h2>
                    </div>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/banner-02.jpg') }}" alt="Banner 2">
                    <div class="caption-banner">
                        <h2>Adventure Awaits</h2>
                    </div>
                </div>
                <div class="item">
                    <img src="{{ asset('assets/images/banner-03.jpg') }}" alt="Banner 3">
                    <div class="caption-banner">
                        <h2>Your Dream Vacation</h2>
                    </div>
                </div>
            </div>
        @endif
        <!-- Search Form -->
    <div class="search-form-wrap ">
        <div class="container">
            <div class="search-form">
                <form action="{{ route('search') }}" method="GET">
                    <div class="form-left">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Where</label>
                                    <input type="text" class="form-control" name="destination" placeholder="Find Destinations">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">When</label>
                                    <input type="text" class="form-control" name="date" placeholder="Choose date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Who</label>
                                    <input type="text" class="form-control" name="travelers" placeholder="Travellers">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-btn">
                        <button class="btn search-btn" type="submit">
                            <span>Search</span>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.4627 16.0833L14.1601 12.7905C15.2256 11.433 15.8038 9.75664 15.8017 8.0309C15.8017 6.49398 15.3459 4.99159 14.492 3.71369C13.6382 2.4358 12.4246 1.4398 11.0046 0.851649C9.58472 0.263499 8.02228 0.109612 6.5149 0.409448C5.00752 0.709285 3.6229 1.44938 2.53614 2.53614C1.44938 3.6229 0.709285 5.00752 0.409448 6.5149C0.109612 8.02228 0.263499 9.58472 0.851649 11.0046C1.4398 12.4246 2.4358 13.6382 3.71369 14.492C4.99159 15.3459 6.49398 15.8017 8.0309 15.8017C9.75664 15.8038 11.433 15.2256 12.7905 14.1601L16.0833 17.4627C16.1736 17.5537 16.2811 17.626 16.3994 17.6753C16.5178 17.7246 16.6448 17.75 16.773 17.75C16.9012 17.75 17.0282 17.7246 17.1466 17.6753C17.2649 17.626 17.3724 17.5537 17.4627 17.4627C17.5537 17.3724 17.626 17.2649 17.6753 17.1466C17.7246 17.0282 17.75 16.9012 17.75 16.773C17.75 16.6448 17.7246 16.5178 17.6753 16.3994C17.626 16.2811 17.5537 16.1736 17.4627 16.0833ZM2.20283 8.0309C2.20283 6.87821 2.54464 5.75141 3.18503 4.79299C3.82543 3.83457 4.73565 3.08757 5.80059 2.64646C6.86553 2.20535 8.03736 2.08993 9.16789 2.31481C10.2984 2.53969 11.3369 3.09476 12.152 3.90983C12.967 4.7249 13.5221 5.76336 13.747 6.8939C13.9719 8.02443 13.8564 9.19626 13.4153 10.2612C12.9742 11.3261 12.2272 12.2364 11.2688 12.8768C10.3104 13.5172 9.18358 13.859 8.0309 13.859C6.48519 13.859 5.0028 13.2449 3.90983 12.152C2.81685 11.059 2.20283 9.5766 2.20283 8.0309Z" fill="white"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.Search Form -->
    </div>
    <!-- /.Banner Slider -->

    

    <!-- Offer Strip -->
    <div class="offer-strip">
        <div class="container">
            <div class="offer-strip-in">
                <p>Save 10% or more on over international holiday packages</p>
                <a href="{{ route('packages') }}" class="btn">See more deals</a>
            </div>
        </div>
    </div>
    <!-- /.Offer Strip -->
</header>
<!-- /.Home Page Header -->
