<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        {{-- External CSS libraries for frontend pages --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

        @routes
        
        {{-- Vite Assets with Smart Fallback --}}
        @php
            $manifestPath = public_path('build/manifest.json');
            $hasManifest = file_exists($manifestPath);
        @endphp
        
        @if($hasManifest)
            {{-- Use Vite helper when manifest exists (preferred method) --}}
            @viteReactRefresh
            @vite(['resources/js/app.tsx'])
        @else
            {{-- Fallback: Load assets directly if manifest doesn't exist --}}
            @php
                $cssFile = 'build/assets/app.css';
                $jsFiles = glob(public_path('build/assets/app-*.js'));
                $jsFile = !empty($jsFiles) ? 'build/assets/' . basename($jsFiles[0]) : null;
            @endphp
            
            @if(file_exists(public_path($cssFile)))
                <link rel="stylesheet" href="{{ asset($cssFile) }}">
            @endif
            
            @if($jsFile && file_exists(public_path($jsFile)))
                <script type="module" src="{{ asset($jsFile) }}"></script>
            @endif
        @endif
        
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
