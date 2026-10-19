@extends('layouts.frontend-3', ['main_title' => 'Subscription list - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
    <meta name="robots" content="noindex">
@endsection
@section('content')
@php
    $subscriptions = $subscriptions ?? collect();
    $isSubscribed  = Auth::user()->subscribed('default');
    $fmtDate = function ($value) {
        return filled($value) ? \Illuminate\Support\Carbon::parse($value)->format('j M Y') : null;
    };

    // stripe_status => [chip class, icon, label]
    $statusStyles = [
        'active'             => ['is-success', 'bi-check-circle',  'Active'],
        'trialing'           => ['is-info',    'bi-stars',         'Trial'],
        'past_due'           => ['is-warning', 'bi-exclamation-circle', 'Payment due'],
        'incomplete'         => ['is-warning', 'bi-hourglass-split', 'Incomplete'],
        'paused'             => ['is-muted',   'bi-pause-circle',  'Paused'],
        'canceled'           => ['is-danger',  'bi-x-circle',      'Cancelled'],
        'incomplete_expired' => ['is-danger',  'bi-x-circle',      'Expired'],
        'unpaid'             => ['is-danger',  'bi-x-circle',      'Unpaid'],
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
                        <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
                    </ol>
                </nav>
                <p class="spec-code"><span>{{ $subscriptions->count() }}</span> {{ \Illuminate\Support\Str::plural('subscription', $subscriptions->count()) }}</p>
            </div>

            <div class="course-header-main">
                <div>
                    <p class="eyebrow"><span class="eyebrow-dot"></span>Membership</p>
                    <h1 class="course-title">My subscriptions</h1>
                    <p class="course-intro">Your plans, what they include and when they renew. You can pause, resume or cancel an active plan at any time.</p>
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

                @if($subscriptions->isNotEmpty())
                    <div class="sub-list">
                        @foreach($subscriptions as $data)
                            @php
                                $plan       = $data->plan;
                                $status     = (string) $data->stripe_status;
                                [$chipClass, $chipIcon, $chipLabel] = $statusStyles[$status] ?? ['is-muted', 'bi-dot', ucfirst(str_replace('_', ' ', $status))];
                                $endsAt     = $fmtDate($data->ends_at);
                                $trialEnds  = $fmtDate($data->trial_ends_at);
                                $nextDate   = empty($data->ends_at) ? $fmtDate($data->next_billing_date) : null;
                                $fullAccess = \App\Enums\Statement::tryFrom($plan?->has_full_access)?->name;
                                $price      = (float) ($plan?->price ?? 0);
                                $isActive   = $status === 'active';
                                $onGrace    = $isActive && !empty($data->ends_at);
                            @endphp

                            <article class="sub-card {{ $isActive ? 'is-active' : '' }}">
                                <!-- Head -->
                                <div class="sub-head">
                                    <div class="sub-plan">
                                        <span class="sub-icon"><i class="bi bi-patch-check"></i></span>
                                        <div>
                                            <h2 class="sub-name">{{ ucfirst($plan?->name ?? 'Plan') }}</h2>
                                            <span class="status-chip {{ $chipClass }}"><i class="bi {{ $chipIcon }}"></i> {{ $onGrace ? 'Cancels '.$endsAt : $chipLabel }}</span>
                                        </div>
                                    </div>
                                    <p class="sub-price">
                                        £{{ fmod($price, 1) == 0 ? number_format($price) : number_format($price, 2) }}
                                    </p>
                                </div>

                                <!-- What's included -->
                                <ul class="sub-features">
                                    <li><i class="bi bi-people"></i><span>User limit</span><strong>{{ $plan?->user_limit ?? '—' }}</strong></li>
                                    <li><i class="bi bi-download"></i><span>Package downloads</span><strong>{{ $plan?->download_limit ?? '—' }}</strong></li>
                                    <li><i class="bi bi-calendar-week"></i><span>Weekly downloads</span><strong>{{ $plan?->weekly_limit ?? '—' }}</strong></li>
                                    <li><i class="bi bi-unlock"></i><span>Full access</span><strong>{{ $fullAccess ? ucfirst(strtolower($fullAccess)) : '—' }}</strong></li>
                                    <li><i class="bi bi-gift"></i><span>Trial days</span><strong>{{ $plan?->trial_days ?? 0 }}</strong></li>
                                </ul>

                                <!-- Dates + actions -->
                                <div class="sub-foot">
                                    <dl class="sub-dates">
                                        @if($nextDate)
                                            <div><dt>Next billing</dt><dd>{{ $nextDate }}</dd></div>
                                        @endif
                                        @if($trialEnds)
                                            <div><dt>Trial ends</dt><dd>{{ $trialEnds }}</dd></div>
                                        @endif
                                        @if($endsAt)
                                            <div><dt>Subscription ends</dt><dd>{{ $endsAt }}</dd></div>
                                        @endif
                                        @if(!$nextDate && !$trialEnds && !$endsAt)
                                            <div><dt>Renewal</dt><dd class="cell-muted">—</dd></div>
                                        @endif
                                    </dl>

                                    @if($isSubscribed && $isActive)
                                        <div class="sub-actions">
                                            @if(empty($data->ends_at))
                                                <button type="button" class="btn btn-soft subscription-pause-button"
                                                        data-route="{{ route('user.pause', ['subscription' => $data]) }}">
                                                    <i class="bi bi-pause-circle"></i> Pause
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-soft sub-btn-resume subscription-resume-button"
                                                        data-route="{{ route('user.resume', ['subscription' => $data]) }}">
                                                    <i class="bi bi-play-circle"></i> Resume
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-soft sub-btn-cancel subscription-cancel-button"
                                                    data-route="{{ route('user.cancel', ['subscription' => $data]) }}">
                                                <i class="bi bi-x-circle"></i> Cancel
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state data-empty">
                        <i class="bi bi-patch-check"></i>
                        <p class="data-empty-title">No subscriptions yet</p>
                        <p>Subscribe to unlock every mark scheme, worked solution and printable pack.</p>
                        <a class="btn btn-merit btn-sm" href="{{ url('pricing') }}">See plans</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(".subscription-pause-button").on('click', function () {
            let route = $(this).data('route');
            $("#subscription-pause-modal-action").attr('action', route);
            $("#subscription-pause-modal").modal('show');
        })

        $(".subscription-cancel-button").on('click', function () {
            let route = $(this).data('route');
            $("#subscription-cancel-modal-action").attr('action', route);
            $("#subscription-cancel-modal").modal('show');
        })

        $(".subscription-resume-button").on('click', function () {
            let route = $(this).data('route');
            $("#subscription-resume-modal-action").attr('action', route);
            $("#subscription-resume-modal").modal('show');
        })
    </script>
@endsection