@extends('layouts.frontend-2')
@section('content')
    <header class="page-banner text-center" style="padding-bottom:36px;">
        <div class="container">
            <h1 class="mb-2">Checkout</h1>
            <div class="breadcrumb-msr text-center mb-4">
                <a href="{{ route('home') }}">Home</a> &nbsp;&gt;&nbsp;
                <a href="{{ route('view.cart') }}">Cart</a>
                &nbsp;&gt;&nbsp; Checkout
            </div>

            <div class="checkout-steps">
                <div class="co-step done">
                    <span class="cs-num"><svg viewBox="0 0 24 24" fill="none" width="14" height="14"><path
                                d="M5 13l4 4L19 7" stroke="#fff" stroke-width="2.4" stroke-linecap="round"
                                stroke-linejoin="round"/></svg></span>
                    <span class="cs-label">Cart</span>
                </div>
                <div class="co-step-line"></div>
                <div class="co-step active">
                    <span class="cs-num">2</span>
                    <span class="cs-label">Checkout</span>
                </div>
                <div class="co-step-line"></div>
                <div class="co-step">
                    <span class="cs-num">3</span>
                    <span class="cs-label">Confirmation</span>
                </div>
            </div>
        </div>
    </header>

    <!-- ============================= CHECKOUT CONTENT ============================= -->
    <section class="section-pad" style="padding-top:20px;">
        <div class="container">

            <!-- STEP: FORM + SUMMARY -->
            <div id="checkoutFormWrap">
                <form action="{{ route('user.process.to.payment') }}" method="post">
                    @csrf
                    <div class="row g-4">

                        <!-- LEFT: BILLING + PAYMENT -->
                        <div class="col-lg-7">

                            <div class="checkout-panel mb-4">
                                <h2>Billing Address</h2>
                                <p class="cp-sub">Used for your payment receipt.</p>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label-msr" for="billing_name">Full Name</label>
                                        <input type="text"
                                               value="{{ old('billing_name') }}"
                                               name="billing_name"
                                               id="billing_name"
                                               class="form-control-msr @error('billing_name') is-invalid @enderror"
                                               placeholder="Jane">
                                        @error('billing_name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-msr" for="billing_phone">Contact Number</label>
                                        <input type="text"
                                               name="billing_phone"
                                               id="billing_phone"
                                               value="{{ old('billing_phone') }}"
                                               class="form-control-msr @error('billing_phone') is-invalid @enderror"
                                               placeholder="e.g. +1239 333 3333">
                                        @error('billing_phone')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-msr" for="billing_alternative_phone">Alternative
                                            Contact Number</label>
                                        <input type="text"
                                               name="billing_alternative_phone"
                                               id="billing_alternative_phone"
                                               value="{{ old('billing_alternative_phone') }}"
                                               class="form-control-msr @error('billing_alternative_phone') is-invalid @enderror"
                                               placeholder="e.g. +1239 333 3333">
                                        @error('billing_alternative_phone')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-8">
                                        <label class="form-label-msr" for="billing_address">Billing Address</label>
                                        <textarea
                                            id="billing_address"
                                            class="form-control-msr @error('billing_address') is-invalid @enderror"
                                            placeholder="Type Address"
                                            name="billing_address"
                                            rows="3"></textarea>
                                        @error('billing_address')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label-msr" for="remarks">Remarks</label>
                                        <textarea
                                            id="remarks"
                                            name="remarks"
                                            class="form-control-msr @error('remarks') is-invalid @enderror"
                                            placeholder="Add Remarks"
                                            rows="3"></textarea>
                                        @error('remarks')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label-msr" for="billing_city">City</label>
                                        <input type="text" id="billing_city" name="billing_city"
                                               value="{{ old('billing_city') }}"
                                               class="form-control-msr @error('billing_city') is-invalid @enderror"
                                               placeholder="London">
                                        @error('billing_city')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label-msr" for="billing_state">State</label>
                                        <input type="text" id="billing_state" name="billing_state"
                                               value="{{ old('billing_state') }}"
                                               class="form-control-msr @error('billing_state') is-invalid @enderror"
                                               placeholder="State">
                                        @error('billing_state')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label-msr" for="billing_post_code">Post Code</label>
                                        <input type="text" id="billing_post_code" name="billing_post_code"
                                               value="{{ old('billing_post_code') }}"
                                               class="form-control-msr @error('billing_post_code') is-invalid @enderror"
                                               placeholder="e.g. EX_66784">
                                        @error('billing_post_code')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                        </div>

                        <!-- RIGHT: ORDER SUMMARY -->
                        <div class="col-lg-5">
                            <div class="cart-summary-panel">
                                <h2 class="h5 mb-3">Order Summary</h2>
                                <div class="checkout-success-alert d-none">
                                    hello aksdjasdjaoisjdapsjdapidapisjdaipsjdaipjapidajpdajpidj asdaasdasda
                                </div>
                                <div id="orderItems">
                                    @if(!empty($cartItems))
                                        @foreach($cartItems as $item)
                                            <div class="order-item-row">
                                                <div class="order-thumb-sm">
                                                    <img style="object-fit: cover; width: 100%; height: 100%; display: block"
                                                         src="https://images.unsplash.com/photo-1779896412430-b9ea6a9e742d?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                                         alt="sssss">
                                                </div>
                                                <div class="order-item-info">
                                                    <div class="oi-name">{{ $item->product->title }}</div>
                                                    <div class="oi-qty">
                                                        Qty: {{ $item->quantity }} × £{{ number_format($item->product->mirror_actual_price ?? 0, 2) }}</div>
                                                </div>
                                                <div class="order-item-price">£{{ number_format($item->total ?? 0, 2) }}</div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>

                                <div class="promo-row my-2">
                                    <input type="text" class="form-control-msr"
                                           id="coupon_code"
                                           placeholder="Promo code">

                                    <button type="button"
                                            id="apply-coupon-button"
                                            class="btn-ghost-navy" style="padding:0 18px;">Apply</button>

                                </div>
                                <small id="promo-apply-error"
                                       class="d-none mb-2 text-danger"></small>

                                <div class="cs-row">
                                    <span>Sub Total</span>
                                    <span class="cs-val" id="subtotal">
                                        £{{ number_format($subTotalPrice ?? 0, 2) }}
                                    </span>
                                </div>
                                <div class="cs-row">
                                    <span>Shipping Cost</span>
                                    <span class="cs-val" id="coShipping">
                                        £{{ number_format($deliveryCharge ?? 0, 2) }}
                                    </span>
                                </div>
                                <div class="cs-row total">
                                    <span>Grand Total</span>
                                    <span class="cs-val" id="grandTotal">
                                        £{{ number_format($grandTotalPrice ?? 0, 2) }}
                                    </span>
                                </div>

                                <button type="submit" class="btn-navy-block mt-4" id="placeOrderBtn">
                                    <span id="placeOrderText">Place Order &amp; Pay</span>
                                    <svg viewBox="0 0 24 24" fill="none" width="15" height="15" id="placeOrderIcon">
                                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>

                                <div class="secure-note">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor"
                                              stroke-width="1.6"/>
                                        <path d="M8 10V7a4 4 0 018 0v3" stroke="currentColor" stroke-width="1.6"/>
                                    </svg>
                                    Secured with 256-bit SSL encryption
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <!-- STEP: SUCCESS -->
{{--            <div id="checkoutSuccess" class="d-none">--}}
{{--                <div class="co-success-wrap">--}}
{{--                <span class="success-icon-circle">--}}
{{--                    <svg viewBox="0 0 24 24" fill="none">--}}
{{--                        <path d="M5 13l4 4L19 7"--}}
{{--                              stroke="currentColor"--}}
{{--                              stroke-width="2.4"--}}
{{--                              stroke-linecap="round"--}}
{{--                              stroke-linejoin="round"/>--}}
{{--                    </svg>--}}
{{--                </span>--}}
{{--                    <h2 class="mb-2" style="font-size:1.6rem;">Order confirmed!</h2>--}}
{{--                    <p class="lead-muted mb-0">--}}
{{--                        Thanks — your payment was successful. A receipt and download links have--}}
{{--                        been sent to your email.--}}
{{--                    </p>--}}
{{--                    <div class="order-number-chip">--}}
{{--                        <svg viewBox="0 0 24 24" fill="none" width="16" height="16">--}}
{{--                            <path d="M5 4h9l5 5v11H5z" stroke="currentColor" stroke-width="1.6"--}}
{{--                                  stroke-linejoin="round"/>--}}
{{--                        </svg>--}}
{{--                        <span id="orderNumberText">Order #MSR-000000</span>--}}
{{--                    </div>--}}
{{--                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">--}}
{{--                        <a href="dashboard.html" class="btn-brand justify-content-center">--}}
{{--                            Go to Dashboard--}}
{{--                            <svg viewBox="0 0 24 24" fill="none" width="16" height="16">--}}
{{--                                <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2"--}}
{{--                                      stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                            </svg>--}}
{{--                        </a>--}}
{{--                        <a href="products.html" class="btn-ghost-navy justify-content-center">Continue Shopping</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>
    </section>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-4.0.0.min.js"></script>
    <script>
        $("#apply-coupon-button").on('click', function (e) {
            console.log('ssss: ')
            e.preventDefault();
            const errorDom = $("#promo-apply-error");
            const rowDiv = $(".promo-row");

            errorDom.addClass('d-none');
            rowDiv.removeClass("mt-2 mb-0")
            rowDiv.addClass('my-2');

            $(this).prop('disabled', true);
            const couponCode = $("#coupon_code").val();

            $.ajax({
                url: '{{ route('ajax.apply.coupon') }}',
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    coupon_code: couponCode,
                },
                success: function (response) {
                    if (response.success) {

                        console.log(response);


                        $("#grandTotal").html('<del>£ ' + response.grandTotalPrice + '</del> £ ' + response.currentGrandTotalPrice);
                        $(".checkout-success-alert").html('<strong>'+ response.message + '</strong>')
                            .removeClass('d-none');
                        $("#coupon_code").attr('name', 'coupon_code');
                    }
                },
                error: function (error) {
                    if (error.status === 422) {
                        console.log('hello error', error.responseJSON.message, rowDiv);
                        errorDom.html(error.responseJSON.message);
                        errorDom.removeClass('d-none');
                        rowDiv.addClass("mt-2 mb-0")
                        rowDiv.removeClass('my-2');
                    }
                }
            });
            $(this).prop('disabled', false);
        })
    </script>
@endpush
