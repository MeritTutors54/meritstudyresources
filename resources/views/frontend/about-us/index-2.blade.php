@extends('layouts.frontend-2', ['main_title' => $defaultSEO->meta_title ?? 'About Us - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <header class="page-banner">
        <div class="container">
            <div class="breadcrumb-msr mb-3"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; About Us</div>
            <span class="eyebrow"><span class="divider-dot"></span> OUR STORY</span>
            <h1 class="mt-4 mb-3">Built by teachers, trusted by <span class="text-green">thousands of students.</span>
            </h1>
            <p class="lead-muted" style="max-width:600px;">Merit Study Resources started with a simple idea: revision
                materials should be exam-board accurate, affordable, and written by people who actually teach the
                subject.</p>
        </div>
    </header>

    <!-- ============================= STATS ============================= -->
    <section class="bg-navy-2 stat-band py-5">
        <div class="container py-3">
            <div class="row gy-4">
                <div class="col-6 col-lg-3 stat-col">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M6 4h9l5 5v11H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
                    <div class="stat-num font-mono">7,689+</div><div class="stat-label">Past Papers</div>
                </div>
                <div class="col-6 col-lg-3 stat-col">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
                    <div class="stat-num font-mono">350+</div><div class="stat-label">Worksheets &amp; Booklets</div>
                </div>
                <div class="col-6 col-lg-3 stat-col">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/><circle cx="17" cy="9" r="2.4" stroke="currentColor" stroke-width="1.6"/><path d="M3 19c0-3 2.7-5 6-5s6 2 6 5M14 19c0-2.2 1.6-4 4.5-4 1.6 0 2.5.5 2.5 1.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
                    <div class="stat-num font-mono">1,000+</div><div class="stat-label">Active Students</div>
                </div>
                <div class="col-6 col-lg-3 stat-col">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
                    <div class="stat-num font-mono">15+</div><div class="stat-label">Certified Tutors</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= OUR STORY ============================= -->
    <section class="section-pad">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6">
                    <div class="paper-stack" style="height:380px;">
                        <div class="sheet sheet-back"></div>
                        <div class="sheet sheet-mid p-4">
                            <span class="tag-pill-mini">Founded by tutors</span>
                            <div class="mt-4">
                                <div class="line-bar w-80"></div><div class="line-bar w-60"></div><div class="line-bar w-40"></div>
                            </div>
                        </div>
                        <div class="sheet sheet-front p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="tag-pill-mini">Our Mission</span>
                                <span class="icon-circle"><svg viewBox="0 0 24 24" fill="none"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z" stroke="#fff" stroke-width="1.6" stroke-linejoin="round"/></svg></span>
                            </div>
                            <div class="mt-4"><div class="line-bar w-80"></div><div class="line-bar w-60"></div></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="eyebrow"><span class="divider-dot"></span> HOW WE STARTED</span>
                    <h2 class="mt-4 mb-4" style="font-size:2.1rem;">From a tutoring centre in London to a UK-wide revision library</h2>
                    <p class="lead-muted mb-3">Merit Study Resources grew out of Merit Tutors, a London exam centre where our founding tutors kept rebuilding the same worksheets and past-paper packs year after year for their students.</p>
                    <p class="lead-muted mb-4">We decided to put that library online, mapped precisely to AQA, Edexcel, OCR, Cambridge iGCSE and CIE specifications, so every student — not just the ones we tutor in person — could revise with confidence.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('products') }}" class="btn-brand">Browse Resources
                            <svg viewBox="0 0 24 24" fill="none" width="16" height="16"><path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
{{--                        <a href="{{ route('products') }}" class="btn-ghost-navy">See Pricing</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= VALUES ============================= -->
    <section class="section-pad bg-mint">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-6">
                    <span class="eyebrow"><span class="divider-dot"></span> WHAT WE STAND FOR</span>
                    <h2 class="mt-4 mb-3" style="font-size:2.1rem;">The values behind every resource</h2>
                    <p class="lead-muted">These principles guide how we write, check and price everything we publish.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card-paper value-card">
                        <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                        <h3 class="h5">Accuracy first</h3>
                        <p class="text-muted-c mb-0">Every paper and mark scheme is checked against the current syllabus before it's published.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-paper value-card">
                        <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-4.4-9.5-9C.7 8 2.6 4.5 6 4c2-.3 3.6.6 4.9 2 1.3-1.4 2.9-2.3 4.9-2 3.4.5 5.3 4 3.5 8-2.5 4.6-9.5 9-9.5 9z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg></div>
                        <h3 class="h5">Fair pricing</h3>
                        <p class="text-muted-c mb-0">Plans built for individual students up to whole-school rollouts, with free resources always available.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-paper value-card">
                        <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.8"/><path d="M3 19c0-3 2.7-5 6-5s6 2 6 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
                        <h3 class="h5">Taught by real tutors</h3>
                        <p class="text-muted-c mb-0">Every guide is written and graded by certified, subject-qualified tutors — never generated content.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= TEAM ============================= -->
    <section class="section-pad">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-6">
                    <span class="eyebrow"><span class="divider-dot"></span> MEET THE TEAM</span>
                    <h2 class="mt-4 mb-3" style="font-size:2.1rem;">Certified tutors behind the resources</h2>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-6 col-lg-3">
                    <div class="team-card">
                        <span class="team-avatar" style="background:#3D6BFF;">RH</span>
                        <h3 class="h6 mb-1">Rachel Hughes</h3>
                        <p class="text-muted-c small mb-0">Founder &amp; Maths Tutor</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="team-card">
                        <span class="team-avatar" style="background:#F3A93C;">SK</span>
                        <h3 class="h6 mb-1">Sam Khatri</h3>
                        <p class="text-muted-c small mb-0">Head of Sciences</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="team-card">
                        <span class="team-avatar" style="background:#E45B7A;">NT</span>
                        <h3 class="h6 mb-1">Nishat Tasnim</h3>
                        <p class="text-muted-c small mb-0">English &amp; Humanities Lead</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="team-card">
                        <span class="team-avatar" style="background:var(--green);">DP</span>
                        <h3 class="h6 mb-1">Daniel Price</h3>
                        <p class="text-muted-c small mb-0">Content &amp; Quality Lead</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= NEWSLETTER ============================= -->
    @include('frontend.includes.newsletter')

@endsection
