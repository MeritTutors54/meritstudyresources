@extends('layouts.frontend-3', ['main_title' => 'Order History - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
    <meta name="robots" content="noindex">
@endsection
@section('content')
@php
    use App\Enums\PaymentStatus;
    use App\Enums\OrderStatus;

    $orderHistory = $orderHistory ?? collect();
    $isPaginated  = $orderHistory instanceof \Illuminate\Contracts\Pagination\Paginator;
    $hasRows      = count($orderHistory) > 0;
    $total        = $orderHistory instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
                        ? $orderHistory->total()
                        : count($orderHistory);

    $money = fn ($v) => is_numeric($v) ? number_format((float) $v, 2) : ($v ?: '0.00');

    // enum name => [chip class, icon]
    $chip = function (?string $name) {
        return match ($name) {
            'CONFIRMED', 'PAID', 'COMPLETED', 'DELIVERED', 'SUCCESS' => ['is-success', 'bi-check-circle'],
            'SHIPPED', 'DISPATCHED', 'PROCESSING', 'ON_THE_WAY'     => ['is-info',    'bi-truck'],
            'PENDING', 'UNPAID', 'AWAITING'                         => ['is-warning', 'bi-hourglass-split'],
            'FAILED', 'CANCELLED', 'CANCELED', 'REJECTED', 'DECLINED' => ['is-danger', 'bi-x-circle'],
            'REFUNDED'                                              => ['is-muted',   'bi-arrow-counterclockwise'],
            default                                                 => ['is-muted',   'bi-dot'],
        };
    };
    $label = fn (?string $name) => $name ? ucfirst(strtolower(str_replace('_', ' ', $name))) : '—';
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
                    <p class="course-intro">Your book orders, what you paid and where each order is. Pending orders can still be cancelled.</p>
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
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Payment</th>
                                    <th scope="col">Order status</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orderHistory as $history)
                                    @php
                                        $itemCount   = $history->items_count ?? $history->items()->count();
                                        $payName     = PaymentStatus::tryFrom($history->status)?->name;
                                        [$payClass, $payIcon] = $chip($payName);
                                        $trackName   = OrderStatus::tryFrom($history->latest_tracking_status)?->name;
                                        [$trackClass, $trackIcon] = $chip($trackName);
                                        $canCancel   = $history->latest_tracking_status == OrderStatus::PENDING->value;
                                        $time        = $history->created_at ? \Illuminate\Support\Carbon::parse($history->created_at) : null;
                                        $discount    = (float) ($history->mirror_discount ?? 0);
                                    @endphp
                                    <tr>
                                        <td data-label="Invoice">
                                            <div class="cell-resource">
                                                <span class="cell-icon cell-icon-amber"><i class="bi bi-receipt"></i></span>
                                                <span>
                                                    <a class="cell-strong cell-link" href="{{ route('user.order.history.details', [$history->invoice_number]) }}">#{{ $history->invoice_number }}</a>
                                                    <span class="cell-sub">
                                                        {{ $itemCount }} {{ \Illuminate\Support\Str::plural('item', $itemCount) }}@if($time) · {{ $time->format('j M Y') }}@endif
                                                    </span>
                                                </span>
                                            </div>
                                        </td>
                                        <td data-label="Amount">
                                            <span class="cell-price">£{{ $money($history->mirror_total) }}</span>
                                            <span class="cell-sub amount-breakdown">
                                                Subtotal £{{ $money($history->mirror_subtotal) }}
                                                @if($discount > 0) · <span class="amount-discount">−£{{ $money($history->mirror_discount) }}</span>@endif
                                                · Delivery £{{ $money($history->mirror_delivery) }}
                                            </span>
                                        </td>
                                        <td data-label="Payment">
                                            <span class="status-chip {{ $payClass }}"><i class="bi {{ $payIcon }}"></i> {{ $label($payName) }}</span>
                                        </td>
                                        <td data-label="Order status">
                                            @if($trackName)
                                                <span class="status-chip {{ $trackClass }}"><i class="bi {{ $trackIcon }}"></i> {{ $label($trackName) }}</span>
                                            @else
                                                <span class="cell-muted">—</span>
                                            @endif
                                        </td>
                                        <td data-label="Actions" class="text-end">
                                            <div class="row-actions-inline">
                                                <a class="btn btn-soft btn-sm" href="{{ route('user.order.history.details', [$history->invoice_number]) }}">
                                                    <i class="bi bi-eye"></i> Details
                                                </a>
                                                @if($canCancel)
                                                    <a class="btn btn-soft btn-sm sub-btn-cancel" href="{{ route('user.cancel.order', [$history]) }}"
                                                       onclick="return confirm('Cancel order #{{ $history->invoice_number }}? This cannot be undone.')">
                                                        <i class="bi bi-x-circle"></i> Cancel
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($isPaginated && $orderHistory->hasPages())
                        <div class="data-pager">
                            {{ $orderHistory->onEachSide(1)->links('pagination::bootstrap-5') }}
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