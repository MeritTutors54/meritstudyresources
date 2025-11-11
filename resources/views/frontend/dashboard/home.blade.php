@extends('layouts.frontend', ['main_title' => 'Dashboard - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
<div class="rbt-page-banner-wrapper">
    <!-- Start Banner BG Image  -->
    <div class="rbt-banner-image"></div>
    <!-- End Banner BG Image  -->
</div>
<!-- Start Card Style -->
<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Start Dashboard Top  -->
                <div class="rbt-dashboard-content-wrapper">
                    <!-- Start Tutor Information  -->
                    @include('frontend.dashboard.include.header')
                    <!-- End Tutor Information  -->
                </div>
                <!-- End Dashboard Top  -->
                <div class="row g-5">
                    <div class="col-lg-3">
                        <!-- Start Dashboard Sidebar  -->
                        <div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
                            <div class="inner">
                                <div class="content-item-content">
                                    @include('frontend.dashboard.include.menu')
                                </div>
                            </div>
                        </div>
                        <!-- End Dashboard Sidebar  -->
                    </div>

                    <div class="col-lg-9">
                        @if(!empty($warning))
                            <div class="alert alert-warning background-warning">
                                <p class="m-0"><strong>Warning!</strong> {{ $warning }}</p>
                            </div>
                        @endif
                        @include('layouts.frontend.notification')
                        <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
                            <div class="content">
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3">Dashboard</h4>
                                </div>
                                <div class="row g-5">

                                    <!-- Start Single Card  -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div
                                            class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-primary-opacity">
                                            <div class="inner">
                                                <div class="rbt-round-icon bg-primary-opacity">
                                                    <i class="feather-book-open"></i>
                                                </div>
                                                <div class="content">
                                                    <h3 class="counter without-icon color-primary"><span
                                                            class="odometer" data-count="{{ $count['subscriptions'] }}">00</span>
                                                    </h3>
                                                    <span class="rbt-title-style-2 d-block">Active Subscription</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Card  -->

                                    <!-- Start Single Card  -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div
                                            class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-secondary-opacity">
                                            <div class="inner">
                                                <div class="rbt-round-icon bg-secondary-opacity">
                                                    <i class="feather-monitor"></i>
                                                </div>
                                                <div class="content">
                                                    <h3 class="counter without-icon color-secondary"><span
                                                            class="odometer" data-count="{{ $count['book_orders'] }}">00</span>
                                                    </h3>
                                                    <span class="rbt-title-style-2 d-block">Total Book Purchase</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- End Single Card  -->

                                    <!-- Start Single Card  -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div
                                            class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-violet-opacity">
                                            <div class="inner">
                                                <div class="rbt-round-icon bg-violet-opacity">
                                                    <i class="feather-award"></i>
                                                </div>
                                                <div class="content">
                                                    <h3 class="counter without-icon color-violet"><span
                                                            class="odometer" data-count="{{ $count['downloads'] }}">00</span>
                                                    </h3>
                                                    <span class="rbt-title-style-2 d-block">Total Downloads</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Card  -->

                                    <!-- Start Single Card  -->
{{--                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">--}}
{{--                                        <div--}}
{{--                                            class="rbt-counterup variation-01 rbt-hover-03 rbt-border-dashed bg-pink-opacity">--}}
{{--                                            <div class="inner">--}}
{{--                                                <div class="rbt-round-icon bg-pink-opacity">--}}
{{--                                                    <i class="feather-users"></i>--}}
{{--                                                </div>--}}
{{--                                                <div class="content">--}}
{{--                                                    <h3 class="counter without-icon color-pink"><span--}}
{{--                                                            class="odometer" data-count="160">00</span>--}}
{{--                                                    </h3>--}}
{{--                                                    <span class="rbt-title-style-2 d-block">Total User</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <!-- End Single Card  -->


                                </div>
                            </div>
                        </div>
{{--                        <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">--}}
{{--                            <div class="content">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-12">--}}
{{--                                        <div class="section-title">--}}
{{--                                            <h4 class="rbt-title-style-3">My Recent Download History</h4>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row gy-5">--}}
{{--                                    <div class="col-lg-12">--}}
{{--                                        <div class="rbt-dashboard-table table-responsive">--}}
{{--                                            <table class="rbt-table table table-borderless">--}}
{{--                                                <thead>--}}
{{--                                                    <tr>--}}
{{--                                                        <th>Item Name</th>--}}
{{--                                                        <th>Date</th>--}}

{{--                                                    </tr>--}}
{{--                                                </thead>--}}
{{--                                                <tbody>--}}
{{--                                                    <tr>--}}
{{--                                                        <th><a href="#">Accounting</a></th>--}}
{{--                                                        <td>50</td>--}}
{{--                                                    </tr>--}}
{{--                                                </tbody>--}}
{{--                                            </table>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Card Style -->
<div class="rbt-separator-mid">
    <div class="container">
        <hr class="rbt-separator m-0">
    </div>
</div>
@endsection
