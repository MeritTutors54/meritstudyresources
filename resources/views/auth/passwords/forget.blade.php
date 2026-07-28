@extends('layouts.frontend')

@section('title', 'Forget Password - ' . $global_seo['seo_title'])

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
                        <form action="{{ route('forget.password.form') }}" method="POST" class="max-width-auto">
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

                            <div class="form-submit-group">
                                <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Sent verification code</span>
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
