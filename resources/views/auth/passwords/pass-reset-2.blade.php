@extends('auth.auth-layout')

{{--@section('title', 'Forget Password - ' . $global_seo['seo_title'])--}}

@section('content')
    <div class="auth-wrap">
        <div class="auth-card">
            <div class="auth-brand">
                <span class="brand-mark">
                    <img class="new-logo" src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="logo">
                </span>
            </div>
            <div class="text-center mb-4">
                <span class="eyebrow"><span class="divider-dot"></span> SET NEW PASSWORD</span>
                <h1 class="mt-3 mb-2" style="font-size:1.7rem;">Create a new password</h1>
                <p class="lead-muted mb-0" style="font-size:.92rem;">
                    Your new password must be different from your previously used password.
                </p>
            </div>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3">
                    <label class="form-label-msr" for="loginEmail">Email address</label>
                    <div class="input-icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M3 6h18v12H3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            <path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                        </svg>
                        <input type="email" id="loginEmail" name="email"
                               value="{{ $email ?? old('email') }}"
                               class="form-control-msr @error('email') is-invalid @enderror" placeholder="you@example.com">
                    </div>
                    @error('email')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label-msr" for="password">New Password</label>
                    <div class="input-icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8 10V7a4 4 0 018 0v3" stroke="currentColor" stroke-width="1.6"/>
                        </svg>
                        <input type="password" id="password" name="password"
                               value="{{ old('password') }}"
                               class="form-control-msr @error('password') is-invalid @enderror"
                               placeholder="Enter new password">
                    </div>
                    @error('password')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label-msr" for="password_confirmation">Confirm New Password</label>
                    <div class="input-icon-wrap">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8 10V7a4 4 0 018 0v3" stroke="currentColor" stroke-width="1.6"/>
                        </svg>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               value="{{ old('password_confirmation') }}"
                               class="form-control-msr @error('password_confirmation') is-invalid @enderror"
                               placeholder="Re-enter new password">
                    </div>
                    @error('password_confirmation')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>


                <button type="submit" class="btn-brand btn-brand-block">
                    Reset Password
                    <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>

            <p class="text-center mt-4 mb-0" style="font-size:.9rem;color:var(--muted);">
                Remember your password? <a href="{{ route('login') }}" class="fw-semibold" style="color:var(--green-dark);">Log in</a>
            </p>
        </div>
    </div>
@endsection
