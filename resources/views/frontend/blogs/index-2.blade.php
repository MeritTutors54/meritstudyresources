@extends('layouts.frontend-2', ['main_title' => $defaultSEO->meta_title ?? 'Blogs - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <header class="page-banner">
        <div class="container">
            <div class="breadcrumb-msr mb-3"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; Blog</div>
            <span class="eyebrow"><span class="divider-dot"></span> OUR BLOG</span>

        </div>
    </header>

    <!-- ============================= FEATURED POST ============================= -->
    @if(!empty($featured))
        <section class="section-pad" style="padding-top:36px;padding-bottom:20px;">
            <div class="container">
                <a href="{{ route('blogs.details', $featured->slug) }}" class="text-decoration-none">
                    <div class="featured-post">
                        <div class="featured-thumb">
                            <span class="fp-badge">Featured</span>
                            {{-- Add Image Here --}}
                            @if($featured->cover_image)
                                <img src="{{ asset(Storage::url($featured->cover_image)) }}"
                                     alt="{{ $featured->title }}"
                                     class="featured-img">
                            @endif
                        </div>
                        <div class="featured-body">
                            <span class="eyebrow"><span class="divider-dot"></span> EDITOR'S PICK</span>
                            <h2 class="mt-3">{{ $featured->title }}</h2>
                            <p class="text-muted-c mb-4">{{ $featured->description }}</p>
                            <div class="blog-meta" style="border-top:none;padding-top:0;margin-top:0;">
                                <span class="bm-avatar" style="background:#3D6BFF;">{{ $featured->author->initials }}</span>
                                <div class="bm-info"><strong>{{ $featured->author->name }}</strong>{{ $featured->created_at?->format('j M Y') }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </section>
    @endif


    <!-- ============================= CATEGORY FILTER + GRID ============================= -->
    <section class="section-pad" style="padding-top:10px;">
        <div class="container">
            <div class="blog-cat-row mb-5" id="blogCats">
                <button class="blog-cat-btn active" data-cat="all">All Articles</button>
                <button class="blog-cat-btn" data-cat="exam-tips">Exam Tips</button>
                <button class="blog-cat-btn" data-cat="revision">Revision</button>
                <button class="blog-cat-btn" data-cat="subject-guides">Subject Guides</button>
                <button class="blog-cat-btn" data-cat="study-skills">Study Skills</button>
                <button class="blog-cat-btn" data-cat="school-news">School News</button>
            </div>

            <div class="row g-4" id="blogGrid">
                @forelse($blogs as $blog)
                    <div class="col-md-6 col-lg-4 blog-item" data-cat="revision">
                        <div class="blog-card">
                            <div class="blog-media">
                                <a href="{{ route('blogs.details', $blog->slug) }}">
                                    <img src="{{ asset(Storage::url($blog->cover_image)) }}" alt="{{ $blog->title }}" class="img-fluid blog-img">
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
                @empty
                    <div class="col-12">
                        <p>No blogs found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            <p class="text-center text-muted-c mt-4 d-none" id="blogNoResults">No articles match your search — try a
                different term.</p>

            {{ $blogs->links('vendor.pagination.custom-2') }}
        </div>
    </section>

    <!-- ============================= NEWSLETTER ============================= -->
    <section class="section-pad bg-mint">
        @include('frontend.includes.newsletter')
    </section>
@endsection
@push('js')
    <script>
        // Category filter
        document.querySelectorAll('.blog-cat-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.blog-cat-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterBlog();
            });
        });

        // Search + category combined filter
        function filterBlog() {
            const term = document.getElementById('blogSearchInput').value.trim().toLowerCase();
            const activeCat = document.querySelector('.blog-cat-btn.active').dataset.cat;
            let visibleCount = 0;
            document.querySelectorAll('.blog-item').forEach(item => {
                const matchesCat = activeCat === 'all' || item.dataset.cat === activeCat;
                const matchesTerm = term === '' || item.textContent.toLowerCase().includes(term);
                const show = matchesCat && matchesTerm;
                item.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });
            document.getElementById('blogNoResults').classList.toggle('d-none', visibleCount !== 0);
        }

        document.getElementById('blogSearchBtn').addEventListener('click', filterBlog);
        document.getElementById('blogSearchInput').addEventListener('input', filterBlog);
        document.getElementById('blogSearchInput').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') e.preventDefault();
        });

        // Pagination (visual only)
        document.querySelectorAll('.pg-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                if (!/^\d+$/.test(btn.textContent.trim())) return;
                document.querySelectorAll('.pg-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('blogGrid').scrollIntoView({behavior: 'smooth', block: 'start'});
            });
        });
    </script>
@endpush
