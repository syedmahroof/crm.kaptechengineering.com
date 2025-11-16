@php
    $navLinks = [
        ['label' => 'Home', 'route' => route('rh.home'), 'active' => request()->routeIs('rh.home')],
        ['label' => 'About', 'route' => route('rh.about'), 'active' => request()->routeIs('rh.about')],
        ['label' => 'Products', 'route' => route('rh.products.index'), 'active' => request()->routeIs('rh.products.index') || request()->routeIs('rh.products.show')],
        ['label' => 'Contact', 'route' => route('rh.contact'), 'active' => request()->routeIs('rh.contact')],
    ];
@endphp

<header>
    <nav>
        <div class="nav-container">
            <div class="logo">
                <a href="{{ route('rh.home') }}">
                    <img src="{{ asset('rh/LOGO-03.png') }}" alt="Kaptech Logo">
                </a>
            </div>
            <ul class="nav-menu">
                @foreach ($navLinks as $link)
                    <li>
                        <a href="{{ $link['route'] }}" class="{{ $link['active'] ? 'active' : '' }}">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="menu-toggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>
</header>

