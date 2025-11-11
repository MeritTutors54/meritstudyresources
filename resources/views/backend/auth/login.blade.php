<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <title>Admin Login</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/vendors_css.css')}}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/skin_color.css') }}">

</head>

<body class="hold-transition theme-primary bg-img"
      style="background-image: url({{ asset('backend/assets/images/auth-bg/bg-1.jpg') }})">

<div class="container h-p100">
    <div class="row align-items-center justify-content-md-center h-p100">

        <div class="col-12">
            <div class="row justify-content-center g-0">
                <div class="col-lg-5 col-md-5 col-12">
                    <div class="bg-white rounded10 shadow-lg">
                        <div class="content-top-agile p-20 pb-0">
                            <h2 class="text-primary">Admin Login</h2>
                            @include('layouts.backend.notification')
                        </div>
                        <div class="p-40">
                            <form action="{{ route('admin.login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group {{ $errors->has('email') ? 'mb-1' : 'mb-3' }}">
                                        <span
                                            class="input-group-text bg-transparent {{ $errors->has('email') ? 'border-danger' : '' }}">
                                            <i class="ti-user {{ $errors->has('email') ? 'text-danger' : '' }}"></i>
                                        </span>
                                        <input
                                            type="text"
                                            class="form-control ps-15 bg-transparent {{ $errors->has('email') ? 'border-danger' : '' }}"
                                            name="email"
                                            placeholder="Email">
                                    </div>
                                    @error('email')
                                    <div class="form-control-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="input-group {{ $errors->has('password') ? 'mb-1' : 'mb-3' }}">
                                        <span
                                            class="input-group-text bg-transparent {{ $errors->has('password') ? 'border-danger' : '' }}">
                                            <i class="ti-lock {{ $errors->has('email') ? 'text-danger' : '' }}"></i>
                                        </span>
                                        <input
                                            type="password"
                                            class="form-control ps-15 bg-transparent {{ $errors->has('password') ? 'border-danger' : '' }}"
                                            name="password"
                                            placeholder="Password">
                                    </div>
                                    @error('email')
                                    <div class="form-control-feedback text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-danger mt-10">Login</button>
                                    </div>
                                </div>
                            </form>
                            {{--                            <div class="text-center">--}}
                            {{--                                <p class="mt-15 mb-0">Don't have an account? <a href="auth_register.html" class="text-warning ms-5">Sign Up</a></p>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                    {{--                    <div class="text-center">--}}
                    {{--                        <p class="mt-20 text-white">- Sign With -</p>--}}
                    {{--                        <p class="gap-items-2 mb-20">--}}
                    {{--                            <a class="btn btn-social-icon btn-round btn-facebook" href="#"><i class="fa fa-facebook"></i></a>--}}
                    {{--                            <a class="btn btn-social-icon btn-round btn-twitter" href="#"><i class="fa fa-twitter"></i></a>--}}
                    {{--                            <a class="btn btn-social-icon btn-round btn-instagram" href="#"><i class="fa fa-instagram"></i></a>--}}
                    {{--                        </p>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Vendor JS -->
<script src="{{ asset('backend/assets/js/vendors.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/pages/chat-popup.js') }}"></script>
<script src="{{ asset('backend/assets/icons/feather-icons/feather.min.js') }}"></script>

</body>
</html>
