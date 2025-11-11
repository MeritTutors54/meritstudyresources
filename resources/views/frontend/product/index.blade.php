@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'All Books - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')

    <div class="rbt-page-banner-wrapper">
        <!-- Start Banner BG Image  -->
        <div class="rbt-banner-image"></div>
        <!-- End Banner BG Image  -->
        <div class="rbt-banner-content base-margin-top">

            <!-- Start Banner Content Top  -->
            <div class="rbt-banner-content-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Start Breadcrumb Area  -->
                            <ul class="page-list">
                                <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li>
                                    <div class="icon-right"><i class="feather-chevron-right"></i></div>
                                </li>
                                <li class="rbt-breadcrumb-item active">All B</li>
                            </ul>
                            <!-- End Breadcrumb Area  -->

                            <div class=" title-wrapper">
                                <h1 class="title mb--0">All Books</h1>
                                {{--                                <a href="#" class="rbt-badge-2">--}}
                                {{--                                    <div class="image">🎉</div>--}}
                                {{--                                    50 Products--}}
                                {{--                                </a>--}}
                            </div>

{{--                            <p class="description">Products that help beginner designers become true unicorns. </p>--}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Banner Content Top  -->

            <!-- Start Course Top  -->
            <div class="rbt-course-top-wrapper mt--40">
                <div class="container">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-5 col-md-12">
                            <div class="rbt-sorting-list d-flex flex-wrap align-items-center">
                                <div class="rbt-short-item">
                                    <span class="course-index">
                                        Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} results
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Course Top  -->
        </div>
    </div>
    <div class="rbt-shop-area rbt-section-overlayping-top rbt-section-gapBottom">
        <div class="container">
            <div class="row g-5">
                @if(!empty($products))
                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="rbt-default-card style-three rbt-hover">
                                <div class="inner">
                                    <div class="content pt--0 pb--10">
                                        <h2 class="title">
                                            <a href="{{ route('single.product', [$product->slug]) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h2>
                                        <span class="team-form"><span class="location">By MeritTutors</span></span>
                                    </div>
                                    <div class="thumbnail">
                                        <a href="{{ route('single.product', [$product->slug]) }}">
                                            <img
                                                src="{{ asset(\Illuminate\Support\Facades\Storage::url($product->image)) }}"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <div class="rbt-price justify-content-center mt--10">
                                            @if(!empty($product->mirror_discount))
                                                <span class="current-price theme-gradient">£ {{ $product->mirror_discount }}</span>
                                                <span class="off-price">£ {{ $product->mirror_price }}</span>
                                            @else
                                                <span class="current-price theme-gradient">£ {{ $product->mirror_price }}</span>
                                            @endif
                                        </div>
                                        <div class="addto-cart-btn mt--20">
                                            <button
                                                data-product="{{ $product->id }}"
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
            <div class="row">
                <div class="col-lg-12 mt--60">
                    {!! $products->links('pagination::custom') !!}
                </div>
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
                            icon: 'success',
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
