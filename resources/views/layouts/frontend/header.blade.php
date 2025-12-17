<!-- Start Header Area  -->
<header class="rbt-header rbt-header-10 munna-header-main">
    <div class="rbt-sticky-placeholder"></div>
    <div class="rbt-header-wrapper header-space-betwween header-transparent dark-header-transparent header-sticky">
        <div class="container-fluid">
            <div class="mainbar-row rbt-navigation-start align-items-center">
                <div class="header-left rbt-header-content">
                    <div class="header-info">
                        <div class="logo logo-dark">
                            <a href="{{ route('home') }}">
                                @if(!empty($settings->site_logo))
                                    <img
                                        src="{{ asset(\Illuminate\Support\Facades\Storage::url($settings->site_logo)) }}"
                                        alt="logo">
                                @else
                                    <img src="{{ asset('frontend/assets/images/merithub/logo.png') }}"
                                         alt="Education Logo Images">
                                @endif
                            </a>
                        </div>
                        <div class="logo d-none logo-light">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('frontend/assets/images/merithub/logo.png') }}"
                                     alt="Education Logo Images">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="rbt-main-navigation d-none d-xl-block">
                    <nav class="mainmenu-nav">
                        @guest
                            <ul class="mainmenu">
                                <li><a href="{{ url('/') }}">Home</a></li>

                                <li><a href="{{ route('blogs') }}">Blogs</a></li>

                                <li><a href="{{ route('about-us') }}">About Us</a></li>

                                <li><a href="{{ route('products') }}">Products</a></li>

                                <li><a href="{{ route('pricing') }}">Pricing</a></li>


{{--                                <li class="has-custom-submenu">--}}
{{--                                    <a href="#">Resources--}}
{{--                                        <i class="feather-chevron-down"></i>--}}
{{--                                    </a>--}}
{{--                                    @if(!empty($allResource))--}}
{{--                                        <div class="custom-submenu">--}}
{{--                                            @foreach($allResource as $subjectTitle => $resource)--}}
{{--                                                @if(!empty($resource))--}}
{{--                                                    <div class="submenu-box">--}}
{{--                                                        <div class="submenu-header">{{ $subjectTitle }}</div>--}}
{{--                                                        <ul class="custom-submenu-list">--}}
{{--                                                            @foreach($resource as $subject)--}}
{{--                                                                <li class="submenu-item">--}}
{{--                                                                    <a href="{{ route('resources.topic', [$subject['education_level']['slug'], $subject['slug']]) }}">{{ $subject['education_level']['name'] }}</a>--}}
{{--                                                                </li>--}}
{{--                                                            @endforeach--}}
{{--                                                        </ul>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                </li>--}}
                                <li><a href="{{ route('past.papers') }}">Past Papers</a></li>
                            </ul>
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


                                @if(Auth::user()->type !== \App\Enums\UserType::TEACHER->value)
                                    <li>
                                        <a href="{{ route('pricing') }}">Pricing</a>
                                    </li>
                                @endif

{{--                                @can('viewResourcesSection', Auth::user())--}}
{{--                                    <li class="has-custom-submenu">--}}
{{--                                        <a href="#">Resources--}}
{{--                                            <i class="feather-chevron-down"></i>--}}
{{--                                        </a>--}}
{{--                                        @if(!empty($allResource))--}}
{{--                                            <div class="custom-submenu">--}}
{{--                                                @foreach($allResource as $subjectTitle => $resource)--}}
{{--                                                    @if(!empty($resource))--}}
{{--                                                        <div class="submenu-box">--}}
{{--                                                            <div class="submenu-header">{{ $subjectTitle }}</div>--}}
{{--                                                            <ul class="custom-submenu-list">--}}
{{--                                                                @foreach($resource as $subject)--}}
{{--                                                                    <li class="submenu-item">--}}
{{--                                                                        <a href="{{ route('resources.topic', [$subject['education_level']['slug'], $subject['slug']]) }}">{{ $subject['education_level']['name'] }}</a>--}}
{{--                                                                    </li>--}}
{{--                                                                @endforeach--}}
{{--                                                            </ul>--}}
{{--                                                        </div>--}}
{{--                                                    @endif--}}
{{--                                                @endforeach--}}
{{--                                            </div>--}}
{{--                                        @endif--}}
{{--                                    </li>--}}
{{--                                @endcan--}}
                                @can('viewPastPaperSection', Auth::user())
                                    <li>
                                        <a href="{{ route('past.papers') }}">
                                            Past Papers
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        @endauth
                    </nav>
                </div>
                <div class="header-right gap-5">
                    @guest
                        <div class="rbt-btn-wrapper d-none d-xl-block">
                            <a href="{{ route('login') }}" class="btn-style" style="background: #339E53">Login</a>
                        </div>

                        <div class="rbt-btn-wrapper d-none d-xl-block">
                            <a href="{{ route('contact-us') }}" class="btn-style">Contact Us</a>
                        </div>
                    @endguest

                    @auth
                        @can('viewProductsSection', Auth::user())
                            <div class="access-icon rbt-mini-cart">
                                <a class="rbt-cart-sidenav-activation rbt-round-btn"
                                   style="margin-top: 8px"
                                   href="{{ route('view.cart') }}">
                                    <i class="feather-shopping-cart" style="font-size: 25px"></i>
                                    <span id="merit-cart-count" class="rbt-cart-count" style="top: -5px">
                                    {{ $cartCount }}
                                </span>
                                </a>
                            </div>
                        @endcan
                        <div class="rbt-btn-wrapper d-none d-xl-block">
                            <a href="{{ route('user.dashboard') }}" class="btn-style">Dashboard</a>
                        </div>
                    @endauth
                    <!-- Start Mobile-Menu-Bar -->
                    <div class="mobile-menu-bar d-block d-xl-none">
                        <div class="hamberger">
                            <button class="hamberger-button rbt-round-btn">
                                <i class="feather-menu"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Start Mobile-Menu-Bar -->
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End Header Area  -->
