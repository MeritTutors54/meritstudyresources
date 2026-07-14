@extends('layouts.frontend-2', ['main_title' => 'Login - MeritStudyResources.co.uk'])
@section('no-footer', true)
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <div class="auth-page">

        <!-- LEFT PANEL -->
        <div class="auth-left">
            <div>
                <div class="left-brand">
                    <span class="brand-mark">
                        <img class="new-logo" src="{{ asset('frontend/assets/images/logo/logo-light.png') }}"
                            alt="logo">
                    </span>
                    <div class="bt">MERIT STUDY<span>RESOURCES</span></div>
                </div>

                <div class="left-headline">
                    <span class="left-pill"><i class="fa-solid fa-graduation-cap"></i> Your Revision Hub</span>
                    <h2>Everything you need to <span>excel in your exams.</span></h2>
                    <p>Join thousands of students and teachers who use Merit Study Resources to find past papers, mark
                        schemes and revision materials — fast, free and verified.</p>
                </div>

                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feat-icon"><i class="fa-solid fa-file-lines"></i></div>
                        <div class="feat-text">
                            <h6>1,027+ Past Papers</h6><span>A Level, AS Level, GCSE & IGCSE — fully indexed.</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feat-icon"><i class="fa-solid fa-list-check"></i></div>
                        <div class="feat-text">
                            <h6>Official Mark Schemes</h6><span>Verified against every exam board release.</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feat-icon"><i class="fa-solid fa-shield-check"></i></div>
                        <div class="feat-text">
                            <h6>Safe & Secure</h6><span>Your data is protected. No spam, ever.</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feat-icon"><i class="fa-solid fa-bolt"></i></div>
                        <div class="feat-text">
                            <h6>Instant Access</h6><span>Download any paper the moment you sign in.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="left-stats">
                <div class="left-stat">
                    <div class="num">12K+</div>
                    <div class="lbl">Students</div>
                </div>
                <div class="left-stat">
                    <div class="num">60+</div>
                    <div class="lbl">Subjects</div>
                </div>
                <div class="left-stat">
                    <div class="num">100%</div>
                    <div class="lbl">Free Access</div>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="auth-right">
            <div class="auth-box">

                <!-- TABS -->
                <div class="auth-tabs">
                    <button class="auth-tab active" id="tabLogin" onclick="switchTab('login')">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Sign In
                    </button>
                    <button class="auth-tab" id="tabRegister" onclick="switchTab('register')">
                        <i class="fa-solid fa-user-plus me-1"></i> Create Account
                    </button>
                </div>

                <!-- ── LOGIN PANEL ── -->
                <div class="auth-panel active" id="panelLogin">
                    <div class="form-head">
                        <h3>Welcome back 👋</h3>
                        <p>Sign in to access your past papers and resources.</p>
                    </div>

                    <!-- GOOGLE -->
                    <a href="{{ url('auth/google') }}" class="btn-google" type="button">
                        <svg width="20" height="20" viewBox="0 0 48 48">
                            <path fill="#EA4335"
                                d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                            <path fill="#4285F4"
                                d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                            <path fill="#FBBC05"
                                d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                            <path fill="#34A853"
                                d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.36-8.16 2.36-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                        </svg>
                        Continue with Google
                    </a>

                    <div class="divider"><span>or sign in with email</span></div>

                    <form action="{{ route('login') }}" id="loginForm" onsubmit="handleLogin(event)" novalidate>
                        @csrf
                        <div class="field-group">
                            <label class="field-label" for="loginEmail">Email or Username</label>
                            <div class="field-wrap">
                                <i class="field-icon fa-solid fa-envelope"></i>
                                <input class="field-input @error('email') is-invalid @enderror" id="loginEmail"
                                    type="email" placeholder="you@example.com" name="email" value="{{ old('email') }}"
                                    autocomplete="email" autofocus required>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="loginPass">Password</label>
                            <div class="field-wrap">
                                <i class="field-icon fa-solid fa-lock"></i>
                                <input class="field-input @error('password') is-invalid @enderror" name="password"
                                    id="loginPass" type="password" placeholder="Enter your password" required>
                                <button class="eye-btn" type="button" onclick="togglePwd('loginPass',this)"><i
                                        class="fa-regular fa-eye"></i></button>
                            </div>
                        </div>

                        <div class="extras-row">
                            <label class="check-label">
                                <input type="checkbox"> Remember me
                            </label>
                            <a class="forgot-link" href="{{ route('forget.password.form') }}">Lost your password?</a>
                        </div>

                        <button class="btn-submit" type="submit">
                            <i class="fa-solid fa-right-to-bracket"></i> Sign In
                        </button>
                    </form>

                    <p class="switch-text">Don't have an account? <a href="#"
                            onclick="switchTab('register');return false;">Create one free</a></p>
                </div>

                <!-- ── REGISTER PANEL ── -->
                <div class="auth-panel" id="panelRegister">
                    <div class="form-head">
                        <h3>Create your account ✨</h3>
                        <p>Free forever. Access every past paper in seconds.</p>
                    </div>

                    <!-- GOOGLE -->
                    <button class="btn-google" type="button">
                        <svg width="20" height="20" viewBox="0 0 48 48">
                            <path fill="#EA4335"
                                d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                            <path fill="#4285F4"
                                d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                            <path fill="#FBBC05"
                                d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                            <path fill="#34A853"
                                d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.36-8.16 2.36-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                        </svg>
                        Sign up with Google
                    </button>

                    <div class="divider"><span>or register with email</span></div>

                    <form id="registerForm" onsubmit="handleRegister(event)" novalidate>
                        <div class="row g-2 mb-0">
                            <div class="col-6">
                                <div class="field-group">
                                    <label class="field-label" for="regFirst">First Name</label>
                                    <div class="field-wrap">
                                        <i class="field-icon fa-solid fa-user"></i>
                                        <input class="field-input" id="regFirst" type="text" placeholder="Sarah"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="field-group">
                                    <label class="field-label" for="regLast">Last Name</label>
                                    <div class="field-wrap">
                                        <i class="field-icon fa-solid fa-user"></i>
                                        <input class="field-input" id="regLast" type="text" placeholder="Thompson"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="regEmail">Email Address</label>
                            <div class="field-wrap">
                                <i class="field-icon fa-solid fa-envelope"></i>
                                <input class="field-input" id="regEmail" type="email" placeholder="you@example.com"
                                    required>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="regRole">I am a…</label>
                            <div class="field-wrap">
                                <i class="field-icon fa-solid fa-graduation-cap"></i>
                                <select class="field-input" id="regRole"
                                    style="padding-left:2.7rem;appearance:none;cursor:pointer;">
                                    <option value="">Select your role</option>
                                    <option>Student</option>
                                    <option>Teacher / Tutor</option>
                                    <option>Parent</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="regPass">Password</label>
                            <div class="field-wrap">
                                <i class="field-icon fa-solid fa-lock"></i>
                                <input class="field-input" id="regPass" type="password"
                                    placeholder="Create a strong password" oninput="checkStrength(this.value)" required>
                                <button class="eye-btn" type="button" onclick="togglePwd('regPass',this)"><i
                                        class="fa-regular fa-eye"></i></button>
                            </div>
                            <div class="strength-wrap" id="strengthWrap" style="display:none;">
                                <div class="strength-bars">
                                    <div class="strength-bar" id="sb1"></div>
                                    <div class="strength-bar" id="sb2"></div>
                                    <div class="strength-bar" id="sb3"></div>
                                    <div class="strength-bar" id="sb4"></div>
                                </div>
                                <span class="strength-label" id="strengthLabel"></span>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="regConfirm">Confirm Password</label>
                            <div class="field-wrap">
                                <i class="field-icon fa-solid fa-lock"></i>
                                <input class="field-input" id="regConfirm" type="password"
                                    placeholder="Repeat your password" required>
                                <button class="eye-btn" type="button" onclick="togglePwd('regConfirm',this)"><i
                                        class="fa-regular fa-eye"></i></button>
                            </div>
                        </div>

                        <div class="terms-check">
                            <input type="checkbox" id="terms" required>
                            <label for="terms">I agree to the <a href="#">Terms & Conditions</a> and <a
                                    href="#">Privacy Policy</a> of Merit Study Resources.</label>
                        </div>

                        <button class="btn-submit" type="submit">
                            <i class="fa-solid fa-user-plus"></i> Create Free Account
                        </button>
                    </form>

                    <p class="switch-text">Already have an account? <a href="#"
                            onclick="switchTab('login');return false;">Sign in here</a></p>
                </div>

            </div>
        </div>
    </div>






    {{-- <div class="rbt-elements-area bg-color-white rbt-section-gap pt-5">
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
    </div> --}}
@endsection
@push('js')
    <script>
        function switchTab(tab) {
            ['login', 'register'].forEach(t => {
                document.getElementById('panel' + cap(t)).classList.toggle('active', t === tab);
                document.getElementById('tab' + cap(t)).classList.toggle('active', t === tab);
            });
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function cap(s) {
            return s.charAt(0).toUpperCase() + s.slice(1);
        }

        if (window.location.hash === '#register') switchTab('register');
    </script>
@endpush
