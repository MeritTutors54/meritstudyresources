@extends('layouts.frontend')
@extends('layouts.frontend', ['main_title' => 'Login - MeritStudyResources.co.uk' ])
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
                        <h2 class="title">Login</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Login</li>
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
                        <h3 class="title">Login</h3>
                        <form action="{{ route('login') }}" method="POST" class="max-width-auto">
                            @csrf

                            <div class="form-group">
                                <input type="text"
                                       class="@error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}"
                                       autocomplete="email" autofocus/>
                                <label>Username or email *</label>
                                <span class="focus-border"></span>
                            </div>
                            <div class="form-group">
                                <input name="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror">
                                <label>Password *</label>
                                <span class="focus-border"></span>
                            </div>

                            <div class="row mb--30">
                                <div class="col-lg-6">
                                    <div class="rbt-checkbox">
                                        <input type="checkbox" id="rememberme" name="rememberme">
                                        <label for="rememberme">Remember me</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="rbt-lost-password text-end">
                                        <a class="rbt-btn-link" href="{{ route('forget.password.form') }}">Lost your password?</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-submit-group">
                                <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Log In</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>
                            <div class="max-width-auto google-login-button mt-5 form-submit-group text-center">
                                <a href="{{ url('auth/google') }}"
                                   class="login-with-google-btn">
                                    Sign in with Google
                                </a>
                            </div>
                            <div class="max-width-auto google-login-button mt-5 form-submit-group text-center">
                                Don't have any account?
                                <a href="{{ url('register') }}">Register now</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
