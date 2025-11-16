<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>The Complete Piping Solution - Your trusted partner for quality cable trays, channels, brackets and piping solutions.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="Twitter">𝕏</a>
                    <a href="#" aria-label="LinkedIn">in</a>
                    <a href="#" aria-label="Instagram">📷</a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('rh.home') }}">Home</a></li>
                    <li><a href="{{ route('rh.about') }}">About Us</a></li>
                    <li><a href="{{ route('rh.products.index') }}">Products</a></li>
                    <li><a href="{{ route('rh.contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Products</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('rh.products.index') }}#cable-trays">Cable Trays</a></li>
                    <li><a href="{{ route('rh.products.index') }}#channels-brackets">Channels & Brackets</a></li>
                    <li><a href="{{ route('rh.products.index') }}#accessories">Accessories</a></li>
                    <li><a href="{{ route('rh.products.index') }}">Custom Solutions</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <p>📧 info@kaptechsolutions.com</p>
                <p>📞 +91-9744629000</p>
                <p>📍 No. 7/6, Silver Streak, Venkatappa Road, Tasker Town, Bangalore North, Bangalore, Karnataka - 560051</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ now()->year }} Kaptech Tray and Pipe Supports Private Limited. All rights reserved.</p>
        </div>
    </div>
</footer>

