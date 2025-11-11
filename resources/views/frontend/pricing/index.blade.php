@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Pricing - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container base-margin-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Pricing</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Pricing</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rbt-pricing-area bg-color-white">
        <div class="container">
            <div class="row g-5 mb--60">
                <div class="col-lg-12 col-md-6 col-12">
                    @include('layouts.frontend.notification')
                </div>
            </div>
        </div>
        @if(Auth::guest() || Auth::user()->type === \App\Enums\UserType::SCHOOL->value)
            {{--School Section--}}
            <div class="container">
                <div class="row g-5 mb--60">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="section-title text-start">
                            <span class="subtitle bg-primary-opacity">School Pricing</span>
                            <h2 class="title">Pricing for school</h2>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="pricing-billing-duration text-start text-md-end">
                            <ul>
                                <li class="nav-item">
                                    <button class="nav-link yearly-plan-btn school-year" type="button">Yearly Plan
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link monthly-plan-btn school-month active" type="button">Monthly
                                        Plan
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <!-- Start Single Pricing  -->
                    @if($subscriptionPricing->isNotEmpty())
                        @foreach($subscriptionPricing['school'] as $plan)
                            @if($plan->duration === \App\Enums\SubscriptionDuration::MONTHLY->value)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-12 monthly-pricing-school">
                                    <div class="pricing-table">
                                        <div class="pricing-header">
                                            <h3 class="title">{{ ucfirst($plan->name) }}</h3>
                                            {{--                                    <span class="rbt-badge mb--35">{{ $subscription->sub_title }}</span>--}}
                                            <div class="price-wrap">
                                                <div>
                                                    <span class="amount">£{{ $plan->price }}</span>
                                                    <span class="duration">/monthly</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pricing-body">
                                            <ul class="list-item">
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    User Limit: {{ $plan->user_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Package Download
                                                    Limit: {{ $plan->download_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Weekly Download Limit: {{ $plan->weekly_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Has Full
                                                    Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Trial Days: {{ $plan->trial_days }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="pricing-btn">
                                            <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100"
                                               href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}">
                                                <div class="icon-reverse-wrapper">
                                                    <span class="btn-text">Purchase Plan</span>
                                                    <span class="btn-icon"><i
                                                            class="feather-arrow-right"></i></span>
                                                    <span class="btn-icon"><i
                                                            class="feather-arrow-right"></i></span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-xl-4 col-lg-6 col-md-6 col-12 yearly-pricing-school d-none">
                                    <div class="pricing-table">
                                        <div class="pricing-header">
                                            <h3 class="title">{{ ucfirst($plan->name) }}</h3>
                                            {{--                                    <span class="rbt-badge mb--35">{{ $subscription->sub_title }}</span>--}}
                                            <div class="price-wrap">
                                                <div>
                                                    <span class="amount">£{{ $plan->price }}</span>
                                                    <span class="duration">/yearly</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pricing-body">
                                            <ul class="list-item">
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    User Limit: {{ $plan->user_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Package Download
                                                    Limit: {{ $plan->download_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Weekly Download Limit: {{ $plan->weekly_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Has Full
                                                    Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Trial Days: {{ $plan->trial_days }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="pricing-btn">
                                            <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100"
                                               href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}">
                                                <div class="icon-reverse-wrapper">
                                                    <span class="btn-text">Purchase Plan</span>
                                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <!-- End Single Pricing  -->
                </div>
            </div>
        @endif

        @if(Auth::guest() || Auth::user()->type === \App\Enums\UserType::STUDENT->value)
            {{--Student Section--}}
            <div class="container base-margin-top">
                <div class="row g-5 mb--60">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="section-title text-start">
                            <span class="subtitle bg-primary-opacity">Student Pricing</span>
                            <h2 class="title">Pricing for Students</h2>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="pricing-billing-duration text-start text-md-end">
                            <ul>
                                <li class="nav-item">
                                    <button class="nav-link yearly-plan-btn student-year" type="button">Yearly Plan
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link monthly-plan-btn active student-month" type="button">Monthly
                                        Plan
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <!-- Start Single Pricing  -->
                    @if($subscriptionPricing->isNotEmpty())
                        @foreach($subscriptionPricing['student'] as $plan)
                            @if($plan->duration === \App\Enums\SubscriptionDuration::MONTHLY->value)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-12 monthly-pricing-student">
                                    <div class="pricing-table">
                                        <div class="pricing-header">
                                            <h3 class="title">{{ ucfirst($plan->name) }}</h3>
                                            {{--                                    <span class="rbt-badge mb--35">{{ $subscription->sub_title }}</span>--}}
                                            <div class="price-wrap">
                                                <div>
                                                    <span class="amount">£{{ $plan->price }}</span>
                                                    <span class="duration">/monthly</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pricing-body">
                                            <ul class="list-item">
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    User Limit: {{ $plan->user_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Package Download
                                                    Limit: {{ $plan->download_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Weekly Download Limit: {{ $plan->weekly_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Has Full
                                                    Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Trial Days: {{ $plan->trial_days }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="pricing-btn">
                                            <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100"
                                               href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}">
                                                <div class="icon-reverse-wrapper">
                                                    <span class="btn-text">Purchase Plan</span>
                                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-xl-4 col-lg-6 col-md-6 col-12 yearly-pricing-student d-none">
                                    <div class="pricing-table">
                                        <div class="pricing-header">
                                            <h3 class="title">{{ ucfirst($plan->name) }}</h3>
                                            {{--                                    <span class="rbt-badge mb--35">{{ $subscription->sub_title }}</span>--}}
                                            <div class="price-wrap">
                                                <div>
                                                    <span class="amount">£{{ $plan->price }}</span>
                                                    <span class="duration">/yearly</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pricing-body">
                                            <ul class="list-item">
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    User Limit: {{ $plan->user_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Package Download
                                                    Limit: {{ $plan->download_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Weekly Download Limit: {{ $plan->weekly_limit }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Has Full
                                                    Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}
                                                </li>
                                                <li>
                                                    <i class="feather-check"></i> {{ $access ?? '' }}
                                                    Trial Days: {{ $plan->trial_days }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="pricing-btn">
                                            <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100"
                                               href="{{ route('user.subscription.checkout', ['q' => $plan->slug])  }}">
                                                <div class="icon-reverse-wrapper">
                                                    <span class="btn-text">Purchase Plan</span>
                                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <!-- End Single Pricing  -->
                </div>
            </div>
        @endif
        @include('frontend.home.testimonial')
        @include('frontend.home.subscription')
    </div>
@endsection
@section('js')
    <script>
        $('.pricing-btn a').on('click', function(e) {
            e.preventDefault();

            $(this).prop('disabled', true);
            let hrefValue = $(this).attr('href');
            let urlParams = new URLSearchParams(new URL(hrefValue).search);
            let qValue = urlParams.get('q');

            $.ajax({
                url: '{{ route('ajax.check.packs') }}',
                type: "get",
                dataType: 'json',
                data: {
                    q: qValue,
                },
                success: function (response) {
                    console.log('res: ', response)
                    if (response.type === 'error') {
                        if (response.action === 'redirect') {
                            window.location.href = response.redirect;
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                customClass: 'swal-wide',
                                confirmButtonText: 'Close'
                            })
                        }



                    } else if (response.type === 'success') {
                        window.location.href = hrefValue
                    }
                    // if (response.success) {
                    //     // Handle successful login
                    //     Swal.fire({
                    //         title: 'Success!',
                    //         text: response.message,
                    //         icon: 'Success',
                    //         customClass: 'swal-wide',
                    //     })
                    //     location.reload();
                    // }
                },
                error: function (error) {
                    console.log('err: ', error)
                    // Swal.fire({
                    //     title: 'Error!',
                    //     text: error.responseJSON.message,
                    //     icon: 'error',
                    //     customClass: 'swal-wide',
                    //     confirmButtonText: 'Close'
                    // })
                }
            });

            $(this).prop('disabled', false);
        });
    </script>
    <script>
        let schoolMonthlyButtonSelector = $('.school-month');
        let schoolYearlyButtonSelector = $('.school-year');
        let schoolYearContent = $(".yearly-pricing-school");
        let schoolMonthContent = $(".monthly-pricing-school");

        schoolMonthlyButtonSelector.on('click', function () {
            schoolYearlyButtonSelector.removeClass('active');
            $(this).addClass('active');
            schoolYearContent.addClass('d-none');
            schoolMonthContent.removeClass('d-none');
        })

        schoolYearlyButtonSelector.on("click", function () {
            schoolMonthlyButtonSelector.removeClass('active');
            $(this).addClass('active');
            schoolMonthContent.addClass('d-none');
            schoolYearContent.removeClass('d-none');
        })

        let studentMonthlyButtonSelector = $('.student-month');
        let studentYearlyButtonSelector = $('.student-year');
        let studentYearContent = $(".yearly-pricing-student");
        let studentMonthContent = $(".monthly-pricing-student");

        studentMonthlyButtonSelector.on('click', function () {
            studentYearlyButtonSelector.removeClass('active');
            $(this).addClass('active');
            studentYearContent.addClass('d-none');
            studentMonthContent.removeClass('d-none');
        })

        studentYearlyButtonSelector.on("click", function () {
            studentMonthlyButtonSelector.removeClass('active');
            $(this).addClass('active');
            studentMonthContent.addClass('d-none');
            studentYearContent.removeClass('d-none');
        })
    </script>
@endsection
