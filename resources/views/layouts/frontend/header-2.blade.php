<!-- ============================= NAVBAR ============================= -->
<nav class="navbar navbar-expand-lg navbar-msr fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="brand-mark">
                <img class="new-logo" src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="logo">
            </span>
            <span class="brand-wordmark">MERIT STUDY<br><span class="l2">RESOURCES</span></span>
        </a>

        <!-- Mobile & Action items layout block -->
        <div class="d-flex align-items-center gap-2 navbar-actions-wrap order-lg-last">
            @auth
                <!-- Responsive Cart Button -->
                <a href="{{ route('view.cart') }}" class="btn-cart" id="cartButton" aria-label="View Shopping Cart">
                    <svg viewBox="0 0 24 24" fill="none" width="20" height="20" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-badge" id="cartCount">{{ $cartCount ?? 0 }}</span>
                </a>
                <a href="{{ route('user.dashboard') }}" class="btn-brand d-none d-lg-inline-block">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost-navy d-none d-sm-inline-block">Login</a>
                <a href="{{ route('contact-us') }}" class="btn-brand d-none d-sm-inline-block">Contact Us</a>
            @endauth

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Navigation Links (Visible for both Guest & Auth Users) -->
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav mx-auto my-3 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav-link-msr {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">Home</a>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link nav-link-msr {{ request()->routeIs('blogs') || request()->routeIs('blogs.details') ? 'active' : '' }}"
                           href="{{ route('blogs') }}">Blogs</a>
                    </li>
                @else
                    @can('viewBlogsSection', Auth::user())
                        <li class="nav-item">
                            <a class="nav-link nav-link-msr {{ request()->routeIs('blogs') || request()->routeIs('blogs.details') ? 'active' : '' }}"
                               href="{{ route('blogs') }}">Blogs</a>
                        </li>
                    @endcan
                @endguest

                <li class="nav-item">
                    <a class="nav-link nav-link-msr {{ request()->routeIs('about-us') ? 'active' : '' }}"
                       href="{{ route('about-us') }}">
                        About Us</a>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link nav-link-msr {{ request()->routeIs('products') ? 'active' : '' }}"
                           href="{{ route('products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-msr {{ request()->routeIs('pricing') ? 'active' : '' }}"
                           href="{{ route('pricing') }}">Pricing</a>
                    </li>
                @else
                    @can('viewProductsSection', Auth::user())
                        <li class="nav-item">
                            <a class="nav-link nav-link-msr {{ request()->routeIs('products') ? 'active' : '' }}"
                               href="{{ route('products') }}">Products</a>
                        </li>
                    @endcan

                    @if (Auth::user()->type !== \App\Enums\UserType::TEACHER->value)
                        <li class="nav-item">
                            <a class="nav-link nav-link-msr {{ request()->routeIs('pricing') ? 'active' : '' }}"
                               href="{{ route('pricing') }}">Pricing</a>
                        </li>
                    @endif
                @endguest

                <!-- Resources Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-msr {{ request()->routeIs('') ? 'active' : '' }}"
                       href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        Resources
                        <svg class="dropdown-chevron" viewBox="0 0 24 24" fill="none" width="14" height="14"
                             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    @if (!empty($allResource))
                        <ul class="dropdown-menu">
                            @foreach ($allResource as $subjectTitle => $resource)
                                @if (!empty($resource))
                                    <div class="nav-link-msr father-of-child">
                                        {{ $subjectTitle }}
                                    </div>
                                    @foreach ($resource as $subject)
                                        <li class="nav-item">
                                            <a class="nav-item nav-link-msr msr-child dropdown-item"
                                               href="{{ route('resources.topic', [$subject['education_level']['slug'], $subject['slug']]) }}">
                                                {{ $subject['education_level']['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-msr {{ request()->routeIs('past.papers') || request()->routeIs('past.papers.details') ? 'active' : '' }}"
                       href="{{ route('past.papers') }}">
                        Past Papers
                    </a>
                </li>
            </ul>

            @auth
                <a href="{{ route('user.dashboard') }}" class="btn-brand d-block d-lg-none">Dashboard</a>
            @endauth

            <!-- Mobile Auth Buttons (shows inside collapsed menu on small screens) -->
            @guest
                <div class="d-flex gap-2 d-sm-none my-2">
                    <a href="{{ route('login') }}" class="btn-ghost-navy w-50 text-center">Login</a>
                    <a href="{{ route('contact-us') }}" class="btn-brand w-50 text-center">Contact Us</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
