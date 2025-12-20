@extends('layouts.frontend', ['main_title' => 'Single Blog - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $seo['meta_description'] ?? '' }}">
    <meta name="keywords" content="{{ $seo['meta_keywords'] ?? '' }}">
    <meta name="author" content="{{ $seo['meta_author'] ?? '' }}">
@endsection
@section('content')
    <style>
        .rbt-page-banner-wrapper {
            padding: 60px 0px 35px;
        }

         .h1 {
    font-size: 34px !important;

}

        h2 {
    font-size: 18px;
    font-weight: 700;
}

        h3{
    font-size: 18px;
    font-weight: 700;

}
.anchor-tag {
    border: 1px solid #247E3D;
    color: #247E3D;
    border-radius: 13px;
    padding: 0px 22px;
    inline-size: max-content;
    margin-top: 17px;
    margin-bottom: 17px;
    transition: 0.2s;
}

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
    <div class="blog_details_main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="blog_details">
                        <!-- Start Blog Details Left -->
                        <div class="blog_details_left">
                            <div class="blog_details_left_contents_main">
                                <div class="bdlcm_img">
                                    @if(empty($blog->cover_image))
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($blog->author->name) }}"
                                             alt="blog-image">
                                    @else
                                        <img
                                            src="{{ asset(\Illuminate\Support\Facades\Storage::url($blog->cover_image)) }}"
                                            alt="blog-image">
                                    @endif
                                    <a href="{{ url('/blogs') }}" class="btn_style" style="padding: 8px 8px 8px 8px;">
{{--                                        <span>--}}
{{--                                            <img src="{{ asset('frontend/assets/images/a-level-exam-booking/arrow-left.png')}}" alt="">--}}
{{--                                            <img src="{{ asset('frontend/assets/vector-left.png')}}" alt="">--}}
{{--                                        </span>--}}
                                        Back
                                    </a>
                                </div>
                                <div class="blog_details_left_title course_overview_title">
                                    <ul>
                                        {{-- <li><a href="#">Exams</a></li> --}}

                                    </ul>
                                    <h1 style="font-size:33px">{{ $blog->title }} </h1>
                                    <p><img src="{{ asset('frontend/calender.png') }}"
                                            alt=""> {{ $blog->created_at->format('F j, Y') }}</p>
                                </div>
                                <div class="blog_details_left_contents">

                                    {!! $blog->details !!}
                                </div>
                            </div>

                        </div>
                        <!-- End Blog Details Left -->

                        <!-- Start Blog Details Right -->
                        <div class="blog_details_right">
                            <div class="blog_details_right_contents">
                                <div class="blog_details_right_single">
                                    <div class="blog_details_right_single_title"><p>Recent Posts</p></div>
                                    <div class="blog_details_right_single_contents">
                                        @foreach ($latestBlogs as $lBlogs)
                                            <div class="bd_contents_single">
                                                <a href="{{ route('blogs.details', $lBlogs->slug) }}">
                            						<span class="recent_post_img">
	                            						<img
                                                            src="{{ asset(\Illuminate\Support\Facades\Storage::url($lBlogs->cover_image)) }}"
                                                            alt="">
	                            					</span>
                                                    <span class="recent_post_contents">
	                            						<p><img src="{{ asset('frontend/calender.png') }}" alt=""> {{ $lBlogs->created_at->format('F j, Y') }}</p>
	                            						<h4>{{ $lBlogs->title }} </h4>
	                            					</span>
                                                </a>
                                            </div>
                                            <div class="refund_policy_border"></div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="blog_details_right_single blog_details_right_single_mt">
                                    <div class="blog_details_right_single_title"><p>Categories</p></div>
                                    <div class="blog_details_right_single_contents">
                                        @if(!empty($categories))
                                            <ul class="bdrs_categories">
                                                @foreach($categories as $category)
                                                    <li>
                                                        <a href="{{ route('blogs', ['q' => $category->slug]) }}">{{ $category->name }}
                                                            <span>{{ $category->validBlogCount }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="blog_details_right_single blog_details_right_single_mt">
                                    <div class="blog_details_right_single_title"><p>Tags</p></div>
                                    <div class="blog_details_right_single_contents">
                                        @if($blog->tags()->count() > 0)
                                            <div class="">
                                                @foreach($blog->tags as $tag)
                                                    <a class="anchor-tag" href="{{ route('blogs', ['p' => $tag->slug]) }}">{{ $tag->name }}</a><br>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End Blog Details Right -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================  End (Blog Details) Section  ================-->
@endsection
