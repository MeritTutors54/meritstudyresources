@extends('layouts.frontend-2')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@section('content')
    <!-- ============================= PAGE HEADER ============================= -->
    <header class="page-banner">
        <div class="container">
            <div class="breadcrumb-msr mb-3"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; Products</div>
            <span class="eyebrow"><span class="divider-dot"></span> OUR PRODUCTS</span>
            <h1 class="mt-4 mb-3">Workbooks &amp; resources for <span class="text-green">every year group.</span></h1>
            <p class="lead-muted mb-4" style="max-width:580px;">Printable, tutor-written workbooks for Years 3–6, GCSE,
                iGCSE and A Level — built around targeted, exam-style questions.</p>


        </div>
    </header>

    <!-- ============================= FILTER + GRID ============================= -->
    <section class="section-pad" style="padding-top:36px;">
        <div class="container">
            {{--            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-5">--}}
            {{--                <div class="prod-cat-row" id="prodCats">--}}
            {{--                    <button class="prod-cat-btn active" data-cat="all">All</button>--}}
            {{--                    <button class="prod-cat-btn" data-cat="ks2">Years 3–6</button>--}}
            {{--                    <button class="prod-cat-btn" data-cat="gcse">GCSE</button>--}}
            {{--                    <button class="prod-cat-btn" data-cat="igcse">iGCSE</button>--}}
            {{--                    <button class="prod-cat-btn" data-cat="alevel">A Level</button>--}}
            {{--                </div>--}}
            {{--                <select class="prod-sort-select" id="prodSort">--}}
            {{--                    <option value="popular">Sort by: Popular</option>--}}
            {{--                    <option value="price-low">Price: Low to High</option>--}}
            {{--                    <option value="price-high">Price: High to Low</option>--}}
            {{--                    <option value="rating">Highest Rated</option>--}}
            {{--                </select>--}}
            {{--            </div>--}}

            <div class="row g-4" id="prodGrid">
                @if(!empty($products))
                    @foreach($products as $product)

                        <div class="col-sm-6 col-lg-3">
                            <div class="product-card">
                                <div class="discount-ribbon">{{ $product->discount_percentage }}% OFF</div>
                                <a class="product-thumb-container"
                                   href="{{ route('single.product', [$product->slug]) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->title }}"
                                         class="product-thumb-img">

                                    <div class="product-thumb-overlay">
                                        <span class="year-pill">{{ $product->yearGroup->year_name ?? "" }}</span>
                                    </div>
                                </a>
                                <div class="p-3">
                                    <h3 class="h6 mb-1">
                                        <a href="{{ route('single.product', [$product->slug]) }}"
                                           style="color:var(--navy);">
                                            {{ $product->title }}
                                        </a>
                                    </h3>
                                    <p class="small text-muted-c mb-2">MeritStudyResource</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="price-new">£{{ $product->mirror_discount }}</span>
                                            <span class="price-old">£{{ $product->mirror_price }}</span>
                                        </div>
                                    </div>
                                    <div class="prod-card-actions">
                                        <a href="{{ route('single.product', [$product->slug]) }}"
                                           class="btn-ghost-navy flex-grow-1 justify-content-center"
                                           style="padding:9px 14px;">View Product</a>
                                        <button class="addToCartButton add-cart-icon-btn" type="button"
                                                data-product="{{ $product->id }}"
                                                data-title="{{ $product->title }}"
                                                aria-label="Add to cart">
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M3 4h2l2.4 12.4a2 2 0 002 1.6h8.4a2 2 0 002-1.6L21 8H6"
                                                      stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                                      stroke-linejoin="round"/>
                                                <circle cx="10" cy="20" r="1.3" fill="currentColor"/>
                                                <circle cx="17" cy="20" r="1.3" fill="currentColor"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-muted-c mt-4" id="prodNoResults">
                        No products match your search — try a different term.
                    </p>
                @endif
            </div>
        </div>
    </section>

    <!-- ============================= NEWSLETTER ============================= -->
    <section class="section-pad bg-mint">
        @include('frontend.includes.newsletter')
    </section>

    <!-- ============================= CART TOAST ============================= -->
    <div class="cart-toast" id="cartToast">
        <span class="ct-ico">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M5 13l4 4L19 7" stroke="#fff" stroke-width="2.4" stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </span>
        <span id="cartToastText">Added to cart</span>
    </div>

@endsection
@push('js')
    <script>
        function showCartToast(name){
            const toast = document.getElementById('cartToast');
            if(!toast) return;
            document.getElementById('cartToastText').textContent = `Added "${name}" to cart`;
            toast.classList.add('show');
            clearTimeout(window._cartToastTimer);
            window._cartToastTimer = setTimeout(() => toast.classList.remove('show'), 2800);
        }

        function increaseCartCount(amount) {
            const counter = document.getElementById('cartCount');
            if (counter) {
                counter.innerHTML = amount;
            }
        }

        document.querySelectorAll('.addToCartButton').forEach(button => {
            button.addEventListener('click', async function (e) {
                e.preventDefault();

                const currentButton = this;
                const loader = document.getElementById('merit-loader');
                const productID = currentButton.dataset.product;
                const productTitle = currentButton.dataset.title;

                // Show loader & disable button
                if (loader) loader.classList.remove('hidden');
                currentButton.disabled = true;

                try {
                    const response = await fetch("{{ route('ajax.add.cart') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            product_id: productID
                        })
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showCartToast(productTitle);

                        increaseCartCount(data.count);
                    } else if (response.status === 401) {
                        window.location.href = "{{ route('login') }}";
                    } else if (response.status === 422) {
                        // Handle Laravel validation errors
                        let errorMessages = Object.values(data.errors)
                            .flatMap(val => val)
                            .join(' ');
                    } else {
                        throw new Error('Server error');
                    }
                } catch (error) {
                    // Catches network failures or unexpected server responses
                    // Swal.fire({
                    //     title: 'Error!',
                    //     text: "An error occurred. Please try again.",
                    //     icon: 'error',
                    //     customClass: 'swal-wide',
                    //     confirmButtonText: 'Close'
                    // });
                    console.log(error)
                } finally {
                    // Always hide loader and re-enable button when done
                    if (loader) loader.classList.add('hidden');
                    currentButton.disabled = false;
                }
            });
        });
    </script>
@endpush
