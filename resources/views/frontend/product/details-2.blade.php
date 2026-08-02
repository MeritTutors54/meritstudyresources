@extends('layouts.frontend-2')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@section('content')

    <!-- Start breadcrumb Area -->
    <header class="page-banner" style="padding-bottom:20px;">
        <div class="container">
            <div class="breadcrumb-msr"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; <a
                    href="{{ route('products') }}">Products</a> &nbsp;/&nbsp; {{ $product->title }}
            </div>
        </div>
    </header>

    <!-- ============================= PRODUCT DETAILS ============================= -->
    <section class="section-pad" style="padding-top:24px;">
        <div class="container">
            <div class="row g-5">

                <!-- GALLERY -->
                <div class="col-lg-6">
                    <div class="pd-gallery-main thumb-blue" id="pdMainImage">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->title }}"
                             class="product-thumb-img">
                        <div class="pd-badge-row">
                            @if(!empty($product->yearGroup->year_name))
                                <span class="year-pill">{{ $product->yearGroup->year_name }}</span>
                            @endif

                            @if(!empty($product->discount_percentage))
                                <span class="year-pill discount-pill">{{ $product->discount_percentage }}% OFF</span>
                            @endif
                        </div>
                    </div>
                    <div class="pd-thumb-row">
                        <div class="pd-thumb-sm active"
                             onclick="switchGallery(this, '{{ asset('storage/' . $product->image) }}')">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->title }} sample 1"
                                 class="thumb-sm-img">
                        </div>
                        @if(!empty($product->getSampleImages) && $product->getSampleImages->count() > 0)
                            @foreach($product->getSampleImages as $key => $sampleImage)
                                <div class="pd-thumb-sm"
                                     onclick="switchGallery(this, '{{ asset('storage/' . $sampleImage->path) }}')">
                                    <img src="{{ asset('storage/' . $sampleImage->path) }}"
                                         alt="{{ $product->title }} sample {{ $key + 2 }}"
                                         class="thumb-sm-img">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- INFO -->
                <div class="col-lg-6">
                    <span class="tag-pill-mini">{{ $product->bookVariant->bookCategory->name }}</span>
                    <h1 class="mt-3 mb-2" style="font-size:1.7rem;">{{ $product->title }}</h1>
                    <p class="text-muted-c mb-2">By MeritStudyResource</p>

                    {{--                    <div class="d-flex align-items-center gap-2 mb-1">--}}
                    {{--                        <div class="stars-row d-flex gap-1">--}}
                    {{--                            <svg viewBox="0 0 20 20">--}}
                    {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
                    {{--                            </svg>--}}
                    {{--                            <svg viewBox="0 0 20 20">--}}
                    {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
                    {{--                            </svg>--}}
                    {{--                            <svg viewBox="0 0 20 20">--}}
                    {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
                    {{--                            </svg>--}}
                    {{--                            <svg viewBox="0 0 20 20">--}}
                    {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
                    {{--                            </svg>--}}
                    {{--                            <svg viewBox="0 0 20 20">--}}
                    {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
                    {{--                            </svg>--}}
                    {{--                        </div>--}}
                    {{--                        <span class="text-muted-c" style="font-size:.86rem;">5.0 · 128 reviews</span>--}}
                    {{--                    </div>--}}

                    <div class="pd-price-row">
                        <span class="pd-price-new">£{{ $product->mirror_discount }}</span>
                        <span class="pd-price-old">£{{ $product->mirror_price }}</span>
                        <span class="pd-discount-chip">Save {{ $product->discount_percentage }}%</span>
                    </div>

                    <p class="lead-muted">A complete workbook of targeted, exam-style maths questions for Year 5
                        students, with fully worked examples for every topic — built to bridge classroom learning and
                        independent practice at home.</p>

                    <div class="pd-meta-list">
                        <div class="pd-meta-row"><span>Year group</span>
                            <span>
                                {{ $product->yearGroup->year_name ?? "" }}
                                ({{ $product->bookVariant->name }})
                            </span>
                        </div>
                        <div class="pd-meta-row"><span>Format</span><span>Printable PDF</span></div>
                        <div class="pd-meta-row"><span>SKU</span><span>{{ $product->sku ?? "" }}</span></div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-3 mb-2">
{{--                        <div class="qty-stepper">--}}
{{--                            <button type="button" onclick="stepQty(-1)">−</button>--}}
{{--                            <input type="text" id="pdQty" value="1" readonly>--}}
{{--                            <button type="button" onclick="stepQty(1)">+</button>--}}
{{--                        </div>--}}
                        <button class="addToCartButton btn-brand flex-grow-1 justify-content-center"
                                data-product="{{ $product->id }}"
                                data-title="{{ $product->title }}"
                                style="padding:13px 20px;">
                            Add to Cart
                            <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                                <path d="M3 4h2l2.4 12.4a2 2 0 002 1.6h8.4a2 2 0 002-1.6L21 8H6" stroke="#fff"
                                      stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="10" cy="20" r="1.3" fill="#fff"/>
                                <circle cx="17" cy="20" r="1.3" fill="#fff"/>
                            </svg>
                        </button>
                    </div>

                    <div class="pd-trust-row">
                        <div class="pd-trust-item">
                            <svg viewBox="0 0 24 24" fill="none">
                                <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor"
                                      stroke-width="1.7"/>
                                <path d="M8 10V7a4 4 0 018 0v3" stroke="currentColor" stroke-width="1.7"/>
                            </svg>
                            Secure checkout
                        </div>
                        <div class="pd-trust-item">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3v13m0 0l-4-4m4 4l4-4" stroke="currentColor" stroke-width="1.8"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Instant download
                        </div>
                        <div class="pd-trust-item">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z" stroke="currentColor"
                                      stroke-width="1.7" stroke-linejoin="round"/>
                            </svg>
                            Answer key included
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABS -->
            <div class="pd-tabs">
                <button class="pd-tab-btn active" data-tab="desc">Description</button>
                {{--                <button class="pd-tab-btn" data-tab="inside">What's Inside</button>--}}
                {{--                <button class="pd-tab-btn" data-tab="reviews">Reviews (128)</button>--}}
            </div>

            <div class="pd-tab-panel active" id="tab-desc">
                <div class="article-body" style="max-width:800px;">
                    {!! $product->description !!}
                </div>
            </div>

            {{--            <div class="pd-tab-panel" id="tab-inside">--}}
            {{--                <div class="row g-4" style="max-width:800px;">--}}
            {{--                    <div class="col-sm-6">--}}
            {{--                        <div class="dash-quick-card">--}}
            {{--                            <span class="feature-ico-wrap" style="margin-bottom:0;"><svg viewBox="0 0 24 24"--}}
            {{--                                                                                         fill="none"><path--}}
            {{--                                        d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="1.6"--}}
            {{--                                        stroke-linecap="round"/></svg></span>--}}
            {{--                            <div>--}}
            {{--                                <div class="fw-semibold small">Number &amp; Place Value</div>--}}
            {{--                                <div class="text-muted-c" style="font-size:.8rem;">12 pages</div>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                    <div class="col-sm-6">--}}
            {{--                        <div class="dash-quick-card">--}}
            {{--                            <span class="feature-ico-wrap" style="margin-bottom:0;"><svg viewBox="0 0 24 24"--}}
            {{--                                                                                         fill="none"><circle cx="12"--}}
            {{--                                                                                                             cy="12"--}}
            {{--                                                                                                             r="9"--}}
            {{--                                                                                                             stroke="currentColor"--}}
            {{--                                                                                                             stroke-width="1.6"/></svg></span>--}}
            {{--                            <div>--}}
            {{--                                <div class="fw-semibold small">Fractions &amp; Decimals</div>--}}
            {{--                                <div class="text-muted-c" style="font-size:.8rem;">16 pages</div>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                    <div class="col-sm-6">--}}
            {{--                        <div class="dash-quick-card">--}}
            {{--                            <span class="feature-ico-wrap" style="margin-bottom:0;"><svg viewBox="0 0 24 24"--}}
            {{--                                                                                         fill="none"><rect x="4" y="4"--}}
            {{--                                                                                                           width="16"--}}
            {{--                                                                                                           height="16"--}}
            {{--                                                                                                           rx="2"--}}
            {{--                                                                                                           stroke="currentColor"--}}
            {{--                                                                                                           stroke-width="1.6"/></svg></span>--}}
            {{--                            <div>--}}
            {{--                                <div class="fw-semibold small">Measurement &amp; Geometry</div>--}}
            {{--                                <div class="text-muted-c" style="font-size:.8rem;">18 pages</div>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                    <div class="col-sm-6">--}}
            {{--                        <div class="dash-quick-card">--}}
            {{--                            <span class="feature-ico-wrap" style="margin-bottom:0;"><svg viewBox="0 0 24 24"--}}
            {{--                                                                                         fill="none"><path--}}
            {{--                                        d="M5 4h14v16H5z" stroke="currentColor" stroke-width="1.6"/></svg></span>--}}
            {{--                            <div>--}}
            {{--                                <div class="fw-semibold small">Statistics &amp; Answer Key</div>--}}
            {{--                                <div class="text-muted-c" style="font-size:.8rem;">18 pages</div>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            {{--            <div class="pd-tab-panel" id="tab-reviews" style="max-width:800px;">--}}
            {{--                <div class="review-item">--}}
            {{--                    <span class="rv-avatar" style="background:#3D6BFF;">JM</span>--}}
            {{--                    <div>--}}
            {{--                        <span class="rv-name">Jamie M.<span class="rv-date">2 weeks ago</span></span>--}}
            {{--                        <div class="stars-row d-flex gap-1 my-1">--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                        </div>--}}
            {{--                        <p>My daughter found the worked examples really helpful — she could see exactly how to approach--}}
            {{--                            each type of question before trying it herself.</p>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--                <div class="review-item">--}}
            {{--                    <span class="rv-avatar" style="background:#F3A93C;">AR</span>--}}
            {{--                    <div>--}}
            {{--                        <span class="rv-name">Aisha R.<span class="rv-date">1 month ago</span></span>--}}
            {{--                        <div class="stars-row d-flex gap-1 my-1">--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                        </div>--}}
            {{--                        <p>Good progression of difficulty and the print quality is great. Would recommend for anyone--}}
            {{--                            doing SATs prep.</p>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--                <div class="review-item">--}}
            {{--                    <span class="rv-avatar" style="background:var(--green);">TB</span>--}}
            {{--                    <div>--}}
            {{--                        <span class="rv-name">Tom B.<span class="rv-date">2 months ago</span></span>--}}
            {{--                        <div class="stars-row d-flex gap-1 my-1">--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                            <svg viewBox="0 0 20 20" style="opacity:.25;">--}}
            {{--                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>--}}
            {{--                            </svg>--}}
            {{--                        </div>--}}
            {{--                        <p>Solid workbook overall. Would like to see a couple more reasoning-style questions in the--}}
            {{--                            fractions section.</p>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </section>

    <!-- ============================= RELATED PRODUCTS ============================= -->
    <section class="section-pad bg-mint">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width:600px;">
                <span class="eyebrow"><span class="divider-dot"></span> YOU MAY ALSO LIKE</span>
                <h2 class="mt-4" style="font-size:1.9rem;">Related products</h2>
            </div>
            <div class="row g-4">
                @if(!empty($relatedProducts))
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-sm-6 col-lg-3">
                            <div class="product-card">
                                <div class="discount-ribbon">{{ $relatedProduct->discount_percentage }}% OFF</div>
                                <a class="product-thumb-container"
                                   href="{{ route('single.product', [$relatedProduct->slug]) }}">
                                    <img src="{{ asset('storage/' . $relatedProduct->image) }}"
                                         alt="{{ $relatedProduct->title }}"
                                         class="product-thumb-img">

                                    <div class="product-thumb-overlay">
                                        <span class="year-pill">{{ $relatedProduct->yearGroup->year_name ?? "" }}</span>
                                    </div>
                                </a>
                                <div class="p-3">
                                    <h3 class="h6 mb-1">
                                        <a href="{{ route('single.product', [$relatedProduct->slug]) }}"
                                           style="color:var(--navy);">
                                            {{ $relatedProduct->title }}
                                        </a>
                                    </h3>
                                    <p class="small text-muted-c mb-2">MeritStudyResource</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="price-new">£{{ $relatedProduct->mirror_discount }}</span>
                                            <span class="price-old">£{{ $relatedProduct->mirror_price }}</span>
                                        </div>
                                    </div>
                                    <div class="prod-card-actions">
                                        <a href="{{ route('single.product', [$relatedProduct->slug]) }}"
                                           class="btn-ghost-navy flex-grow-1 justify-content-center"
                                           style="padding:9px 14px;">View Product</a>
                                        <button class="addToCartButton add-cart-icon-btn" type="button"
                                                data-product="{{ $relatedProduct->id }}"
                                                data-title="{{ $relatedProduct->title }}"
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
                @endif


            </div>
        </div>
    </section>

    <!-- ============================= CART TOAST ============================= -->
    <div class="cart-toast" id="cartToast">
        <span class="ct-ico">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M5 13l4 4L19 7" stroke="#fff"
                      stroke-width="2.4" stroke-linecap="round"
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
    <script>
        function switchGallery(element, imageSrc) {
            // 1. Remove active class from all thumbnails
            document.querySelectorAll('.pd-thumb-sm').forEach(thumb => {
                thumb.classList.remove('active');
            });

            // 2. Add active class to clicked thumbnail
            element.classList.add('active');

            // 3. Update main image source
            const mainImg = document.querySelector('#pdMainImage .product-thumb-img');
            if (mainImg) {
                mainImg.src = imageSrc;
            }
        }
    </script>
@endpush
