<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Kaptech Solutions' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Premium cable trays, channels, brackets and piping solutions manufactured in India.' }}">
    <meta name="author" content="Kaptech Solutions">

    <link rel="icon" href="{{ asset('rh/LOGO-03.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('rh/css/style.css') }}">

    @stack('styles')
</head>
<body>
    @include('frontend.rh.partials.topbar')
    @include('frontend.rh.partials.header')

    @yield('content')

    @include('frontend.rh.partials.footer')
    @include('frontend.rh.partials.whatsapp')

    <script src="{{ asset('rh/js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>

