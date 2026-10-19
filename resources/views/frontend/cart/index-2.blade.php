@extends('layouts.frontend-3')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@section('content')
@php
    $cartItems   = $cartItems ?? collect();
    $hasItems    = $cartItems->isNotEmpty();
    $itemCount   = $cartItems->sum('quantity');
    $showDelivery = !is_null($siteSettings->delivery_charge ?? null);
@endphp

{{-- Needs Bootstrap Icons + style.css and resources.css (Merit tokens) loaded by the layout --}}
<link href="{{ asset('frontend/new/css/cart.css') }}" rel="stylesheet">

<div class="page-resources page-cart">

    <!-- ============================= PAGE HEADER ============================= -->
    <section class="course-header cart-header">
        <div class="container">
            <div class="course-header-top">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb course-crumbs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products') }}">Bookshop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
                <p class="spec-code"><span id="cartItemCount">{{ $itemCount }}</span> {{ \Illuminate\Support\Str::plural('item', $itemCount) }}</p>
            </div>
            <p class="eyebrow"><span class="eyebrow-dot"></span>Checkout</p>
            <h1 class="course-title mb-0">Your cart</h1>

            <!-- checkout steps -->
            <ol class="cart-steps list-unstyled" aria-label="Checkout progress">
                <li class="is-current"><span>1</span> Cart</li>
                <li><span>2</span> Details &amp; delivery</li>
                <li><span>3</span> Payment</li>
            </ol>
        </div>
    </section>

    <!-- ============================= CART CONTENT ============================= -->
    <section class="cart-body">
        <div class="container">

            <div id="cartLoaded" @if(!$hasItems) hidden @endif>
                <div class="row g-4">

                    <!-- Items -->
                    <div class="col-lg-8">
                        <div class="cart-card">
                            <div class="cart-card-head">
                                <span>Product</span>
                                <span class="text-center">Quantity</span>
                                <span class="text-end">Total</span>
                                <span class="visually-hidden">Remove</span>
                            </div>

                            <ul class="cart-list list-unstyled" id="cartList">
                                @foreach($cartItems as $item)
                                    @php
                                        $product   = $item->product;
                                        $regular   = (float) ($product?->mirror_price ?? 0);
                                        $sale      = (float) ($product?->mirror_discount ?? 0);
                                        $onSale    = $sale > 0 && $sale < $regular;
                                        $unit      = $sale > 0 ? $sale : $regular;
                                        $image     = $product?->image ? asset(\Illuminate\Support\Facades\Storage::url($product->image)) : null;
                                        $lineTotal = is_numeric($item->total) ? number_format((float) $item->total, 2) : $item->total;
                                    @endphp
                                    <li class="cart-row" data-row="{{ $item->id }}">
                                        <!-- product -->
                                        <div class="cart-product">
                                            <span class="cart-thumb">
                                                @if($image)
                                                    <img src="{{ $image }}" alt="{{ $product?->title }}" loading="lazy">
                                                @else
                                                    <i class="bi bi-book" aria-hidden="true"></i>
                                                @endif
                                            </span>
                                            <div class="cart-product-info">
                                                <p class="cart-prod-name">{{ $product?->title ?? 'Removed product' }}</p>
                                                <p class="cart-unit">
                                                    <span class="cart-unit-now">£{{ number_format($unit, 2) }}</span>
                                                    @if($onSale)
                                                        <s class="cart-unit-was">£{{ number_format($regular, 2) }}</s>
                                                        <span class="cart-sale-tag">Sale</span>
                                                    @endif
                                                    <span class="cart-unit-each">each</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- quantity -->
                                        <div class="qty-stepper" role="group" aria-label="Quantity for {{ $product?->title }}">
                                            <button type="button" class="cart-minus" data-cart="{{ $item->id }}" aria-label="Decrease quantity">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="text" class="cart-quantity-input" value="{{ $item->quantity }}" readonly
                                                   inputmode="numeric" aria-label="Quantity">
                                            <button type="button" class="cart-plus" data-cart="{{ $item->id }}" aria-label="Increase quantity">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>

                                        <!-- total -->
                                        <div class="cart-total">£{{ $lineTotal }}</div>

                                        <!-- remove -->
                                        <button type="button" class="cart-remove-btn" data-cart="{{ $item->id }}"
                                                aria-label="Remove {{ $product?->title }} from cart" title="Remove">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <a href="{{ route('products') }}" class="cart-continue">
                            <i class="bi bi-arrow-left"></i> Continue shopping
                        </a>
                    </div>

                    <!-- Summary -->
                    <div class="col-lg-4">
                        <aside class="cart-summary" aria-labelledby="summary-title">
                            <h2 class="cart-summary-title" id="summary-title">Order summary</h2>

                            <dl class="cart-sum-list">
                                <div>
                                    <dt>Subtotal</dt>
                                    <dd id="csSubtotal">£{{ number_format($subTotalPrice ?? 0, 2) }}</dd>
                                </div>
                                @if($showDelivery)
                                    <div>
                                        <dt>Delivery</dt>
                                        <dd id="csShipping">£{{ number_format($deliveryCharge ?? 0, 2) }}</dd>
                                    </div>
                                @endif
                                <div class="is-total">
                                    <dt>Total</dt>
                                    <dd id="csGrandTotal">£{{ number_format($grandTotalPrice ?? 0, 2) }}</dd>
                                </div>
                            </dl>

                            <a href="{{ route('user.order.checkout') }}" class="btn btn-merit cart-checkout" id="checkoutBtn">
                                Proceed to checkout <i class="bi bi-arrow-right"></i>
                            </a>

                            <ul class="cart-assure list-unstyled">
                                <li><i class="bi bi-shield-lock"></i> Secure checkout</li>
                                <li><i class="bi bi-qr-code"></i> Free QR-code downloads with every book</li>
                                <li><i class="bi bi-truck"></i> UK delivery</li>
                            </ul>
                        </aside>
                    </div>

                </div>
            </div>

            <!-- Empty state -->
            <div class="empty-state cart-empty" id="cartEmptyState" @if($hasItems) hidden @endif>
                <span class="cart-empty-ico"><i class="bi bi-bag"></i></span>
                <h2 class="cart-empty-title">Your cart is empty</h2>
                <p>Looks like you haven't added anything yet — browse our workbooks and past papers to get started.</p>
                <a href="{{ route('products') }}" class="btn btn-merit cart-checkout d-inline-flex w-auto">
                    Browse products <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </div>
    </section>
