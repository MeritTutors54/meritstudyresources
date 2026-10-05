@extends('layouts.frontend-3', ['main_title' => $defaultSEO->meta_title ?? 'Home - MeritStudyResources.co.uk' ])
@section('title', 'Register - ' . $global_seo['seo_title'])
@section('content')

    <main id="main">
  <section class="auth-section">
    <div class="container">
      <div class="row g-4 justify-content-center align-items-start">

        <div class="col-lg-6 col-xl-5">
          <div class="auth-card">
            <p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Free resources<span class="eyebrow-sep" aria-hidden="true">/</span> No account needed</p>
            <h1 class="auth-title">Create your free account</h1>
            <p class="auth-intro">It takes a minute, and everything on the site stays free either way.</p>

            <form class="auth-form" action="{{ route('register') }}" method="POST" novalidate>
              @csrf

              {{-- Name --}}
              <div class="form-field">
                <label class="form-label" for="name">Your name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                       value="{{ old('name') }}" autocomplete="name" required placeholder="First and last name">
                @error('name')
                  <p class="field-error d-block">{{ $message }}</p>
                @enderror
              </div>

              {{-- Email --}}
              <div class="form-field">
                <label class="form-label" for="email">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ old('email') }}" autocomplete="email" required placeholder="you@example.com">
                <p class="field-hint">We use this to sign you in and reset your password. Nothing else.</p>
                @error('email')
                  <p class="field-error d-block">{{ $message }}</p>
                @enderror
              </div>

              {{-- Role + Qualification --}}
              {{-- @php
                $roles = ['Student', 'Parent or guardian', 'Teacher or tutor'];
                $qualifications = ['GCSE', 'IGCSE', 'AS Level', 'A Level'];
              @endphp
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-field">
                    <label class="form-label" for="role">I am a</label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                      <option value="" @selected(!old('role'))>Select one</option>
                      @foreach ($roles as $role)
                        <option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}</option>
                      @endforeach
                    </select>
                    @error('role')
                      <p class="field-error d-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-field">
                    <label class="form-label" for="qualification">Studying for</label>
                    <select class="form-select @error('qualification') is-invalid @enderror" id="qualification" name="qualification">
                      <option value="" @selected(!old('qualification'))>Select (optional)</option>
                      @foreach ($qualifications as $qualification)
                        <option value="{{ $qualification }}" @selected(old('qualification') === $qualification)>{{ $qualification }}</option>
                      @endforeach
                    </select>
                    @error('qualification')
                      <p class="field-error d-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
              </div> --}}

              {{-- Password --}}
              <div class="form-field">
                <label class="form-label" for="password">Password</label>
                <div class="password-field">
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                         autocomplete="new-password" required minlength="8" placeholder="At least 8 characters">
                  <button type="button" class="password-toggle" data-password-toggle="password"
                          aria-label="Show password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                </div>
                <div class="strength" aria-hidden="true"><span class="strength-bar" data-strength-bar></span></div>
                <p class="field-hint" data-strength-label>Use 8 characters or more. A short phrase works well.</p>
                @error('password')
                  <p class="field-error d-block">{{ $message }}</p>
                @enderror
              </div>

              {{-- Confirm password (kept so existing backend validation keeps working) --}}
              <div class="form-field">
                <label class="form-label" for="confirm_password">Confirm password</label>
                <div class="password-field">
                  <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password"
                         autocomplete="new-password" required placeholder="Re-enter your password">
                  <button type="button" class="password-toggle" data-password-toggle="confirm_password"
                          aria-label="Show password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                </div>
                @error('confirm_password')
                  <p class="field-error d-block">{{ $message }}</p>
                @enderror
              </div>

              {{-- Terms --}}
              <div class="form-check form-check-inline-row">
                <input class="form-check-input @error('agree_term') is-invalid @enderror" type="checkbox" id="terms" name="agree_term"
                       value="1" @checked(old('agree_term')) required>
                <label class="form-check-label" for="terms">
                  I agree to the <a href="{{ route('terms-condition') }}">terms</a> and the <a href="{{ route('privacy.policy') }}">privacy policy</a>.
                </label>
                @error('agree_term')
                  <p class="field-error d-block">{{ $message }}</p>
                @enderror
              </div>

              <button type="submit" class="btn btn-merit btn-lg w-100">Create account</button>

              <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>

              @if (session('success'))
                <p class="form-status" role="status" aria-live="polite">{{ session('success') }}</p>
              @endif
            </form>
          </div>
        </div>

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
@endsection
