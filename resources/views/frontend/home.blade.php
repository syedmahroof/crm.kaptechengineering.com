@extends('layouts.frontend')

@section('content')
<!-- Trending Destinations -->
<section class="attractions-section">
    <div class="container">
        <div class="heading">
            <div class="left">
                <h3>See What’s Trending <br>Around the Globe</h3>
                <a href="{{ route('destinations') }}" class="view-all">Our Destinations</a>
            </div>
        </div>
        <div class="attractions-list">
            <div class="attractions-slider owl-carousel owl-theme">
                @forelse($destinations as $destination)
                <div class="item">
                    <div class="attractions-box">
                        <a href="{{ route('destination.show', $destination->slug) }}">
                            <img src="{{ asset($destination->image) }}" alt="{{ $destination->name }}">
                            <div class="content">
                                <h3>{{ $destination->name }}</h3>
                                <p>{{ $destination->packages_count ?? rand(5, 25) }} Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                @empty
                <!-- Fallback destinations if database is empty -->
                <div class="item">
                    <div class="attractions-box">
                        <a href="{{ route('destinations') }}">
                            <img src="{{ asset('assets/images/dubai.jpg') }}" alt="Dubai">
                            <div class="content">
                                <h3>Dubai</h3>
                                <p>16 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="{{ route('destinations') }}">
                            <img src="{{ asset('assets/images/bali-min.jpg') }}" alt="Bali">
                            <div class="content">
                                <h3>Bali</h3>
                                <p>8 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="{{ route('destinations') }}">
                            <img src="{{ asset('assets/images/phuket-min.jpg') }}" alt="Phuket">
                            <div class="content">
                                <h3>Phuket</h3>
                                <p>12 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="{{ route('destinations') }}">
                            <img src="{{ asset('assets/images/destination-03.jpg') }}" alt="Maldives">
                            <div class="content">
                                <h3>Maldives</h3>
                                <p>10 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="{{ route('destinations') }}">
                            <img src="{{ asset('assets/images/destination-05.jpg') }}" alt="Singapore">
                            <div class="content">
                                <h3>Singapore</h3>
                                <p>7 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="{{ route('destinations') }}">
                            <img src="{{ asset('assets/images/destination-06.jpg') }}" alt="Thailand">
                            <div class="content">
                                <h3>Thailand</h3>
                                <p>22 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- /.Trending Destinations -->

<section class="slider-section light-bg mb-10">
    <div class="container attractions-container">
        <div class="heading">
            <div class="left">
                <h3>Step Into the World’s <br>Trending Adventures</h3>
                <a href="destinations.html" class="view-all">Our Destinations</a>
            </div>
        </div>
        <div class="attractions-list">
            <div class="contain-slider owl-carousel owl-theme">
                <div class="item">
                    <div class="attractions-box">
                        <a href="#"><img src="assets/images/vivu-min.jpg" alt="">
                            <div class="content">
                                <h3>Phu quoc</h3>
                                <p>Vietnam</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="#"><img src="assets/images/bali-min.jpg" alt="">
                            <div class="content">
                                <h3>Bali</h3>
                                <p>Indonesia</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="#"><img src="assets/images/phuket-min.jpg" alt="">
                            <div class="content">
                                <h3>phuket</h3>
                                <p>Thailand</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tour Type -->
