@extends('layouts.frontend', ['main_title' => 'Pricing - Warning - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container base-margin-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Pricing</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Pricing</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rbt-pricing-area bg-color-white">
        <div class="container">
            <div class="row g-5 mb--60">
                <div class="col-lg-6 col-md-6 col-12">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
