<!-- ============================================================
    1. HEADER — utility bar (logo / search / tagline) + main nav
============================================================ -->
<header class="site-header">
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center g-3">

                <!-- Brand -->
                <div class="col-lg-4 col-6 order-1">
                    <a class="brand" href="{{ route('home') }}">
                        <img src="{{ asset('frontend/new/assets/images/logo.png')}}" alt="Merit Study Resources logo" width="60" height="60" class="brand-mark">
                        <span class="brand-text">
                            <span class="brand-name">Merit Study<br>
                                <span class="brand-name-accent">Resources</span>
                            </span>
                            <span class="brand-tagline">Learn &nbsp;Practise &nbsp;Succeed</span>
                        </span>
                    </a>
                </div>

                <!-- Site search -->
                <div class="col-lg-5 col-12 order-3 order-lg-2">
                    <form class="site-search" role="search" id="siteSearchForm" novalidate>
                        <label for="siteSearch" class="visually-hidden">Search Merit Study Resources</label>
                        <div class="search-shell">
                            <i class="bi bi-search search-icon" aria-hidden="true"></i>
                            <input type="search" class="form-control search-input" id="siteSearch"
                                   name="q" placeholder="Search for topics, past papers, or resources..."
                                   autocomplete="off">
                            <button class="btn btn-merit search-btn" type="submit">Search</button>
                        </div>
                        <p class="search-feedback" id="searchFeedback" role="status" aria-live="polite"></p>
                    </form>
                </div>

                <!-- Strapline -->
                <div class="col-lg-3 col-6 order-2 order-lg-3 text-end">
                    <p class="strapline">
                        Free Resources
                        <span class="strapline-script">for Brighter Futures</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg main-nav" aria-label="Main navigation">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#primaryNav" aria-controls="primaryNav"
                    aria-expanded="false" aria-label="Toggle navigation menu">
                <i class="bi bi-list" aria-hidden="true"></i>
                <span class="toggler-label">Menu</span>
            </button>

            <div class="collapse navbar-collapse" id="primaryNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}" aria-current="page">
                            <i class="bi bi-house-door-fill" aria-hidden="true"></i> Home
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('blogs') }}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products') }}">Product</a></li>

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Resources
                        </a>

                        @if(!empty($allResource))
                            <ul class="dropdown-menu">
                                @foreach($allResource as $subjectTitle => $resource)
                                    <li><h6 class="dropdown-header" style="padding-left: 11px; color: var(--merit-dark-green)">{{ $subjectTitle }}</h6></li>
                                    @if(!empty($resource))
                                        <div class="">
                                            @foreach($resource as $sub)
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('resources.topic', [$sub->educationLevel->slug, $sub->slug]) }}">
                                                        {{ $sub->educationLevel->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('past.papers') }}">Past Papers</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Help</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('about-us') }}">About this site</a></li>
                            <li><a class="dropdown-item" href="{{ route('contact-us') }}">Contact us</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Login & Register Buttons (Pushed to the right using ms-auto) -->
                <div class="navbar-nav ms-auto d-flex align-items-center gap-2 mt-2 mt-lg-0">
                    @auth
                        <!-- Cart Icon with Incrementable Badge -->
                        <a href="{{ route('view.cart') }}" class="btn-soft position-relative px-2.5" title="View Cart">
                            <i class="bi bi-cart3 fs-6"></i>
                            <!-- Cart count badge (update variable or dynamic count as needed) -->
                            @if(isset($cartCount) && $cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background: var(--merit-green); font-size: 0.65rem;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Dashboard Button -->
                        <a href="{{ route('user.dashboard') }}" class="btn btn-merit btn-sm px-3 py-2 d-inline-flex align-items-center gap-1">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    @else
                        <!-- Login Button -->
                        <a href="{{ route('login') }}" class="btn-soft">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>

                        <!-- Register Button -->
                        <a href="{{ route('register') }}" class="btn btn-merit btn-sm px-3 py-2">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