<section class="block-section mt-10" style="margin-top: 60px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="tour-type">
                    <h4>Discover Your Perfect Getaway </h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="attractions-box">
                                <a href="{{ route('packages', ['type' => 'honeymoon']) }}">
                                    <img src="{{ asset('assets/images/tour-type-01.jpg') }}" alt="Honeymoon">
                                    <div class="content">
                                        <h5>Honeymoon</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="attractions-box">
                                <a href="{{ route('packages', ['type' => 'family']) }}">
                                    <img src="{{ asset('assets/images/tour-type-02.jpg') }}" alt="Family Tours">
                                    <div class="content">
                                        <h5>Family Tours</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="attractions-box">
                                <a href="{{ route('packages', ['type' => 'adventure']) }}">
                                    <img src="{{ asset('assets/images/tour-type-03.jpg') }}" alt="Adventure Tours">
                                    <div class="content">
                                        <h5>Adventure Tours</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="attractions-box">
                                <a href="{{ route('packages', ['type' => 'pilgrimage']) }}">
                                    <img src="{{ asset('assets/images/tour-type-04.jpg') }}" alt="Pilgrimage">
                                    <div class="content">
                                        <h5>Pilgrimage</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="emi-option">
                    <div class="heading">
                        <p>Easy EMIs, Endless Adventures</p>
                        <h4>Your World Awaits</h4>
                        <a href="{{ route('emi-packages') }}" class="btn">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="attractions-section light-bg">
    <div class="container">
        <div class="heading">
            <div class="left">
                <h3>Explore the Most <br>Trending Destinations</h3>
                <a href="destinations.html" class="view-all">Our Destinations</a>
            </div>
        </div>
        <div class="attractions-list">
            <div class="attractions-slider owl-carousel owl-theme">
                <div class="item">
                    <div class="attractions-box">
                        <a href="#"><img src="assets/images/destination-01.jpg" alt="">
                            <div class="content">
                                <h3>Switzerland</h3>
                                <p>16 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="#"><img src="assets/images/destination-02.jpg" alt="">
                            <div class="content">
                                <h3>Egypt</h3>
                                <p>8 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="#"><img src="assets/images/destination-03.jpg" alt="">
                            <div class="content">
                                <h3>Maldives</h3>
                                <p>12 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="#"><img src="assets/images/destination-04.jpg" alt="">
                            <div class="content">
                                <h3>Switzerland</h3>
                                <p>10 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="#"><img src="assets/images/destination-05.jpg" alt="">
                            <div class="content">
                                <h3>Italy</h3>
                                <p>7 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="attractions-box">
                        <a href="#"><img src="assets/images/destination-06.jpg" alt="">
                            <div class="content">
                                <h3>Singapore</h3>
                                <p>22 Packages</p>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<!-- /.Tour Type -->

<!-- Trending Destinations Slider -->
<!-- <section class="slider-section light-bg">
    <div class="container attractions-container">
        <div class="heading">
            <div class="left">
                <h3>Explore the Most <br>Trending Destinations</h3>
                <a href="{{ route('destinations') }}" class="view-all">Our Destinations</a>
            </div>
        </div>
        <div class="attractions-list">
            <div class="contain-slider owl-carousel owl-theme">
                @forelse($destinations as $destination)
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destination.show', $destination->slug) }}">
                                <img src="{{ asset('assets/images/destination-01.jpg') }}" alt="{{ $destination->name }}">
                                <div class="content">
                                    <h3>{{ $destination->name }}</h3>
                                    <p>{{ $destination->packages_count ?? rand(5, 25) }} Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                  
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destinations') }}">
                                <img src="{{ asset('assets/images/destination-11.jpg') }}" alt="Singapore">
                                <div class="content">
                                    <h3>Azerbaijan</h3>
                                    <p>22 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destinations') }}">
                                <img src="{{ asset('assets/images/destination-11.jpg') }}" alt="Georgia">
                                <div class="content">
                                    <h3>Georgia</h3>
                                    <p>22 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destinations') }}">
                                <img src="{{ asset('assets/images/destination-11.jpg') }}" alt="Georgia">
                                <div class="content">
                                    <h3></h3>
                                    <p>22 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section> -->
<!-- /.Trending Destinations Slider -->

<!-- Indian Packages -->
<!-- <section class="attractions-section light-bg">
    <div class="container">
        <div class="heading">
            <div class="left">
                <h3>Explore the Cultural <br> of India</h3>
                <a href="{{ route('destinations', ['type' => 'indian']) }}" class="view-all">Our Destinations</a>
            </div>
        </div>
        <div class="attractions-list">
            <div class="attractions-slider owl-carousel owl-theme">
                @forelse($indianDestinations as $destination)
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destination.show', $destination->slug) }}">
                                <img src="{{ asset($destination->images[0] ?? 'assets/images/indian-01.jpg') }}" alt="{{ $destination->name }}">
                                <div class="content">
                                    <h3>{{ $destination->name }}</h3>
                                    <p>{{ $destination->packages_count ?? rand(5, 25) }} Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destinations') }}">
                                <img src="{{ asset('assets/images/indian-01.jpg') }}" alt="Hyderabad">
                                <div class="content">
                                    <h3>Hyderabad</h3>
                                    <p>16 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destinations') }}">
                                <img src="{{ asset('assets/images/indian-02.jpg') }}" alt="Kerala">
                                <div class="content">
                                    <h3>Kerala</h3>
                                    <p>9 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destinations') }}">
                                <img src="{{ asset('assets/images/indian-03.jpg') }}" alt="Manali">
                                <div class="content">
                                    <h3>Manali</h3>
                                    <p>16 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destinations') }}">
                                <img src="{{ asset('assets/images/indian-04.jpg') }}" alt="Rajasthan">
                                <div class="content">
                                    <h3>Rajasthan</h3>
                                    <p>13 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destinations') }}">
                                <img src="{{ asset('assets/images/indian-05.jpg') }}" alt="Kashmir">
                                <div class="content">
                                    <h3>Kashmir</h3>
                                    <p>21 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="attractions-box">
                            <a href="{{ route('destinations') }}">
                                <img src="{{ asset('assets/images/indian-06.jpg') }}" alt="Taj Mahal">
                                <div class="content">
                                    <h3>Taj Mahal</h3>
                                    <p>8 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section> -->
