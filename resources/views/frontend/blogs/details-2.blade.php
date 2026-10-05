@extends('layouts.frontend-3')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route;

    $categoryName = $blog->category->name ?? null;
    $categorySlug = $blog->category->slug ?? null;

    // Read time: ~200 words per minute
    $readTime = function ($post) {
        $words = str_word_count(strip_tags($post->details ?? $post->description ?? ''));
        return max(1, (int) ceil($words / 200));
    };

    // Build "On this page" from the <h2> headings in the post body,
    // giving each heading an id so the links can jump to it.
    $toc = [];
    $usedIds = [];
    $body = preg_replace_callback('/<h2([^>]*)>(.*?)<\/h2>/is', function ($m) use (&$toc, &$usedIds) {
        $attrs = $m[1];
        $text  = trim(html_entity_decode(strip_tags($m[2])));
        if ($text === '') return $m[0];

        if (preg_match('/\sid=["\']([^"\']+)["\']/i', $attrs, $idMatch)) {
            $id = $idMatch[1];
        } else {
            $base = Str::slug($text) ?: 'section';
            $id = $base;
            $n = 2;
            while (in_array($id, $usedIds)) $id = $base . '-' . $n++;
            $attrs .= ' id="' . $id . '"';
        }

        $usedIds[] = $id;
        $toc[] = ['id' => $id, 'text' => $text];

        return '<h2' . $attrs . '>' . $m[2] . '</h2>';
    }, $blog->details ?? '');

    $authorName     = $blog->author->name ?? 'Merit Study Resources team';
    $authorInitials = $blog->author->initials ?? 'MS';

    $shareUrl   = urlencode(url()->current());
    $shareTitle = urlencode($blog->title);

    $resourcesUrl = Route::has('resources') ? route('resources') : url('/resources');

    $tints = ['sky', 'cream', 'lilac', 'mint', 'sage', 'blush'];
@endphp

