<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Merit Study Resources — Free past papers, revision notes and practice resources</title>
    <meta name="description"
          content="Free GCSE, IGCSE, AS and A Level past papers, revision notes, topic questions, topic tests, workbooks and worked solutions, organised by subject and exam board.">

    <link rel="icon" href="{{ asset('frontend/new/assets/images/logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/new/css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('frontend/new/js/main.js') }}" defer></script>
</head>

<body>
<a class="skip-link" href="#main">Skip to main content</a>

@include('layouts.new-frontend.header')

<main id="main">

    @yield('content')

</main>

@include('layouts.new-frontend.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
