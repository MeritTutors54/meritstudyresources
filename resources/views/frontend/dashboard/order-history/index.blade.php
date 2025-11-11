@extends('layouts.frontend', ['main_title' => 'Order History - MeritStudyResources.co.uk' ])
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
                            @include('layouts.frontend.notification')
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Order History</h4>
                                    </div>
                                    <div class="rbt-dashboard-table table-responsive mobile-table-750" style="height: 50vh">
                                        <table class="rbt-table table table-borderless">
                                            <thead>
                                            <tr>
                                                <th>Invoice Number</th>
                                                <th>(£) Subtotal</th>
                                                <th>(£) Discount</th>
                                                <th>(£) Delivery</th>
                                                <th>(£) Total Amount</th>
                                                <th>Item Count</th>
                                                <th>Payment Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @if(!empty($orderHistory))
                                                @foreach($orderHistory as $history)
                                                    <tr>
                                                        <td>#{{ $history->invoice_number }}</td>
                                                        <td>£ {{ $history->mirror_subtotal }}</td>
                                                        <td>£ {{ $history->mirror_discount }}</td>
                                                        <td>£ {{ $history->mirror_delivery }}</td>
                                                        <td>£ {{ $history->mirror_total }}</td>
                                                        <td>{{ $history->items()->count() }}</td>
                                                        <td>
                                                            @if($history->status === \App\Enums\PaymentStatus::CONFIRMED->value)
                                                                <span
                                                                    class="rbt-badge-5 bg-color-success-opacity color-success">
                                                                    <b>{{ ucfirst(strtolower(\App\Enums\PaymentStatus::CONFIRMED->name)) }}</b>
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="rbt-badge-5 bg-color-danger-opacity color-danger">
                                                                    <b>{{ ucfirst(strtolower(\App\Enums\PaymentStatus::from($history->status)->name)) }}</b>
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
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
                                                                    <li class="custom-dropdown-item">
                                                                        <a href="{{ route('user.order.history.details', [$history->invoice_number]) }}">
                                                                            See Order Details
                                                                        </a>
                                                                    </li>

                                                                    @if($history->latest_tracking_status == \App\Enums\OrderStatus::PENDING->value)
                                                                        <li class="custom-dropdown-item">
                                                                            <a href="{{ route('user.cancel.order', [$history]) }}">
                                                                                Cancel Order
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
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
