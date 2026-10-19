@extends('layouts.frontend-3', ['main_title' => 'Order History Details - MeritStudyResources.co.uk' ])
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

    $tracks   = collect($tracks ?? []);
    $items    = $order?->items ?? collect();
    $money    = fn ($v) => is_numeric($v) ? number_format((float) $v, 2) : ($v ?: '0.00');
    $label    = fn (?string $name) => $name ? ucfirst(strtolower(str_replace('_', ' ', $name))) : '—';
    $chip     = function (?string $name) {
        return match ($name) {
            'CONFIRMED', 'PAID', 'COMPLETED', 'DELIVERED', 'SUCCESS' => ['is-success', 'bi-check-circle'],
            'SHIPPED', 'DISPATCHED', 'PROCESSING', 'ON_THE_WAY'     => ['is-info',    'bi-truck'],
            'PENDING', 'UNPAID', 'AWAITING'                         => ['is-warning', 'bi-hourglass-split'],
            'FAILED', 'CANCELLED', 'CANCELED', 'REJECTED', 'DECLINED' => ['is-danger', 'bi-x-circle'],
            'REFUNDED'                                              => ['is-muted',   'bi-arrow-counterclockwise'],
            default                                                 => ['is-muted',   'bi-dot'],
        };
    };

    $payName   = $order ? PaymentStatus::tryFrom($order->status)?->name : null;
    [$payClass, $payIcon] = $chip($payName);
    $trackName = $order ? OrderStatus::tryFrom($order->latest_tracking_status)?->name : null;
    [$trackClass, $trackIcon] = $chip($trackName);
    $canCancel = $order && $order->latest_tracking_status == OrderStatus::PENDING->value;
    $placed    = $order?->created_at ? \Illuminate\Support\Carbon::parse($order->created_at) : null;
    $discount  = (float) ($order->mirror_discount ?? 0);
    $itemQty   = $items->sum('quantity');
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
                        <li class="breadcrumb-item"><a href="{{ route('user.order.history') }}">Order history</a></li>
                        <li class="breadcrumb-item active" aria-current="page">#{{ $order->invoice_number ?? '' }}</li>
                    </ol>
                </nav>
                @if($placed)
                    <p class="spec-code">Placed <span>{{ $placed->format('j M Y, g:i a') }}</span></p>
                @endif
            </div>

            <div class="course-header-main">
                <div>
                    <p class="eyebrow"><span class="eyebrow-dot"></span>Order details</p>
                    <h1 class="course-title">Order #{{ $order->invoice_number ?? '—' }}</h1>
                    <div class="order-head-chips">
                        <span class="status-chip {{ $payClass }}"><i class="bi {{ $payIcon }}"></i> Payment: {{ $label($payName) }}</span>
                        @if($trackName)
                            <span class="status-chip {{ $trackClass }}"><i class="bi {{ $trackIcon }}"></i> {{ $label($trackName) }}</span>
                        @endif
                    </div>
                </div>
                <div class="course-actions">
                    <a class="btn-outline-merit" href="{{ route('user.order.history') }}"><i class="bi bi-arrow-left"></i> All orders</a>
                    @if($canCancel)
                        <a class="btn btn-soft sub-btn-cancel d-inline-flex align-items-center gap-2" href="{{ route('user.cancel.order', [$order]) }}"
                           onclick="return confirm('Cancel order #{{ $order->invoice_number }}? This cannot be undone.')">
                            <i class="bi bi-x-circle"></i> Cancel order
                        </a>
                    @endif
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

                @if($order)
                    <div class="row g-4">

                        <!-- Items -->
                        <div class="col-xl-8">
                            <section aria-labelledby="items-title">
                                <div class="section-head">
                                    <h2 class="section-heading" id="items-title">Items</h2>
                                    <span class="unit-count">{{ $itemQty }} {{ \Illuminate\Support\Str::plural('item', $itemQty) }}</span>
                                </div>

                                <div class="data-card">
                                    <div class="table-responsive">
                                        <table class="data-table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col" class="text-end">Unit price</th>
                                                <th scope="col" class="text-center">Qty</th>
                                                <th scope="col" class="text-end">Subtotal</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($items as $item)
                                                <tr>
                                                    <td data-label="Product">
                                                        <div class="cell-resource">
                                                            <span class="cell-icon cell-icon-amber"><i class="bi bi-book"></i></span>
                                                            <span class="cell-strong">{{ $item->product?->name ?? 'Removed product' }}</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Unit price" class="text-end">£{{ $money($item->mirror_price) }}</td>
                                                    <td data-label="Qty" class="text-center"><span class="qty-chip">× {{ $item->quantity }}</span></td>
                                                    <td data-label="Subtotal" class="text-end"><span class="cell-price">£{{ $money($item->mirror_subtotal) }}</span></td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="4" class="cell-muted text-center py-4">No items on this order.</td></tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Summary -->
                        <div class="col-xl-4">
                            <section class="order-summary" aria-labelledby="summary-title">
                                <h2 class="order-summary-title" id="summary-title">Summary</h2>
                                <dl class="order-sum-list">
                                    <div><dt>Subtotal</dt><dd>£{{ $money($order->mirror_subtotal) }}</dd></div>
                                    @if($discount > 0)
                                        <div class="is-discount"><dt>Discount</dt><dd>−£{{ $money($order->mirror_discount) }}</dd></div>
                                    @endif
                                    <div><dt>Delivery</dt><dd>£{{ $money($order->mirror_delivery) }}</dd></div>
                                    <div class="is-total"><dt>Total</dt><dd>£{{ $money($order->mirror_total) }}</dd></div>
                                </dl>
                                <p class="order-sum-pay">
                                    <span class="status-chip {{ $payClass }}"><i class="bi {{ $payIcon }}"></i> {{ $label($payName) }}</span>
                                </p>
                            </section>
                        </div>

                        <!-- Tracking -->
                        <div class="col-12">
                            <section aria-labelledby="track-title">
                                <div class="section-head">
                                    <h2 class="section-heading" id="track-title">Tracking</h2>
                                </div>

                                @if($tracks->isNotEmpty())
                                    <ol class="track-list">
                                        @foreach($tracks as $track)
                                            @php
                                                $stepName = OrderStatus::tryFrom($track->status)?->name;
                                                $stepTime = $track->created_at ? \Illuminate\Support\Carbon::parse($track->created_at) : null;
                                                $isLast   = $loop->last;
                                                $isBad    = in_array($stepName, ['CANCELLED', 'CANCELED', 'FAILED', 'REJECTED'], true);
                                                $note     = $track->note ?? $track->comment ?? $track->message ?? null;
                                            @endphp
                                            <li class="track-step {{ $isLast ? 'is-current' : 'is-done' }} {{ $isBad ? 'is-bad' : '' }}">
                                                <span class="track-dot" aria-hidden="true">
                                                    <i class="bi {{ $isBad ? 'bi-x-lg' : ($isLast ? 'bi-geo-alt-fill' : 'bi-check-lg') }}"></i>
                                                </span>
                                                <div class="track-body">
                                                    <p class="track-name">
                                                        {{ $label($stepName) }}
                                                        @if($isLast)<span class="track-now">Current</span>@endif
                                                    </p>
                                                    @if($stepTime)
                                                        <p class="track-time">{{ $stepTime->format('j M Y, g:i a') }}</p>
                                                    @endif
                                                    @if($note)
                                                        <p class="track-note">{{ $note }}</p>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                @else
                                    <div class="empty-state data-empty">
                                        <i class="bi bi-truck"></i>
                                        <p class="data-empty-title">No tracking updates yet</p>
                                        <p>We'll show each step here as your order is processed and dispatched.</p>
                                    </div>
                                @endif
                            </section>
                        </div>

                    </div>
                @else
                    <div class="empty-state data-empty">
                        <i class="bi bi-receipt"></i>
                        <p class="data-empty-title">Order not found</p>
                        <p>We couldn't find this order on your account.</p>
                        <a class="btn btn-merit btn-sm" href="{{ route('user.order.history') }}">Back to orders</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection