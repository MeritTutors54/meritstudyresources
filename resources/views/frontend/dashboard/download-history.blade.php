@extends('layouts.frontend', ['main_title' => 'Download History - MeritStudyResources.co.uk' ])
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
    <div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Start Dashboard Top  -->
                    <div class="rbt-dashboard-content-wrapper">
                        @include('frontend.dashboard.include.header')
                        <!-- Start Tutor Information  -->

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
                            <!-- Start Instructor Profile  -->
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Download History</h4>
                                    </div>
                                    <div class="rbt-dashboard-table table-responsive mobile-table-750">
                                        <table class="rbt-table table table-borderless">
                                            <thead>
                                            <tr>
                                                @if(Auth::user()->type == \App\Enums\UserType::SCHOOL->value)
                                                    <th>User Name</th>
                                                    <th>Person Type</th>
                                                @endif
                                                <th>Resource Name</th>
                                                <th>Subscription ID</th>
                                                <th>Resource Type</th>

                                                <th>Fingerprint</th>
                                                <th>IP</th>
                                                <th>Time</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @if(!empty($downloads))
                                                @foreach($downloads as $history)
                                                    <tr>
                                                        @if(Auth::user()->type == \App\Enums\UserType::SCHOOL->value)
                                                            <td>{{ $history->user?->name }}</td>
                                                            <td>{{ $history->user?->person_type_name }}</td>
                                                        @endif
                                                        <td>{{ $history->resource?->name }}</td>
                                                        <td>{{ $history->stripe_id }}</td>
                                                        <td>{{ $history->resource_type_name }}</td>

                                                        <td>{{ $history->short_fingerprint }}</td>
                                                        <td>
                                                            <span
                                                                class="rbt-badge-5 bg-color-success-opacity color-success">
                                                                {{ $history->ip_address }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ $history->created_at }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <!-- End Instructor Profile  -->

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
