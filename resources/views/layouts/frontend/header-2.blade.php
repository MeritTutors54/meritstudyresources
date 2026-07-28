<!-- ============================= NAVBAR ============================= -->
<nav class="navbar navbar-expand-lg navbar-msr fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="brand-mark">
                <img class="new-logo" src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="logo">
            </span>
            <span class="brand-wordmark">MERIT STUDY<br><span class="l2">RESOURCES</span></span>
            {{-- @if (!empty($settings->site_logo))
                <img class="new-logo" src="{{ asset(\Illuminate\Support\Facades\Storage::url($settings->site_logo)) }}"
                    alt="logo">
            @else
                <img class="new-logo" src="{{ asset('frontend/assets/images/merithub/logo.png') }}"
                    alt="Education Logo Images">
            @endif --}}
        </a>


        <!-- Action items layout block for responsiveness -->
        <div class="d-flex align-items-center gap-2 navbar-actions-wrap">
            @auth
                <!-- Responsive Cart Button -->
                <a href="#" class="btn-cart" id="cartButton" aria-label="View Shopping Cart">
                    <svg viewBox="0 0 24 24" fill="none" width="20" height="20" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-badge" id="cartCount">0</span>
                </a>
                <a href="{{ route('user.dashboard') }}" class="btn-brand">Dashboard</a>
            @endauth

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navMain">
            @guest
                    <ul class="navbar-nav mx-auto my-3 my-lg-0">
                        <li class="nav-item"><a class="nav-link nav-link-msr" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link nav-link-msr" href="{{ route('blogs') }}">Blogs</a></li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-msr" href="{{ route('about-us') }}">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-msr" href="{{ route('products') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-msr" href="{{ route('pricing') }}">Pricing</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-msr" href="#" data-bs-toggle="dropdown" aria-expanded="true">
                                Resources
                                <svg class="dropdown-chevron" viewBox="0 0 24 24" fill="none" width="14" height="14"
                                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>
                            @if (!empty($allResource))
                                <ul class="dropdown-menu" data-bs-popper="static">
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
                            <a class="nav-link nav-link-msr" href="{{ route('past.papers') }}">
                                Past Papers
                            </a>
                        </li>
                    </ul>

                <div class="d-flex gap-2 my-2 my-lg-0 m-auto">
                    <a href="{{ route('login') }}" class="btn-ghost-navy">Login</a>
                    <a href="{{ route('contact-us') }}" class="btn-brand">Contact Us</a>
                </div>
            @endguest
        </div>


        {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button> --}}
        {{-- <div class="collapse navbar-collapse" id="navMain">
            @guest
                <ul class="navbar-nav mx-auto my-3 my-lg-0">
                    <li class="nav-item"><a class="nav-link nav-link-msr active" href="{{ url('/') }}">Home</a></li>

                    <li class="nav-item"><a class="nav-link nav-link-msr active" href="{{ route('blogs') }}">Blogs</a></li>

                    <li class="nav-item"><a class="nav-link nav-link-msr active" href="{{ route('about-us') }}">About Us</a>
                    </li>

                    <li class="nav-item"><a class="nav-link nav-link-msr active" href="{{ route('products') }}">Products</a>
                    </li>

                    <li class="nav-item"><a class="nav-link nav-link-msr active" href="{{ route('pricing') }}">Pricing</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-msr" href="#" data-bs-toggle="dropdown" aria-expanded="true">
                            Resources
                            <svg class="dropdown-chevron" viewBox="0 0 24 24" fill="none" width="14" height="14"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        @if (!empty($allResource))
                            <ul class="dropdown-menu" data-bs-popper="static">
                                @foreach ($allResource as $subjectTitle => $resource)
                                    @if (!empty($resource))
                                        <div class="nav-link-msr father-of-child">
                                            {{ $subjectTitle }}
                                        </div>
                                        @foreach ($resource as $subject)
                                            <li class="nav-item"><a class="nav-item nav-link-msr msr-child dropdown-item"
                                                    href="#">{{ $subject['education_level']['name'] }}</a></li>
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-msr active" href="{{ route('past.papers') }}">
                            Past Papers
                        </a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    {{-- <a href="#" class="btn-ghost-navy">Login</a> --}}
        {{-- <div class="access-icon rbt-mini-cart">
                        <a class="rbt-cart-sidenav-activation rbt-round-btn" style="margin-top: 8px"
                            href="{{ route('view.cart') }}">
                            <i class="feather-shopping-cart" style="font-size: 25px"></i>
                            <span id="merit-cart-count" class="rbt-cart-count" style="top: -5px">
                                {{ $cartCount }}
                            </span>
                        </a>
                    </div>
                    <a href="#" class="btn-brand">Contact Us</a>
                </div>
            @endguest
            @auth
                <ul class="mainmenu">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>

                    @can('viewBlogsSection', Auth::user())
                        <li>
                            <a href="{{ route('blogs') }}">Blogs</a>
                        </li>
                    @endcan

                    <li>
                        <a href="{{ route('about-us') }}">About Us</a>
                    </li>

                    @can('viewProductsSection', Auth::user())
                        <li>
                            <a href="{{ route('products') }}">Products</a>
                        </li>
                    @endcan


                    @if (Auth::user()->type !== \App\Enums\UserType::TEACHER->value)
                        <li>
                            <a href="{{ route('pricing') }}">Pricing</a>
                        </li>
                    @endif

                    {{-- @can('viewResourcesSection', Auth::user()) --}}
        {{-- @if (!empty($allResource))
                        <ul class="dropdown-menu" data-bs-popper="static">
                            @foreach ($allResource as $subjectTitle => $resource)
                                @if (!empty($resource))
                                    <div class="nav-link-msr father-of-child">
                                        {{ $subjectTitle }}
                                    </div>
                                    @foreach ($resource as $subject)
                                        <li class="nav-item"><a class="nav-item nav-link-msr msr-child dropdown-item"
                                                href="#">{{ $subject['education_level']['name'] }}</a></li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    @endif
                    {{-- @endcan --}}
        {{-- @can('viewPastPaperSection', Auth::user())
                        <li>
                            <a href="{{ route('past.papers') }}">
                                Past Papers
                            </a>
                        </li>
                    @endcan  --}}
        {{-- </ul> --}}


        {{-- <div class="d-flex gap-2">
                    <a href="#" class="btn-ghost-navy">Login</a>
                    <a href="#" class="btn-brand">Contact Us</a>
                </div> --}}

        {{-- @can('viewProductsSection', Auth::user())
                    <div class="access-icon rbt-mini-cart">
                        <a class="rbt-cart-sidenav-activation rbt-round-btn" style="margin-top: 8px"
                            href="{{ route('view.cart') }}">
                            <i class="feather-shopping-cart" style="font-size: 25px"></i>
                            <span id="merit-cart-count" class="rbt-cart-count" style="top: -5px">
                                {{ $cartCount }}
                            </span>
                        </a>
                    </div>
                @endcan
                <div class="rbt-btn-wrapper d-none d-xl-block">
                    <a href="{{ route('user.dashboard') }}" class="btn-brand">Dashboard</a>
                </div>
            @endauth --}}
        {{-- </div>  --}}
    </div>
</nav>
