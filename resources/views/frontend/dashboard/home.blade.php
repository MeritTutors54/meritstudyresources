@extends('layouts.frontend-3', ['main_title' => 'Dashboard - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
    <meta name="robots" content="noindex">
@endsection
@section('content')
@php
    $user      = auth()->user();
    $fullName  = trim($user->name ?? 'there');
    $firstName = \Illuminate\Support\Str::of($fullName)->explode(' ')->first();
    $initials  = collect(explode(' ', $fullName))->filter()->take(2)
                    ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
    $typeName  = \App\Enums\UserType::tryFrom($user->type)?->name;
    $hasPlan   = ($count['subscriptions'] ?? 0) > 0;
@endphp

{{-- Load after style.css, resources.css and pages.css (or move these into your layout's <head>) --}}
<link href="{{ asset('frontend/new/css/dashboard.css') }}" rel="stylesheet">

<div class="page-resources page-dashboard">

    <!-- ===== Page header ===== -->
    <section class="course-header dash-header">
        <div class="container">
            <div class="course-header-top">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb course-crumbs">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My dashboard</li>
                    </ol>
                </nav>
                @if(!empty($user->created_at))
                    <p class="spec-code">Member since <span>{{ $user->created_at->format('M Y') }}</span></p>
                @endif
            </div>

            <div class="course-header-main">
                <div class="dash-hello">
                    <span class="dash-avatar" aria-hidden="true">{{ $initials }}</span>
                    <div>
                        <p class="eyebrow"><span class="eyebrow-dot"></span>{{ $typeName ? ucfirst(strtolower($typeName)).' account' : 'My account' }}</p>
                        <h1 class="course-title">Welcome back, {{ $firstName }}</h1>
                        <p class="course-intro">Pick up where you left off, or find new resources for your subjects.</p>
                    </div>
                </div>
                <div class="course-actions">
                    <a class="btn-outline-merit" href="{{ url('subjects') }}"><i class="bi bi-search"></i> Find resources</a>
                    <a class="btn btn-merit d-inline-flex align-items-center gap-2" href="{{ url('bookshop') }}"><i class="bi bi-book"></i> Bookshop</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Body ===== -->
    <div class="container dash-body">
        <div class="row g-4">

            <!-- Side nav -->
            <aside class="col-lg-3">
                @include('frontend.dashboard.include.menu')
            </aside>

            <!-- Main column -->
            <div class="col-lg-9">

                @if(!empty($warning))
                    <div class="dash-alert" role="alert">
                        <i class="bi bi-exclamation-triangle"></i>
                        <p class="m-0"><strong>Warning!</strong> {{ $warning }}</p>
                    </div>
                @endif
                @include('layouts.frontend.notification')

                <!-- Overview -->
                <section class="dash-section" aria-labelledby="overview-title">
                    <div class="section-head">
                        <h2 class="section-heading" id="overview-title">Overview</h2>
                    </div>
                    <div class="row g-3">
                        <div class="col-6 col-xl-3">
                            <div class="stat-card res-green">
                                <span class="resource-icon"><i class="bi bi-patch-check"></i></span>
                                <span class="stat-value">{{ number_format($count['subscriptions'] ?? 0) }}</span>
                                <span class="stat-label">Active subscriptions</span>
                            </div>
                        </div>
                        <div class="col-6 col-xl-3">
                            <div class="stat-card res-blue">
                                <span class="resource-icon"><i class="bi bi-bag-check"></i></span>
                                <span class="stat-value">{{ number_format($count['book_orders'] ?? 0) }}</span>
                                <span class="stat-label">Books purchased</span>
                            </div>
                        </div>
                        <div class="col-6 col-xl-3">
                            <div class="stat-card res-purple">
                                <span class="resource-icon"><i class="bi bi-download"></i></span>
                                <span class="stat-value">{{ number_format($count['downloads'] ?? 0) }}</span>
                                <span class="stat-label">Total downloads</span>
                            </div>
                        </div>
                        <div class="col-6 col-xl-3">
                            <div class="stat-card res-amber">
                                <span class="resource-icon"><i class="bi bi-hourglass-split"></i></span>
                                <span class="stat-value">{{ number_format($user->remaining_downloads ?? 0) }}</span>
                                <span class="stat-label">Downloads remaining</span>
                            </div>
                        </div>
                    </div>

                    <div class="plan-card mt-3">
                        <div>
                            <p class="plan-label">Your plan</p>
                            @if($hasPlan)
                                <p class="plan-name">Subscriber</p>
                                <p class="plan-text">You have {{ $count['subscriptions'] }} active {{ \Illuminate\Support\Str::plural('subscription', $count['subscriptions']) }}.</p>
                            @else
                                <p class="plan-name">Free</p>
                                <p class="plan-text">Subscribe to unlock every mark scheme, worked solution and printable pack.</p>
                            @endif
                        </div>
                        @if(empty($warning))
                            <a class="btn btn-light" href="{{ route('user.subscription.list') }}">
                                {{ $hasPlan ? 'Manage subscriptions' : 'View subscriptions' }}
                            </a>
                        @endif
                    </div>
                </section>

                <!-- Quick links -->
                @if(empty($warning))
                <section class="dash-section" aria-labelledby="quick-title">
                    <div class="section-head">
                        <h2 class="section-heading" id="quick-title">Jump back in</h2>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="resource-card res-green">
                                <span class="resource-icon"><i class="bi bi-journal-bookmark"></i></span>
                                <h3 class="resource-title">Browse subjects</h3>
                                <p class="resource-text">Past papers, notes and worksheets for every subject.</p>
                                <a class="btn-soft" href="{{ url('subjects') }}">Open <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="resource-card res-blue">
                                <span class="resource-icon"><i class="bi bi-clock-history"></i></span>
                                <h3 class="resource-title">Download history</h3>
                                <p class="resource-text">Everything you've downloaded, in one place.</p>
                                <a class="btn-soft" href="{{ route('user.download.history') }}">Open <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="resource-card res-amber">
                                <span class="resource-icon"><i class="bi bi-bag"></i></span>
                                <h3 class="resource-title">Order history</h3>
                                <p class="resource-text">Track your book orders and unlocked downloads.</p>
                                <a class="btn-soft" href="{{ route('user.order.history') }}">Open <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </section>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection