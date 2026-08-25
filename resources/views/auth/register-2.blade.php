@extends('auth.auth-layout')

@section('title', 'Register - ' . $global_seo['seo_title'])

@section('content')
    <div class="auth-wrap">
        <div class="auth-card" style="max-width:480px;">
            <div class="auth-brand">
            <span class="brand-mark">
                <img class="new-logo" src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="logo">
            </span>
            </div>
            <div class="text-center mb-4">
                <span class="eyebrow"><span class="divider-dot"></span> GET STARTED</span>
                <h1 class="mt-3 mb-2" style="font-size:1.7rem;">Create your account</h1>
                <p class="lead-muted mb-0" style="font-size:.92rem;">Join 1,000+ students revising smarter with Merit
                    Study
                    Resources.</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="g-3 mb-1">
                    <label class="form-label-msr" for="name">Full name</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}"
                           class="form-control-msr @error('name') is-invalid @enderror" placeholder="Jane">
                    @error('name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label-msr" for="regEmail">Email address</label>
                    <div class="input-icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M3 6h18v12H3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            <path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                        </svg>
                        <input type="email" id="regEmail" name="email"
                               value="{{ old('email') }}"
                               class="form-control-msr @error('email') is-invalid @enderror"
                               placeholder="you@example.com">
                    </div>
                    @error('email')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-1">
                    <label class="form-label-msr" for="regPassword">Password</label>
                    <div class="input-icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8 10V7a4 4 0 018 0v3" stroke="currentColor" stroke-width="1.6"/>
                        </svg>
                        <input type="password" name="password" id="regPassword" class="form-control-msr @error('password') is-invalid @enderror"
                               placeholder="Create a password"
                               oninput="checkStrength(this.value)">
                        <button type="button" class="toggle-pass" onclick="togglePass('regPassword', this)">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z" stroke="currentColor"
                                      stroke-width="1.6"/>
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>
                            </svg>
                        </button>
                    </div>
                    <div class="strength-bar"><span id="strengthFill"></span></div>
                    <p class="mb-0 mt-1" id="strengthLabel" style="font-size:.76rem;color:var(--muted);">Use 8+
                        characters
                        with a mix of letters &amp; numbers</p>

                    @error('password')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label-msr" for="regConfirm">Confirm password</label>
                    <div class="input-icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8 10V7a4 4 0 018 0v3" stroke="currentColor" stroke-width="1.6"/>
                        </svg>
                        <input type="password" name="confirm_password" id="regConfirm" class="form-control-msr"
                               placeholder="Re-enter your password"
                        >
                    </div>
                </div>

                <label class="form-check-msr {{ $errors->has('agree_term') ? 'mb-1' : 'mb-4' }}" style="align-items:flex-start;">
                    <input type="checkbox" name="agree_term" style="margin-top:2px;">
                    <span>I agree to the <a href="{{ route('terms-condition') }}"
                                            style="color:var(--green-dark);font-weight:600;">Terms &amp; Conditions</a> and <a
                            href="{{ route('privacy.policy') }}"
                            style="color:var(--green-dark);font-weight:600;">Privacy Policy</a></span>
                </label>
                @error('agree_term')
                <span class="invalid-feedback d-block mb-3">{{ $message }}</span>
                @enderror

                <button type="submit" class="btn-brand btn-brand-block">
                    Create Account
                    <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>

            <div class="auth-divider">or sign up with</div>
            <div class="d-flex gap-3">
                <button class="btn-social" type="button">
                    <svg width="17" height="17" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                              d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.7-2.4 3.6v3h3.9c2.3-2.1 3.5-5.2 3.5-8.8z"/>
                        <path fill="#34A853"
                              d="M12 24c3.2 0 5.9-1.1 7.9-2.9l-3.9-3c-1.1.7-2.4 1.2-4 1.2-3.1 0-5.7-2.1-6.6-4.9H1.4v3.1C3.4 21.4 7.4 24 12 24z"/>
                        <path fill="#FBBC05"
                              d="M5.4 14.4c-.2-.7-.4-1.5-.4-2.4s.1-1.6.4-2.4V6.5H1.4C.5 8.2 0 10.1 0 12s.5 3.8 1.4 5.5l4-3.1z"/>
                        <path fill="#EA4335"
                              d="M12 4.8c1.7 0 3.3.6 4.5 1.7l3.4-3.4C17.9 1.2 15.2 0 12 0 7.4 0 3.4 2.6 1.4 6.5l4 3.1C6.3 6.9 8.9 4.8 12 4.8z"/>
                    </svg>
                    Google
                </button>
{{--                <button class="btn-social" type="button">--}}
{{--                    <svg width="17" height="17" viewBox="0 0 24 24" fill="#1A2152">--}}
{{--                        <path--}}
{{--                            d="M13.5 9H15V6.5h-1.5C12 6.5 11 7.6 11 9.5V11H9.5v2.3H11V18h2.3v-4.7h1.7l.3-2.3h-2V9.6c0-.4.2-.6.6-.6z"/>--}}
{{--                    </svg>--}}
{{--                    Facebook--}}
{{--                </button>--}}
            </div>

            <p class="text-center mt-4 mb-0" style="font-size:.9rem;color:var(--muted);">
                Already have an account? <a href="{{ route('login') }}" class="fw-semibold" style="color:var(--green-dark);">Log
                    in</a>
            </p>
        </div>
    </div>
@endsection
