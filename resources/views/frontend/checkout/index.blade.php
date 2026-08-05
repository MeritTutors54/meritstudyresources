@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Checkout - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1 ">
        <div class="container base-margin-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Checkout</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <div class="checkout_area bg-color-white rbt-section-gap pt-5">
        <div class="container">
            <form action="{{ route('user.process.to.payment') }}" method="post">
                @csrf
                <div class="row g-5 checkout-form">
                    <div class="col-lg-7">
                        <div class="checkout-content-wrapper">
                            <!-- Billing Address -->
                            <div id="billing-form">
                                <h4 class="checkout-title">Billing and Shipping Address</h4>
                                <div class="row">
                                    <div class="col-md-12 col-12 mb--20">
                                        <label for="billing_name">Customer Name*</label>
                                        <input type="text"
                                               class="mb-0"
                                               value="{{ old('billing_name') }}"
                                               name="billing_name"
                                               id="billing_name"
                                               placeholder="Customer Name">
                                        @error('billing_name')
                                        <div class="form-control-feedback text-danger mt-1">
                                            <small> {{ $message }}</small>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-12 mb--20">
                                        <label for="billing_phone">Customer Phone Number*</label>
                                        <input type="text"
                                               name="billing_phone"
                                               id="billing_phone"
                                               class="mb-0"
                                               value="{{ old('billing_phone') }}"
                                               placeholder="Phone Number">
                                        @error('billing_phone')
                                        <div class="form-control-feedback text-danger mt-1">
                                            <small> {{ $message }}</small>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-12 mb--20">
                                        <label for="billing_alternative_phone">Customer Alternative Phone Number</label>
                                        <input type="text"
                                               name="billing_alternative_phone"
                                               id="billing_alternative_phone"
                                               class="mb-0"
                                               value="{{ old('billing_alternative_phone') }}"
                                               placeholder="Customer Alternative Phone Number">
                                        @error('billing_alternative_phone')
                                        <div class="form-control-feedback text-danger mt-1">
                                            <small> {{ $message }}</small>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-8 mb--20">
                                        <label for="billing_address">Address*</label>
                                        <textarea name="billing_address"
                                                  id="billing_address"
                                                  class="mb-0"
                                                  placeholder="Address"
                                                  rows="3">{{ old('billing_address') }}</textarea>
                                        @error('billing_address')
                                        <div class="form-control-feedback text-danger mt-1">
                                            <small> {{ $message }}</small>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-4 mb--20">
                                        <label for="remarks">Remarks</label>
                                        <textarea name="remarks"
                                                  id="remarks"
                                                  class="mb-0"
                                                  placeholder="remarks"
                                                  rows="3">{{ old('remarks') }}</textarea>
                                        @error('remarks')
                                        <div class="form-control-feedback text-danger mt-1">
                                            <small> {{ $message }}</small>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-12 mb--20">
                                        <label for="billing_city">Town/City*</label>
                                        <input type="text"
                                               name="billing_city"
                                               id="billing_city"
                                               class="mb-0"
                                               value="{{ old('billing_city') }}"
                                               placeholder="Town/City">
                                        @error('billing_city')
                                        <div class="form-control-feedback text-danger mt-1">
                                            <small> {{ $message }}</small>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-12 mb--20">
                                        <label for="billing_state">State*</label>
                                        <input type="text"
                                               id="billing_state"
                                               name="billing_state"
                                               class="mb-0"
                                               value="{{ old('billing_state') }}"
                                               placeholder="State">
                                        @error('billing_state')
                                        <div class="form-control-feedback text-danger mt-1">
                                            <small> {{ $message }}</small>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-12 mb--20">
                                        <label for="billing_post_code">Post Code*</label>
                                        <input type="text"
                                               id="billing_post_code"
                                               name="billing_post_code"
                                               class="mb-0"
                                               value="{{ old('billing_post_code') }}"
                                               placeholder="Post Code">
                                        @error('billing_post_code')
                                        <div class="form-control-feedback text-danger mt-1">
                                            <small> {{ $message }}</small>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="row pl--50 pl_md--0 pl_sm--0">
                            <!-- Cart Total -->
                            <div class="col-12 mb--60">
                                <h4 class="checkout-title">Cart Total</h4>
                                <div class="checkout-cart-total">
                                    <h4>Product <span>Total</span></h4>
                                    <ul id="product-list">
                                        @if(!empty($cartItems))
                                            @foreach($cartItems as $item)
                                                <li>{{ $item->product->name, 30 }} X
                                                    {{ $item->quantity }} <span>£ {{ $item->total }}</span></li>
                                            @endforeach
                                        @endif
                                    </ul>

                                    <p>Sub Total <span>£ {{ $subTotalPrice }}</span></p>
                                    <p>Shipping Fee <span>£ {{ $deliveryCharge }}</span></p>

                                    <h4 class="mt--30">Grand Total <span id="grand-total">£ {{ $grandTotalPrice }}</span></h4>

                                    <div class="row mt-5">
                                        <div class="col-md-8 col-12 mb--25">
                                            <input type="text" id="coupon_code"
                                                   placeholder="Coupon Code">
                                        </div>
                                        <div class="col-md-4 col-12 mb--25 text-end">
                                            <button type="button"
                                                    id="apply-coupon-button"
                                                    class="rbt-btn btn-gradient hover-icon-reverse btn-sm">
                                                    Apply Code
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit"
                                                class="rbt-btn btn-gradient hover-icon-reverse mt--60">
                                            <span class="icon-reverse-wrapper">
                                                <span class="btn-text">Place order</span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $("#apply-coupon-button").on('click', function (e) {
            e.preventDefault();
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
                        Swal.fire({
                            title: 'Coupon Applied!',
                            text: response.message,
                            icon: 'success',
                            customClass: 'swal-wide',
                            confirmButtonText: 'Close'
                        })

                        $("#grand-total").html('<del>£ '+ response.grandTotalPrice +'</del> £ '+ response.currentGrandTotalPrice);
                        $("#product-list").append('<li>Applied Coupon <span>- £ '+ response.discountPrice +'</span></li>');
                        $("#coupon_code").attr('name', 'coupon_code');
                    }
                },
                error: function (error) {
                    if (error.status === 422) {
                        Swal.fire({
                            title: 'Error!',
                            text: error.responseJSON.message,
                            icon: 'error',
                            customClass: 'swal-wide',
                            confirmButtonText: 'Close'
                        })
                    }
                }
            });
            $(this).prop('disabled', false);
        })
    </script>
@endsection
