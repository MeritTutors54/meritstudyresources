@extends('layouts.frontend-3', ['main_title' => 'Order History - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
    <meta name="robots" content="noindex">
@endsection
@section('content')
@php
    // Pass $orders from the controller, e.g. BookOrder::where('user_id', auth()->id())->latest()->paginate(15)
    $orders      = $orders ?? collect();
    $isPaginated = $orders instanceof \Illuminate\Contracts\Pagination\Paginator;
    $hasRows     = count($orders) > 0;
    $total       = $orders instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
                    ? $orders->total()
                    : count($orders);

    // status => [label class, icon]
    $statusStyles = [
        'paid'       => ['is-success', 'bi-check-circle'],
        'success'    => ['is-success', 'bi-check-circle'],
        'completed'  => ['is-success', 'bi-check-circle'],
        'delivered'  => ['is-success', 'bi-box-seam'],
        'dispatched' => ['is-info',    'bi-truck'],
        'shipped'    => ['is-info',    'bi-truck'],
        'processing' => ['is-info',    'bi-arrow-repeat'],
        'pending'    => ['is-warning', 'bi-hourglass-split'],
        'unpaid'     => ['is-warning', 'bi-hourglass-split'],
        'failed'     => ['is-danger',  'bi-x-circle'],
        'cancelled'  => ['is-danger',  'bi-x-circle'],
        'canceled'   => ['is-danger',  'bi-x-circle'],
        'refunded'   => ['is-muted',   'bi-arrow-counterclockwise'],
    ];
@endphp

{{-- Load after style.css, resources.css and pages.css (or move into your layout's <head>) --}}
<link href="{{ asset('frontend/new/css/dashboard.css') }}" rel="stylesheet">

<div class="page-resources page-dashboard">

    <!-- ===== Page header ===== -->
    <section class="course-header dash-header">
        <div class="container">
            <div class="course-header-top">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb course-crumbs">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order history</li>
                    </ol>
                </nav>
                <p class="spec-code"><span>{{ number_format($total) }}</span> {{ \Illuminate\Support\Str::plural('order', $total) }}</p>
            </div>

            <div class="course-header-main">
                <div>
                    <p class="eyebrow"><span class="eyebrow-dot"></span>Bookshop</p>
                    <h1 class="course-title">Order history</h1>
                    <p class="course-intro">Your book orders and their status. Book downloads unlock once an order is paid.</p>
                </div>
                <div class="course-actions">
                    <a class="btn btn-merit d-inline-flex align-items-center gap-2" href="{{ url('bookshop') }}">
                        <i class="bi bi-book"></i> Visit bookshop
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Body ===== -->
    <div class="container dash-body">
        <div class="row g-4">

            <!-- Side nav -->
            <aside class="col-lg-3">
                <div class="dash-nav">
                    @include('frontend.dashboard.include.menu')
                </div>
            </aside>

            <!-- Main column -->
            <div class="col-lg-9">
                @include('layouts.frontend.notification')

                @if($hasRows)
                    <div class="data-card">
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                <tr>
                                    <th scope="col">Order</th>
                                    <th scope="col">Book</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    @php
                                        $orderNo  = $order->order_number ?? $order->id;
                                        $bookName = $order->book?->name
                                                    ?? $order->book_name
                                                    ?? $order->name
                                                    ?? 'Book order';
                                        $qty      = $order->quantity ?? null;
                                        $amount   = $order->total ?? $order->amount ?? $order->price ?? null;
                                        $time     = $order->created_at ? \Illuminate\Support\Carbon::parse($order->created_at) : null;
                                        $status   = strtolower((string) ($order->status_name ?? $order->status ?? ''));
                                        [$statusClass, $statusIcon] = $statusStyles[$status] ?? ['is-muted', 'bi-dot'];
                                    @endphp
                                    <tr>
                                        <td data-label="Order">
                                            <code class="cell-code">#{{ $orderNo }}</code>
                                        </td>
                                        <td data-label="Book">
                                            <div class="cell-resource">
                                                <span class="cell-icon cell-icon-amber"><i class="bi bi-book"></i></span>
                                                <span>
                                                    <span class="cell-strong">{{ $bookName }}</span>
                                                    @if($qty)
                                                        <span class="cell-sub">Qty {{ $qty }}</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td data-label="Date">
                                            @if($time)
                                                <span class="cell-strong">{{ $time->format('j M Y') }}</span>
                                                <span class="cell-sub">{{ $time->format('g:i a') }}</span>
                                            @else
                                                <span class="cell-muted">—</span>
                                            @endif
                                        </td>
                                        <td data-label="Price">
                                            @if(!is_null($amount))
                                                <span class="cell-price">£{{ number_format((float) $amount, 2) }}</span>
                                            @else
                                                <span class="cell-muted">—</span>
                                            @endif
                                        </td>
                                        <td data-label="Status">
                                            @if($status !== '')
                                                <span class="status-chip {{ $statusClass }}">
                                                    <i class="bi {{ $statusIcon }}"></i> {{ ucfirst($status) }}
                                                </span>
                                            @else
                                                <span class="cell-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($isPaginated && $orders->hasPages())
                        <div class="data-pager">
                            {{ $orders->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @else
                    <div class="empty-state data-empty">
                        <i class="bi bi-bag"></i>
                        <p class="data-empty-title">No orders yet</p>
                        <p>When you buy a workbook, your order will appear here.</p>
                        <a class="btn btn-merit btn-sm" href="{{ url('bookshop') }}">Browse the bookshop</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection