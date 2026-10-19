@extends('layouts.frontend-3', ['main_title' => 'Edit Profile - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
    <meta name="robots" content="noindex">
@endsection
@section('content')
@php
    $user      = Auth::user();
    $isSchool  = $user->type == \App\Enums\UserType::SCHOOL->value;
    $activeTab = (int) old('tab', $tab ?? 1) ?: 1;
    if ($activeTab === 3 && ! $isSchool) { $activeTab = 1; }

    $tabs = [
        1 => ['id' => 'profile',  'icon' => 'bi-person',  'label' => 'Profile'],
        2 => ['id' => 'password', 'icon' => 'bi-shield-lock', 'label' => 'Password'],
    ];
    if ($isSchool) {
        $tabs[3] = ['id' => 'team', 'icon' => 'bi-people', 'label' => 'Team'];
    }
@endphp

{{-- Load after style.css, resources.css and pages.css (or move into your layout's <head>) --}}
<link href="{{ asset('frontend/new/css/dashboard.css') }}" rel="stylesheet">

<div class="page-resources page-dashboard">

    <!-- ===== Page header ===== -->
    <section class="course-header dash-header">
        <div class="container">
            <div class="course-header-top">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb course-crumbs">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit profile</li>
                    </ol>
                </nav>
            </div>

            <div class="course-header-main">
                <div>
                    <p class="eyebrow"><span class="eyebrow-dot"></span>Account</p>
                    <h1 class="course-title">Settings</h1>
                    <p class="course-intro">Update your details, change your password{{ $isSchool ? ' or rename your team' : '' }}.</p>
                </div>
                <div class="course-actions">
                    <a class="btn-outline-merit" href="{{ url('/profile') }}"><i class="bi bi-person"></i> View profile</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Body ===== -->
    <div class="container dash-body">
        <div class="row g-4">

            <!-- Side nav -->
            <aside class="col-lg-3">
                <div class="dash-nav">
                    @include('frontend.dashboard.include.menu')
                </div>
            </aside>

            <!-- Main column -->
            <div class="col-lg-9">
                @include('layouts.frontend.notification')

                <div class="settings-card">
                    <!-- Tabs -->
                    <ul class="nav resource-tabs settings-tabs" id="settingsTab" role="tablist">
                        @foreach($tabs as $num => $t)
                            <li class="nav-item" role="presentation">
                                <button type="button"
                                        class="nav-link {{ $activeTab === $num ? 'active' : '' }}"
                                        id="{{ $t['id'] }}-tab"
                                        data-bs-toggle="tab" data-bs-target="#{{ $t['id'] }}"
                                        role="tab" aria-controls="{{ $t['id'] }}"
                                        aria-selected="{{ $activeTab === $num ? 'true' : 'false' }}">
                                    <i class="bi {{ $t['icon'] }}"></i> {{ $t['label'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content settings-body">

                        <!-- ===== Profile ===== -->
                        <div class="tab-pane fade {{ $activeTab === 1 ? 'active show' : '' }}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="settings-head">
                                <h2 class="pane-title">Profile details</h2>
                                <p class="pane-sub">This information appears on your profile and orders.</p>
                            </div>

                            <form action="{{ route('user.profile.update') }}" method="POST" class="auth-form">
                                @csrf
                                <input type="hidden" name="tab" value="1">

                                <div class="row g-3">
                                    <div class="col-md-6 form-field mb-0">
                                        <label class="form-label" for="name">Full name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text"
                                               value="{{ old('name', $user->name) }}" autocomplete="name" required>
                                        @error('name')<p class="field-error is-shown">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="col-md-6 form-field mb-0">
                                        <label class="form-label" for="email">Email</label>
                                        <input class="form-control" id="email" name="email" type="email"
                                               value="{{ $user->email }}" readonly aria-describedby="email-hint">
                                        <p class="field-hint" id="email-hint"><i class="bi bi-lock"></i> Contact us to change your email address.</p>
                                    </div>

                                    <div class="col-md-6 form-field mb-0">
                                        <label class="form-label" for="phone">Phone number</label>
                                        <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="tel"
                                               value="{{ old('phone', $user->phone) }}" autocomplete="tel">
                                        @error('phone')<p class="field-error is-shown">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="col-md-6 form-field mb-0">
                                        <label class="form-label" for="post_code">Post code</label>
                                        <input class="form-control @error('post_code') is-invalid @enderror" id="post_code" name="post_code" type="text"
                                               value="{{ old('post_code', $user->post_code) }}" autocomplete="postal-code">
                                        @error('post_code')<p class="field-error is-shown">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="col-12 form-field mb-0">
                                        <label class="form-label" for="address">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                                  rows="3" autocomplete="street-address">{{ old('address', $user->address) }}</textarea>
                                        @error('address')<p class="field-error is-shown">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="col-12 form-field mb-0">
                                        <label class="form-label" for="bio">Bio <span class="label-note">(optional)</span></label>
                                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio"
                                                  rows="4" placeholder="A few words about you">{{ old('bio', $user->bio) }}</textarea>
                                        @error('bio')<p class="field-error is-shown">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <div class="settings-actions">
                                    <button type="submit" class="btn btn-merit"><i class="bi bi-check2"></i> Update info</button>
                                    <a class="btn btn-soft" href="{{ url('/profile') }}">Cancel</a>
                                </div>
                            </form>
                        </div>

                        <!-- ===== Password ===== -->
                        <div class="tab-pane fade {{ $activeTab === 2 ? 'active show' : '' }}" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <div class="settings-head">
                                <h2 class="pane-title">Change password</h2>
                                <p class="pane-sub">Use at least 8 characters, mixing letters, numbers and symbols.</p>
                            </div>

                            <form action="{{ route('user.password.update') }}" method="POST" class="auth-form settings-narrow">
                                @csrf
                                <input type="hidden" name="tab" value="2">

                                <div class="form-field">
                                    <label class="form-label" for="old_password">Current password</label>
                                    <div class="password-field">
                                        <input class="form-control @error('old_password') is-invalid @enderror" id="old_password" type="password"
                                               name="old_password" autocomplete="current-password" placeholder="Current password">
                                        <button type="button" class="password-toggle" aria-label="Show password" data-toggle-password="old_password"><i class="bi bi-eye"></i></button>
                                    </div>
                                    @error('old_password')<p class="field-error is-shown">{{ $message }}</p>@enderror
                                </div>

                                <div class="form-field">
                                    <label class="form-label" for="password">New password</label>
                                    <div class="password-field">
                                        <input class="form-control @error('password') is-invalid @enderror" id="password" type="password"
                                               name="password" autocomplete="new-password" placeholder="New password">
                                        <button type="button" class="password-toggle" aria-label="Show password" data-toggle-password="password"><i class="bi bi-eye"></i></button>
                                    </div>
                                    <div class="strength" aria-hidden="true"><span class="strength-bar" id="strength-bar"></span></div>
                                    @error('password')<p class="field-error is-shown">{{ $message }}</p>@enderror
                                </div>

                                <div class="form-field">
                                    <label class="form-label" for="password_confirmation">Re-type new password</label>
                                    <div class="password-field">
                                        <input class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" type="password"
                                               name="password_confirmation" autocomplete="new-password" placeholder="Re-type new password">
                                        <button type="button" class="password-toggle" aria-label="Show password" data-toggle-password="password_confirmation"><i class="bi bi-eye"></i></button>
                                    </div>
                                    @error('password_confirmation')<p class="field-error is-shown">{{ $message }}</p>@enderror
                                </div>

                                <div class="settings-actions">
                                    <button type="submit" class="btn btn-merit"><i class="bi bi-shield-check"></i> Update password</button>
                                </div>
                            </form>
                        </div>

                        <!-- ===== Team (schools only) ===== -->
                        @if($isSchool)
                            <div class="tab-pane fade {{ $activeTab === 3 ? 'active show' : '' }}" id="team" role="tabpanel" aria-labelledby="team-tab">
                                <div class="settings-head">
                                    <h2 class="pane-title">Team</h2>
                                    <p class="pane-sub">The name your staff and students see when they join your school account.</p>
                                </div>

                                <form action="{{ route('user.update.team') }}" method="POST" class="auth-form settings-narrow">
                                    @csrf
                                    <input type="hidden" name="tab" value="3">

                                    <div class="form-field">
                                        <label class="form-label" for="team_name">Team name</label>
                                        <input class="form-control @error('team_name') is-invalid @enderror" id="team_name" name="team_name" type="text"
                                               value="{{ old('team_name', $team->name ?? '') }}" placeholder="e.g. Oakwood Academy Science">
                                        @error('team_name')<p class="field-error is-shown">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="settings-actions">
                                        <button type="submit" class="btn btn-merit"><i class="bi bi-check2"></i> Update team</button>
                                        <a class="btn btn-soft" href="{{ route('users.index') }}"><i class="bi bi-people"></i> Manage users</a>
                                    </div>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        // show / hide password
        document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById(btn.getAttribute('data-toggle-password'));
                if (!input) return;
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                btn.innerHTML = show ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
            });
        });

        // simple strength meter
        var pw = document.getElementById('password'), bar = document.getElementById('strength-bar');
        if (pw && bar) {
            pw.addEventListener('input', function () {
                var v = pw.value, s = 0;
                if (v.length >= 8) s++;
                if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
                if (/\d/.test(v)) s++;
                if (/[^A-Za-z0-9]/.test(v)) s++;
                bar.style.width = v ? Math.max(s, 1) * 25 + '%' : '0';
                bar.className = 'strength-bar ' + (s <= 1 ? 'is-weak' : s <= 2 ? 'is-ok' : 'is-good');
            });
        }
    })();
</script>
@endsection