<!-- /.Indian Packages -->


<!-- Indian Packages -->
<section class="attractions-section">
    <div class="container">
        <div class="heading">
            <div class="left">
                <h3>Explore Popular <br>Indian Destinations</h3>
                <a href="#" class="view-all">Explore All</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 pop-col">
                <div class="row">
                    <div class="indian-pack col-sm-4">
                        <div class="attractions-box">
                            <a href="#"><img src="assets/images/indian-01.jpg" alt="">
                                <div class="content">
                                    <h3>Switzerland</h3>
                                    <p>16 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="indian-pack col-sm-4">
                        <div class="attractions-box">
                            <a href="#"><img src="assets/images/indian-02.jpg" alt="">
                                <div class="content">
                                    <h3>Switzerland</h3>
                                    <p>16 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="indian-pack col-sm-4">
                        <div class="attractions-box">
                            <a href="#"><img src="assets/images/indian-03.jpg" alt="">
                                <div class="content">
                                    <h3>Switzerland</h3>
                                    <p>16 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="indian-pack col-sm-4">
                        <div class="attractions-box">
                            <a href="#"><img src="assets/images/indian-04.jpg" alt="">
                                <div class="content">
                                    <h3>Switzerland</h3>
                                    <p>16 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="indian-pack col-sm-4">
                        <div class="attractions-box">
                            <a href="#"><img src="assets/images/indian-05.jpg" alt="">
                                <div class="content">
                                    <h3>Switzerland</h3>
                                    <p>16 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="indian-pack col-sm-4">
                        <div class="attractions-box">
                            <a href="#"><img src="assets/images/indian-06.jpg" alt="">
                                <div class="content">
                                    <h3>Switzerland</h3>
                                    <p>16 Packages</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.Indian Packages -->


