@extends('layouts.frontend', ['main_title' => 'Subscription list - MeritStudyResources.co.uk' ])
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
                            @include('layouts.frontend.notification')
                            <!-- Start Instructor Profile  -->
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Subscription List</h4>
                                    </div>

                                    <div class="rbt-dashboard-table table-responsive mobile-table-750">
                                        <table class="rbt-table table table-borderless">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price (£)</th>
                                                <th>Details</th>
                                                <th>Duration</th>
                                                <th>Next Date</th>
                                                <th>Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($subscriptions->isNotEmpty())
                                                @foreach($subscriptions as $data)
                                                    <tr>
                                                        <td>{{ ucfirst($data->plan->name) }}</td>
                                                        <td>{{ number_format($data->plan->price) }}</td>
                                                        <td>
                                                            <ul>
                                                                <li>
                                                                    <i class="fa-solid fa-circle-check"></i>
                                                                    User Limit: {{ $data->plan->user_limit }}
                                                                </li>
                                                                <li>
                                                                    <i class="fa-solid fa-circle-check"></i>
                                                                    Package Download
                                                                    Limit: {{ $data->plan->download_limit }}
                                                                </li>
                                                                <li>
                                                                    <i class="fa-solid fa-circle-check"></i>
                                                                    Weekly Download
                                                                    Limit: {{ $data->plan->weekly_limit }}
                                                                </li>
                                                                <li>
                                                                    <i class="fa-solid fa-circle-check"></i>
                                                                    Has Full
                                                                    Access: {{ \App\Enums\Statement::from($data->plan->has_full_access)->name }}
                                                                </li>
                                                                <li>
                                                                    <i class="fa-solid fa-circle-check"></i>
                                                                    Trial Days: {{ $data->plan->trial_days }}
                                                                </li>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                <li>
                                                                    <i class="fa-solid fa-circle-check"></i>
                                                                    Trial Ends: {{ $data->trial_ends_at }}
                                                                </li>
                                                                <li>
                                                                    <i class="fa-solid fa-circle-check"></i>
                                                                    Subscription Ends: {{ $data->ends_at }}
                                                                </li>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            @if(empty($data->ends_at))
                                                                {{ $data->next_billing_date }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $data->stripe_status }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if (Auth::user()->subscribed('default'))
                                                                @if($data->stripe_status === 'active')
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-link text-dark"
                                                                                type="button"
                                                                                id="dropdownMenuButton"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-expanded="false">
                                                                            <i class="fas fa-ellipsis-v"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton">
                                                                            @if(empty($data->ends_at))
                                                                                <li class="custom-dropdown-item hover-warning">
                                                                                    <div
                                                                                        data-route="{{ route('user.pause', ['subscription' => $data]) }}"
                                                                                        class="subscription-pause-button">
                                                                                        Pause Subscription
                                                                                    </div>
                                                                                </li>
                                                                            @else
                                                                                <li class="custom-dropdown-item hover-success">
                                                                                    <div
                                                                                        data-route="{{ route('user.resume', ['subscription' => $data]) }}"
                                                                                        class="subscription-resume-button">
                                                                                        Resume Subscription
                                                                                    </div>
                                                                                </li>
                                                                            @endif
                                                                            <li class="custom-dropdown-item hover-danger">
                                                                                <div
                                                                                    data-route="{{ route('user.cancel', ['subscription' => $data]) }}"
                                                                                    class="subscription-cancel-button">
                                                                                    Cancel Subscription
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                            @endif
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
@section('js')
    <script>
        $(".subscription-pause-button").on('click', function () {
            let route = $(this).data('route');
            $("#subscription-pause-modal-action").attr('action', route);
            $("#subscription-pause-modal").modal('show');
        })

        $(".subscription-cancel-button").on('click', function () {
            let route = $(this).data('route');
            $("#subscription-cancel-modal-action").attr('action', route);
            $("#subscription-cancel-modal").modal('show');
        })

        $(".subscription-resume-button").on('click', function () {
            let route = $(this).data('route');
            $("#subscription-resume-modal-action").attr('action', route);
            $("#subscription-resume-modal").modal('show');
        })
    </script>
@endsection
