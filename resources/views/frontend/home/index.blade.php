@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Home - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')

    <!--================== Start Discount Area ==================-->
    {{-- <div class="discount-area-main">
        <div class="discount-area">
            <div class="discount-area-single">
                <h2>ALL Booklets</h2>
                <p>Year 10 & Year 11 Mathematics</p>
            </div>
            <div class="discount-area-single">
                <p>UPTO</p>
                <h2>15% OFF</h2>
            </div>
            <div class="discount-area-single">
                <h2>ALL Past Papers</h2>
                <p>GCSE, IGCSE, A Level, AS Level</p>
            </div>
        </div>
    </div> --}}
    <!--================== End Discount Area ==================-->

    <!--================== Start Banner Area ==================-->
    <div class="banner-area-main">
        <div class="container">
            <div class="mt-3">
                @include('layouts.frontend.notification')
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="banner-area">
                        <div class="banner-area-left">
                            <div class="banener-al-contents">
                                <h1>Master Your Studies with <span>Merit Study Resources <img
                                            src="{{ asset('frontend/assets/images/merithub/title-shape.png') }}" alt=""></span>
                                </h1>
                                <p>Explore a vast collection of past papers and resources to excel in your exams.
                                    Simplify
                                    your preparation with MeritStudyResources!</p>
                            </div>
                            <div class="banner-al-btns">
                                <a href="{{ url('/pricing') }}" class="btn-style2">Explore Our Subscriptions <span><img
                                            src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}" alt=""></span></a>
                                <a href="{{ url('/past-papers') }}"><img
                                        src="{{ asset('frontend/assets/images/merithub/view.png') }}" alt="">
                                    View PastPapers</a>
                            </div>
                            <div class="banner-al-users">
                                <p>Trusted by 1000+ Users</p>
                                <ul>
                                    <li><img src="{{ asset('frontend/assets/images/merithub/user1.png') }}" alt=""></li>
                                    <li><img src="{{ asset('frontend/assets/images/merithub/user2.jpg') }}" alt=""></li>
                                    <li><img src="{{ asset('frontend/assets/images/merithub/user3.jpg') }}" alt=""></li>
                                    <li><img src="{{ asset('frontend/assets/images/merithub/user4.png') }}" alt=""></li>
                                    <li><img src="{{ asset('frontend/assets/images/merithub/user5.jpg') }}" alt=""></li>
                                </ul>
                            </div>
                        </div>
                        <div class="banner-area-right">
                            <img src="{{ asset('frontend/assets/images/merithub/banner.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================== End Banner Area ==================-->

    <!--================== Start Carousel Area ==================-->
    <div class="brands-carousel">
        <div class="brands-track">
            <div class="brands-carousel-single"><p>Past Papers</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>WorkSheets</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>WorkSheets Tests</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Homeworks Booklet</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Classwork Booklet</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>

            <!-- Repeat again for infinite effect -->
            <div class="brands-carousel-single"><p>Past Papers</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>WorkSheets</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>WorkSheets Tests</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Homeworks Booklet</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Classwork Booklet</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
        </div>
    </div>
    <!--================== End Carousel Area ==================-->

    <!--================== Start About Area ==================-->
    @include('frontend.home.about-us')
    <!--================== End About Area ==================-->

    <!--================== Start Our Pricing Area ==================-->
    <div class="our-pricing-area-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="our-pricing-area">
                        <div class="default-title">
                            <span class="default-span">Our Pricing</span>
                            <h2>The right price for you,
                                <b>
                                    <span class="default-shape">
                                        whoever
                                        <img src="{{ asset('frontend/assets/images/merithub/title-shape.png') }}"
                                             alt="">
                                    </span> you are
                                </b>
                            </h2>
                            <p>Your paid plans allow you to access resources from all year groups.</p>
                        </div>


                        <div class="row g-5">
                            <div class="col-lg-10 offset-lg-1">
                                <div class="advance-tab-button">
                                    <ul class="nav nav-tabs tab-button-style-2" id="myTab-4" role="tablist">
                                        @guest()
                                            <li role="presentation">
                                                <a href="#" class="tab-button active" id="home-tab-4"
                                                   data-bs-toggle="tab"
                                                   data-bs-target="#home-4" role="tab" aria-controls="home"
                                                   aria-selected="true">
                                                    <span class="title">School</span>
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#" class="tab-button" id="profile-tab-4" data-bs-toggle="tab"
                                                   data-bs-target="#profile-4" role="tab" aria-controls="profile-4"
                                                   aria-selected="false">
                                                    <span class="title">Student</span>
                                                </a>
                                            </li>
                                        @endguest
                                        @auth()
                                            @if(Auth::user()->type === \App\Enums\UserType::SCHOOL->value)
                                                <li role="presentation">
                                                    <a href="#" class="tab-button active" id="home-tab-4"
                                                       data-bs-toggle="tab"
                                                       data-bs-target="#home-4" role="tab" aria-controls="home"
                                                       aria-selected="true">
                                                        <span class="title">School</span>
                                                    </a>
                                                </li>
                                            @else
                                                <li role="presentation">
                                                    <a href="#" class="tab-button active" id="profile-tab-4"
                                                       data-bs-toggle="tab"
                                                       data-bs-target="#profile-4" role="tab" aria-controls="profile"
                                                       aria-selected="true">
                                                        <span class="title">Student</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endauth
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-10 offset-lg-1">
                                <div class="tab-content advance-tab-content-style-2 p-0">
                                    @auth()
                                        @if(Auth::user()->type === \App\Enums\UserType::SCHOOL->value)
                                            <div class="tab-pane fade active show" id="home-4" role="tabpanel"
                                                 aria-labelledby="home-tab-4">
                                                <div class="content">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-12">
                                                            <div class="pricing-billing-duration text-center">
                                                                <ul>
                                                                    <li class="nav-item">
                                                                        <button class="nav-link yearly-plan-btn active"
                                                                                type="button">Yearly Plan
                                                                        </button>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <button class="nav-link monthly-plan-btn"
                                                                                type="button">Monthly Plan
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="our-pricing-contents">
                                                        @if($subscriptionPricing->isNotEmpty())
                                                            @foreach($subscriptionPricing['school'] as $plan)
                                                                @if($plan->duration === \App\Enums\SubscriptionDuration::YEARLY->value)
                                                                    <div class="our-pricing-single content-y">
                                                                        <div class="opsingle-title">
                                                                            <b>{{ ucfirst($plan->name) }}</b>
                                                                            <h3>£{{ number_format($plan->price) }}
                                                                                <sub>/{{ strtolower(\App\Enums\SubscriptionDuration::from($plan->duration)->name) }}</sub>
                                                                            </h3>
                                                                            <p>
                                                                                This package is
                                                                                for {{ ucfirst(strtolower(\App\Enums\SubscriptionType::from($plan->type)->name)) }}
                                                                            </p>
                                                                        </div>
                                                                        <ul>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                User Limit: {{ $plan->user_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Package Download
                                                                                Limit: {{ $plan->download_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Weekly Download
                                                                                Limit: {{ $plan->weekly_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Has Full
                                                                                Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Trial Days: {{ $plan->trial_days }}
                                                                            </li>
                                                                        </ul>
                                                                        <div class="orsingle-btn">
                                                                            <a href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}"
                                                                               class="btn-style2">Select Package
                                                                                <span>
                                                                            <img
                                                                                src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="our-pricing-single d-none content-m">
                                                                        <div class="opsingle-title">
                                                                            <b>{{ ucfirst($plan->name) }}</b>
                                                                            <h3>£{{ number_format($plan->price) }}
                                                                                <sub>/{{ strtolower(\App\Enums\SubscriptionDuration::from($plan->duration)->name) }}</sub>
                                                                            </h3>
                                                                            <p>
                                                                                This package is
                                                                                for {{ ucfirst(strtolower(\App\Enums\SubscriptionType::from($plan->type)->name)) }}
                                                                            </p>
                                                                        </div>
                                                                        <ul>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                User Limit: {{ $plan->user_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Package Download
                                                                                Limit: {{ $plan->download_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Weekly Download
                                                                                Limit: {{ $plan->weekly_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Has Full
                                                                                Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Trial Days: {{ $plan->trial_days }}
                                                                            </li>
                                                                        </ul>
                                                                        <div class="orsingle-btn">
                                                                            <a href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}"
                                                                               class="btn-style2">Select Package
                                                                                <span>
                                                                            <img
                                                                                src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="tab-pane fade active show" id="profile-4" role="tabpanel"
                                                 aria-labelledby="profile-tab-4">
                                                <div class="content">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-12">
                                                            <div class="pricing-billing-duration text-center">
                                                                <ul>
                                                                    <li class="nav-item">
                                                                        <button class="nav-link yearly-plan-btn active"
                                                                                type="button">Yearly Plan
                                                                        </button>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <button class="nav-link monthly-plan-btn"
                                                                                type="button">Monthly Plan
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="our-pricing-contents">
                                                        @if($subscriptionPricing->isNotEmpty())
                                                            @foreach($subscriptionPricing['student'] as $plan)
                                                                @if($plan->duration === \App\Enums\SubscriptionDuration::YEARLY->value)
                                                                    <div class="our-pricing-single content-y">
                                                                        <div class="opsingle-title">
                                                                            <b>{{ ucfirst($plan->name) }}</b>
                                                                            <h3>£{{ number_format($plan->price) }}
                                                                                <sub>/{{ strtolower(\App\Enums\SubscriptionDuration::from($plan->duration)->name) }}</sub>
                                                                            </h3>
                                                                            <p>
                                                                                This package is
                                                                                for {{ ucfirst(strtolower(\App\Enums\SubscriptionType::from($plan->type)->name)) }}
                                                                            </p>
                                                                        </div>
                                                                        <ul>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                User Limit: {{ $plan->user_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Package Download
                                                                                Limit: {{ $plan->download_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Weekly Download
                                                                                Limit: {{ $plan->weekly_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Has Full
                                                                                Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Trial Days: {{ $plan->trial_days }}
                                                                            </li>
                                                                        </ul>
                                                                        <div class="orsingle-btn">
                                                                            <a href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}"
                                                                               class="btn-style2">Select Package
                                                                                <span>
                                                                            <img
                                                                                src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="our-pricing-single d-none content-m">
                                                                        <div class="opsingle-title">
                                                                            <b>{{ ucfirst($plan->name) }}</b>
                                                                            <h3>£{{ number_format($plan->price) }}
                                                                                <sub>/{{ strtolower(\App\Enums\SubscriptionDuration::from($plan->duration)->name) }}</sub>
                                                                            </h3>
                                                                            <p>
                                                                                This package is
                                                                                for {{ ucfirst(strtolower(\App\Enums\SubscriptionType::from($plan->type)->name)) }}
                                                                            </p>
                                                                        </div>
                                                                        <ul>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                User Limit: {{ $plan->user_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Package Download
                                                                                Limit: {{ $plan->download_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Weekly Download
                                                                                Limit: {{ $plan->weekly_limit }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Has Full
                                                                                Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                                            </li>
                                                                            <li>
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                                Trial Days: {{ $plan->trial_days }}
                                                                            </li>
                                                                        </ul>
                                                                        <div class="orsingle-btn">
                                                                            <a href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}"
                                                                               class="btn-style2">Select Package
                                                                                <span>
                                                                            <img
                                                                                src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endauth
                                    @guest()
                                        <div class="tab-pane fade active show" id="home-4" role="tabpanel"
                                             aria-labelledby="home-tab-4">
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <div class="pricing-billing-duration text-center">
                                                            <ul>
                                                                <li class="nav-item">
                                                                    <button class="nav-link yearly-plan-btn active"
                                                                            type="button">Yearly Plan
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button class="nav-link monthly-plan-btn"
                                                                            type="button">Monthly Plan
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="our-pricing-contents">
                                                    @if($subscriptionPricing->isNotEmpty())
                                                        @foreach($subscriptionPricing['school'] as $plan)
                                                            @if($plan->duration === \App\Enums\SubscriptionDuration::YEARLY->value)
                                                                <div class="our-pricing-single content-y">
                                                                    <div class="opsingle-title">
                                                                        <b>{{ ucfirst($plan->name) }}</b>
                                                                        <h3>£{{ number_format($plan->price) }}
                                                                            <sub>/{{ strtolower(\App\Enums\SubscriptionDuration::from($plan->duration)->name) }}</sub>
                                                                        </h3>
                                                                        <p>
                                                                            This package is
                                                                            for {{ ucfirst(strtolower(\App\Enums\SubscriptionType::from($plan->type)->name)) }}
                                                                        </p>
                                                                    </div>
                                                                    <ul>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            User Limit: {{ $plan->user_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Package Download
                                                                            Limit: {{ $plan->download_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Weekly Download
                                                                            Limit: {{ $plan->weekly_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Has Full
                                                                            Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Trial Days: {{ $plan->trial_days }}
                                                                        </li>
                                                                    </ul>
                                                                    <div class="orsingle-btn">
                                                                        <a href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}"
                                                                           class="btn-style2">Select Package
                                                                            <span>
                                                                            <img
                                                                                src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="our-pricing-single d-none content-m">
                                                                    <div class="opsingle-title">
                                                                        <b>{{ ucfirst($plan->name) }}</b>
                                                                        <h3>£{{ number_format($plan->price) }}
                                                                            <sub>/{{ strtolower(\App\Enums\SubscriptionDuration::from($plan->duration)->name) }}</sub>
                                                                        </h3>
                                                                        <p>
                                                                            This package is
                                                                            for {{ ucfirst(strtolower(\App\Enums\SubscriptionType::from($plan->type)->name)) }}
                                                                        </p>
                                                                    </div>
                                                                    <ul>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            User Limit: {{ $plan->user_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Package Download
                                                                            Limit: {{ $plan->download_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Weekly Download
                                                                            Limit: {{ $plan->weekly_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Has Full
                                                                            Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Trial Days: {{ $plan->trial_days }}
                                                                        </li>
                                                                    </ul>
                                                                    <div class="orsingle-btn">
                                                                        <a href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}"
                                                                           class="btn-style2">Select Package
                                                                            <span>
                                                                            <img
                                                                                src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="profile-4" role="tabpanel"
                                             aria-labelledby="profile-tab-4">
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <div class="pricing-billing-duration text-center">
                                                            <ul>
                                                                <li class="nav-item">
                                                                    <button class="nav-link yearly-plan-btn active"
                                                                            type="button">Yearly Plan
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button class="nav-link monthly-plan-btn"
                                                                            type="button">Monthly Plan
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="our-pricing-contents">
                                                    @if($subscriptionPricing->isNotEmpty())
                                                        @foreach($subscriptionPricing['student'] as $plan)
                                                            @if($plan->duration === \App\Enums\SubscriptionDuration::YEARLY->value)
                                                                <div class="our-pricing-single content-y">
                                                                    <div class="opsingle-title">
                                                                        <b>{{ ucfirst($plan->name) }}</b>
                                                                        <h3>£{{ number_format($plan->price) }}
                                                                            <sub>/{{ strtolower(\App\Enums\SubscriptionDuration::from($plan->duration)->name) }}</sub>
                                                                        </h3>
                                                                        <p>
                                                                            This package is
                                                                            for {{ ucfirst(strtolower(\App\Enums\SubscriptionType::from($plan->type)->name)) }}
                                                                        </p>
                                                                    </div>
                                                                    <ul>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            User Limit: {{ $plan->user_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Package Download
                                                                            Limit: {{ $plan->download_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Weekly Download
                                                                            Limit: {{ $plan->weekly_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Has Full
                                                                            Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Trial Days: {{ $plan->trial_days }}
                                                                        </li>
                                                                    </ul>
                                                                    <div class="orsingle-btn">
                                                                        <a href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}"
                                                                           class="btn-style2">Select Package
                                                                            <span>
                                                                            <img
                                                                                src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="our-pricing-single d-none content-m">
                                                                    <div class="opsingle-title">
                                                                        <b>{{ ucfirst($plan->name) }}</b>
                                                                        <h3>£{{ number_format($plan->price) }}
                                                                            <sub>/{{ strtolower(\App\Enums\SubscriptionDuration::from($plan->duration)->name) }}</sub>
                                                                        </h3>
                                                                        <p>
                                                                            This package is
                                                                            for {{ ucfirst(strtolower(\App\Enums\SubscriptionType::from($plan->type)->name)) }}
                                                                        </p>
                                                                    </div>
                                                                    <ul>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            User Limit: {{ $plan->user_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Package Download
                                                                            Limit: {{ $plan->download_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Weekly Download
                                                                            Limit: {{ $plan->weekly_limit }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Has Full
                                                                            Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa-solid fa-circle-check"></i>
                                                                            Trial Days: {{ $plan->trial_days }}
                                                                        </li>
                                                                    </ul>
                                                                    <div class="orsingle-btn">
                                                                        <a href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}"
                                                                           class="btn-style2">Select Package
                                                                            <span>
                                                                            <img
                                                                                src="{{ asset('frontend/assets/images/merithub/arrow-right.png') }}"
                                                                                alt="">
                                                                        </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================== End Our Pricing Area ==================-->

    <!--================== Start Our Products Area ==================-->
    <div class="our-product-area-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="our-product-area">
                        <div class="default-title">
                            <span class="default-span">Our Products</span>
                            <h2>Featured <b>GCSE, <span class="default-shape">GCSE, A Level, <img
                                            src="{{ asset('frontend/assets/images/merithub/title-shape.png') }}" alt=""></span>
                                    AS Level</b>
                                Products</h2>
                            <p>See a selection of our high-quality GCSE, GCSE, A Level, AS Level products and Year 10 &
                                Year
                                11 Mathematics booklets</p>
                        </div>
                        <div class="our-product-contents owl-carousel owl-theme">
                            @if(!empty($products))
                                @foreach($products as $product)
                                    <div class="our-product-single">
                                        <img
                                            src="{{ asset(\Illuminate\Support\Facades\Storage::url($product->image)) }}"
                                            alt="">
                                        {{-- <img src="{{ asset('frontend/assets/images/merithub/product1.png') }}" alt="">--}}
                                        <p class="mb-0">{{ $product->name }}</p>
                                        <div class="d-flex">
                                            <small>{{ $product->bookVariant->bookSubject->name }}</small>
                                            <i class="ms-2 fa-solid fa-angle-right"
                                               style="font-size: 10px;margin-top: 4px;"></i>
                                            <small class="ms-2">{{ $product->bookVariant->name }}</small>
                                        </div>
                                        @if(!empty($product->mirror_discount))
                                            <h4>£ {{ $product->mirror_discount }}
                                                <del>£ {{ $product->mirror_price }}</del>
                                            </h4>
                                        @else
                                            <h4>£ {{ $product->mirror_price }}</h4>
                                        @endif

                                        <a href="{{ route('single.product', [$product->slug]) }}" class="btn-style2">
                                            View Product
                                            <span>
                                                <img src="{{ asset('frontend/assets/images/merithub/arrow-right.png')}}"
                                                     alt="">
                                            </span>
                                        </a>
                                        @if(!empty($product->mirror_discount))
                                            <div class="our-product-off"><p>{{ $product->actual_discount }}% OFF</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="our-product-btn">
                            <a href="{{ route('products') }}" class="btn-style">View All Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================== End Our Products Area ==================-->

    <!--================== Start Discuss and discover Area ==================-->
    {{--
    <div class="discuss-and-discover-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="discuss-and-discover">
                        <div class="default-title">
                            <h2>Discuss and discover, <span class="default-shape">Together <img
                                        src="{{ asset('frontend/assets/images/merithub/title-shape.png') }}"
                                        alt=""></span></h2>
                            <p>Find friendly and supportive discussions on everything from GCSEs to uni life, from
                                A-levels
                                to Ucas applications.</p>
                        </div>
                        <div class="discuss-and-discover-tabs">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home"
                                            aria-selected="true">Latest
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">Trending
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="false">For You
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <!-- Start Tab-1 Contents -->
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                     aria-labelledby="pills-home-tab">
                                    <div class="discuss-tab-contents">
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Mark</b></p>
                                                        <p>Teacher</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>Shoutout to ppl doing IGCSE's 2025!</b></p>
                                                    <p>GCSE Choice and Study Help</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>21 min ago</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">5
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">4
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile2.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Tommy</b></p>
                                                        <p>Exam Candidate</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>KCL Law offers 2025</b></p>
                                                    <p>Law</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>2 hours ago</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">4
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">10
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile3.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Nada</b></p>
                                                        <p>Student</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>Who do you think is the best military commander ever?</b></p>
                                                    <p>History</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>5 hours ago</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">5
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">10
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile4.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>John</b></p>
                                                        <p>Teacher</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>is it possible to get into a top uni for law with horrible
                                                            gcses</b></p>
                                                    <p>Law</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>18 hours ago</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">2
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">2
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile5.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Richard</b></p>
                                                        <p>Exam Candidate</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>As of now do I stand a decent chance in getting into
                                                            Oxford?</b>
                                                    </p>
                                                    <p>GCSE Choice and Study Help</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>Yesterday</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">3
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">10
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Tab-1 Contents -->

                                <!-- Start Tab-2 Contents -->
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                     aria-labelledby="pills-profile-tab">
                                    <div class="discuss-tab-contents">
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Mark</b></p>
                                                        <p>Teacher</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>Shoutout to ppl doing IGCSE's 2025!</b></p>
                                                    <p>GCSE Choice and Study Help</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>21 min ago</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">5
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">4
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile3.png')}}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Nada</b></p>
                                                        <p>Student</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>Who do you think is the best military commander ever?</b></p>
                                                    <p>History</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>5 hours ago</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">5
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">10
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile5.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Richard</b></p>
                                                        <p>Exam Candidate</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>As of now do I stand a decent chance in getting into
                                                            Oxford?</b>
                                                    </p>
                                                    <p>GCSE Choice and Study Help</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>Yesterday</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">3
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">10
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Tab-2 Contents -->

                                <!-- Start Tab-3 Contents -->
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                     aria-labelledby="pills-contact-tab">
                                    <div class="discuss-tab-contents">
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Mark</b></p>
                                                        <p>Teacher</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>Shoutout to ppl doing IGCSE's 2025!</b></p>
                                                    <p>GCSE Choice and Study Help</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>21 min ago</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">5
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">4
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile2.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Tommy</b></p>
                                                        <p>Exam Candidate</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>KCL Law offers 2025</b></p>
                                                    <p>Law</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>2 hours ago</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">4
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">10
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile3.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Nada</b></p>
                                                        <p>Student</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>Who do you think is the best military commander ever?</b></p>
                                                    <p>History</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>5 hours ago</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">5
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">10
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Single -->
                                        <div class="discuss-tab-single">
                                            <div class="dt-single-left">
                                                <div class="dtsl-profile">
                                                    <div class="dtslp-img"><img
                                                            src="{{ asset('frontend/assets/images/merithub/profile5.png') }}"
                                                            alt=""></div>
                                                    <div class="dtslp-text">
                                                        <p><b>Richard</b></p>
                                                        <p>Exam Candidate</p>
                                                    </div>
                                                </div>
                                                <div class="dtsl-contents">
                                                    <p><b>As of now do I stand a decent chance in getting into
                                                            Oxford?</b>
                                                    </p>
                                                    <p>GCSE Choice and Study Help</p>
                                                </div>
                                            </div>
                                            <div class="dt-single-right">
                                                <p>Yesterday</p>
                                                <ul>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/star2.png') }}"
                                                            alt="">3
                                                    </li>
                                                    <li><img
                                                            src="{{ asset('frontend/assets/images/merithub/message.png') }}"
                                                            alt="">10
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Tab-3 Contents -->
                            </div>
                        </div>
                        <div class="discuss-and-discover-btn"><a href="#" class="btn-style">View All</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

      --}}
    <!--================== End Discuss and discover Area ==================-->

    <!--================== Start Carousel Area ==================-->
    <div class="brands-carousel">
        <div class="brands-track">
            <div class="brands-carousel-single"><p>Past Papers</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Worksheets</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Worksheet Tests</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Homeworks Booklet</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Classwork Booklet</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png')}}"
                                                     alt=""></div>

            <!-- Repeat again for infinite effect -->
            <div class="brands-carousel-single"><p>Past Papers</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Worksheets</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Worksheets Tests</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Homeworks Booklet</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
            <div class="brands-carousel-single"><p>Classwork Booklet</p></div>
            <div class="brands-carousel-single"><img src="{{ asset('frontend/assets/images/merithub/star.png') }}"
                                                     alt=""></div>
        </div>
    </div>
    <!--================== End Carousel Area ==================-->

    <!--================== Start Testimonials Area ==================-->
    @include('frontend.home.testimonial')
    <!--================== End Testimonials Area ==================-->

    <!--================== Start Deals-Updates-Resources Area ==================-->
    @include('frontend.home.subscription')
    <!--================== End Deals-Updates-Resources Area ==================-->
@endsection
@section('js')
    <script>
        let monthlyButtonSelector = $('.monthly-plan-btn');
        let yearlyButtonSelector = $(".yearly-plan-btn");
        let yearContent = $(".content-y");
        let monthContent = $(".content-m");

        monthlyButtonSelector.on('click', function () {
            yearlyButtonSelector.removeClass('active');
            $(this).addClass('active');
            yearContent.addClass('d-none');
            monthContent.removeClass('d-none');
        })

        yearlyButtonSelector.on("click", function () {
            monthlyButtonSelector.removeClass('active');
            $(this).addClass('active');
            monthContent.addClass('d-none');
            yearContent.removeClass('d-none');
        })
    </script>
@endsection
