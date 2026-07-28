@extends('auth.auth-layout')

@section('title', 'Login - ' . $global_seo['seo_title'])


@section('content')
    <div class="auth-wrap">
        <div class="auth-card">
            <div class="auth-brand">
                <span class="brand-mark">
                    <img class="new-logo" src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="logo">
                </span>
            </div>
            <div class="text-center mb-4">
                <span class="eyebrow"><span class="divider-dot"></span> WELCOME BACK</span>
                <h1 class="mt-3 mb-2" style="font-size:1.7rem;">Log in to your account</h1>
                <p class="lead-muted mb-0" style="font-size:.92rem;">Access your past papers, worksheets and saved
                    resources.</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label-msr" for="loginEmail">Email address</label>
                    <div class="input-icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M3 6h18v12H3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            <path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                        </svg>
                        <input type="email" id="loginEmail" name="email"
                               value="{{ old('email') }}"
                               class="form-control-msr @error('email') is-invalid @enderror" placeholder="you@example.com">
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-label-msr" for="loginPassword">Password</label>
                    <div class="input-icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8 10V7a4 4 0 018 0v3" stroke="currentColor" stroke-width="1.6"/>
                        </svg>
                        <input type="password" id="loginPassword" name="password" class="form-control-msr @error('password') is-invalid @enderror"
                               placeholder="Enter your password">
                        <button type="button" class="toggle-pass" onclick="togglePass('loginPassword', this)">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z" stroke="currentColor"
                                      stroke-width="1.6"/>
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <label class="form-check-msr"><input type="checkbox"> Remember me</label>
                    <a href="{{ route('forget.password.form') }}" class="fw-semibold" style="font-size:.86rem;color:var(--green-dark);">Forgot
                        password?</a>
                </div>
                <button type="submit" class="btn-brand btn-brand-block">
                    Log In
                    <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>

            <div class="auth-divider">or continue with</div>
            <div class="d-flex gap-3">
                <a href="{{ url('auth/google') }}" class="btn-social" type="button">
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
                </a>
            </div>

            <p class="text-center mt-4 mb-0" style="font-size:.9rem;color:var(--muted);">
                Don't have an account? <a href="{{ route('register') }}" class="fw-semibold" style="color:var(--green-dark);">Create
                    one</a>
            </p>
        </div>
    </div>
@endsection
