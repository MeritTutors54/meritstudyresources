<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Title Tag --}}
    <title>@yield('title', $main_title ?? $seo->meta_title ?? config('app.name'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style-2.css?v=' . $v) }}">

    <link rel="icon" type="image/png" href="{{ asset('frontend/assets/images/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('frontend/assets/images/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/assets/images/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('frontend/assets/images/favicon/site.webmanifest') }}" />

    {{-- Standard SEO Meta Tags --}}
    <meta name="description" content="@yield('meta_description', $seo->meta_description ?? '')">
    <meta name="keywords" content="@yield('meta_keywords', $seo->meta_keywords ?? '')">
    <meta name="author" content="@yield('meta_author', $seo->meta_author ?? '')">

    {{-- Verification Tags --}}
    @if(!empty($seo->google_verification))
        <meta name="google-site-verification" content="{{ $seo->google_verification }}" />
    @endif
    @if(!empty($seo->bing_verification))
        <meta name="msvalidate.01" content="{{ $seo->bing_verification }}" />
    @endif

    {{-- Open Graph / Social Media --}}
    <meta property="og:title" content="@yield('title', $seo->meta_title ?? config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', $seo->meta_description ?? '')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YDG4M0JY4F"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-YDG4M0JY4F');
    </script>
</head>

<body>
    @include('layouts.frontend.header-2')

    @yield('content')


    @unless($hideFooter ?? false)
        @include('layouts.frontend.footer-2')
    @endunless

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get Initials
        function getInitials(name) {
            const cleanName = name.trim().toUpperCase();

            if (!cleanName) return '';
            const words = cleanName.split(/\s+/);

            if (words.length >= 2) {
                return words[0].charAt(0) + words[1].charAt(0);
            } else {
                return words[0].slice(0, 2);
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            const avatars = document.querySelectorAll('.testi-avatar[data-initial]');

            avatars.forEach(avatar => {
                const name = avatar.getAttribute('data-initial');
                avatar.textContent = getInitials(name);
            });
        });
        // Navbar shadow on scroll
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('is-scrolled', window.scrollY > 12);
        });

        // Billing toggle (yearly / monthly)
        function setBilling(mode) {
            document.getElementById('yearlyBtn').classList.toggle('active', mode === 'yearly');
            document.getElementById('monthlyBtn').classList.toggle('active', mode === 'monthly');
            document.querySelectorAll('.price-display').forEach(el => {
                el.textContent = mode === 'yearly' ? el.dataset.yearly : el.dataset.monthly;
            });
            document.querySelectorAll('.period-label').forEach(el => {
                el.textContent = mode === 'yearly' ? 'yearly' : 'monthly';
            });
            document.querySelectorAll('.price-list .dynamic-value').forEach(el => {
                el.textContent = mode === 'yearly' ? el.dataset.yearly : el.dataset.monthly;
            });
            document.querySelectorAll('.plan-link').forEach(el => {
                el.href = mode === 'yearly' ? el.dataset.yearly : el.dataset.monthly;
            });
        }
    </script>
    @stack('js')
</body>

</html>