<!-- Why Choose -->
<section class="why-hoose">
    <div class="container">
        <div class="row">
            <div class="col-md-4 left-col">
                <div class="heading">
                    <div class="left">
                        <h3>Why Choose Our Exceptional Travel Services</h3>
                        <p>Our holidays are designed with customer input, making each experience truly special.</p>
                        <a href="{{ route('about') }}" class="btn">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 right-col">
                <div class="row">
                    <div class="col-md-6 why-hoose-col">
                        <i>
                            <svg width="61" height="61" viewBox="0 0 61 61" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M35.1875 12.6875C37.2586 12.6875 38.9375 11.0086 38.9375 8.9375C38.9375 6.86643 37.2586 5.1875 35.1875 5.1875C33.1164 5.1875 31.4375 6.86643 31.4375 8.9375C31.4375 11.0086 33.1164 12.6875 35.1875 12.6875Z" fill="white" />
                                <path d="M49.2406 41.7502C49.2406 41.6471 49.2406 41.5533 49.2031 41.4502L44.0375 25.9533C44.9187 25.2689 45.5 24.2096 45.5 23.0002H38L34.8031 16.8783C34.4469 16.2408 33.9125 15.7252 33.2656 15.3971L32.4125 14.9658C31.2406 14.3658 29.8344 14.4596 28.7375 15.2002C28.0625 15.6596 27.5562 16.3346 27.2938 17.1221L23.2719 28.4939C23.0938 29.0002 23 29.5252 23 30.0689C23 30.7908 23.1687 31.5033 23.4781 32.1502C23.8063 32.8252 24.2281 33.4346 24.7156 33.9877L23.9375 41.7783L17.375 51.1533H13.625L8.9375 55.8408H52.0625V41.7783H49.2406V41.7502ZM31.4375 49.2502L28.625 51.1252H22.0625L28.625 42.6877L30.0312 37.0533L34.25 38.7689L37.0625 49.2502H31.4375ZM42.6875 49.2502H40.8125L38.9375 35.1877L30.5 30.5002L33.5188 24.4627L35.1875 26.7502H41.75C41.9375 26.7502 42.125 26.7221 42.3031 26.6939L47.3187 41.7502H46.4281L42.6781 49.2502H42.6875ZM18.9781 27.2096L21.4062 28.1752C21.425 28.0627 21.4625 27.9502 21.5 27.8471L25.5219 16.4846C25.7844 15.6783 26.2531 14.9283 26.8812 14.3096L24.6875 13.3346C22.7375 12.4721 20.4687 13.3908 19.6812 15.3689L16.8969 22.3346C16.1281 24.2564 17.0562 26.4408 18.9781 27.2096Z" fill="white" />
                            </svg>
                        </i>
                        <h5>Holidays Crafted by Experts</h5>
                        <p>Our seasoned travel specialists create holidays that blend comfort, culture, and unforgettable experiences — making every itinerary truly exceptional</p>
                    </div>
                    <div class="col-md-6 why-hoose-col">
                        <i>
                            <svg width="71" height="71" viewBox="0 0 71 71" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M61.1667 37.6874L32 28.7333C31.4909 28.5821 30.9502 28.5729 30.4362 28.7065C29.9222 28.8402 29.4544 29.1116 29.0834 29.4916C28.7135 29.8688 28.453 30.3393 28.3297 30.853C28.2064 31.3667 28.225 31.9043 28.3834 32.4083L37.7459 61.2249C37.9293 61.7725 38.2711 62.2532 38.7281 62.6063C39.185 62.9594 39.7364 63.1689 40.3125 63.2083H40.5459C41.0875 63.2039 41.6173 63.0488 42.0758 62.7603C42.5343 62.4718 42.9034 62.0614 43.1417 61.5749L49.2667 49.2083L61.75 43.0833C62.2705 42.8209 62.7005 42.4086 62.9845 41.8996C63.2684 41.3905 63.3934 40.8081 63.3432 40.2274C63.2929 39.6467 63.0699 39.0943 62.7027 38.6416C62.3356 38.1888 61.8412 37.8565 61.2834 37.6874H61.1667ZM18.8167 14.7333C18.2675 14.184 17.5226 13.8755 16.7459 13.8755C15.9692 13.8755 15.2243 14.184 14.675 14.7333C14.1258 15.2825 13.8173 16.0274 13.8173 16.8041C13.8173 17.5808 14.1258 18.3257 14.675 18.8749L22.725 26.8958C22.9976 27.1661 23.3208 27.3799 23.6761 27.5251C24.0315 27.6702 24.412 27.7438 24.7959 27.7416C25.5306 27.716 26.2285 27.4139 26.75 26.8958C27.0234 26.6246 27.2404 26.302 27.3885 25.9466C27.5365 25.5912 27.6128 25.21 27.6128 24.8249C27.6128 24.4399 27.5365 24.0587 27.3885 23.7032C27.2404 23.3478 27.0234 23.0252 26.75 22.7541L18.8167 14.7333ZM20.3625 36.3166C21.0616 36.3256 21.7407 36.0832 22.276 35.6335C22.8114 35.1838 23.1674 34.5567 23.2792 33.8666C23.4064 33.1091 23.2297 32.3319 22.7874 31.7039C22.345 31.0759 21.6728 30.6478 20.9167 30.5124L9.57087 28.7333C8.81869 28.641 8.06014 28.8452 7.45585 29.3025C6.85156 29.7598 6.44899 30.4343 6.33337 31.1833C6.21576 31.9449 6.40436 32.7221 6.85795 33.3451C7.31155 33.9681 7.99327 34.3863 8.7542 34.5083L19.9834 36.2874L20.3625 36.3166ZM20.5084 40.3416L10.3875 45.4749C9.80625 45.7727 9.34173 46.257 9.06839 46.8501C8.79504 47.4433 8.72869 48.111 8.87997 48.7464C9.03124 49.3817 9.39139 49.9479 9.90271 50.3543C10.414 50.7606 11.0469 50.9836 11.7 50.9874C12.1579 50.9955 12.61 50.885 13.0125 50.6666L23.1625 45.5333C23.5151 45.366 23.8306 45.1296 24.0902 44.8382C24.3498 44.5467 24.5482 44.2062 24.6738 43.8366C24.7994 43.4671 24.8495 43.0761 24.8213 42.6869C24.793 42.2976 24.6869 41.918 24.5092 41.5705C24.3316 41.223 24.086 40.9147 23.787 40.6638C23.488 40.4129 23.1417 40.2246 22.7687 40.11C22.3956 39.9954 22.0033 39.9569 21.615 39.9967C21.2268 40.0364 20.8505 40.1537 20.5084 40.3416ZM41.6542 24.6208C42.0719 24.8264 42.5303 24.9361 42.9959 24.9416C43.5345 24.94 44.0621 24.7892 44.5203 24.5061C44.9785 24.2229 45.3493 23.8184 45.5917 23.3374L50.7542 13.2458C50.9393 12.9006 51.053 12.5217 51.0885 12.1316C51.124 11.7415 51.0806 11.3483 50.9608 10.9754C50.841 10.6025 50.6474 10.2575 50.3914 9.96106C50.1354 9.66461 49.8223 9.42276 49.4709 9.24992C48.7856 8.90182 47.9906 8.83829 47.2587 9.07314C46.5269 9.30799 45.9173 9.82224 45.5625 10.5041L40.4 20.6833C40.2231 21.024 40.1152 21.3963 40.0825 21.7788C40.0498 22.1614 40.093 22.5466 40.2095 22.9124C40.326 23.2783 40.5136 23.6175 40.7615 23.9106C41.0095 24.2038 41.3128 24.4451 41.6542 24.6208ZM33.4292 23.3958H33.8959C34.2755 23.3355 34.6396 23.2008 34.967 22.9994C35.2944 22.7979 35.5788 22.5338 35.8038 22.2221C36.0287 21.9104 36.1899 21.5572 36.2779 21.183C36.3659 20.8088 36.3791 20.4209 36.3167 20.0416L34.5375 8.84159C34.4762 8.45857 34.3401 8.09137 34.1369 7.76095C33.9337 7.43054 33.6674 7.14338 33.3533 6.91588C33.0391 6.68837 32.6832 6.52498 32.3059 6.43502C31.9286 6.34506 31.5372 6.33031 31.1542 6.39159C30.7712 6.45287 30.404 6.589 30.0736 6.79219C29.7431 6.99539 29.456 7.26167 29.2285 7.57585C29.001 7.89002 28.8376 8.24592 28.7476 8.62324C28.6577 9.00056 28.6429 9.3919 28.7042 9.77492L30.5417 20.9166C30.6465 21.6071 30.9955 22.2371 31.5254 22.692C32.0553 23.147 32.7308 23.3967 33.4292 23.3958Z" fill="white" />
                            </svg>
                        </i>
                        <h5>Personalised Holidays</h5>
                        <p>Every traveler is unique — and so are our trips. From private tours to custom itineraries, we design journeys that perfectly match your interests and pace.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 why-hoose-col">
                        <i>
                            <svg width="61" height="61" viewBox="0 0 61 61" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M35.1875 12.6875C37.2586 12.6875 38.9375 11.0086 38.9375 8.9375C38.9375 6.86643 37.2586 5.1875 35.1875 5.1875C33.1164 5.1875 31.4375 6.86643 31.4375 8.9375C31.4375 11.0086 33.1164 12.6875 35.1875 12.6875Z" fill="white" />
                                <path d="M49.2406 41.7502C49.2406 41.6471 49.2406 41.5533 49.2031 41.4502L44.0375 25.9533C44.9187 25.2689 45.5 24.2096 45.5 23.0002H38L34.8031 16.8783C34.4469 16.2408 33.9125 15.7252 33.2656 15.3971L32.4125 14.9658C31.2406 14.3658 29.8344 14.4596 28.7375 15.2002C28.0625 15.6596 27.5562 16.3346 27.2938 17.1221L23.2719 28.4939C23.0938 29.0002 23 29.5252 23 30.0689C23 30.7908 23.1687 31.5033 23.4781 32.1502C23.8063 32.8252 24.2281 33.4346 24.7156 33.9877L23.9375 41.7783L17.375 51.1533H13.625L8.9375 55.8408H52.0625V41.7783H49.2406V41.7502ZM31.4375 49.2502L28.625 51.1252H22.0625L28.625 42.6877L30.0312 37.0533L34.25 38.7689L37.0625 49.2502H31.4375ZM42.6875 49.2502H40.8125L38.9375 35.1877L30.5 30.5002L33.5188 24.4627L35.1875 26.7502H41.75C41.9375 26.7502 42.125 26.7221 42.3031 26.6939L47.3187 41.7502H46.4281L42.6781 49.2502H42.6875ZM18.9781 27.2096L21.4062 28.1752C21.425 28.0627 21.4625 27.9502 21.5 27.8471L25.5219 16.4846C25.7844 15.6783 26.2531 14.9283 26.8812 14.3096L24.6875 13.3346C22.7375 12.4721 20.4687 13.3908 19.6812 15.3689L16.8969 22.3346C16.1281 24.2564 17.0562 26.4408 18.9781 27.2096Z" fill="white" />
                            </svg>
                        </i>
                        <h5>Great Value, No Compromise</h5>
                        <p>Enjoy premium experiences at the best prices. Our trusted global partnerships and transparent pricing ensure exceptional value without sacrificing quality.</p>
                    </div>
                    <div class="col-md-6 why-hoose-col">
                        <i>
                            <svg width="37" height="51" viewBox="0 0 37 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.9207 25.1277L20.9195 29.415C21.0756 29.4983 21.2464 29.5395 21.4183 29.5395C21.5902 29.5395 21.7611 29.4983 21.9161 29.415L29.9149 25.1277C32.2078 23.899 33.6327 21.5196 33.6327 18.9177V8.60391C33.6327 8.24953 33.4544 7.91941 33.1591 7.72324L21.9984 0.361523C21.6461 0.129492 21.1895 0.129492 20.8372 0.361523L9.67754 7.72324C9.38118 7.91941 9.20399 8.24953 9.20399 8.60391V18.9177C9.20399 21.5196 10.6278 23.899 12.9207 25.1277ZM28.4193 11.8028C28.8317 12.2152 28.8317 12.8828 28.4193 13.2952L22.1028 19.6117C21.9045 19.8089 21.6366 19.9207 21.3572 19.9207C21.0777 19.9207 20.8087 19.8089 20.6115 19.6117L16.609 15.6091C16.1966 15.1978 16.1966 14.5291 16.609 14.1178C17.0213 13.7054 17.689 13.7054 18.1003 14.1178L21.3572 17.3747L26.928 11.8028C27.3393 11.3914 28.007 11.3914 28.4193 11.8028ZM35.1662 30.9527C34.2802 30.263 32.9556 30.3621 31.7933 31.2059C30.8567 31.8861 29.9613 32.6392 29.0965 33.3659C27.9627 34.3193 26.8922 35.22 25.732 35.9762C24.0635 37.0646 22.2241 37.8198 20.3288 38.2121C21.1072 37.65 21.8529 37.0256 22.5627 36.3411C23.4897 35.4468 24.3598 33.8816 23.7597 32.4124C23.3948 31.518 22.4329 30.5182 19.9281 30.8409C16.8157 31.2407 13.8003 32.1867 10.9474 33.6559C10.4063 32.617 9.31895 31.9051 8.06809 31.9051H4.22481C2.43606 31.9051 0.980591 33.3606 0.980591 35.1493V47.5683C0.980591 49.357 2.43606 50.8125 4.22481 50.8125H8.06809C9.20188 50.8125 10.1996 50.2282 10.7807 49.3465C12.1339 49.4636 13.3057 49.5205 14.3931 49.5205C14.932 49.5205 15.4488 49.5068 15.9582 49.4794C20.0219 49.2589 24.0065 47.6041 27.4807 44.6953C30.1279 42.4805 33.8573 39.0063 35.6788 34.4448C36.2683 32.9661 36.0774 31.6615 35.1662 30.9527ZM33.7191 33.6622C32.9313 35.6355 31.2881 38.7574 26.1275 43.0785C23.0046 45.692 19.4482 47.177 15.8432 47.3732C14.4975 47.4459 13.0705 47.4154 11.3134 47.274V35.8507C14.1241 34.3109 17.1099 33.33 20.1981 32.9324C20.7286 32.8649 21.644 32.81 21.8075 33.2098C21.9752 33.6222 21.5702 34.3678 21.0988 34.8234C19.4081 36.4529 17.4949 37.7006 15.4108 38.5307C14.9584 38.711 14.6884 39.1782 14.7569 39.6602C14.8255 40.1422 15.2157 40.5145 15.6998 40.5609C19.5579 40.9311 23.5309 39.9302 26.8848 37.7428C28.1525 36.9159 29.3222 35.9319 30.4538 34.9806C31.2913 34.2771 32.1572 33.5494 33.0325 32.9134C33.4829 32.5864 33.8109 32.5833 33.8679 32.6139C33.9037 32.6582 33.9902 32.9841 33.7191 33.6622Z" fill="white" />
                            </svg>
                        </i>
                        <h5>24/7 Travel Support</h5>
                        <p>Travel worry-free with round-the-clock assistance. From arrival to departure, our dedicated team ensures your journey stays seamless and stress-free.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.Why Choose -->

