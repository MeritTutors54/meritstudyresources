<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Merit Study Resources</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('frontend/assets/css/auth-style-2.css') }}" rel="stylesheet">
    <style>
        .new-logo {
            height: 100%;
            width: 55px;
            object-fit: contain;
        }
    </style>
</head>
<body>

<!-- ============================= NAVBAR ============================= -->
<nav class="navbar navbar-expand-lg navbar-msr fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="brand-mark">
                <img class="new-logo" src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="logo">
            </span>
            <span class="brand-wordmark">MERIT STUDY<br><span class="l2">RESOURCES</span></span>
        </a>

        @if(request()->routeIs('register'))
            <div class="d-flex gap-2 ms-auto">
                <a href="{{ route('login') }}" class="btn-ghost-navy">Login</a>
            </div>
        @else
        <div class="d-flex gap-2 ms-auto">
            <a href="{{ route('register') }}" class="btn-ghost-navy">Create Account</a>
        </div>

        @endif


    </div>
</nav>

<!-- ============================= REGISTER ============================= -->
@yield('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePass(id, btn) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function checkStrength(val) {
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        const pct = (score / 4) * 100;
        const fill = document.getElementById('strengthFill');
        const label = document.getElementById('strengthLabel');
        fill.style.width = pct + '%';
        const colors = ['#E45B7A', '#F3A93C', '#F3A93C', '#1F9E59'];
        fill.style.background = colors[Math.max(score - 1, 0)] || '#E45B7A';
        const labels = ['Too weak', 'Weak', 'Good', 'Strong password'];
        label.textContent = val.length === 0 ? 'Use 8+ characters with a mix of letters & numbers' : labels[Math.max(score - 1, 0)];
    }

    // document.getElementById('registerForm').addEventListener('submit', function (e) {
    //     e.preventDefault();
    //     const pass = document.getElementById('regPassword').value;
    //     const confirm = document.getElementById('regConfirm').value;
    //     if (pass !== confirm) {
    //         alert("Passwords don't match — please check and try again.");
    //         return;
    //     }
    //     window.location.href = 'dashboard.html';
    // });

    let selectedOrg = 'student';
    function selectOrg(type){
        selectedOrg = type;
        document.getElementById('optStudent').classList.toggle('selected', type === 'student');
        document.getElementById('optSchool').classList.toggle('selected', type === 'school');
    }
    function continueRegister(){
        // In production this would pass `selectedOrg` along to the backend / next step
        window.location.href = 'dashboard.html';
    }
</script>
</body>
</html>
