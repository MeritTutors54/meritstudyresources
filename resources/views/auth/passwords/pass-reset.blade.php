@extends('layouts.frontend')
@extends('layouts.frontend', ['main_title' => 'Reset Password - MeritStudyResources.co.uk' ])
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
                        <h2 class="title">Password Reset</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Reset Password</li>
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
                    @include('layouts.frontend.notification')

                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                        <form action="{{ route('password.update') }}" method="POST" class="max-width-auto">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <input type="email"
                                       class="@error('email') is-invalid @enderror"
                                       name="email"
                                       id="email"
                                       value="{{ $email ?? old('email') }}"
                                       autocomplete="email" autofocus/>
                                <label for="email">Username or email *</label>
                                <span class="focus-border"></span>
                            </div>

                            <div class="form-group">
                                <input name="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror">
                                <label>Password *</label>
                                <span class="focus-border"></span>
                            </div>

                            <div class="form-group">
                                <input name="password_confirmation" type="password"
                                       class="form-control @error('password') is-invalid @enderror">
                                <label>Confirm Password *</label>
                                <span class="focus-border"></span>
                            </div>

                            <div class="form-submit-group">
                                <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Reset Password</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>

                            <div class="max-width-auto google-login-button mt-5 form-submit-group text-center">
                                Already have any account?
                                <a href="{{ url('login') }}">Login now</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