@section('content')
<main id="main">
    <article class="post-page">

        {{-- ===================== HEADER ===================== --}}
        <header class="course-header post-header">
            <div class="container">
                <div class="course-header-top">
                    <nav aria-label="Breadcrumb">
                        <ol class="breadcrumb course-crumbs">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Blog</a></li>
                            @if($categoryName)
                                <li class="breadcrumb-item active" aria-current="page">{{ $categoryName }}</li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($blog->title, 40) }}</li>
                            @endif
                        </ol>
                    </nav>
                    <p class="spec-code">{{ $readTime($blog) }} min read</p>
                </div>

                @if($categoryName)
                    <p class="post-cat post-cat-lead">{{ $categoryName }}</p>
                @endif

                <h1 class="course-title post-page-title">{{ $blog->title }}</h1>

                @if($blog->description)
                    <p class="course-intro">{{ $blog->description }}</p>
                @endif

                <div class="post-byline">
                    <span class="byline-avatar" aria-hidden="true">{{ $authorInitials }}</span>
                    <span>
                        <span class="byline-name">{{ $authorName }}</span>
                        <span class="byline-date">Published {{ $blog->created_at?->format('j F Y') }}</span>
                    </span>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row g-4 g-xl-5 post-layout">

                {{-- ===================== BODY ===================== --}}
                <div class="col-lg-8">
                    @if($blog->cover_image)
                        <figure class="post-cover">
                            <img src="{{ asset(Storage::url($blog->cover_image)) }}" alt="{{ $blog->title }}">
                        </figure>
                    @endif

                    <div class="prose">
                        {!! $body !!}

                        <div class="prose-cta">
                            <p><strong>Ready to try it?</strong> Every paper in the library comes with its mark scheme and a
                                worked solution, so you can practise without hunting for files.</p>
                            <a class="btn btn-merit" href="{{ $resourcesUrl }}">Find past papers <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>

                    <div class="post-foot">
                        @if($blog->tags && $blog->tags->isNotEmpty())
                            <ul class="post-tags list-unstyled">
                                @foreach($blog->tags as $tag)
                                    <li><a href="{{ route('blogs', ['p' => $tag->slug]) }}">{{ $tag->name }}</a></li>
                                @endforeach
                            </ul>
                        @else
                            <span></span>
                        @endif

                        <div class="post-share">
                            <span class="share-label">Share</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener" aria-label="Share on X"><i class="bi bi-twitter-x" aria-hidden="true"></i></a>
                            <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>
                            <button type="button" class="share-copy" data-copy-link data-url="{{ url()->current() }}">
                                <i class="bi bi-link-45deg" aria-hidden="true"></i> <span>Copy link</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ===================== SIDEBAR ===================== --}}
                <div class="col-lg-4">
                    <aside class="post-aside">
                        @if(count($toc))
                            <nav class="toc" aria-label="On this page">
                                <h2 class="toc-heading">On this page</h2>
                                <ul class="toc-list list-unstyled">
                                    @foreach($toc as $item)
                                        <li><a href="#{{ $item['id'] }}">{{ $item['text'] }}</a></li>
                                    @endforeach
                                </ul>
                            </nav>
                        @endif

                        <div class="aside-card">
                            <h2 class="aside-title">Get the papers</h2>
                            <p class="aside-text">Question paper, mark scheme and worked solution together, free, by board.</p>
                            <a class="btn btn-soft" href="{{ $resourcesUrl }}">Browse past papers <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </aside>
                </div>

            </div>

            {{-- ===================== RELATED ===================== --}}
            @if(!empty($latestBlogs) && count($latestBlogs))
                <section class="related" aria-labelledby="relatedHeading">
                    <div class="group-head">
                        <h2 class="group-heading" id="relatedHeading">Keep reading</h2>
                        <a class="section-link" href="{{ route('blogs') }}">All posts <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                    </div>
                    <div class="row g-4 row-cols-1 row-cols-md-3 post-grid">
                        @foreach($latestBlogs as $post)
                            @php $postCat = $post->category->name ?? null; @endphp
                            <div class="col">
                                <article class="post-card">
                                    <a class="post-thumb tint-{{ $tints[$loop->index % count($tints)] }}"
                                       href="{{ route('blogs.details', $post->slug) }}" aria-hidden="true" tabindex="-1">
                                        @if($post->cover_image)
                                            <img src="{{ asset(Storage::url($post->cover_image)) }}" alt="" loading="lazy">
                                        @else
                                            <i class="bi bi-journal-text"></i>
                                        @endif
                                    </a>
                                    <div class="post-body">
                                        <p class="post-meta">
                                            @if($postCat)<span class="post-cat">{{ $postCat }}</span> · @endif
                                            {{ $post->created_at?->format('j F Y') }} · {{ $readTime($post) }} min read
                                        </p>
                                        <h3 class="post-title"><a href="{{ route('blogs.details', $post->slug) }}">{{ $post->title }}</a></h3>
                                        <p class="post-excerpt">{{ Str::limit($post->description, 170) }}</p>
                                        <span class="post-more">Read post <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </article>
</main>

<style>
    .post-cover { margin: 0 0 2rem; border-radius: 16px; overflow: hidden; }
    .post-cover img { width: 100%; height: auto; display: block; }
    .post-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .post-tags a { color: inherit; text-decoration: none; }
    .prose h2[id] { scroll-margin-top: 96px; }
</style>
@endsection

@push('js')
<script>
    // Copy link button
    document.querySelectorAll('[data-copy-link]').forEach(btn => {
        btn.addEventListener('click', async () => {
            const url = btn.dataset.url || window.location.href;
            const label = btn.querySelector('span');
            try {
                await navigator.clipboard.writeText(url);
                if (label) {
                    label.textContent = 'Copied';
                    setTimeout(() => label.textContent = 'Copy link', 2000);
                }
            } catch (e) {
                window.prompt('Copy this link:', url);
            }
        });
    });
</script>
@endpush