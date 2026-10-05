@extends('layouts.frontend-3')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@php
    use Illuminate\Support\Str;

    // Tints rotate across cards when a post has no cover image
    $tints = ['mint', 'sky', 'cream', 'lilac', 'sage', 'blush'];

    $activeCategory = request('category');
    $searchTerm     = request('search');

    // Rough read time: ~200 words per minute
    $readTime = function ($post) {
        $words = str_word_count(strip_tags($post->content ?? $post->description ?? ''));
        return max(1, (int) ceil($words / 200));
    };

    // Keep category/search in the pagination links
    $blogs->appends(request()->query());

    $showFeatured = !empty($featured) && $blogs->onFirstPage() && blank($searchTerm);
@endphp

@section('content')
<main id="main">
    <section class="course-header" aria-labelledby="pageTitle">
        <div class="container">
            <div class="course-header-top">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb course-crumbs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
                <p class="spec-code"><span>{{ $blogs->total() }}</span> {{ Str::plural('post', $blogs->total()) }}</p>
            </div>
            <p class="eyebrow">
                <span class="eyebrow-dot" aria-hidden="true"></span> Free resources
                <span class="eyebrow-sep" aria-hidden="true">/</span> No account needed
            </p>
            <h1 class="course-title" id="pageTitle">Study advice from the <span class="course-title-board">Merit blog</span></h1>
            <p class="course-intro">Short, practical posts on revising, using past papers and making sense of exams — written by the tutors who put this library together.</p>
        </div>
    </section>

    <div class="blog-body">
        <div class="container">

            {{-- ===================== FILTERS + SEARCH ===================== --}}
            <div class="blog-controls">
                <div class="filter-pills blog-filter" role="group" aria-label="Filter posts by category">
                    <a href="{{ route('blogs', array_filter(['search' => $searchTerm])) }}"
                       class="filter-pill {{ blank($activeCategory) ? 'is-active' : '' }}"
                       @if(blank($activeCategory)) aria-current="page" @endif>All posts</a>

                    @foreach($categories as $category)
                        @php $isActive = $activeCategory === $category->slug; @endphp
                        <a href="{{ route('blogs', array_filter(['category' => $category->slug, 'search' => $searchTerm])) }}"
                           class="filter-pill {{ $isActive ? 'is-active' : '' }}"
                           @if($isActive) aria-current="page" @endif>{{ $category->name }}</a>
                    @endforeach
                </div>

                <form class="blog-search" role="search" method="GET" action="{{ route('blogs') }}">
                    @if($activeCategory)
                        <input type="hidden" name="category" value="{{ $activeCategory }}">
                    @endif
                    <label class="visually-hidden" for="postSearch">Search posts</label>
                    <div class="search-shell search-shell-sm">
                        <i class="bi bi-search search-icon" aria-hidden="true"></i>
                        <input type="search" class="form-control search-input" id="postSearch" name="search"
                               value="{{ $searchTerm }}" placeholder="Search posts...">
                    </div>
                </form>
            </div>

            {{-- ===================== FEATURED POST ===================== --}}
            @if($showFeatured)
                @php $featuredCat = $featured->category->name ?? null; @endphp
                <div class="featured-wrap" data-post-wrap>
                    <article class="post-card post-card-featured"
                             data-keywords="{{ Str::lower($featured->title . ' ' . $featuredCat) }}">
                        <a class="post-thumb tint-mint" href="{{ route('blogs.details', $featured->slug) }}" aria-hidden="true" tabindex="-1">
                            @if($featured->cover_image)
                                <img src="{{ asset(Storage::url($featured->cover_image)) }}" alt="" loading="lazy">
                            @else
                                <i class="bi bi-file-earmark-text"></i>
                            @endif
                        </a>
                        <div class="post-body">
                            <p class="post-meta">
                                @if($featuredCat)<span class="post-cat">{{ $featuredCat }}</span> · @endif
                                {{ $featured->created_at?->format('j F Y') }} · {{ $readTime($featured) }} min read
                            </p>
                            <h3 class="post-title"><a href="{{ route('blogs.details', $featured->slug) }}">{{ $featured->title }}</a></h3>
                            <p class="post-excerpt">{{ $featured->description }}</p>
                            <span class="post-more">Read the full post <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                        </div>
                    </article>
                </div>
            @endif

            {{-- ===================== POST GRID ===================== --}}
            @if($blogs->isNotEmpty())
                <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-xl-3 post-grid" data-post-wrap>
                    @foreach($blogs as $blog)
                        @php $catName = $blog->category->name ?? null; @endphp
                        <div class="col">
                            <article class="post-card"
                                     data-keywords="{{ Str::lower($blog->title . ' ' . $catName) }}">
                                <a class="post-thumb tint-{{ $tints[$loop->index % count($tints)] }}"
                                   href="{{ route('blogs.details', $blog->slug) }}" aria-hidden="true" tabindex="-1">
                                    @if($blog->cover_image)
                                        <img src="{{ asset(Storage::url($blog->cover_image)) }}" alt="" loading="lazy">
                                    @else
                                        <i class="bi bi-journal-text"></i>
                                    @endif
                                </a>
                                <div class="post-body">
                                    <p class="post-meta">
                                        @if($catName)<span class="post-cat">{{ $catName }}</span> · @endif
                                        {{ $blog->created_at?->format('j F Y') }} · {{ $readTime($blog) }} min read
                                    </p>
                                    <h3 class="post-title"><a href="{{ route('blogs.details', $blog->slug) }}">{{ $blog->title }}</a></h3>
                                    <p class="post-excerpt">{{ Str::limit($blog->description, 170) }}</p>
                                    <span class="post-more">Read post <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Shown by the server when nothing comes back, or by JS when live search hides everything --}}
            <p class="empty-state" id="postEmpty" role="status" aria-live="polite" @if($blogs->isNotEmpty()) hidden @endif>
                <i class="bi bi-search" aria-hidden="true"></i>
                No posts match that. Try another word or choose "All posts".
            </p>

            {{-- ===================== PAGINATION ===================== --}}
            @if($blogs->hasPages())
                <nav class="blog-pagination" aria-label="Blog pages">
                    @if($blogs->onFirstPage())
                        <span class="page-btn is-disabled" aria-disabled="true"><i class="bi bi-arrow-left" aria-hidden="true"></i> Newer</span>
                    @else
                        <a class="page-btn" href="{{ $blogs->previousPageUrl() }}" rel="prev"><i class="bi bi-arrow-left" aria-hidden="true"></i> Newer</a>
                    @endif

                    <span class="page-status">Page {{ $blogs->currentPage() }} of {{ $blogs->lastPage() }}</span>

                    @if($blogs->hasMorePages())
                        <a class="page-btn" href="{{ $blogs->nextPageUrl() }}" rel="next">Older <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                    @else
                        <span class="page-btn is-disabled" aria-disabled="true">Older <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                    @endif
                </nav>
            @endif

        </div>
    </div>
</main>

<style>
    /* Cover images fill the tinted thumb box */
    .post-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
</style>
@endsection

@push('js')
<script>
    // Live filter on the current page while typing; pressing Enter runs the full server search
    (function () {
        const input = document.getElementById('postSearch');
        const empty = document.getElementById('postEmpty');
        if (!input) return;

        const cards = document.querySelectorAll('[data-post-wrap] .post-card');
        if (!cards.length) return;

        input.addEventListener('input', () => {
            const term = input.value.trim().toLowerCase();
            let visible = 0;

            cards.forEach(card => {
                const show = term === '' || card.dataset.keywords.includes(term);
                // hide the grid column (or featured wrapper), not just the card
                const box = card.closest('.col') || card.closest('.featured-wrap') || card;
                box.hidden = !show;
                if (show) visible++;
            });

            empty.hidden = visible !== 0;
        });
    })();
</script>
@endpush