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

    <div class="checkout_area bg-color-white">
        <div class="container">
            <form action="{{ route('user.subscription.checkout') }}" method="post" id="card-payment-form">
                @csrf
                <div class="row g-5 checkout-form">
                    <div class="col-lg-7">
                        <div class="checkout-content-wrapper">
                            <!-- Billing Address -->
                            <div id="billing-form">
                                <h4 class="checkout-title">Card Information</h4>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <input type="hidden" name="plan_id" value="{{ $subscriptionPlan->id }}">
                                        <label>Card Holder Name</label>
                                        <input id="card-holder-name"
                                               name="card_holder_name"
                                               type="text" placeholder="Card Holder Name" value="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <label>Details</label>
                                        <div id="card-element"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Shipping Address -->
                        </div>
                        <div class="mt-4 single-method">
                            <input type="checkbox" id="accept_terms">
                            <label for="accept_terms">
                                I’ve read and accept the
                                <a target="_blank" style="color: #0d6efd" href="{{ route('terms-condition') }}">
                                    terms & conditions
                                </a>
                            </label>
                            <div id="terms_error" style="color: red; display: none; font-size: 13px;">You must accept the terms and conditions.</div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="row pl--50 pl_md--0 pl_sm--0">
                            <!-- Cart Total -->
                            <div class="col-12">
                                <h4 class="checkout-title">Total</h4>
                                <div class="checkout-cart-total text-left">
                                    <h4 class="mb-0">
                                        {{ ucfirst($subscriptionPlan->name) ?? '' }}
                                    </h4>
                                    <p class="">
                                        For {{ \App\Enums\SubscriptionType::from($subscriptionPlan->type)->name }}
                                    </p>
                                    <ul class="mt-4">
                                        <li>
                                            <i class="fa-solid fa-circle-check"></i>
                                            User Limit: {{ $subscriptionPlan->user_limit }}
                                        </li>
                                        <li>
                                            <i class="fa-solid fa-circle-check"></i>
                                            Package Download
                                            Limit: {{ $subscriptionPlan->download_limit }}
                                        </li>
                                        <li>
                                            <i class="fa-solid fa-circle-check"></i>
                                            Weekly Download Limit: {{ $subscriptionPlan->weekly_limit }}
                                        </li>
                                        <li>
                                            <i class="fa-solid fa-circle-check"></i>
                                            Has Full
                                            Access: {{ \App\Enums\Statement::from($subscriptionPlan->has_full_access)->name }}
                                        </li>
                                        <li>
                                            <i class="fa-solid fa-circle-check"></i>
                                            Trial Days: {{ $subscriptionPlan->trial_days }}
                                        </li>
                                    </ul>
                                    <h5 class="mt--30">
                                        Grand Total
                                        <span>
                                            £ {{ $subscriptionPlan->price }} / {{ strtolower(\App\Enums\SubscriptionDuration::from($subscriptionPlan->duration)->name) }}
                                        </span>
                                    </h5>
                                </div>
                            </div>
                            <!-- Payment Method -->
                            <div class="col-12 mb--60">
                                <div class="plceholder-button mt-5 text-end">
                                    <button id="payemnt-button"
                                        data-secret="{{ $intent->client_secret }}"
                                        type="submit" class="rbt-btn btn-gradient hover-icon-reverse">
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
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ $stripe_key }}')

        const elements = stripe.elements()
        const style = {
            base: {
                color: '#495057',
                fontSize: '16px',
                fontFamily: 'inherit',
                '::placeholder': {
                    color: '#6c757d'
                }
            },
            invalid: {
                color: '#dc3545'
            }
        };

        const accept_terms = document.getElementById('accept_terms');
        const termsError = document.getElementById('terms_error');



        const cardElement = elements.create('card', {
            style,
            hidePostalCode: true
        })

        cardElement.mount("#card-element");

        const form = document.getElementById('card-payment-form');
        const paymentButton = document.getElementById('payemnt-button');
        const cardHolderField = document.getElementById('card-holder-name');

        const loader = document.getElementById('merit-loader');

        // loader.classList.remove('hidden');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            loader.classList.remove('hidden');
            paymentButton.disabled = true;

            if (!accept_terms.checked) {
                termsError.style.display = 'block';
                paymentButton.disabled = false;
                loader.classList.add('hidden');

                return;
            } else {
                termsError.style.display = 'none';
            }

            const {setupIntent, error} = await stripe.confirmCardSetup(
                paymentButton.dataset.secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderField.value
                        }
                    }
                }
            )

            if (error) {
                if (error.type === "card_error" || error.type === "invalid_request_error") {
                    Swal.fire({
                        title: 'Error!',
                        text: error.message,
                        icon: 'error',
                        customClass: 'swal-wide',
                        confirmButtonText: 'Close'
                    })
                }

                paymentButton.disabled = false;
                loader.classList.add('hidden');
            } else {
                let token = document.createElement('input');
                token.setAttribute('type', 'hidden');
                token.setAttribute('name', 'stripe_token');
                token.setAttribute('value', setupIntent.payment_method);

                form.appendChild(token);

                form.submit();
            }
        })

    </script>
@endsection
