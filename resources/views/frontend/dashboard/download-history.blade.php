@extends('layouts.frontend-3', ['main_title' => 'Download History - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
    <meta name="robots" content="noindex">
@endsection
@section('content')
@php
    $isSchool    = Auth::user()->type == \App\Enums\UserType::SCHOOL->value;
    $isPaginated = $downloads instanceof \Illuminate\Contracts\Pagination\Paginator;
    $hasRows     = !empty($downloads) && count($downloads) > 0;
    $total       = $downloads instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
                    ? $downloads->total()
                    : ($hasRows ? count($downloads) : 0);
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
                        <li class="breadcrumb-item active" aria-current="page">Download history</li>
                    </ol>
                </nav>
                <p class="spec-code"><span>{{ number_format($total) }}</span> {{ \Illuminate\Support\Str::plural('download', $total) }}</p>
            </div>

            <div class="course-header-main">
                <div>
                    <p class="eyebrow"><span class="eyebrow-dot"></span>Activity</p>
                    <h1 class="course-title">Download history</h1>
                    <p class="course-intro">
                        {{ $isSchool ? 'Every resource downloaded by you and the users on your school account.' : 'Every resource you have downloaded, newest first.' }}
                    </p>
                </div>
                <div class="course-actions">
                    <a class="btn btn-merit d-inline-flex align-items-center gap-2" href="{{ url('subjects') }}">
                        <i class="bi bi-search"></i> Find resources
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

                @if($hasRows)
                    <div class="data-card">
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                <tr>
                                    @if($isSchool)
                                        <th scope="col">User</th>
                                    @endif
                                    <th scope="col">Resource</th>
                                    <th scope="col">Subscription ID</th>
                                    <th scope="col">Fingerprint</th>
                                    <th scope="col">IP</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($downloads as $history)
                                    @php $time = $history->created_at ? \Illuminate\Support\Carbon::parse($history->created_at) : null; @endphp
                                    <tr>
                                        @if($isSchool)
                                            <td data-label="User">
                                                <span class="cell-strong">{{ $history->user?->name ?? '—' }}</span>
                                                @if($history->user?->person_type_name)
                                                    <span class="cell-sub">{{ $history->user->person_type_name }}</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td data-label="Resource">
                                            <div class="cell-resource">
                                                <span class="cell-icon"><i class="bi bi-file-earmark-arrow-down"></i></span>
                                                <span>
                                                    <span class="cell-strong">{{ $history->resource?->name ?? 'Removed resource' }}</span>
                                                    @if($history->resource_type_name)
                                                        <span class="type-chip">{{ $history->resource_type_name }}</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td data-label="Subscription ID">
                                            @if($history->stripe_id)
                                                <code class="cell-code" title="{{ $history->stripe_id }}">{{ $history->stripe_id }}</code>
                                            @else
                                                <span class="cell-muted">—</span>
                                            @endif
                                        </td>
                                        <td data-label="Fingerprint">
                                            <code class="cell-code">{{ $history->short_fingerprint ?: '—' }}</code>
                                        </td>
                                        <td data-label="IP">
                                            <span class="ip-chip">{{ $history->ip_address ?: '—' }}</span>
                                        </td>
                                        <td data-label="Time">
                                            @if($time)
                                                <span class="cell-strong">{{ $time->format('j M Y') }}</span>
                                                <span class="cell-sub" title="{{ $time->toDayDateTimeString() }}">{{ $time->format('g:i a') }} · {{ $time->diffForHumans() }}</span>
                                            @else
                                                <span class="cell-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($isPaginated && $downloads->hasPages())
                        <div class="data-pager">
                            {{ $downloads->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @else
                    <div class="empty-state data-empty">
                        <i class="bi bi-cloud-arrow-down"></i>
                        <p class="data-empty-title">No downloads yet</p>
                        <p>Resources you download will appear here.</p>
                        <a class="btn btn-merit btn-sm" href="{{ url('subjects') }}">Browse subjects</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection