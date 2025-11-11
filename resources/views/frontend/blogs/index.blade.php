@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Blogs - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')

    <style>
        .rbt-page-banner-wrapper {
            padding: 60px 0 35px;
        }


        ul {
            display: flex;;
        }


        /*==================== End (Blogs) Page ====================*/
    </style>
    <div class="rbt-page-banner-wrapper">
        <!-- Start Banner BG Image  -->
        <div class="rbt-banner-image"></div>
        <!-- End Banner BG Image  -->
        <div class="rbt-banner-content">

            <!-- Start Banner Content Top  -->
            <div class="rbt-banner-content-top">
                <div class="container base-margin-top">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Start Breadcrumb Area  -->
                            <ul class="page-list">
                                <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li>
                                    <div class="icon-right"><i class="feather-chevron-right"></i></div>
                                </li>
                                <li class="rbt-breadcrumb-item active">All Blogs</li>
                            </ul>
                            <!-- End Breadcrumb Area  -->
                            <div class="title-wrapper">
                                <h1 class="title mb--0">All Blogs</h1>

                            </div>
                            <p class="description">Get more information and insights — explore our latest blogs
                                below.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Banner Content Top  -->
        </div>
    </div>

    <section class="blogs_main mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="blogs">
                        <div class="blogs_contents">
                            @if(isset($blogs) && $blogs->isNotEmpty())
                                @foreach($blogs as $blog)
                                    <div class="blogs_content_single">
                                        <img
                                            src="{{ asset(\Illuminate\Support\Facades\Storage::url($blog->cover_image)) }}"
                                            alt="">
                                        <h4> {{ $blog->title }}</h4>
                                        <p><img src="{{ asset('frontend/calender.png') }}" alt="">
                                            Updated {{ $blog->created_at->format('F j, Y') }}</p>
                                        <div class="blogs_btns">
                                            <a href="{{ route('blogs.details', $blog->slug) }}" class="btn_style">Read
                                                More</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="blog_page_count exam_fees_modal_page_count">
                            {{ isset($blogs) ? $blogs->links('pagination::blog') : ''}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================  End (Blogs) Section  ================-->
@endsection
