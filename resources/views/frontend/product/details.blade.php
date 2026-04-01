@extends('layouts.frontend', ['main_title' => $product->name . ' - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $seo['meta_description'] ?? '' }}">
    <meta name="keywords" content="{{ $seo['meta_keywords'] ?? '' }}">
    <meta name="author" content="{{ $seo['meta_author'] ?? '' }}">
@endsection
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container base-margin-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">{{ $product->name }}</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">{{ $product->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="rbt-single-product-area rbt-single-product rbt-section-gap pb-5">
        <div class="container">
            <div class="row g-5 row--30 align-items-center">
                <div class="col-lg-6">
                    <div class="thumbnail">
                        <img class="w-100 radius-10"
                             src="{{ asset(\Illuminate\Support\Facades\Storage::url($product->image)) }}"
                             alt="Product Images">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content">
                        <h1 class="title mt--10 mb--10" style="font-size:30px">{{ $product->name }}</h1>
                        <span class="rbt-label-style description">By: MeritTutor</span>

                        @if(!empty($product->mirror_discount))
                            <div class="rbt-price justify-content-start mt--10">
                                <span class="current-price theme-gradient">{{ $product->mirror_discount }}</span>
                                <span class="off-price">{{ $product->mirror_price }}</span>
                                <span class="ms-3">{{ $product->actual_discount }}% OFF</span>
                            </div>
                        @else

                            <div class="rbt-price justify-content-start mt--10">
                                <span class="current-price theme-gradient">{{ $product->mirror_price }}</span>
                            </div>
                        @endif

                        <p class="mt--20">
                            {{ $product->description }}
                        </p>

                        <div class="product-action mt-5">
                            {{--                            <div class="pro-qty"><input  type="text" value="1"></div>--}}
                            <div class="addto-cart-btn">
                                <button
                                    data-product="{{ $product->id }}"
                                    {{--                                    data-product="14"--}}
                                    class="btn btn-success addToCartButton"
                                    style="font-size: 16px;border-radius: 4px;padding: 12px 32px;">
                                    Add To Cart
                                </button>
                            </div>
                        </div>

                        <ul class="product-feature mt-5">
                            <li>
                                <span>Category: </span>
                                <a href="#">
                                    {{ $product->bookVariant->bookSubject->bookCategory->name }}
                                </a>
                            </li>
                            <li>
                                <span>Subject: </span>
                                <a href="#">
                                    {{ $product->bookVariant->bookSubject->name }}
                                </a>
                            </li>
                            <li>
                                <span>Variant: </span>
                                <a href="#">
                                    {{ $product->bookVariant->name }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-related-product rbt-section-gapBottom bg-color-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mt--50 mb--50">
                        {{--                        <span class="subtitle bg-secondary-opacity">Related Book</span>--}}
                        <h2 class="title">Similar Books</h2>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <!-- Start Single Product  -->
                @if(!empty($relatedProducts))
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="rbt-default-card style-three rbt-hover">
                                <div class="inner">
                                    <div class="content pt--0 pb--10">
                                        <h2 class="title">
                                            <a href="{{ route('single.product', [$relatedProduct->slug]) }}">
                                                {{ $relatedProduct->name }}
                                            </a>
                                        </h2>
                                        <span class="team-form">
                                            <span class="location">By MeritTutor</span>
                                        </span>
                                    </div>
                                    <div class="thumbnail">
                                        <a href="{{ route('single.product', [$relatedProduct->slug]) }}">
                                            <img
                                                src="{{ asset(\Illuminate\Support\Facades\Storage::url($relatedProduct->image)) }}"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <div class="rbt-price justify-content-center mt--10">
                                            @if(!empty($relatedProduct->mirror_discount))
                                                <span
                                                    class="current-price theme-gradient">£ {{ $relatedProduct->mirror_discount }}</span>
                                                <span class="off-price">£ {{ $relatedProduct->mirror_price }}</span>
                                            @else
                                                <span
                                                    class="current-price theme-gradient">£ {{ $relatedProduct->mirror_price }}</span>
                                            @endif
                                        </div>
                                        <div class="addto-cart-btn mt--20">
                                            <button
                                                data-product="{{ $relatedProduct->id }}"
                                                {{--                                    data-product="14"--}}
                                                class="btn btn-success addToCartButton"
                                                style="font-size: 16px;border-radius: 4px;padding: 12px 32px;">
                                                Add To Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <!-- End Single Product  -->
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $('.addToCartButton').on('click', function (e) {
            e.preventDefault();
            const loader = $('#merit-loader');
            let productID = $(this).data('product');
            console.log('ssss', productID, loader);
            loader.removeClass('hidden');
            $(this).prop('disabled', true);

            $.ajax({
                url: '{{ route('ajax.add.cart') }}',
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productID
                },
                success: function (response) {
                    if (response.success) {
                        // Handle successful login
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'Success',
                            customClass: 'swal-wide',
                        })

                        $("#merit-cart-count").html(response.count);
                    }
                    loader.addClass('hidden');
                },
                error: function (error) {
                    if (error.status === 401) {
                        window.location.href = '{{ route('login') }}';
                    } else if (error.status === 422) {
                        let errors = error.responseJSON.errors;
                        let errorMessages = '';
                        $.each(errors, function (key, value) {
                            errorMessages += `${value.join(' ')}`;
                        });

                        Swal.fire({
                            title: 'Error!',
                            text: errorMessages,
                            icon: 'error',
                            customClass: 'swal-wide',
                            confirmButtonText: 'Close'
                        })
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: "An error occurred. Please try again.",
                            icon: 'error',
                            customClass: 'swal-wide',
                            confirmButtonText: 'Close'
                        })
                    }
                    loader.addClass('hidden');
                }
            });

            $(this).prop('disabled', false);
        });
    </script>
@endsection
