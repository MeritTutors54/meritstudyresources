@extends('layouts.frontend-3')
@section('title', 'Login - ' . $global_seo['seo_title'])

@section('content')
<main id="main">
  <section class="auth-section">
    <div class="container">
      <div class="row g-4 justify-content-center align-items-start">

        {{-- ===================== SIGN-IN CARD ===================== --}}
        <div class="col-lg-6 col-xl-5">
          <div class="auth-card">
            <p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Free resources<span class="eyebrow-sep" aria-hidden="true">/</span> No account needed</p>
            <h1 class="auth-title">Welcome back</h1>
            <p class="auth-intro">Sign in to reach your saved resources and your course.</p>

            {{-- Success messages (e.g. after password reset or email verification) --}}
            @if (session('status') || session('success'))
              <p class="form-status d-block" role="status" aria-live="polite">{{ session('status') ?? session('success') }}</p>
            @endif

            {{-- General errors (e.g. Google sign-in failed) --}}
            @if (session('error'))
              <p class="field-error d-block mb-3" role="alert">{{ session('error') }}</p>
            @endif

            <form class="auth-form" action="{{ route('login') }}" method="POST" novalidate>
              @csrf

              {{-- Email --}}
              <div class="form-field">
                <label class="form-label" for="email">Email address</label>
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email"
                       value="{{ old('email') }}"
                       autocomplete="email" required autofocus
                       placeholder="you@example.com"
                       @error('email') aria-invalid="true" aria-describedby="emailError" @enderror>
                @error('email')
                  <p class="field-error d-block" id="emailError">{{ $message }}</p>
                @enderror
              </div>

              {{-- Password --}}
              <div class="form-field">
                <div class="label-row">
                  <label class="form-label" for="password">Password</label>
                  <a class="label-link" href="{{ route('forget.password.form') }}">Forgot password?</a>
                </div>
                <div class="password-field">
                  <input type="password"
                         class="form-control @error('password') is-invalid @enderror"
                         id="password" name="password"
                         autocomplete="current-password" required
                         placeholder="••••••••"
                         @error('password') aria-invalid="true" aria-describedby="passwordError" @enderror>
                  <button type="button" class="password-toggle" data-password-toggle="password"
                          aria-label="Show password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                </div>
                @error('password')
                  <p class="field-error d-block" id="passwordError">{{ $message }}</p>
                @enderror
              </div>

              {{-- Remember me: on by default, keeps the user's choice after a failed attempt --}}
              <div class="form-check form-check-inline-row">
                <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1"
                       @checked(old('_token') ? old('remember') : true)>
                <label class="form-check-label" for="remember">Keep me signed in on this device</label>
              </div>

              <button type="submit" class="btn btn-merit btn-lg w-100">Sign in</button>

              {{-- Google sign-in (kept from the old page) --}}
              <div class="auth-or" aria-hidden="true"><span>or</span></div>
              <a href="{{ url('auth/google') }}" class="btn btn-soft btn-lg w-100 btn-google">
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.7-2.4 3.6v3h3.9c2.3-2.1 3.5-5.2 3.5-8.8z"/>
                  <path fill="#34A853" d="M12 24c3.2 0 5.9-1.1 7.9-2.9l-3.9-3c-1.1.7-2.4 1.2-4 1.2-3.1 0-5.7-2.1-6.6-4.9H1.4v3.1C3.4 21.4 7.4 24 12 24z"/>
                  <path fill="#FBBC05" d="M5.4 14.4c-.2-.7-.4-1.5-.4-2.4s.1-1.6.4-2.4V6.5H1.4C.5 8.2 0 10.1 0 12s.5 3.8 1.4 5.5l4-3.1z"/>
                  <path fill="#EA4335" d="M12 4.8c1.7 0 3.3.6 4.5 1.7l3.4-3.4C17.9 1.2 15.2 0 12 0 7.4 0 3.4 2.6 1.4 6.5l4 3.1C6.3 6.9 8.9 4.8 12 4.8z"/>
                </svg>
                Continue with Google
              </a>

              <p class="auth-switch">New here? <a href="{{ route('register') }}">Create a free account</a></p>
            </form>
          </div>
        </div>

        {{-- ===================== BENEFITS ASIDE ===================== --}}
        <div class="col-lg-5 col-xl-4">
          <aside class="auth-aside">
            <h2 class="auth-aside-title">An account is optional — here is what it adds</h2>
            <ul class="auth-benefits list-unstyled">
              <li><span class="auth-benefit-icon"><i class="bi bi-bookmark-heart" aria-hidden="true"></i></span>
                <span><strong>Save resources</strong> and pick them up on any device.</span></li>
              <li><span class="auth-benefit-icon"><i class="bi bi-compass" aria-hidden="true"></i></span>
                <span><strong>Keep your course</strong> so the site opens on your subjects and exam board.</span></li>
              <li><span class="auth-benefit-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
                <span><strong>See what you have opened</strong> and carry on where you stopped.</span></li>
              <li><span class="auth-benefit-icon"><i class="bi bi-envelope-open" aria-hidden="true"></i></span>
                <span><strong>Hear when papers land</strong> for your subjects — only if you ask us to.</span></li>
            </ul>
            <p class="auth-aside-note">
              Everything on the site stays free and open without an account.
              <a href="{{ route('privacy.policy') }}">How we handle your data</a>.
            </p>
          </aside>
        </div>

      </div>
    </div>
  </section>
</main>

<style>
  .auth-or { display: flex; align-items: center; gap: .75rem; margin: 1rem 0; color: var(--muted, #6b7280); font-size: .85rem; }
  .auth-or::before, .auth-or::after { content: ""; flex: 1; height: 1px; background: currentColor; opacity: .25; }
  .btn-google { display: inline-flex; align-items: center; justify-content: center; gap: .6rem; }
</style>
@endsection