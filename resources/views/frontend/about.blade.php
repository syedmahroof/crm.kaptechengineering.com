@extends('layouts.frontend')

@section('content')
<!-- About Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="img">
            <img src="{{ asset('assets/images/about-ban.jpg') }}" alt="">
        </div>
        <div class="text-center">
            <h1>Where Journeys Become Stories</h1>
            <p>We don't just plan trips – we craft chapters of your life's greatest adventure</p>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="subpage-content" >
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3>The Spark That Lit Our Compass</h3>
                <p>
                    In 2010, a group of passionate travelers sat in a tiny Kochi café, dreaming of a world where travel wasn't just about destinations, but about the stories that change us. That spark of inspiration became Good Vacation – not just a travel company, but a storyteller, a dream weaver, and a bridge between cultures.
                </p>
                <p>
                    From our first booking – a couple's honeymoon to Bali – to orchestrating grand adventures across seven continents, we've learned that the best journeys are those that leave footprints on your heart. We've witnessed proposals under the Northern Lights, family reunions on tropical beaches, and solo travelers finding themselves in the most unexpected places.
                </p>
                <p>
                    Today, with every itinerary we craft, we're not just planning trips; we're setting the stage for life's most extraordinary moments. Because to us, you're not just a traveler – you're the main character in your own epic story.
                </p>
                <a href="{{ route('contact') }}" class="btn">Let's Write Your Next Chapter</a>
            </div>
            <div class="col-md-6">
                <div class="img">
                    <img src="{{ asset('assets/images/about-story.jpg') }}" alt="Our Story" >
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="subpage-content mission-vision-section light-bg" >
    <div class="container">
        <h3>Our Compass & Constellation</h3>
        <p class="para-lg">
            In a world that often feels divided, we believe in the magic of travel to weave humanity closer together, one journey at a time.
        </p>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <h4>Why We Wake Up Every Morning</h4>
                    <p>
                        We exist to turn 'someday' into 'right now.' Our mission is to break down the barriers between you and your dreams, crafting experiences that don't just show you the world, but change how you see it.
                    </p>
                    <p>
                        We're not in the business of selling vacations – we're in the business of creating transformations. Whether it's helping you conquer a fear, celebrate a milestone, or simply press pause on life's chaos, we're here to make it extraordinary.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h4>The Horizon We're Chasing</h4>
                    <p>
                        We dream of a world where travel isn't just about the places you go, but who you become along the way. Where every journey leaves you – and the places you visit – better than before.
                    </p>
                    <p>
                        Our North Star? A future where borders are just lines on a map, where every culture is celebrated, and where the most valuable souvenir you bring home is a broader perspective and a more open heart.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="subpage-content primary-sec statistics-section">
    <div class="container">
        <h3>Moments That Count</h3>
        <p class="para-lg">
            Behind every number is a story – a family's laughter, a solo traveler's courage, a couple's promise. Here's a glimpse of the joy we've been privileged to be part of.
        </p>
        <div class="row text-center counter">
            <div class="col-md-3">
                <div class="card stat-item">
                    <h3>10+</h3>
                    <p>Years of Excellence</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-item">
                    <h3>50,000+</h3>
                    <p>Happy Travelers</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-item">
                    <h3>100+</h3>
                    <p>Destinations</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-item">
                    <h3>150+</h3>
                    <p>Travel Experts</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="subpage-content">
    <div class="container">
        <h3>Why Travelers Trust Us With Their Dreams</h3>
        <p class="para-lg">
            In a world of ordinary, we believe in crafting experiences that make your heart race and your soul sing.
        </p>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <h4>Storytellers, Not Salespeople</h4>
                    <p>
                        We don't just book trips; we craft narratives. Our travel designers are modern-day explorers who've walked the paths they recommend, ensuring every detail tells part of your unique story.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h4>Your Safety Net</h4>
                    <p>
                        We've got your back, always. From 24/7 emergency support to local contacts in every destination, we're your safety net so you can leap into adventure with confidence.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h4>Value Beyond Price Tags</h4>
                    <p>
                        We're not the cheapest, and we're proud of that. Because while others cut corners, we're busy adding value – exclusive experiences, local connections, and memories that outlast any price tag.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Caption -->
@include('frontend.partials.footer-caption')
@endsection