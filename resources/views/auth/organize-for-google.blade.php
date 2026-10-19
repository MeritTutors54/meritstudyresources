@extends('layouts.frontend-3')

@section('title', 'Select Organization - ' . $global_seo['seo_title'])

@section('content')
<style>
    /* ==========================================================================
   Merit Study Resources — Select organisation (Google sign-up, step 2)
   Load AFTER style.css, resources.css and pages.css (uses auth-card,
   auth-title, field-error, eyebrow, course-crumbs).
   ========================================================================== */

.org-section {
  background-color: #f6faf7;
  background-image: radial-gradient(rgba(22, 138, 69, .11) 1px, transparent 1.2px);
  background-size: 22px 22px;
}
.org-wrap { max-width: 44rem; margin: 0 auto; }
.org-card { box-shadow: var(--shadow-md); }

/* progress */
.org-steps {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: .5rem 1.75rem;
  margin: 0 0 1.75rem;
  padding-bottom: 1.25rem;
  border-bottom: 1px solid var(--merit-line);
  font-size: .8rem;
  font-weight: 600;
  color: var(--merit-muted);
}
.org-steps li { display: inline-flex; align-items: center; gap: .45rem; }
.org-steps span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  border: 1px solid var(--merit-border);
  border-radius: 50%;
  background: #fff;
  font-size: .72rem;
}
.org-steps .is-done { color: var(--merit-dark-green); }
.org-steps .is-done span { background: var(--merit-light-green); border-color: #cfe5d8; color: var(--merit-green); }
.org-steps .is-current { color: var(--merit-navy); }
.org-steps .is-current span { background: var(--merit-green); border-color: var(--merit-green); color: #fff; }

/* errors */
.org-alert {
  display: flex;
  gap: .6rem;
  margin: 0 0 1.25rem;
  padding: .8rem 1rem;
  border: 1px solid #f0c9d2;
  border-radius: var(--radius);
  background: var(--tint-blush);
  font-size: .88rem;
  color: var(--ink-rose);
}
.org-alert i { margin-top: .1rem; }
.org-alert p { margin: 0; }
.org-alert p + p { margin-top: .2rem; }

/* option cards */
.org-options {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
  margin: 0;
  padding: 0;
  border: 0;
}
.org-option { position: relative; }
.org-input { position: absolute; opacity: 0; pointer-events: none; }
.org-label {
  position: relative;
  display: flex;
  flex-direction: column;
  height: 100%;
  padding: 1.35rem 1.25rem 1.25rem;
  border: 1.5px solid var(--merit-border);
  border-radius: var(--radius-lg);
  background: #fff;
  cursor: pointer;
  transition: border-color var(--ease), box-shadow var(--ease), transform var(--ease), background var(--ease);
}
.org-label:hover { border-color: #b9d9c6; transform: translateY(-2px); box-shadow: var(--shadow-sm); }

.org-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 52px;
  height: 52px;
  margin-bottom: 1rem;
  border-radius: 14px;
  background: var(--tint-mint);
  color: var(--merit-green);
  font-size: 1.5rem;
  transition: background var(--ease), color var(--ease);
}
.org-title { display: block; margin-bottom: .3rem; font-size: 1.05rem; font-weight: 800; letter-spacing: -.015em; color: var(--merit-navy); }
.org-text { display: block; margin-bottom: 1rem; font-size: .86rem; line-height: 1.5; color: var(--merit-muted); }
.org-perks {
  display: grid;
  gap: .35rem;
  margin-top: auto;
  padding-top: .9rem;
  border-top: 1px solid var(--merit-line);
}
.org-perks span { display: flex; align-items: center; gap: .4rem; font-size: .8rem; font-weight: 500; color: var(--merit-text); }
.org-perks i { color: var(--merit-green); }

.org-check {
  position: absolute;
  top: 1rem;
  right: 1rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  border: 1.5px solid var(--merit-border);
  border-radius: 50%;
  background: #fff;
  color: transparent;
  font-size: .8rem;
  transition: all var(--ease);
}

/* selected */
.org-input:checked + .org-label {
  border-color: var(--merit-green);
  background: #fbfefc;
  box-shadow: 0 0 0 4px rgba(22, 138, 69, .1);
}
.org-input:checked + .org-label .org-check { border-color: var(--merit-green); background: var(--merit-green); color: #fff; }
.org-input:checked + .org-label .org-icon { background: var(--merit-green); color: #fff; }
.org-input:focus-visible + .org-label { outline: 2px solid var(--merit-green); outline-offset: 3px; }

.org-error { margin-top: .85rem; text-align: center; }

/* submit */
.org-submit {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .5rem;
  width: 100%;
  min-height: 52px;
  margin-top: 1.5rem;
  font-size: .98rem;
}
.org-submit i { transition: transform var(--ease); }
.org-submit:hover i { transform: translateX(3px); }

.org-note {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .4rem;
  margin: 1rem 0 0;
  font-size: .8rem;
  color: var(--merit-muted);
}
.org-note i { color: var(--merit-green); }

@media (max-width: 575.98px) {
  .org-options { grid-template-columns: 1fr; }
  .org-steps { gap: .5rem 1rem; }
}

@media (prefers-reduced-motion: reduce) {
  .org-label:hover { transform: none; }
}
</style>
@php
    $selected = (string) old('type', '');
    $options = [
        [
            'value' => '1',
            'id'    => 'org-individual',
            'icon'  => 'bi-person',
            'title' => 'Individual',
            'text'  => 'For students, parents and private tutors revising on their own.',
            'perks' => ['Personal dashboard', 'Download history', 'Individual plans'],
        ],
        [
            'value' => '2',
            'id'    => 'org-school',
            'icon'  => 'bi-building',
            'title' => 'School or organisation',
            'text'  => 'For schools, colleges and tuition centres managing several users.',
            'perks' => ['Add staff & students', 'Shared team account', 'School plans'],
        ],
    ];
@endphp

{{-- Needs Bootstrap Icons + style.css, resources.css and pages.css loaded by the layout --}}
<link href="{{ asset('css/organization.css') }}" rel="stylesheet">

<div class="page-resources page-auth">
    <section class="auth-section org-section">
        <div class="container">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb course-crumbs justify-content-center mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Register</li>
                </ol>
            </nav>

            <div class="org-wrap">
                <div class="auth-card org-card">

                    <!-- progress -->
                    <ol class="org-steps list-unstyled" aria-label="Registration progress">
                        <li class="is-done"><span><i class="bi bi-check-lg"></i></span> Google sign-in</li>
                        <li class="is-current"><span>2</span> Account type</li>
                        <li><span>3</span> Done</li>
                    </ol>

                    <div class="text-center">
                        <p class="eyebrow justify-content-center"><span class="eyebrow-dot"></span>Almost there</p>
                        <h1 class="auth-title">How will you use Merit?</h1>
                        <p class="auth-intro mb-4">Choose the account type that fits you. This sets up the right dashboard and plans.</p>
                    </div>

                    @if ($errors->any())
                        <div class="org-alert" role="alert">
                            <i class="bi bi-exclamation-circle"></i>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('google.final.callback') }}" method="POST" id="orgForm" novalidate>
                        @csrf
                        <input type="hidden" name="data" value="{{ old('data', $encrypted ?? '') }}">

                        <fieldset class="org-options">
                            <legend class="visually-hidden">Account type</legend>

                            @foreach($options as $opt)
                                <div class="org-option">
                                    <input type="radio" name="type" id="{{ $opt['id'] }}" value="{{ $opt['value'] }}"
                                           class="org-input" required @checked($selected === $opt['value'])>
                                    <label for="{{ $opt['id'] }}" class="org-label">
                                        <span class="org-check" aria-hidden="true"><i class="bi bi-check-lg"></i></span>
                                        <span class="org-icon" aria-hidden="true"><i class="bi {{ $opt['icon'] }}"></i></span>
                                        <span class="org-title">{{ $opt['title'] }}</span>
                                        <span class="org-text">{{ $opt['text'] }}</span>
                                        <span class="org-perks">
                                            @foreach($opt['perks'] as $perk)
                                                <span><i class="bi bi-check2"></i> {{ $perk }}</span>
                                            @endforeach
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </fieldset>

                        <p class="field-error org-error" id="orgError">Please choose an account type to continue.</p>

                        <button type="submit" class="btn btn-merit org-submit" id="orgSubmit">
                            Confirm and continue <i class="bi bi-arrow-right"></i>
                        </button>

                        <p class="org-note">
                            <i class="bi bi-shield-check"></i>
                            You can contact us later if you need to change your account type.
                        </p>
                    </form>
                </div>

                <p class="auth-switch">
                    Need help? <a href="{{ url('contact') }}">Contact us</a>
                </p>
            </div>

        </div>
    </section>
</div>
@endsection

@push('js')
    <script>
        (function () {
            var form  = document.getElementById('orgForm');
            var error = document.getElementById('orgError');
            var btn   = document.getElementById('orgSubmit');
            if (!form) return;

            form.addEventListener('change', function () {
                error.classList.remove('is-shown');
            });

            form.addEventListener('submit', function (e) {
                if (!form.querySelector('input[name="type"]:checked')) {
                    e.preventDefault();
                    error.classList.add('is-shown');
                    form.querySelector('.org-input').focus();
                    return;
                }
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Setting up your account…';
            });
        })();
    </script>
@endpush