<!-- Testimonials -->
<section class="testimonials">
    <div class="container">
        <div class="testimonials-wrap">
            <div class="heading">
                <div class="left">
                    <h3>What Our Customers Say</h3>
                    <p>Customer Reviews</p>
                </div>
            </div>
            <div class="testimonials-slider owl-carousel owl-theme">
                @forelse($testimonials as $testimonial)
                <div class="item">
                    <div class="testi-box">
                        <div class="content">
                            <p>{{ $testimonial->review }}</p>
                            <div class="user">
                                <div class="img">
                                    <img src="{{ asset($testimonial->image ?? 'assets/images/user-01.jpg') }}" alt="{{ $testimonial->name }}">
                                </div>
                                <p class="overview">
                                    <b>{{ $testimonial->name }}</b>
                                    <span>{{ $testimonial->location }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Fallback testimonials -->
                <div class="item">
                    <div class="testi-box">
                        <div class="content">
                            <p>Such an awesome experience of a one day staff trip. Golden Palace as always kept the promises and gave the best memorable experience with affordable price. Special thanks to beloved Joshi Sir and our team man Mr. Jawad.</p>
                            <div class="user">
                                <div class="img">
                                    <img src="{{ asset('assets/images/user-01.jpg') }}" alt="Ashwanth Kok">
                                </div>
                                <p class="overview">
                                    <b>Ashwanth Kok</b>
                                    <span>Calicut</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="testi-box">
                        <div class="content">
                            <p>Thanks, Golden Palace Travels and Tours for your Excellent service during our Delhi- Agra family trip. You made our complete trip very smooth and memorable. Great service from the team and best wishes for your future. Highly recommended. Once again thanks for being an author in writing our happiness.</p>
                            <div class="user">
                                <div class="img">
                                    <img src="{{ asset('assets/images/user-01.jpg') }}" alt="Ejas Ahmend">
                                </div>
                                <p class="overview">
                                    <b>Ejas Ahmend</b>
                                    <span>Malappuram</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="testi-box">
                        <div class="content">
                            <p>Exceptional tour experience with Golden Palace Travels and Tours! Knowledgeable guides, well-organized itinerary, and seamless execution. They went above and beyond to make our trip memorable. Highly recommend for anyone seeking a top-notch travel adventure.</p>
                            <div class="user">
                                <div class="img">
                                    <img src="{{ asset('assets/images/user-01.jpg') }}" alt="Alvin Thomas">
                                </div>
                                <p class="overview">
                                    <b>Alvin Thomas</b>
                                    <span>Cochin</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- /.Testimonials -->

<!-- Footer Caption -->
@include('frontend.partials.footer-caption')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Owl Carousel
        $('.attractions-slider').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });

        $('.contain-slider').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        });

        $('.testimonials-slider').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        });

        // Initialize Flatpickr for date input
        flatpickr("#when", {
            dateFormat: "Y-m-d",
            minDate: "today"
        });

        // Smooth scrolling for anchor links
        $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });
    });
</script>
@endpush