@extends('layouts.frontend-2')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@section('content')
    <!-- ============================= PAGE HEADER ============================= -->
    <header class="page-banner text-center" style="padding-bottom:50px;">
        <div class="container">
            <h1 class="mb-2">Cart</h1>
            <div class="breadcrumb-msr text-center"><a href="{{ route('home') }}">Home</a> &nbsp;&gt;&nbsp; Cart</div>
        </div>
    </header>

    <!-- ============================= CART CONTENT ============================= -->
    <section class="section-pad" style="padding-top:36px;">
        <div class="container">

            <div id="cartLoaded">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="cart-table-wrap">
                            <div class="cart-table-head">
                                <span>Image</span>
                                <span>Product</span>
                                <span>Price</span>
                                <span>Quantity</span>
                                <span>Total</span>
                                <span>Remove</span>
                            </div>
                            @if(isset($cartItems) && $cartItems->isNotEmpty())
                                @foreach($cartItems as $item)
                                    <div class="cart-row">
                                        <div class="w-50">
                                            <a href="#" class="d-flex text-black-50">
                                                <img
                                                    class="cart-thumb-img"
                                                    src="{{ asset(\Illuminate\Support\Facades\Storage::url($item->product->image)) }}"
                                                    alt="Product">
                                            </a>
                                        </div>
                                        <div class="cart-prod-name">{{ $item->product->title }}</div>
                                        <div class="cart-price">
                                            @if(!empty($item->product->mirror_discount))
                                                <span>£{{ number_format($item->product->mirror_discount ?? 0, 2) }}</span>
                                            @else
                                                <span>£{{ number_format($item->product->mirror_price ?? 0, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="qty-stepper">
                                            <button type="button" class="cart-minus"
                                                    data-cart="{{ $item->id }}">−
                                            </button>
                                            <input type="text" class="cart-quantity-input"
                                                   value="{{ $item->quantity }}" readonly>
                                            <button type="button" data-cart="{{ $item->id }}"
                                                    class="cart-plus">+
                                            </button>
                                        </div>
                                        <div class="cart-total">£{{ $item->total }}</div>
                                        <button data-cart="{{ $item->id }}"
                                                class="cart-remove-btn"
                                                aria-label="Remove item">
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M6 6l12 12M18 6L6 18"
                                                      stroke="currentColor"
                                                      stroke-width="2"
                                                      stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="cart-summary-panel">
                            <h2 class="h5 mb-3">Cart Summary</h2>
                            <div class="cs-row">
                                <span>Sub Total</span>
                                <span class="cs-val" id="csSubtotal">£{{ number_format($subTotalPrice ?? 0, 2) }}</span>
                            </div>
                            @if(!empty($settings->delivery_charge))
                                <div class="cs-row">
                                    <span>Shipping Cost</span>
                                    <span class="cs-val" id="csShipping">£{{ number_format($deliveryCharge ?? 0, 2) }}</span>
                                </div>
                            @endif
                            <div class="cs-row total">
                                <span>Grand Total</span>
                                <span class="cs-val" id="csGrandTotal">£{{ number_format($grandTotalPrice ?? 0, 2) }}</span>
                            </div>
                            <a href="{{ route('user.order.checkout') }}" class="btn-navy-block mt-4" id="checkoutBtn">
                                Proceed To Checkout
                                <svg viewBox="0 0 24 24" fill="none" width="15" height="15">
                                    <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                            <a href="{{ route('products') }}" class="d-block d-flex align-items-center gap-1 justify-content-center text-center mt-3 fw-semibold"
                               style="font-size:.85rem;color:var(--green-dark);">
                                <svg viewBox="0 0 24 24" fill="none" width="15" height="15">
                                    <path d="M19 12H5M5 12L11 6M5 12L11 18" stroke="#16804AFF" stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Continue shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cart-empty d-none" id="cartEmptyState">
                <span class="ce-ico">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M3 4h2l2.4 12.4a2 2 0 002 1.6h8.4a2 2 0 002-1.6L21 8H6" stroke="currentColor"
                            stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10" cy="20"
                                r="1.3"
                                fill="currentColor"/>
                        <circle cx="17" cy="20" r="1.3" fill="currentColor"/>
                    </svg>
                </span>
                <h2 class="h4 mb-2">Your cart is empty</h2>
                <p class="text-muted-c mb-4">
                    Looks like you haven't added anything yet — browse our workbooks and past
                    papers to get started.
                </p>
                <a href="{{ route('products') }}" class="btn-brand">
                    Browse Products
                    <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>

        </div>
    </section>

@endsection
@push('js')
    <script>

        const loader = document.getElementById('merit-loader');
        const subTotalDiv = document.querySelector('#sub-total span');
        const grandTotalDiv = document.querySelector('#grand-total span');
        const deliveryDiv = document.querySelector('#delivery-cost span');

        const minusCall = 1;
        const plusCall = 2;
        const deleteCall = 3;

        document.addEventListener('click', function (e) {
            const minusBtn = e.target.closest('.cart-minus');
            const plusBtn = e.target.closest('.cart-plus');
            const deleteBtn = e.target.closest('.cart-quantity-input');

            if (!minusBtn && !plusBtn && !deleteBtn) return;

            e.preventDefault();

            const button = minusBtn || plusBtn || deleteBtn;
            const cartID = button.dataset.cart;

            if (!cartID) return;

            let action;
            if (minusBtn) {
                action = minusCall;
            } else if (plusBtn) {
                action = plusCall;
            } else {
                action = deleteCall;
            }

            // DOM References
            const row = button.closest('.cart-row');
            const input = row?.querySelector('.cart-quantity-input');
            const totalElement = row?.querySelector('.cart-total');

            if (action === minusCall && parseInt(input?.value, 10) <= 1) {
                return;
            }

            // Safe lookup for global cart summary elements
            const loader = document.querySelector('.loader-selector') || null;
            const subTotalDiv = document.querySelector('#csSubtotal');
            const deliveryDiv = document.querySelector('#csShipping');
            const grandTotalDiv = document.querySelector('#csGrandTotal');

            console.log(subTotalDiv, deliveryDiv, grandTotalDiv);

            // UI state updates
            button.disabled = true;
            if (loader) loader.classList.remove('hidden');

            ajaxCall(action, cartID, function (response) {
                // Safe UI re-enable
                button.disabled = false;
                if (loader) loader.classList.add('hidden');

                console.log(response);

                if (!response) return;


                // Update item quantity input
                if (input && response?.cart) {
                    input.value = response?.cart?.quantity;
                }

                // Update item total price
                if (totalElement && response.unitPrice !== undefined) {
                    totalElement.textContent = '£' + parseFloat(response.unitPrice).toFixed(2);
                }

                // Update summary totals
                if (subTotalDiv && response.subTotalPrice !== undefined) {
                    subTotalDiv.textContent = '£' + parseFloat(response.subTotalPrice).toFixed(2);
                }
                if (deliveryDiv && response.deliveryCharge !== undefined) {
                    deliveryDiv.textContent = '£' + parseFloat(response.deliveryCharge).toFixed(2);
                }
                if (grandTotalDiv && response.grandTotalPrice !== undefined) {
                    grandTotalDiv.textContent = '£' + parseFloat(response.grandTotalPrice).toFixed(2);
                }
            }, function (error) {
                // Error handling fallback
                console.error('Cart update failed:', error);
                button.disabled = false;
                if (loader) loader.classList.add('hidden');
            });
        });

        // $('.remove-cart').on('click', function (e) {
        //     e.preventDefault();
        //     loader.removeClass('hidden');
        //     let button = $(this);
        //     let cartID = button.data('cart');
        //     let closetTableRow = $(this).closest('tr');
        //
        //     ajaxCall(3, cartID, function (response) {
        //         console.log(response);
        //         closetTableRow.remove();
        //         subTotalDiv.html('£ ' + response.subTotalPrice);
        //         deliveryDiv.html('£ ' + response.deliveryCharge);
        //         grandTotalDiv.html('£ ' + response.grandTotalPrice);
        //         button.prop('disabled', false);
        //         loader.addClass('hidden');
        //         $("#merit-cart-count").html(response.count);
        //     })
        // })


        // type 1 = minus call, type 2 = plus call, type 3 = delete
        function ajaxCall(type, cartID, callback) {
            fetch("{{ route('ajax.cart.item') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}", // Standard Laravel CSRF header
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    _token: "{{ csrf_token() }}",
                    type: type,
                    cart_id: cartID
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json(); // Parses JSON response body
                })
                .then(data => {
                    callback(data);
                })
                .catch(error => {
                    console.error('AJAX Error:', error);
                    callback(error);
                });
        }

    </script>
@endpush
