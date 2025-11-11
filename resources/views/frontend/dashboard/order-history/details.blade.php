@extends('layouts.frontend', ['main_title' => 'Order History Details - MeritStudyResources.co.uk' ])
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
                                        <h4 class="rbt-title-style-3">Order History Details</h4>
                                    </div>
                                    <div class="rbt-dashboard-table table-responsive mobile-table-750">
                                        <table class="rbt-table table table-borderless">
                                            <thead>
                                            <tr>
                                                <th>Invoice Number</th>
                                                <th>Product Name</th>
                                                <th>(£) Unit Price</th>
                                                <th>Quantity</th>
                                                <th>(£) Subtotal Amount</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @if(!empty($order))
                                                @foreach($order->items as $item)
                                                    <tr>
                                                        <td>#{{ $order->invoice_number }}</td>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>£ {{ $item->mirror_price }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>£ {{ $item->mirror_subtotal }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <!-- End Instructor Profile  -->
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mt-5">
                                <div class="content">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Tracking Order</h4>
                                    </div>
                                    <div class="rbt-dashboard-table table-responsive mobile-table-750">
                                        @if(!empty($tracks))
                                        <ol class="progress-meter">
                                            @foreach($tracks as $track)
                                                <li class="progress-point done">
                                                    {{ ucfirst(strtolower(\App\Enums\OrderStatus::from($track->status)->name)) }}
                                                </li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
