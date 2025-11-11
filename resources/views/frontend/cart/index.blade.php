@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Cart - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container base-margin-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Cart</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-cart-area bg-color-white rbt-section-gap pt-5">
        <div class="cart_area">
            <div class="container">
                @include('layouts.frontend.notification')
                @if(is_null($siteSettings->delivery_charge))
                    <div class="alert alert-danger icons-alert mb-5">
                        <p class="m-0"><strong>"The delivery charge hasn't been set yet, so the price might
                                vary.</strong></p>
                    </div>
                @endif
                <div class="row">
                    <div class="col-8">
                        <form action="#">
                            <!-- Cart Table -->
                            <div class="cart-table table-responsive mb--60">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Image</th>
                                        <th class="pro-title">Product</th>
                                        <th class="pro-price">Price</th>
                                        <th class="pro-quantity">Quantity</th>
                                        <th class="pro-subtotal">Total</th>
                                        <th class="pro-remove">Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(isset($cartItems) && $cartItems->isNotEmpty())
                                        @foreach($cartItems as $item)
                                            <tr>
                                                <td class="pro-thumbnail">
                                                    <a href="#">
                                                        <img
                                                            src="{{ asset(\Illuminate\Support\Facades\Storage::url($item->product->image)) }}"
                                                            alt="Product"></a></td>
                                                <td class="pro-title">
                                                    <a href="#">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </td>
                                                <td class="pro-price">
                                                    @if(!empty($item->product->mirror_discount))
                                                        <span>£ {{ $item->product->mirror_discount }}</span>
                                                    @else
                                                        <span>£ {{ $item->product->mirror_price }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="input-group mb-3 cart-section"
                                                             data-cart="{{ $item->id }}"
                                                             style="width: 120px;">
                                                            <button class="cart-minus btn btn-outline-primary"
                                                                    type="button">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                            <input width="10px" type="text"
                                                                   name="some_text"
                                                                   readonly
                                                                   class="form-control cart-quantity-input"
                                                                   value="{{ $item->quantity }}">
                                                            <button class="cart-plus btn btn-outline-primary"
                                                                    type="button">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="pro-subtotal"><span>£ {{ $item->total }}</span></td>
                                                <td class="pro-remove">
                                                    <button data-cart="{{ $item->id }}"
                                                            class="btn remove-cart" style="font-size: 30px">
                                                        <i class="feather-x"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">No item in the cart yet</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="col-4">
                        <div class="cart-summary">
                            <div class="cart-summary-wrap">
                                <div class="section-title text-start">
                                    <h4 class="title mb--30">Cart Summary</h4>
                                </div>
                                <p id="sub-total">Sub Total <span>£ {{ $subTotalPrice }}</span></p>
                                @if(!is_null($siteSettings->delivery_charge))
                                    <p id="delivery-cost">Shipping Cost <span>£ {{ $deliveryCharge }}</span></p>
                                @endif
                                <h2 id="grand-total">Grand Total <span>£ {{ $grandTotalPrice }}</span></h2>
                            </div>

                            <div class="cart-submit-btn-group justify-content-end">
                                <div class="rbt-btn-wrapper d-none d-xl-block">
                                    <a href="{{ route('user.order.checkout') }}" class="btn-style">
                                        Proceed To Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>

        let loader = $("#merit-loader");
        let subTotalDiv = $("#sub-total span");
        let grandTotalDiv = $("#grand-total span");
        let deliveryDiv = $("#delivery-cost span");

        $('.cart-minus').on('click', function (e) {
            e.stopPropagation();
            loader.removeClass('hidden');
            let button = $(this);
            let inputGroup = $(this).parent('div');
            let cartID = inputGroup.data('cart');
            let input = $(this).siblings('input');
            let subtotalCell = $(this).closest('tr').find('.pro-subtotal span');

            button.prop('disabled', true);

            ajaxCall(1, cartID, function (response) {
                subtotalCell.html('£ ' + response.unitPrice);
                input.val(response.cart?.quantity);
                subTotalDiv.html('£ ' + response.subTotalPrice);
                deliveryDiv.html('£ ' + response.deliveryCharge);
                grandTotalDiv.html('£ ' + response.grandTotalPrice);
                button.prop('disabled', false);
                loader.addClass('hidden');
            });
        });

        $('.cart-plus').on('click', function (e) {
            e.stopPropagation();
            loader.removeClass('hidden');
            let button = $(this);
            let inputGroup = $(this).parent('div');
            let cartID = inputGroup.data('cart');
            let input = $(this).siblings('input');
            let subtotalCell = $(this).closest('tr').find('.pro-subtotal span');

            button.prop('disabled', true);

            ajaxCall(2, cartID, function (response) {
                subtotalCell.html('£ ' + response.unitPrice);
                input.val(response.cart?.quantity);
                subTotalDiv.html('£ ' + response.subTotalPrice);
                deliveryDiv.html('£ ' + response.deliveryCharge);
                grandTotalDiv.html('£ ' + response.grandTotalPrice);
                button.prop('disabled', false);
                loader.addClass('hidden');
            });
        });

        $('.remove-cart').on('click', function (e) {
            e.preventDefault();
            loader.removeClass('hidden');
            let button = $(this);
            let cartID = button.data('cart');
            let closetTableRow = $(this).closest('tr');

            ajaxCall(3, cartID, function (response) {
                console.log(response);
                closetTableRow.remove();
                subTotalDiv.html('£ ' + response.subTotalPrice);
                deliveryDiv.html('£ ' + response.deliveryCharge);
                grandTotalDiv.html('£ ' + response.grandTotalPrice);
                button.prop('disabled', false);
                loader.addClass('hidden');
                $("#merit-cart-count").html(response.count);
            })
        })


        // type 1 = minus call, type 2 = plus call, type 3 = delete
        function ajaxCall(type, cartID, callback) {
            $.ajax({
                url: '{{ route('ajax.cart.item') }}',
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    type: type,
                    cart_id: cartID
                },
                success: function (response) {
                    callback(response)
                },
                error: function (error) {
                    callback(error)
                }
            });
        }

    </script>
@endsection
