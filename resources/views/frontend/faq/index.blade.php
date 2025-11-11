@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'FAQs - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container base-margin-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Faqs</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Faqs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <!-- Start Accordion Area  -->
    <div class="rbt-accordion-area accordion-style-1 bg-color-white rbt-section-gap pt--40">
        <div class="container">
            <div class="row g-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="rbt-accordion-style accordion">
                        <div class="section-title text-start mb--60 text-center">
                            <h4 class="title">Merit Hub Frequently Asked Question</h4>
                        </div>
                        <div class="rbt-accordion-style rbt-accordion-04 accordion">
                            <div class="accordion" id="faqs-accordionExamplec3">

                                @if(!empty($faqs))
                                    @foreach($faqs as $k => $item)
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header card-header" id="faqs-headingThree{{ $k }}">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#faqs-collapseThree{{ $k }}" aria-expanded="true"
                                                        aria-controls="faqs-collapseThree{{ $k }}">
                                                    {{ $item->question }}?
                                                </button>
                                            </h2>

                                            <div id="faqs-collapseThree{{ $k }}" class="accordion-collapse collapse show"
                                                 aria-labelledby="faqs-headingThree{{ $k }}" data-bs-parent="#faqs-accordionExamplec3">
                                                <div class="accordion-body card-body">
                                                    {{ $item->answer }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Accordion Area  -->

          @include('frontend.home.testimonial')
    @include('frontend.home.subscription')
@endsection
