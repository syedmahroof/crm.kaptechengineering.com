<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription ?? 'Explore the beautiful places around the world with Good Vacation' }}">
    <meta name="author" content="Good Vacation">
    <title>{{ $pageTitle ?? 'Good Vacation :: Your travelling partner' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/site.webmanifest') }}">


    <link rel="stylesheet" href="{{ asset('assets/css/omega.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- External CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  

    @stack('styles')
</head>

<body>
  
    @if(request()->routeIs('home'))
        @include('frontend.partials.home-header')
    @else
        @include('frontend.partials.common-header')
    @endif
    
    @yield('content')

    @include('frontend.partials.footer')

    <!-- JavaScript Libraries -->
     <!-- jQuery -->
     <script src="{{ asset('assets/js/jquery.js') }}"></script>
     <!-- <script src="assets/js/jquery.easing.min.js"></script> -->
 
     <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script> 
     <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
 
     <script>
 
         // Preloader
         window.onload = function(){
            // document.querySelector(".preloader").style.display = "none";
         }
 
         //scroll nav color
         $(window).scroll(function(){
             if ($(this).scrollTop() > 250) {
             $('.topbar').addClass('topbar-white');
             } else {
             $('.topbar').removeClass('topbar-white');
             }
         });
 
 
         //Slider
         $(function() {
             // Owl Carousel
             var owl = $(".owl-carousel.single-slider");
             owl.owlCarousel({
                 items: 1,
                 margin: 30,
                 loop: false,
                 nav: true
             });
         });
         $(function() {
             // Owl Carousel
             var owl = $(".owl-carousel.attractions-slider");
             owl.owlCarousel({
                 items: 3,
                 margin: 30,
                 loop: false,
                 dots: false,
                 nav: true,
                 responsive: {
                 0: {
                 items: 1
                 },
                 600: {
                 items: 2
                 },
                 991: {
                 items: 3
                 }
             }
             });
         });
 
         $(function() {
             // Owl Carousel
             var owl = $(".owl-carousel.contain-slider");
             owl.owlCarousel({
                 items: 4,
                 margin: 30,
                 loop: false,
                 dots: false,
                 nav: true,
                 responsive: {
                 0: {
                 items: 1
                 },
                 600: {
                 items: 2
                 },
                 991: {
                 items: 3
                 }
             }
             });
         });
         
         $(function() {
             // Owl Carousel
             var owl = $(".owl-carousel.testimonial-carousel");
             owl.owlCarousel({
                 items: 3,
                 margin: 30,
                 loop: false,
                 dots: false,
                 nav: true,
                 responsive: {
                 0: {
                 items: 1
                 },
                 660: {
                 items: 1
                 },
                 991: {
                 items: 3
                 }
             }
             });
         });
         
         $(function() {
            // Owl Carousel
            var owl = $(".owl-carousel.banner-carousel");
            owl.owlCarousel({
                items: 1,
                margin: 0,
                loop: true,
                nav: true,
                dots: false,
                autoplay: true,          // enable autoplay
                autoplayTimeout: 3000,   // 3 seconds
                autoplayHoverPause: true // pause on hover
            });
        });
 
     </script>

    @stack('scripts')
</body>
</html>
