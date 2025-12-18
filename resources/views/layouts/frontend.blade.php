<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $main_title ?? '' }}</title>
    @yield('page-seo')
    {{--    <meta name="google-site-verification" content="{{ $seoSettings->google_verification ?? '' }}">--}}
    {{--    <meta name="msvalidate.01" content="{{ $seoSettings->bing_verification ?? '' }}">--}}
    <meta name="robots" content="index, follow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    @if(isset($settings) && !empty($settings->site_favicon))
        <link rel="icon" href="{{ asset(\Illuminate\Support\Facades\Storage::url($settings->site_favicon)) }}">
    @else
        <link rel="shortcut icon" type="image/x-icon"
              href="{{ asset('frontend/assets/images/merithub/favicon.png?v=' . $v) }}">
    @endif


    <!-- CSS
	============================================ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.min.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.theme.default.min.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendor/bootstrap.min.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendor/slick.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendor/slick-theme.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/sal.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/feather.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/fontawesome.min.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/euclid-circulara.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/swiper.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/odometer.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/animation.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/bootstrap-select.min.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/jquery-ui.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/magnigy-popup.min.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/plyr.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style-munna.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive-munna.css?v=' . $v) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css?v=' . $v) }}">
    {{--    @if (!empty($seoSettings->google_analytics))--}}
    {{--        {!! $seoSettings->google_analytics !!}--}}
    {{--    @endif--}}
    @yield('page-css')

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YDG4M0JY4F"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-YDG4M0JY4F');
    </script>

</head>

<body class="rbt-header-sticky">

<div id="showPDF" class="big-overlay d-none">
    <button id="showPDFClose" class="close-btn" onclick="hideOverlay()">✖</button>
    <div class="overlay-text">
        <div class="">
            <iframe id="pdfFrame" src=""
                    style="width:100%; height:80vh;" frameborder="0"></iframe>
        </div>
    </div>
</div>


<!-- Loader Overlay -->
<div class="loader-overlay hidden" id="merit-loader">
    <div class="loader"></div>
</div>

{{--<div id="my_switcher" class="my_switcher">--}}
{{--    <ul>--}}
{{--        <li>--}}
{{--            <a href="javascript: void(0);" data-theme="light" class="setColor light">--}}
{{--                <img src="{{ asset('frontend/assets/images/about/sun-01.svg') }}" alt="Sun images"><span--}}
{{--                    title="Light Mode"> Light</span>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <a href="javascript: void(0);" data-theme="dark" class="setColor dark">--}}
{{--                <img src="{{ asset('frontend/assets/images/about/vector.svg') }}" alt="Vector Images"><span--}}
{{--                    title="Dark Mode"> Dark</span>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</div>--}}

@include('layouts.frontend.header')
@include('layouts.frontend.mobile-menu')

@yield('content')

@include('layouts.frontend.footer')


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JS
============================================ -->
<!-- Modernizer JS -->
<script src="{{ asset('frontend/assets/js/vendor/modernizr.min.js?v=' . $v) }}"></script>
<!-- jQuery JS -->
<script src="{{ asset('frontend/assets/js/vendor/jquery.js?v=' . $v) }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('frontend/assets/js/vendor/bootstrap.min.js?v=' . $v) }}"></script>
<!-- sal.js -->
<script src="{{ asset('frontend/assets/js/vendor/sal.js?v=' . $v) }}"></script>
<!-- Dark Mode Switcher -->
<script src="{{ asset('frontend/assets/js/vendor/js.cookie.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery.style.switcher.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/swiper.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery-appear.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/odometer.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/backtotop.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/isotop.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/imageloaded.js?v=' . $v) }}"></script>


<script src="{{ asset('frontend/assets/js/vendor/wow.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/waypoint.min.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/easypie.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/text-type.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery-one-page-nav.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/bootstrap-select.min.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery-ui.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/magnify-popup.min.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/paralax-scroll.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/paralax.min.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/countdown.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/plyr.js?v=' . $v) }}"></script>
<!-- Main JS -->
<script src="{{ asset('frontend/assets/js/owl.carousel.min.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/main.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/script.js?v=' . $v) }}"></script>
<script src="{{ asset('frontend/assets/js/dev.js?v=' . $v) }}"></script>


<script>
    $("#showPDFClose").on('click', function () {
        $("#showPDF").addClass('d-none');
        $('#pdfFrame').attr('src', "");
    })

    function hideOverlay() {
        let overlay = document.getElementById("showPDF");
        overlay.classList.add('d-none');
    }


    const custom_submenu = document.querySelector('.custom-submenu');
    if (custom_submenu.offsetWidth > 500) {
        custom_submenu.style.left = '-22%'
    } else if (custom_submenu.offsetWidth > 800) {
        custom_submenu.style.left = '-44%'
    } else if (custom_submenu.offsetWidth > 1200) {
        custom_submenu.style.left = '-66%'
    } else {
        custom_submenu.style.left = '50%'
    }

    // const element = document.querySelector('.has-custom-submenu');
    //
    // element.addEventListener('mouseover', function() {
    //     console.log('Event triggered');
    //     custom_submenu.style.display = 'flex';
    // });

</script>

@yield('js')
</body>

</html>
