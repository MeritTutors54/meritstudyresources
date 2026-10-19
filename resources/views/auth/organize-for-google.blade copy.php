@extends('layouts.frontend')

@section('title', 'Select Organization - ' . $global_seo['seo_title'])

@section('content')
    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container base-margin-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Register</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Register</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <div class="rbt-elements-area bg-color-white rbt-section-gap pt-5">
        <div class="container">
            <div class="row gy-5 row--30 justify-content-center">
                <div class="col-lg-6">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                        <h3 class="title">Select Your Organization</h3>
                        <form action="{{ route('google.final.callback') }}" method="POST" class="max-width-auto">
                            @csrf

                            <input type="hidden" name="data" value="{{ old('data', $encrypted ?? '') }}">

                            <div class="d-flex justify-content-center">
                                <ul class="organize-list">
                                    <li class="organize-list-item">
                                        <input type="radio" name="type" id="cb1" value="1" />
                                        <label for="cb1">
                                            <img width="100px" src="{{ asset('frontend/assets/svgs/person.svg') }}" alt="aaa"/>
                                        </label>
                                    </li>
                                    <li class="organize-list-item">
                                        <input type="radio" name="type" id="cb2" value="2" />
                                        <label for="cb2">
                                            <img width="100px" src="{{ asset("frontend/assets/svgs/school.svg") }}" alt=""/>
                                        </label>
                                    </li>
                                </ul>
                            </div>

                            <div class="form-submit-group mt-5">
                                <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Confirm Organization</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
