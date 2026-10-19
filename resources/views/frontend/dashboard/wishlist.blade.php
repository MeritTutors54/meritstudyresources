@extends('layouts.frontend-3', ['main_title' => 'Wishlist - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="robots" content="noindex">
@endsection
@section('content')
@php
    // Pass $wishlist from the controller, e.g. auth()->user()->wishlist()->with('resource')->latest()->paginate(12)
    $wishlist    = $wishlist ?? collect();
    $isPaginated = $wishlist instanceof \Illuminate\Contracts\Pagination\Paginator;
    $hasItems    = count($wishlist) > 0;
    $total       = $wishlist instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
                    ? $wishlist->total()
                    : count($wishlist);
    $canRemove   = \Illuminate\Support\Facades\Route::has('user.wishlist.remove');

    $tints = ['res-green', 'res-blue', 'res-purple', 'res-amber', 'res-teal', 'res-rose'];
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
                        <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                    </ol>
                </nav>
                <p class="spec-code"><span>{{ number_format($total) }}</span> saved</p>
            </div>

            <div class="course-header-main">
                <div>
                    <p class="eyebrow"><span class="eyebrow-dot"></span>Saved</p>
                    <h1 class="course-title">My wishlist</h1>
                    <p class="course-intro">Resources and books you've saved for later.</p>
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

                @if($hasItems)
                    <div class="row g-3">
                        @foreach($wishlist as $item)
                            @php
                                // works whether each row is the resource itself or a pivot with ->resource
                                $res   = $item->resource ?? $item->book ?? $item;
                                $name  = $res->name ?? $res->title ?? 'Saved item';
                                $type  = $res->resource_type_name ?? $res->type_name ?? null;
                                $meta  = collect([$res->exam_board ?? null, $res->level ?? null, $res->subject?->name ?? null])->filter()->implode(' · ');
                                $link  = $res->url ?? (isset($res->slug) ? url('resources/'.$res->slug) : null);
                                $saved = $item->created_at ? \Illuminate\Support\Carbon::parse($item->created_at)->diffForHumans() : null;
                            @endphp
                            <div class="col-md-6 col-xl-4">
                                <article class="resource-card wish-card {{ $tints[$loop->index % count($tints)] }}">
                                    <div class="wish-top">
                                        <span class="resource-icon"><i class="bi bi-bookmark-heart"></i></span>
                                        @if($canRemove)
                                            <form action="{{ route('user.wishlist.remove', $item) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="wish-remove" aria-label="Remove {{ $name }} from wishlist" title="Remove">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    @if($type)
                                        <p class="row-eyebrow">{{ $type }}</p>
                                    @endif
                                    <h2 class="resource-title">
                                        @if($link)<a href="{{ $link }}">{{ $name }}</a>@else{{ $name }}@endif
                                    </h2>
                                    @if($meta)
                                        <p class="resource-text mb-2">{{ $meta }}</p>
                                    @endif
                                    @if($saved)
                                        <p class="wish-saved"><i class="bi bi-clock"></i> Saved {{ $saved }}</p>
                                    @endif

                                    @if($link)
                                        <a class="btn-soft" href="{{ $link }}">Open <i class="bi bi-arrow-right"></i></a>
                                    @endif
                                </article>
                            </div>
                        @endforeach
                    </div>

                    @if($isPaginated && $wishlist->hasPages())
                        <div class="data-pager">
                            {{ $wishlist->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @else
                    <div class="empty-state data-empty">
                        <i class="bi bi-bookmark-heart"></i>
                        <p class="data-empty-title">Your wishlist is empty</p>
                        <p>Tap the bookmark on any resource or book to save it here.</p>
                        <a class="btn btn-merit btn-sm" href="{{ url('subjects') }}">Browse subjects</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection