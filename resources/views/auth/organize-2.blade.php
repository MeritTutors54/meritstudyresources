@extends('auth.auth-layout')

@section('title', 'Select Organization - ' . $global_seo['seo_title'])

@section('content')
    <!-- Start breadcrumb Area -->
    <header class="page-banner text-center" style="padding-bottom:50px;">
        <div class="container">
            <h1 class="mb-2">Register</h1>
            <div class="breadcrumb-msr text-center"><a href="{{ route('home') }}">Home</a> &nbsp;&gt;&nbsp; Register
            </div>
        </div>
    </header>
    <!-- End Breadcrumb Area -->

    <div class="auth-wrap" style="min-height:auto;padding:0 20px 90px;">
        <div class="auth-card text-center" style="max-width:480px;margin-top:-30px;">
            <h2 class="mb-1" style="font-size:1.4rem;">Select Your Organization</h2>
            <p class="text-muted-c mb-0" style="font-size:.88rem;">Tell us who you're signing up as so we can set up
                your account correctly.</p>

            {{--            <div class="org-select-row">--}}
            {{--                <button type="button" class="org-option selected" id="optStudent" onclick="selectOrg('student')">--}}
            {{--                    <span class="oo-ico">--}}
            {{--                        <svg viewBox="0 0 24 24" fill="none">--}}
            {{--                            <circle cx="12" cy="8" r="3.5"--}}
            {{--                                    stroke="currentColor"--}}
            {{--                                    stroke-width="1.7"/>--}}
            {{--                            <path d="M4.5 20c1.3-3.5 4.2-5.5 7.5-5.5s6.2 2 7.5 5.5" stroke="currentColor"--}}
            {{--                                stroke-width="1.7" stroke-linecap="round"/>--}}
            {{--                        </svg>--}}
            {{--                    </span>--}}
            {{--                    <p>Student</p>--}}
            {{--                    <span class="oo-sub">Individual account</span>--}}
            {{--                </button>--}}
            {{--                <button type="button" class="org-option" id="optSchool" onclick="selectOrg('school')">--}}
            {{--                    <span class="oo-ico"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l9 5-9 5-9-5z"--}}
            {{--                                                                                    stroke="currentColor"--}}
            {{--                                                                                    stroke-width="1.7"--}}
            {{--                                                                                    stroke-linejoin="round"/><path--}}
            {{--                                d="M6 11v5c0 1.4 2.7 2.5 6 2.5s6-1.1 6-2.5v-5" stroke="currentColor"--}}
            {{--                                stroke-width="1.7"/></svg></span>--}}
            {{--                    <p>School</p>--}}
            {{--                    <span class="oo-sub">Institution account</span>--}}
            {{--                </button>--}}
            {{--            </div>--}}


            <form action="{{ route('organize') }}" method="POST">
                @csrf
                <input type="hidden" name="data" value="{{ old('data') ?? $data }}">
                <div class="org-select-row">
                    <label class="org-option">
                        <input type="radio" name="type" value="1" id="optStudent" checked>
                        <span class="oo-ico">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M4.5 20c1.3-3.5 4.2-5.5 7.5-5.5s6.2 2 7.5 5.5" stroke="currentColor" stroke-width="1.7"
                                  stroke-linecap="round"/>
                        </svg>
                    </span>
                        <p>Student</p>
                        <span class="oo-sub">Individual account</span>
                    </label>

                    <label class="org-option">
                        <input type="radio" name="type" value="2" id="optSchool">
                        <span class="oo-ico">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 3l9 5-9 5-9-5z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            <path d="M6 11v5c0 1.4 2.7 2.5 6 2.5s6-1.1 6-2.5v-5" stroke="currentColor" stroke-width="1.7"/>
                        </svg>
                    </span>
                        <p>School</p>
                        <span class="oo-sub">Institution account</span>
                    </label>
                </div>
                <button type="submit" class="btn-brand btn-brand-block" id="orgRegisterBtn">
                    Register
                    <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>



            <div class="auth-divider">or</div>

            {{--            <button class="btn-social w-100" type="button">--}}
            {{--                <svg width="17" height="17" viewBox="0 0 24 24">--}}
            {{--                    <path fill="#4285F4"--}}
            {{--                          d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.7-2.4 3.6v3h3.9c2.3-2.1 3.5-5.2 3.5-8.8z"/>--}}
            {{--                    <path fill="#34A853"--}}
            {{--                          d="M12 24c3.2 0 5.9-1.1 7.9-2.9l-3.9-3c-1.1.7-2.4 1.2-4 1.2-3.1 0-5.7-2.1-6.6-4.9H1.4v3.1C3.4 21.4 7.4 24 12 24z"/>--}}
            {{--                    <path fill="#FBBC05"--}}
            {{--                          d="M5.4 14.4c-.2-.7-.4-1.5-.4-2.4s.1-1.6.4-2.4V6.5H1.4C.5 8.2 0 10.1 0 12s.5 3.8 1.4 5.5l4-3.1z"/>--}}
            {{--                    <path fill="#EA4335"--}}
            {{--                          d="M12 4.8c1.7 0 3.3.6 4.5 1.7l3.4-3.4C17.9 1.2 15.2 0 12 0 7.4 0 3.4 2.6 1.4 6.5l4 3.1C6.3 6.9 8.9 4.8 12 4.8z"/>--}}
            {{--                </svg>--}}
            {{--                Sign in with Google--}}
            {{--            </button>--}}

            <p class="text-center mt-4 mb-0" style="font-size:.9rem;color:var(--muted);">
                Already have an account? <a href="login.html" class="fw-semibold" style="color:var(--green-dark);">Login
                    now</a>
            </p>
        </div>
    </div>
@endsection
