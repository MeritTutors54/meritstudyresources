<header class="rbt-header rbt-header-10">

    <div class="rbt-sticky-placeholder"></div>
    <!-- Start Header Top  -->
    <div
        class="rbt-header-top rbt-header-top-1 header-space-betwween bg-not-transparent bg-color-darker top-expended-activation">
        <div class="container-fluid">
            <div class="top-expended-wrapper">
                <div class="top-expended-inner rbt-header-sec align-items-center ">
                    <div class="rbt-header-sec-col rbt-header-left d-none d-xl-block">
                        <div class="rbt-header-content">
                            <!-- Start Header Information List  -->
                            <div class="header-info">
                                <ul class="rbt-information-list">
                                    <li>
                                        <a href="mailto:{{ $companyInformation->email }}">
                                            <i class="feather-email"></i>{{ $companyInformation->email }}
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <!-- End Header Information List  -->
                        </div>
                    </div>
                    <div class="rbt-header-sec-col rbt-header-center">
                        <div class="rbt-header-content justify-content-start justify-content-xl-center">
                            <div class="header-info">
                                <div class="rbt-header-top-news">
                                    <div class="inner">
                                        <div class="content">
                                            {{--
                                            <span
                                                class="rbt-badge variation-02 bg-color-primary color-white radius-round">Hot</span>
                                            <span class="news-text"><img src="{{ asset('frontend') }}/assets/images/icons/hand-emojji.svg"
                                                    alt="Hand Emojji Images"> Intro price. Get Histudy for Big Sale
                                                -95% off.</span>
                                            --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rbt-header-sec-col rbt-header-right mt_md--10 mt_sm--10">
                        <div class="rbt-header-content justify-content-start justify-content-lg-end">
                            <div class="header-info d-none d-xl-block">
                                <ul class="social-share-transparent">
                                    <li>
                                        <a href="{{ $social->facebook }}"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ $social->twitter }}"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ $social->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ $social->youtube }}"><i class="fab fa-youtube"></i></a>
                                    </li>
                                </ul>
                            </div>
                            {{--
                           <div class="rbt-separator d-none d-xl-block"></div>

                           <div class="header-info">
                               <ul class="rbt-dropdown-menu switcher-language">
                                   <li class="has-child-menu">
                                       <a href="#">
                                           <img class="left-image" src="{{ asset('frontend') }}/assets/images/icons/en-us.png"
                                               alt="Language Images">
                                           <span class="menu-item">English</span>
                                           <i class="right-icon feather-chevron-down"></i>
                                       </a>
                                       <ul class="sub-menu">
                                           <li>
                                               <a href="#">
                                                   <img class="left-image" src="{{ asset('frontend') }}/assets/images/icons/fr.png"
                                                       alt="Language Images">
                                                   <span class="menu-item">Français</span>
                                               </a>
                                           </li>
                                           <li>
                                               <a href="#">
                                                   <img class="left-image" src="{{ asset('frontend') }}/assets/images/icons/de.png"
                                                       alt="Language Images">
                                                   <span class="menu-item">Deutsch</span>
                                               </a>
                                           </li>
                                       </ul>
                                   </li>
                               </ul>
                           </div>

                           <div class="header-info">
                               <ul class="rbt-dropdown-menu currency-menu">
                                   <li class="has-child-menu">
                                       <a href="#">
                                           <span class="menu-item">USD</span>
                                           <i class="right-icon feather-chevron-down"></i>
                                       </a>
                                       <ul class="sub-menu hover-reverse">
                                           <li>
                                               <a href="#">
                                                   <span class="menu-item">EUR</span>
                                               </a>
                                           </li>
                                           <li>
                                               <a href="#">
                                                   <span class="menu-item">GBP</span>
                                               </a>
                                           </li>
                                       </ul>
                                   </li>
                               </ul>
                           </div>
                            --}}


                        </div>
                    </div>
                </div>
                <div class="header-info">
                    <div class="top-bar-expended d-block d-lg-none">
                        <button class="topbar-expend-button rbt-round-btn"><i class="feather-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top  -->
    <div class="rbt-header-wrapper header-space-betwween header-sticky">
        <div class="container-fluid">
            <div class="mainbar-row rbt-navigation-center align-items-center">
                <div class="header-left rbt-header-content">
                    <div class="header-info">
                        <div class="logo logo-dark">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('uploads/logo/'.$logo->logo) }}" alt="Merit Hub Logo Images">
                            </a>
                        </div>
                        <div class="logo d-none logo-light">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('uploads/logo/'.$logo->logo) }}" alt="Merit Hub Logo Images">
                            </a>
                        </div>
                    </div>
                    <div class="header-info">
                        <div class="rbt-category-menu-wrapper rbt-category-update">

                            <div class="rbt-category-btn">
                                <div class="rbt-offcanvas-trigger md-size icon">
                                    <span class="d-none d-xl-block">
                                        <i class="feather-grid"></i>
                                    </span>
                                    <i title="Category" class="feather-grid d-block d-xl-none"></i>
                                </div>
                                <span class="category-text d-none d-xl-block">Resources</span>
                            </div>
                            <div class="category-dropdown-menu d-none d-xl-block">
                                <div class="category-menu-item">
                                    <div class="rbt-vertical-nav">
                                        <ul class="rbt-vertical-nav-list-wrapper vertical-nav-menu">
                                            @foreach ($allCategory as $key => $category)
                                                <li class="vertical-nav-item">
                                                    <a href="#tab{{ ++$key }}">{{ $category->category_name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="rbt-vertical-nav-content">
                                        @foreach ($allCategory as $catekey => $category)
                                            <div class="rbt-vertical-inner tab-content" id="tab{{ ++$catekey }}"
                                                 style="display: block">
                                                <div class="rbt-vertical-single">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-sm-12 col-12">
                                                            <div class="vartical-nav-content-menu">
                                                                <h3 class="rbt-short-title">{{ $category->category_name }}</h3>
                                                                <ul class="rbt-vertical-nav-list-wrapper">
                                                                    @php
                                                                        $allSubcategory=App\Models\SubCategory::where('category_id',$category->id)->where('is_deleted',0)->where('is_active',1)->select(['subcategory_name','id','slug'])->get();
                                                                    @endphp
                                                                    @foreach ($allSubcategory as $subcategory)
                                                                        <li>
                                                                            <a href="{{ url('resources') }}/{{ $category->slug}}/{{ $subcategory->slug }}">{{ $subcategory->subcategory_name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <!-- End category Area  -->
                        </div>
                    </div>
                </div>

                <div class="rbt-main-navigation d-none d-xl-block">
                    <nav class="mainmenu-nav">
                        <ul class="mainmenu">
                            <li class="with-megamenu has-menu-child-item position-static">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="with-megamenu has-menu-child-item">
                                <a href="{{ url('/about-us') }}">About Us</a>
                            </li>
                            <li class="has-dropdown has-menu-child-item">
                                <a href="#">Past Papers
                                    <i class="feather-chevron-down"></i>
                                </a>
                                <ul class="submenu">
                                    @foreach ($allCategory as $catekey => $category)
                                        <li class="has-dropdown"><a href="#">{{ $category->category_name }}</a>
                                            <ul class="submenu">
                                                @php
                                                    $allSubcategory=App\Models\SubCategory::where('category_id',$category->id)->where('is_deleted',0)->where('is_active',1)->select(['subcategory_name','id','slug'])->get();
                                                @endphp
                                                @foreach ($allSubcategory as $subcategory)
                                                    <li>
                                                        <a href="{{ url('resources') }}/{{ $category->slug}}/{{ $subcategory->slug }}">{{ $subcategory->subcategory_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach

                                </ul>
                            </li>

                            {{-- <li class="has-dropdown has-menu-child-item">
                                <a href="#">Pricing
                                    <i class="feather-chevron-down"></i>
                                </a>
                                <ul class="submenu">
                                    <li class="has-dropdown"><a href="{{ url('/schools-pricing') }}">Schools</a>

                                    </li>
                                    <li class="has-dropdown"><a href="{{ url('/individuals-pricing') }}">Individuals</a>

                                    </li>
                                </ul>
                            </li> --}}

                            <li class="has-dropdown has-menu-child-item">
                                <a href="#">Pages
                                    <i class="feather-chevron-down"></i>
                                </a>
                                <ul class="submenu">
                                    <li class=""><a href="{{ url('/blogs') }}">Blogs</a></li>
                                    <li class=""><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                                    <li class=""><a href="{{ url('/terms-condition') }}">Terms Condition</a></li>
                                    <li class=""><a target="__blank" href="https://merittutors.co.uk/">Tuition
                                            Centre</a></li>
                                    <li class=""><a target="__blank"
                                                    href="https://www.examcentrelondon.co.uk/ucas-registered-centre">Ucas
                                            Application</a></li>
                                    <li class="has-dropdown"><a href="#">Exam Centre London</a>
                                        <ul class="submenu">
                                            <li><a target="__blank"
                                                   href="https://www.examcentrelondon.co.uk/gcse-exams">GCSE</a></li>
                                            <li><a target="__blank"
                                                   href="https://www.examcentrelondon.co.uk/igcse-exams">IGCSE</a></li>
                                            <li><a target="__blank"
                                                   href="https://www.examcentrelondon.co.uk/a-level-exams">A Level</a>
                                            </li>
                                            <li><a target="__blank"
                                                   href="https://www.examcentrelondon.co.uk/exam-booking-aslevel">AS
                                                    Level</a></li>
                                            <li><a target="__blank" href="https://www.examcentrelondon.co.uk/aat-exams">AAT</a>
                                            </li>
                                            <li><a target="__blank"
                                                   href="https://www.examcentrelondon.co.uk/acca-exams">ACCA</a></li>
                                            <li><a target="__blank"
                                                   href="https://www.examcentrelondon.co.uk/functional-skills-exams">Functional
                                                    Skills</a></li>
                                            <li><a target="__blank"
                                                   href="https://www.examcentrelondon.co.uk/proctor-exam-details">Proctor
                                                    Exam</a></li>
                                            <li><a target="__blank"
                                                   href="https://www.examcentrelondon.co.uk/iseb-details">ISEB Exam</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            {{-- <li class="with-megamenu has-menu-child-item position-static">
                                <a href="#">Pages <i class="feather-chevron-down"></i></a>

                                <div class="rbt-megamenu grid-item-3">
                                    <div class="wrapper">
                                        <div class="row row--15 single-dropdown-menu-presentation">
                                            <div class="col-lg-4 col-xxl-4 single-mega-item">
                                                <ul class="mega-menu-item">
                                                    <li><a href="style-guide.html">Style Guide <span
                                                                class="rbt-badge-card">Hot</span></a></li>
                                                    <li><a href="accordion.html">Accordion</a></li>
                                                    <li><a href="advancetab.html">Advance Tab</a></li>
                                                    <li><a href="about.html">About <span
                                                                class="rbt-badge-card">New</span></a></li>
                                                    <li><a href="brand.html">Brand</a></li>
                                                    <li><a href="button.html">Button</a></li>
                                                    <li><a href="badge.html">Badge</a></li>
                                                    <li><a href="card.html">Card</a></li>
                                                    <li><a href="#">& More Coming</a></li>
                                                </ul>
                                            </div>

                                            <div class="col-lg-4 col-xxl-4 single-mega-item">
                                                <ul class="mega-menu-item">
                                                    <li><a href="call-to-action.html">Call To Action</a></li>
                                                    <li><a href="counterup.html">Counter</a></li>
                                                    <li><a href="category.html">Categories</a></li>
                                                    <li><a href="header.html">Header Style</a></li>
                                                    <li><a href="newsletter.html">Newsletter</a></li>
                                                    <li><a href="team.html">Team</a></li>
                                                    <li><a href="social.html">Social</a></li>
                                                    <li><a href="list-style.html">List Style</a></li>
                                                    <li><a href="#">& More Coming</a></li>
                                                </ul>
                                            </div>

                                            <div class="col-lg-4 col-xxl-4 single-mega-item">
                                                <ul class="mega-menu-item">
                                                    <li><a href="gallery.html">Gallery</a></li>
                                                    <li><a href="pricing.html">Pricing</a></li>
                                                    <li><a href="progressbar.html">Progressbar</a></li>
                                                    <li><a href="testimonial.html">Testimonial</a></li>
                                                    <li><a href="service.html">Service</a></li>
                                                    <li><a href="split.html">Split Area</a></li>
                                                    <li><a href="search.html">Search Style</a></li>
                                                    <li><a href="instagram.html">Instagram Style</a></li>
                                                    <li><a href="#">& More Coming</a></li>
                                                </ul>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="btn-wrapper">
                                                    <a class="rbt-btn btn-gradient hover-icon-reverse square btn-xl w-100 text-center mt--30 hover-transform-none"
                                                        href="#">
                                                        <span class="icon-reverse-wrapper">
                                                            <span class="btn-text">Visit Histudy Template</span>
                                                            <span class="btn-icon"><i
                                                                    class="feather-arrow-right"></i></span>
                                                            <span class="btn-icon"><i
                                                                    class="feather-arrow-right"></i></span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </li> --}}
                            <li class="with-megamenu has-menu-child-item position-static">
                                <a href="{{ url('/contact') }}">Contact</a>
                            </li>


                        </ul>
                    </nav>
                </div>

                <div class="header-right">

                    <!-- Navbar Icons -->
                    <ul class="quick-access">
                        {{-- <li class="access-icon">
                            <a class="search-trigger-active rbt-round-btn" href="#">
                                <i class="feather-search"></i>
                            </a>
                        </li> --}}

                        {{-- <li class="access-icon rbt-mini-cart">
                            <a class="rbt-cart-sidenav-activation rbt-round-btn" href="#">
                                <i class="feather-shopping-cart"></i>
                                <span class="rbt-cart-count">0</span>
                            </a>
                        </li> --}}

                        @if(Auth::user())
                            {{-- <li class="account-access rbt-user-wrapper d-none d-xl-block">

                                <a href="{{ url('/dashboard') }}"><i class="feather-user"></i>Dashboard</a>
                                <div class="rbt-user-menu-list-wrapper">
                                    <div class="inner">
                                        <div class="rbt-admin-profile">
                                            <div class="admin-thumbnail">
                                                <img src="{{ asset('frontend') }}/assets/images/team/avatar.jpg" alt="User Images">
                                            </div>
                                            <div class="admin-info">
                                                <span class="name">{{ Auth::user()->name }}</span>
                                                <a class="rbt-btn-link color-primary" href="{{ url('/profile') }}">View
                                                    Profile</a>
                                            </div>
                                        </div>
                                        <ul class="user-list-wrapper">
                                            <li>
                                                <a href="{{ url('/dashboard') }}">
                                                    <i class="feather-home"></i>
                                                    <span>My Dashboard</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/profile') }}">
                                                    <i class="feather-bookmark"></i>
                                                    <span>Profile</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/download-history') }}">
                                                    <i class="feather-shopping-bag"></i>
                                                    <span>Download History</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/wishlist') }}">
                                                    <i class="feather-heart"></i>
                                                    <span>Wishlist</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/subcription-details') }}">
                                                    <i class="feather-star"></i>
                                                    <span>Subscription List</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/purchase-history') }}">
                                                    <i class="feather-list"></i>
                                                    <span>Purchase History</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/edit-profile') }}">
                                                    <i class="feather-clock"></i>
                                                    <span>Update Profile</span>
                                                </a>
                                            </li>

                                        </ul>
                                        <hr class="mt--10 mb--10">
                                        <ul class="user-list-wrapper">
                                            <li>
                                                <a href="{{ url('/logout') }}">
                                                    <i class="feather-log-out"></i>
                                                    <span>Logout</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li> --}}
                        @else
                            {{-- <li class="account-access rbt-user-wrapper d-none d-xl-block">

                                <a href="{{ url('/login') }}"><i class="feather-user"></i>Login</a>

                            </li>
                            <li class="access-icon rbt-user-wrapper d-block d-xl-none">
                                <a class="rbt-round-btn" href="#"><i class="feather-user"></i></a>
                                <div class="rbt-user-menu-list-wrapper">
                                    <div class="inner">
                                        <div class="rbt-admin-profile">
                                            <div class="admin-thumbnail">
                                                <img src="{{ asset('frontend') }}/assets/images/team/avatar.jpg" alt="User Images">
                                            </div>
                                            <div class="admin-info">
                                                <span class="name">Fazlay Elahi Rafi</span>
                                                <a class="rbt-btn-link color-primary" href="profile.html">View
                                                    Profile</a>
                                            </div>
                                        </div>
                                        <ul class="user-list-wrapper">
                                            <li>
                                                <a href="instructor-dashboard.html">
                                                    <i class="feather-home"></i>
                                                    <span>My Dashboard</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="feather-bookmark"></i>
                                                    <span>Bookmark</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="instructor-enrolled-courses.html">
                                                    <i class="feather-shopping-bag"></i>
                                                    <span>Enrolled Courses</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="instructor-wishlist.html">
                                                    <i class="feather-heart"></i>
                                                    <span>Wishlist</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="instructor-reviews.html">
                                                    <i class="feather-star"></i>
                                                    <span>Reviews</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="instructor-my-quiz-attempts.html">
                                                    <i class="feather-list"></i>
                                                    <span>My Quiz Attempts</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="instructor-order-history.html">
                                                    <i class="feather-clock"></i>
                                                    <span>Order History</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="instructor-quiz-attempts.html">
                                                    <i class="feather-message-square"></i>
                                                    <span>Question & Answer</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <hr class="mt--10 mb--10">
                                        <ul class="user-list-wrapper">
                                            <li>
                                                <a href="#">
                                                    <i class="feather-book-open"></i>
                                                    <span>Getting Started</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <hr class="mt--10 mb--10">
                                        <ul class="user-list-wrapper">
                                            <li>
                                                <a href="instructor-settings.html">
                                                    <i class="feather-settings"></i>
                                                    <span>Settings</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="index.html">
                                                    <i class="feather-log-out"></i>
                                                    <span>Logout</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li> --}}
                        @endif

                    </ul>
                    @if(Auth::user())
                    @else
                        {{-- <div class="rbt-btn-wrapper d-none d-xl-block">
                            <a class="rbt-btn rbt-marquee-btn marquee-auto btn-border-gradient radius-round btn-sm hover-transform-none"
                                href="{{ url('/register') }}">
                                <span data-text="Enroll Now">Register</span>
                            </a>
                        </div> --}}
                    @endif

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
        <!-- Start Search Dropdown  -->
        <div class="rbt-search-dropdown">
            <div class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="#">
                            <input type="text" placeholder="What are you looking for?">
                            <div class="submit-btn">
                                <a class="rbt-btn btn-gradient btn-md" href="#">Search</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="rbt-separator-mid">
                    <hr class="rbt-separator m-0">
                </div>

                <div class="row g-4 pt--30 pb--60">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h5 class="rbt-title-style-2">Our Top Course</h5>
                        </div>
                    </div>

                    <!-- Start Single Card  -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="course-details.html">
                                    <img src="{{ asset('frontend') }}/assets/images/course/course-online-01.jpg"
                                         alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <h5 class="rbt-card-title"><a href="course-details.html">React Js</a>
                                </h5>
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (15 Reviews)</span>
                                </div>
                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$15</span>
                                        <span class="off-price">$25</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->

                    <!-- Start Single Card  -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="course-details.html">
                                    <img src="{{ asset('frontend') }}/assets/images/course/course-online-02.jpg"
                                         alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <h5 class="rbt-card-title"><a href="course-details.html">Java Program</a>
                                </h5>
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (15 Reviews)</span>
                                </div>
                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$10</span>
                                        <span class="off-price">$40</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->

                    <!-- Start Single Card  -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="course-details.html">
                                    <img src="{{ asset('frontend') }}/assets/images/course/course-online-03.jpg"
                                         alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <h5 class="rbt-card-title"><a href="course-details.html">Web Design</a>
                                </h5>
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (15 Reviews)</span>
                                </div>
                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$10</span>
                                        <span class="off-price">$20</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->

                    <!-- Start Single Card  -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="course-details.html">
                                    <img src="{{ asset('frontend') }}/assets/images/course/course-online-04.jpg"
                                         alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <h5 class="rbt-card-title"><a href="course-details.html">Web Design</a>
                                </h5>
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (15 Reviews)</span>
                                </div>
                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$20</span>
                                        <span class="off-price">$40</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->
                </div>

            </div>
        </div>
        <!-- End Search Dropdown  -->
    </div>
    <!-- Start Side Vav -->
    <div class="rbt-offcanvas-side-menu rbt-category-sidemenu">
        <div class="inner-wrapper">
            <div class="inner-top">
                <div class="inner-title">
                    <h4 class="title">Course Category</h4>
                </div>
                <div class="rbt-btn-close">
                    <button class="rbt-close-offcanvas rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
            <nav class="side-nav w-100">
                <ul class="rbt-vertical-nav-list-wrapper vertical-nav-menu">
                    <li class="vertical-nav-item">
                        <a href="#">Course School</a>
                        <div class="vartical-nav-content-menu-wrapper">
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Web Design</a></li>
                                    <li><a href="#">Art</a></li>
                                    <li><a href="#">Figma</a></li>
                                    <li><a href="#">Adobe</a></li>
                                </ul>
                            </div>
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Photo</a></li>
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">Math</a></li>
                                    <li><a href="#">Read</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="vertical-nav-item">
                        <a href="#">Online School</a>
                        <div class="vartical-nav-content-menu-wrapper">
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Photo</a></li>
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">Math</a></li>
                                    <li><a href="#">Read</a></li>
                                </ul>
                            </div>
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Web Design</a></li>
                                    <li><a href="#">Art</a></li>
                                    <li><a href="#">Figma</a></li>
                                    <li><a href="#">Adobe</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="vertical-nav-item">
                        <a href="#">kindergarten</a>
                        <div class="vartical-nav-content-menu-wrapper">
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Photo</a></li>
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">Math</a></li>
                                    <li><a href="#">Read</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="vertical-nav-item">
                        <a href="#">Classic LMS</a>
                        <div class="vartical-nav-content-menu-wrapper">
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Web Design</a></li>
                                    <li><a href="#">Art</a></li>
                                    <li><a href="#">Figma</a></li>
                                    <li><a href="#">Adobe</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="read-more-btn">
                    <div class="rbt-btn-wrapper mt--20">
                        <a class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none w-100 justify-content-center text-center"
                           href="#">
                            <span>Learn More</span>
                        </a>
                    </div>
                </div>
            </nav>
            <div class="rbt-offcanvas-footer">

            </div>
        </div>
    </div>
    <!-- End Side Vav -->
    <a class="rbt-close_side_menu" href="javascript:void(0);"></a>

</header>
<div class="popup-mobile-menu">
    <div class="inner-wrapper">
        <div class="inner-top">
            <div class="content">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('uploads/logo/'.$logo->logo) }}" alt="MeritStudyResource Logo Images">
                    </a>
                </div>
                <div class="rbt-btn-close">
                    <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
            <p class="description">Merit Study Resource Examiner-crafted revision resources designed to double your grades</p>
            <ul class="navbar-top-left rbt-information-list justify-content-start">
                <li>
                    <a href="mailto:{{ $companyInformation->email }}"><i
                            class="feather-mail"></i>{{ $companyInformation->email }}</a>
                </li>

            </ul>
        </div>

        <nav class="mainmenu-nav">
            <ul class="mainmenu">
                <li class=""><a href="{{ url('/') }}">Home</a></li>

{{--                <li class=""><a href="{{ url('/about-us') }}">About Us </a></li>--}}

                <li class="has-dropdown has-menu-child-item">
                    <a href="#">Past Papers
                        <i class="feather-chevron-down"></i>
                    </a>
                    <ul class="submenu">
                        @foreach ($allCategory as $catekey => $category)
                            <li class="has-dropdown"><a href="#">{{ $category->category_name }}</a>
                                <ul class="submenu">
                                    @php
                                        $allSubcategory=App\Models\SubCategory::where('category_id',$category->id)->where('is_deleted',0)->where('is_active',1)->select(['subcategory_name','id','slug'])->get();
                                    @endphp
                                    @foreach ($allSubcategory as $subcategory)
                                        <li>
                                            <a href="{{ url('resources') }}/{{ $category->slug}}/{{ $subcategory->slug }}">{{ $subcategory->subcategory_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="has-dropdown has-menu-child-item">
                    <a href="#">Pages
                        <i class="feather-chevron-down"></i>
                    </a>
                    <ul class="submenu">
                        <li class=""><a href="{{ url('/blogs') }}">Blogs</a></li>
                        <li class=""><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                        <li class=""><a href="{{ url('/terms-condition') }}">Terms Condition</a></li>
                        <li class=""><a target="__blank" href="https://merittutors.co.uk/">Tuition Centre</a></li>
                        <li class=""><a target="__blank"
                                        href="https://www.examcentrelondon.co.uk/ucas-registered-centre">Ucas
                                Application</a></li>
                        <li class="has-dropdown"><a href="#">Exam Centre London</a>
                            <ul class="submenu">
                                <li><a target="__blank" href="https://www.examcentrelondon.co.uk/gcse-exams">GCSE</a>
                                </li>
                                <li><a target="__blank" href="https://www.examcentrelondon.co.uk/igcse-exams">IGCSE</a>
                                </li>
                                <li><a target="__blank" href="https://www.examcentrelondon.co.uk/a-level-exams">A
                                        Level</a></li>
                                <li><a target="__blank" href="https://www.examcentrelondon.co.uk/exam-booking-aslevel">AS
                                        Level</a></li>
                                <li><a target="__blank" href="https://www.examcentrelondon.co.uk/aat-exams">AAT</a></li>
                                <li><a target="__blank" href="https://www.examcentrelondon.co.uk/acca-exams">ACCA</a>
                                </li>
                                <li><a target="__blank"
                                       href="https://www.examcentrelondon.co.uk/functional-skills-exams">Functional
                                        Skills</a></li>
                                <li><a target="__blank" href="https://www.examcentrelondon.co.uk/proctor-exam-details">Proctor
                                        Exam</a></li>
                                <li><a target="__blank" href="https://www.examcentrelondon.co.uk/iseb-details">ISEB
                                        Exam</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="with-megamenu has-menu-child-item position-static">
                    <a href="{{ url('/contact') }}">Contact</a>
                </li>
            </ul>
        </nav>

        <div class="mobile-menu-bottom">
            <div class="social-share-wrapper">
                <span class="rbt-short-title d-block">Find With Us</span>
                <ul class="social-icon social-default transparent-with-border justify-content-start mt--20">
                    <li><a href="{{ $social->facebook }}">
                            <i class="feather-facebook"></i>
                        </a>
                    </li>
                    <li><a href="{{ $social->twitter }}">
                            <i class="feather-twitter"></i>
                        </a>
                    </li>
                    <li><a href="{{ $social->youtube }}">
                            <i class="feather-instagram"></i>
                        </a>
                    </li>
                    <li><a href="{{ $social->linkend }}">
                            <i class="feather-linkedin"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
<!-- Start Side Vav -->
<div class="rbt-cart-side-menu">
    <div class="inner-wrapper">
        <div class="inner-top">
            <div class="content">
                <div class="title">
                    <h4 class="title mb--0">Your shopping cart</h4>
                </div>
                <div class="rbt-btn-close" id="btn_sideNavClose">
                    <button class="minicart-close-button rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
        </div>
        <nav class="side-nav w-100">
            <ul class="rbt-minicart-wrapper">
                <li class="minicart-item">
                    <div class="thumbnail">
                        <a href="#">
                            <img src="{{ asset('frontend') }}/assets/images/product/1.jpg" alt="Product Images">
                        </a>
                    </div>
                    <div class="product-content">
                        <h6 class="title"><a href="single-product.html">Miracle Morning</a></h6>

                        <span class="quantity">1 * <span class="price">$22</span></span>
                    </div>
                    <div class="close-btn">
                        <button class="rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </li>

                <li class="minicart-item">
                    <div class="thumbnail">
                        <a href="#">
                            <img src="{{ asset('frontend') }}/assets/images/product/7.jpg" alt="Product Images">
                        </a>
                    </div>
                    <div class="product-content">
                        <h6 class="title"><a href="single-product.html">Happy Strong</a></h6>

                        <span class="quantity">1 * <span class="price">$30</span></span>
                    </div>
                    <div class="close-btn">
                        <button class="rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </li>

                <li class="minicart-item">
                    <div class="thumbnail">
                        <a href="#">
                            <img src="{{ asset('frontend') }}/assets/images/product/3.jpg" alt="Product Images">
                        </a>
                    </div>
                    <div class="product-content">
                        <h6 class="title"><a href="single-product.html">Rich Dad Poor Dad</a></h6>

                        <span class="quantity">1 * <span class="price">$50</span></span>
                    </div>
                    <div class="close-btn">
                        <button class="rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </li>

                <li class="minicart-item">
                    <div class="thumbnail">
                        <a href="#">
                            <img src="{{ asset('frontend') }}/assets/images/product/4.jpg" alt="Product Images">
                        </a>
                    </div>
                    <div class="product-content">
                        <h6 class="title"><a href="single-product.html">Momentum Theorem</a></h6>

                        <span class="quantity">1 * <span class="price">$50</span></span>
                    </div>
                    <div class="close-btn">
                        <button class="rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="rbt-minicart-footer">
            <hr class="mb--0">
            <div class="rbt-cart-subttotal">
                <p class="subtotal"><strong>Subtotal:</strong></p>
                <p class="price">$121</p>
            </div>
            <hr class="mb--0">
            <div class="rbt-minicart-bottom mt--20">
                <div class="view-cart-btn">
                    <a class="rbt-btn btn-border icon-hover w-100 text-center" href="#">
                        <span class="btn-text">View Cart</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </a>
                </div>
                <div class="checkout-btn mt--20">
                    <a class="rbt-btn btn-gradient icon-hover w-100 text-center" href="#">
                        <span class="btn-text">Checkout</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End Side Vav -->
<a class="close_side_menu" href="javascript:void(0);"></a>
