<!-- Footer -->
<footer id="footer">
    <div class="footer-container">
        <div class="subscribe-row">
            <div class="left">
                <h6>Subscribe</h6>
                <p>Join our newsletter to stay up to date on the latest events and experiences</p>
            </div>
            <div class="right">
                <form class="subscribe" action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <input type="email" class="subscribe-field" name="email" placeholder="Enter your email" required>
                    <button type="submit" class="btn">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 address-col">
                <div class="footer-logo">
                    <img src="{{ asset('assets/images/footer-logo.png') }}" alt="Good Vacation Logo">
                </div>
                <div class="contact-address">
                    <i>
                        <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M36.8556 29.1848C39.8802 24.2349 39.1041 17.8405 35.0023 13.7387C30.119 8.85544 22.18 8.83382 17.2967 13.7171C13.21 17.8038 12.4564 24.1588 15.4741 29.088L16.7171 31.1183L16.9668 31.4515C19.4041 34.7032 22.0752 37.7826 24.949 40.656C25.6401 41.3466 26.762 41.3482 27.453 40.6572C30.321 37.7901 32.9804 34.7217 35.4111 31.4755L35.655 31.1498L36.8556 29.1848Z" stroke="white" stroke-width="3"/>
                            <path d="M26.2031 28.2344C23.5107 28.2344 21.3281 26.0518 21.3281 23.3594C21.3281 20.667 23.5107 18.4844 26.2031 18.4844C28.8955 18.4844 31.0781 20.667 31.0781 23.3594C31.0781 26.0518 28.8955 28.2344 26.2031 28.2344Z" stroke="white" stroke-width="3"/>
                        </svg>
                    </i>
                    <p>
                        <b>Good Vacation</b><br>
                        South Janatha Rd, Palarivattom<br> Kochi Kerala 682025
                    </p>
                </div>
            </div>
            <div class="col-md-8 menu-col">
                <div class="row">
                    <div class="col-md-4">
                        <div class="title">Company</div>
                        <ul>
                            <li><a href="{{ route('about') }}">About</a></li>
                            <li><a href="{{ route('careers') }}">Careers</a></li>
                            <li><a href="{{ route('management') }}">Management</a></li>
                            <li><a href="{{ route('services') }}">Services</a></li>
                            <li><a href="{{ route('blog') }}">Blog</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="title">Explore</div>
                        <ul>
                            <li><a href="{{ route('destinations') }}">International Packages</a></li>
                            <li><a href="{{ route('destinations', ['type' => 'indian']) }}">Indian Packages</a></li>
                            <li><a href="{{ route('packages', ['type' => 'honeymoon']) }}">Honeymoon Packages</a></li>
                            <li><a href="{{ route('travel-guide') }}">Travel Guide</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="title">Help</div>
                        <ul>
                            <li><a href="{{ route('support') }}">Support</a></li>
                            <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms-of-service') }}">Terms of Service</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="copyright">© {{ date('Y') }} Good Vacations</div>
        </div>
    </div>
</footer>
<!-- /.Footer -->

<div class="cursor"></div>
<div id="stop" class="scrollTop">
    <span><a href="#"></a></span>
</div>
