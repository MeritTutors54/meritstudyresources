@extends('layouts.frontend-3', ['main_title' => 'Profile - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="robots" content="noindex">
@endsection
@section('content')
@php
    $user     = Auth::user();
    $fullName = trim($user->name ?? '');
    $initials = collect(explode(' ', $fullName))->filter()->take(2)
                    ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
    $role     = $user->roles()->first()?->name;

    $details = [
        ['icon' => 'bi-person',        'label' => 'Full name',    'value' => $user->name],
        ['icon' => 'bi-envelope',      'label' => 'Email',        'value' => $user->email],
        ['icon' => 'bi-telephone',     'label' => 'Phone number', 'value' => $user->phone],
        ['icon' => 'bi-geo-alt',       'label' => 'Address',      'value' => $user->address],
        ['icon' => 'bi-mailbox',       'label' => 'Post code',    'value' => $user->post_code],
        ['icon' => 'bi-calendar-check','label' => 'Registered',   'value' => optional($user->created_at)->format('j F Y, g:i a')],
    ];
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
                        <li class="breadcrumb-item active" aria-current="page">My profile</li>
                    </ol>
                </nav>
            </div>

            <div class="course-header-main">
                <div>
                    <p class="eyebrow"><span class="eyebrow-dot"></span>Account</p>
                    <h1 class="course-title">My profile</h1>
                    <p class="course-intro">The details we hold for your account. Keep them up to date so we can reach you about orders and subscriptions.</p>
                </div>
                <div class="course-actions">
                    <a class="btn btn-merit d-inline-flex align-items-center gap-2" href="{{ url('/edit-profile') }}">
                        <i class="bi bi-pencil-square"></i> Edit profile
                    </a>
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

                <!-- Profile card -->
                <section class="profile-card" aria-label="Profile summary">
                    <span class="dash-avatar profile-avatar" aria-hidden="true">{{ $initials }}</span>
                    <div class="profile-who">
                        <h2 class="profile-name">{{ $fullName }}</h2>
                        <p class="profile-email">{{ $user->email }}</p>
                        <div class="profile-tags">
                            @if($role)
                                <span class="profile-tag is-role"><i class="bi bi-shield-check"></i> {{ ucfirst($role) }}</span>
                            @endif
                            @if($user->created_at)
                                <span class="profile-tag"><i class="bi bi-calendar3"></i> Member since {{ $user->created_at->format('M Y') }}</span>
                            @endif
                        </div>
                    </div>
                    <a class="btn-soft profile-edit" href="{{ url('/edit-profile') }}">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </section>

                <!-- Details -->
                <section class="dash-section" aria-labelledby="details-title">
                    <div class="section-head">
                        <h2 class="section-heading" id="details-title">Personal details</h2>
                    </div>

                    <dl class="profile-list">
                        @foreach($details as $row)
                            <div class="profile-row">
                                <dt><i class="bi {{ $row['icon'] }}"></i> {{ $row['label'] }}</dt>
                                <dd>
                                    @if(filled($row['value']))
                                        {{ $row['value'] }}
                                    @else
                                        <span class="profile-empty">Not added yet</span>
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </section>

                <!-- Bio -->
                <section class="dash-section" aria-labelledby="bio-title">
                    <div class="section-head">
                        <h2 class="section-heading" id="bio-title">About me</h2>
                    </div>
                    <div class="profile-bio">
                        @if(filled($user->bio))
                            <p>{!! nl2br(e($user->bio)) !!}</p>
                        @else
                            <p class="profile-empty">You haven't written a bio yet.
                                <a href="{{ url('/edit-profile') }}">Add one</a>
                            </p>
                        @endif
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
@endsection