</div>
@endsection

@push('js')
    <script>
        (function () {
            const MINUS = 1, PLUS = 2, REMOVE = 3;

            const $  = (sel, ctx = document) => ctx.querySelector(sel);
            const gbp = (v) => '£' + (parseFloat(v) || 0).toFixed(2);

            function setSummary(res) {
                if (res.subTotalPrice !== undefined && $('#csSubtotal'))   $('#csSubtotal').textContent   = gbp(res.subTotalPrice);
                if (res.deliveryCharge !== undefined && $('#csShipping'))  $('#csShipping').textContent   = gbp(res.deliveryCharge);
                if (res.grandTotalPrice !== undefined && $('#csGrandTotal')) $('#csGrandTotal').textContent = gbp(res.grandTotalPrice);
                if (res.count !== undefined && $('#merit-cart-count'))     $('#merit-cart-count').textContent = res.count;
            }

            function refreshCount() {
                let n = 0;
                document.querySelectorAll('.cart-quantity-input').forEach(i => n += parseInt(i.value, 10) || 0);
                const el = $('#cartItemCount');
                if (el) el.textContent = n;
            }

            function removeRow(row) {
                row.classList.add('is-removing');
                setTimeout(() => {
                    row.remove();
                    refreshCount();
                    if (!document.querySelector('#cartList .cart-row')) {
                        $('#cartLoaded').hidden = true;
                        $('#cartEmptyState').hidden = false;
                    }
                }, 220);
            }

            function setBusy(row, busy) {
                if (!row) return;
                row.classList.toggle('is-busy', busy);
                row.querySelectorAll('button').forEach(b => b.disabled = busy);
            }

            // type 1 = minus, 2 = plus, 3 = delete
            function ajaxCall(type, cartID) {
                return fetch("{{ route('ajax.cart.item') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ type: type, cart_id: cartID })
                }).then(r => {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.json();
                });
            }

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.cart-minus, .cart-plus, .cart-remove-btn');
                if (!btn) return;
                e.preventDefault();

                const cartID = btn.dataset.cart;
                const row    = btn.closest('.cart-row');
                if (!cartID || !row) return;

                const input  = row.querySelector('.cart-quantity-input');
                const isRemove = btn.classList.contains('cart-remove-btn');
                const isMinus  = btn.classList.contains('cart-minus');

                // minus at 1 = remove
                const type = isRemove || (isMinus && parseInt(input.value, 10) <= 1)
                    ? REMOVE
                    : (isMinus ? MINUS : PLUS);

                if (type === REMOVE && !isRemove && !confirm('Remove this item from your cart?')) return;

                setBusy(row, true);

                ajaxCall(type, cartID)
                    .then(res => {
                        setSummary(res || {});
                        if (type === REMOVE || !res?.cart) {
                            removeRow(row);
                            return;
                        }
                        input.value = res.cart.quantity;
                        if (res.unitPrice !== undefined) row.querySelector('.cart-total').textContent = gbp(res.unitPrice);
                        refreshCount();
                        setBusy(row, false);
                    })
                    .catch(err => {
                        console.error('Cart update failed:', err);
                        setBusy(row, false);
                        row.classList.add('is-error');
                        setTimeout(() => row.classList.remove('is-error'), 1200);
                    });
            });
        })();
    </script>
@endpush