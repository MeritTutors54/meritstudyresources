@extends('layouts.frontend-2')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@section('content')
    <!-- ============================= ARTICLE HEADER ============================= -->
    <header class="article-hero">
        <div class="container">
            <div class="breadcrumb-msr mb-3">
                <a href="{{ route('home') }}">Home</a>
                &nbsp;/&nbsp;
                <a href="{{ route('blogs') }}">Blog</a>
                &nbsp;/&nbsp; Exam Tips
            </div>
            <span class="article-cat-badge">Exam Tips</span>
            <h1>{{ $blog->title }}</h1>

            <div class="article-meta-row">
                <div class="d-flex align-items-center gap-3">
                    <span class="am-avatar" style="background:#3D6BFF;">{{ $blog->author->initials }}</span>
                    <div>
                        <div class="am-name">{{ $blog->author->name }}</div>
                        {{--                        <div class="am-sub">Head of Sciences</div>--}}
                    </div>
                </div>
                {{--                <div class="article-meta-item">--}}
                {{--                    <svg viewBox="0 0 24 24" fill="none">--}}
                {{--                        <path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>--}}
                {{--                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/>--}}
                {{--                    </svg>--}}
                {{--                    7 min read--}}
                {{--                </div>--}}
                <div class="article-meta-item">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M3 10h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.8"
                              stroke-linecap="round"/>
                    </svg>
                    {{ $blog->created_at?->format('j M Y') }}
                </div>

            </div>
        </div>
    </header>

    <!-- ============================= COVER + CONTENT ============================= -->
    <section class="section-pad" style="padding-top:36px;">
        <div class="container">
            <div class="article-cover" style="position: relative;">
                {{-- Display image if present, otherwise show a default fallback --}}
                <img src="{{ asset(Storage::url($blog->cover_image)) }}"
                     alt="{{ $blog->title }}"
                     class="img-fluid blog-img">

                {{-- Positioned badge overlaid on top of the image --}}
                <span class="fp-badge"
                      style="position: absolute; top: 46px; left: 46px; z-index: 2; background: rgb(52 168 28 / 0.81); backdrop-filter: blur(4px); font-size: .72rem; font-weight: 700; padding: 6px 14px; border-radius: 20px; color: #ececec;">
        Science Revision
    </span>
            </div>

            <div class="row mt-5 gy-5">
                <!-- TOC SIDEBAR -->
{{--                <div class="col-lg-3 d-none d-lg-block">--}}
{{--                    <div class="toc-box">--}}
{{--                        <p class="toc-title">In this article</p>--}}
{{--                        <a href="#why-plans-fail">Why most revision plans fail</a>--}}
{{--                        <a href="#eight-week">The 8-week framework</a>--}}
{{--                        <a href="#active-recall">Using active recall properly</a>--}}
{{--                        <a href="#past-papers-role">Where past papers fit in</a>--}}
{{--                        <a href="#final-week">The final week</a>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <!-- ARTICLE BODY -->
                <div class="col-lg-12">
                    <div class="article-body">
                        {!! $blog->details !!}
                    </div>

                    <!-- TAGS -->
                    <div class="d-flex flex-wrap gap-2 mt-5 pt-4" style="border-top:1px solid var(--line);">
                        @if(!empty($blog->tags))
                            @foreach($blog->tags as $tag)
                                <a href="{{ route('blogs', ['p' => $tag->slug]) }}"
                                   class="tag-pill-lg">{{ $tag->name }}</a>
                            @endforeach
                        @endif
                    </div>

                    <!-- AUTHOR BOX -->
                    {{--                    <div class="author-box mt-5">--}}
                    {{--                        <span class="ab-avatar" style="background:#3D6BFF;">SK</span>--}}
                    {{--                        <div>--}}
                    {{--                            <h4>Sam Khatri</h4>--}}
                    {{--                            <p>Head of Sciences at Merit Study Resources. Sam has taught GCSE and A Level Biology,--}}
                    {{--                                Chemistry and Physics for over a decade and leads the science content team.</p>--}}
                    {{--                            <div class="d-flex gap-2">--}}
                    {{--                                <a href="#" class="share-btn">--}}
                    {{--                                    <svg viewBox="0 0 24 24" fill="none">--}}
                    {{--                                        <path--}}
                    {{--                                            d="M13.5 9H15V6.5h-1.5C12 6.5 11 7.6 11 9.5V11H9.5v2.3H11V18h2.3v-4.7h1.7l.3-2.3h-2V9.6c0-.4.2-.6.6-.6z"--}}
                    {{--                                            fill="currentColor"/>--}}
                    {{--                                    </svg>--}}
                    {{--                                </a>--}}
                    {{--                                <a href="#" class="share-btn">--}}
                    {{--                                    <svg viewBox="0 0 24 24" fill="none">--}}
                    {{--                                        <path--}}
                    {{--                                            d="M21 5.9c-.7.3-1.5.5-2.3.6.8-.5 1.4-1.3 1.7-2.3-.8.5-1.7.8-2.6 1A3.7 3.7 0 0012 7.6c0 .3 0 .6.1.9C8.9 8.4 6 6.8 4 4.4c-.4.6-.6 1.3-.6 2.1 0 1.4.7 2.6 1.8 3.4-.7 0-1.3-.2-1.9-.5 0 2 1.4 3.6 3.2 4-.4.1-.7.1-1.1.1-.3 0-.5 0-.8-.1.5 1.6 2 2.8 3.8 2.8a7.5 7.5 0 01-4.6 1.6c-.3 0-.6 0-.9-.1A10.5 10.5 0 0010 19.5c6.4 0 9.9-5.3 9.9-9.9v-.5c.7-.5 1.3-1.2 1.8-1.9-.6.3-1.3.5-2 .6z"--}}
                    {{--                                            fill="currentColor"/>--}}
                    {{--                                    </svg>--}}
                    {{--                                </a>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    <!-- COMMENTS -->
                    {{--                    <div class="mt-5 pt-4" style="border-top:1px solid var(--line);">--}}
                    {{--                        <h2 class="h5 mb-4">Comments (3)</h2>--}}

                    {{--                        <div class="comment-item">--}}
                    {{--                            <span class="cm-avatar" style="background:#F3A93C;">JM</span>--}}
                    {{--                            <div>--}}
                    {{--                                <span class="cm-name">Jamie M.<span class="cm-date">3 days ago</span></span>--}}
                    {{--                                <p>The 8-week breakdown is exactly what I needed — was about to start cramming a week--}}
                    {{--                                    before my exams.</p>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="comment-item">--}}
                    {{--                            <span class="cm-avatar" style="background:#E45B7A;">AR</span>--}}
                    {{--                            <div>--}}
                    {{--                                <span class="cm-name">Aisha R.<span class="cm-date">6 days ago</span></span>--}}
                    {{--                                <p>Really helpful breakdown of command words too — I always lose marks on "evaluate"--}}
                    {{--                                    questions.</p>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="comment-item">--}}
                    {{--                            <span class="cm-avatar" style="background:var(--green);">TB</span>--}}
                    {{--                            <div>--}}
                    {{--                                <span class="cm-name">Tom B.<span class="cm-date">1 week ago</span></span>--}}
                    {{--                                <p>Used this for my son's chemistry revision — the phased approach made a big difference--}}
                    {{--                                    to how organised he felt.</p>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        <form class="comment-form mt-4">--}}
                    {{--                            <label class="form-label-msr" for="commentBox">Leave a comment</label>--}}
                    {{--                            <textarea id="commentBox" class="form-control-msr mb-3"--}}
                    {{--                                      placeholder="Share your thoughts..."></textarea>--}}
                    {{--                            <button type="submit" class="btn-brand">Post Comment</button>--}}
                    {{--                        </form>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= RELATED POSTS ============================= -->
    <section class="section-pad bg-mint" style="padding-top:50px;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <span class="eyebrow"><span class="divider-dot"></span> KEEP READING</span>
                    <h2 class="mt-3 mb-0" style="font-size:1.5rem;">Related articles</h2>
                </div>
                <a href="{{ route('blogs') }}" class="fw-semibold d-none d-sm-block" style="color:var(--green-dark);">View
                    all
                    articles</a>
            </div>
            <div class="row g-4">

                @if(!empty($latestBlogs))
                    @foreach($latestBlogs as $blog)
                        <div class="col-md-4">
                            <div class="blog-card">
                                <div class="blog-media">
                                    <a href="{{ route('blogs.details', $blog->slug) }}">
                                        <img src="{{ asset(Storage::url($blog->cover_image)) }}"
                                             alt="{{ $blog->title }}" class="img-fluid blog-img">
                                    </a>
                                </div>
                                <div class="blog-body">
                                    <h3>
                                        <a href="{{ route('blogs.details', $blog->slug) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h3>
                                    <p>
                                        {{ $blog->description }}
                                    </p>
                                    <div class="blog-meta">
                                    <span class="bm-avatar" style="background:#393939;">
                                        {{ $blog->author->initials ?? 'N/A' }}
                                    </span>
                                        <div class="bm-info">
                                            <strong>{{ $blog->author->name ?? 'Unknown' }}</strong>
                                            {{ $blog->created_at?->format('j M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- ============================= NEWSLETTER ============================= -->
    <section class="section-pad">
        @include('frontend.includes.newsletter')
    </section>
@endsection
