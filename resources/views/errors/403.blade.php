{{--<style>--}}
{{--    @import url("https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900|Nunito:200,300,400,600,700,800,900&display=swap");--}}

{{--    body {--}}
{{--        font-family: "Nunito", sans-serif;--}}
{{--        transition: all 0.5s ease;--}}
{{--    }--}}

{{--    .error-text {--}}
{{--        color: black !important;--}}
{{--        font-size: 22px !important;--}}
{{--    }--}}

{{--    h1,--}}
{{--    h2,--}}
{{--    h3,--}}
{{--    h4,--}}
{{--    h5,--}}
{{--    h6 {--}}
{{--        font-family: "Montserrat", sans-serif;--}}
{{--    }--}}
{{--    .page-wrap {--}}
{{--        padding: 30px 15px;--}}
{{--        text-align: center;--}}
{{--        display: flex;--}}
{{--        align-items: center;--}}
{{--        .page-not-found {--}}
{{--            width: 400px;--}}
{{--            margin-left: auto;--}}
{{--            margin-right: auto;--}}
{{--            position: relative;--}}
{{--            .img-key {--}}
{{--                margin-bottom: 0px;--}}
{{--            }--}}
{{--            h1.text-xl {--}}
{{--                color: #000;--}}
{{--                text-transform: uppercase;--}}
{{--                line-height: 50px;--}}
{{--                font-size: 160px;--}}
{{--                font-weight: 800;--}}
{{--                letter-spacing: -28px;--}}
{{--                text-shadow: -6px 4px 0px #fff;--}}
{{--                margin-left: -20px;--}}
{{--                margin-top: 50px;--}}
{{--                margin-bottom: 50px;--}}
{{--                span {--}}
{{--                    transition: all 1s ease;--}}
{{--                    display: inline-block;--}}
{{--                    animation: pulse 5s infinite;--}}
{{--                }--}}
{{--            }--}}
{{--            h4.text-md,--}}
{{--            h4.text-sm {--}}
{{--                letter-spacing: 0.38px;--}}
{{--                font-weight: 300;--}}
{{--                line-height: 20px;--}}
{{--                font-size: 14px;--}}
{{--                text-transform: none;--}}
{{--                color: rgba(0, 0, 0, 0.5);--}}
{{--                margin-bottom: 0px;--}}
{{--                width: 100%;--}}
{{--                a {--}}
{{--                    color: #1177bd;--}}
{{--                    text-decoration: underline;--}}
{{--                    font-weight: 700;--}}
{{--                    &:hover,--}}
{{--                    &:focus {--}}
{{--                        text-decoration: none;--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--            h4.text-md {--}}
{{--                font-size: 50px;--}}
{{--                font-weigth: 700;--}}
{{--                color: #1177bd;--}}
{{--                text-transform: none;--}}
{{--            }--}}
{{--            h4.text-sm-btm {--}}
{{--                top: auto;--}}
{{--                bottom: 40px;--}}
{{--            }--}}
{{--        }--}}
{{--    }--}}
{{--    @keyframes pulse {--}}
{{--        0% {--}}
{{--            color: #000;--}}
{{--        }--}}
{{--        50% {--}}
{{--            color: rgba(240, 48, 48, 1);--}}
{{--        }--}}
{{--        100% {--}}
{{--            color: #000;--}}
{{--        }--}}
{{--    }--}}
{{--    @media (max-width: 768px) {--}}
{{--        .page-wrap {--}}
{{--            .page-not-found {--}}
{{--                h1.text-xl {--}}
{{--                    font-size: 120px;--}}
{{--                    letter-spacing: -20px;--}}
{{--                    margin-bottom: 30px;--}}
{{--                }--}}
{{--                h4.text-sm {--}}
{{--                    top: 10px;--}}
{{--                }--}}
{{--                h4.text-sm-btm {--}}
{{--                    bottom: -60px;--}}
{{--                }--}}
{{--                h4.text-md {--}}
{{--                    font-size: 30px;--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}
{{--    }--}}

{{--</style>--}}

{{--@php--}}
{{--    $previousUrl = url()->previous();--}}
{{--@endphp--}}

{{--<div class="page-wrap">--}}
{{--    <div class="page-not-found">--}}
{{--        <img src="https://res.cloudinary.com/razeshzone/image/upload/v1588316204/house-key_yrqvxv.svg" class="img-key"--}}
{{--             alt="">--}}
{{--        <h1 class="text-xl">--}}
{{--            <span>4</span>--}}
{{--            <span>0</span>--}}
{{--            <span class="broken">3</span>--}}
{{--        </h1>--}}
{{--        <h4 class="text-md">Access Denied !</h4>--}}
{{--        <h4 class="text-sm text-sm-btm error-text">--}}
{{--            {{ $exception->getMessage() }}--}}
{{--        </h4>--}}
{{--        <div style="margin-top: 30px">--}}
{{--            @if($previousUrl && $previousUrl !== url()->current())--}}
{{--                <a href="{{ url()->previous() }}">previous page</a>--}}
{{--            @else--}}
{{--                <a href="{{ route('home') }}">Go to Homepage</a>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/favicon.ico">

    <title>EduAdmin - 404 Page not found </title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/vendors_css.css')}}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/skin_color.css')}}">

</head>
<body class="hold-transition theme-primary bg-img">

<section class="error-page h-p100">
    <div class="container h-p100">
        <div class="row h-p100 align-items-center justify-content-center text-center">
            <div class="col-lg-7 col-md-10 col-12">
                <div class="rounded10 p-50">
                    <h1 style="font-size: 220px">403</h1>
                    <h1>Unauthorized Access !</h1>
                    <h3>looks like, you don't have the permission</h3>
                    @if(isset($previousUrl) && $previousUrl !== url()->current())
                        <a class="btn btn-danger" href="{{ url()->previous() }}">Go previous page</a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-danger">Back to homepage</a>
                    @endif

                </div>
            </div>
        </div>
    </div>

</section>


<!-- Vendor JS -->
<script src="{{ asset('backend/assets/js/vendors.min.js')}}"></script>
<script src="{{ asset('backend/assets/js/pages/chat-popup.js')}}"></script>
<script src="{{ asset('backend/assets/icons/feather-icons/feather.min.js')}}"></script>


</body>
</html>
