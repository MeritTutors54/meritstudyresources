
@extends('layouts.frontend', [
    'main_title' => (optional($defaultSEO)->meta_title ?? 'Return Policies - MeritStudyResources.co.uk') . ' Refund'
])
@section('page-seo')
    <meta name="description" content="Refund Policy ,{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
<style>
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
</style>
    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container base-margin-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Refund Policy</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Refund Policy</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->
    <div class="rbt-about-area about-style-1 rbt-section-gapTop pb--30 pb_md--80 pb_sm--80 bg-color-white">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-12">
                    @if(!empty($refundPolicy))
                        {!! $refundPolicy !!}
                    @endif
                </div>
            </div>
        </div>
    </div>


    @include('frontend.home.testimonial')
    @include('frontend.home.subscription')
@endsection
