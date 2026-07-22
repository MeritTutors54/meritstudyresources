@extends('layouts.frontend-2')
@section('content')
    <!-- ============================= HERO ============================= -->
    <header class="hero" id="home">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6">
                    <span class="eyebrow"><span class="divider-dot"></span> UK'S TRUSTED REVISION LIBRARY</span>
                    <h1 class="mt-4 mb-4">Master your studies with resources built by <span class="text-green">real
                            teachers.</span></h1>
                    <p class="lead-muted mb-4" style="max-width:480px;">Explore a vast collection of past papers,
                        worksheets and homework booklets across GCSE, iGCSE, A Level and AS Level — all aligned to your
                        exact exam board.</p>
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="#pricing" class="btn-brand">
                            Explore Subscriptions
                            <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                                <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        <a href="{{ route('past.papers') }}" class="btn-ghost-navy">
                            <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                                <path d="M6 4h9l3 3v13H6z" stroke="currentColor" stroke-width="1.6"
                                    stroke-linejoin="round" />
                                <path d="M9 10h6M9 13h6M9 16h4" stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" />
                            </svg>
                            View Past Papers
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-stack">
                            <span class="av av1">RH</span><span class="av av2">SK</span><span class="av av3">NT</span><span
                                class="av av4">+1k</span>
                        </div>
                        <div>
                            <div class="stars-row d-flex gap-1 mb-1">
                                <svg viewBox="0 0 20 20">
                                    <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                </svg>
                                <svg viewBox="0 0 20 20">
                                    <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                </svg>
                                <svg viewBox="0 0 20 20">
                                    <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                </svg>
                                <svg viewBox="0 0 20 20">
                                    <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                </svg>
                                <svg viewBox="0 0 20 20">
                                    <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                </svg>
                            </div>
                            <p class="mb-0 small text-muted-c fw-semibold">4.9/5 rated by 1,000+ students &amp; parents
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="paper-stack">
                        <div class="sheet sheet-back"></div>
                        <div class="sheet sheet-mid p-4">
                            <span class="tag-pill-mini">Worksheets &amp; Tests</span>
                            <div class="mt-4">
                                <div class="line-bar w-80"></div>
                                <div class="line-bar w-60"></div>
                                <div class="line-bar w-40"></div>
                            </div>
                        </div>
                        <div class="sheet sheet-front p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="tag-pill-mini">Past Papers · GCSE</span>
                                <span class="icon-circle"><svg viewBox="0 0 24 24" fill="none">
                                        <path d="M5 13l4 4L19 7" stroke="#fff" stroke-width="2.4" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg></span>
                            </div>
                            <div class="mt-4">
                                <div class="line-bar w-80"></div>
                                <div class="line-bar w-60"></div>
                            </div>
                            <svg class="mini-chart mt-3" viewBox="0 0 60 30" fill="none">
                                <polyline points="0,26 12,18 24,20 36,8 48,12 60,2" stroke="#1F9E59" stroke-width="2.4"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="float-chip c1">
                            <span class="icon-circle" style="background:var(--navy);"><svg viewBox="0 0 24 24"
                                    fill="none">
                                    <path d="M4 19V5a2 2 0 012-2h8l6 6v10a2 2 0 01-2 2H6a2 2 0 01-2-2z" stroke="#fff"
                                        stroke-width="1.6" stroke-linejoin="round" />
                                </svg></span>
                            <div>
                                <div class="fw-bold font-mono" style="font-size:.95rem;">7,689+</div>
                                <div class="small text-muted-c">Past Papers</div>
                            </div>
                        </div>
                        <div class="float-chip c2">
                            <span class="icon-circle"><svg viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z" stroke="#fff"
                                        stroke-width="1.6" stroke-linejoin="round" />
                                </svg></span>
                            <div>
                                <div class="fw-bold font-mono" style="font-size:.95rem;">98%</div>
                                <div class="small text-muted-c">Pass Rate</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ============================= MARQUEE ============================= -->
    <div class="marquee-wrap">
        <div class="marquee-track">
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M5 4h14v16H5z" stroke="#fff" stroke-width="1.6" />
                </svg> Past Papers</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.6" />
                </svg> Worksheets</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M4 6h16M4 12h16M4 18h10" stroke="#fff" stroke-width="1.6" stroke-linecap="round" />
                </svg> Worksheet Tests</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 3l9 4.5-9 4.5-9-4.5z" stroke="#fff" stroke-width="1.6" />
                </svg> Homework Booklets</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <rect x="4" y="4" width="16" height="16" rx="2" stroke="#fff" stroke-width="1.6" />
                </svg> Classwork Booklets</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M5 4h14v16H5z" stroke="#fff" stroke-width="1.6" />
                </svg> Past Papers</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.6" />
                </svg> Worksheets</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M4 6h16M4 12h16M4 18h10" stroke="#fff" stroke-width="1.6" stroke-linecap="round" />
                </svg> Worksheet Tests</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 3l9 4.5-9 4.5-9-4.5z" stroke="#fff" stroke-width="1.6" />
                </svg> Homework Booklets</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <rect x="4" y="4" width="16" height="16" rx="2" stroke="#fff" stroke-width="1.6" />
                </svg> Classwork Booklets</div>
        </div>
    </div>

    <!-- ============================= STATS ============================= -->
    <section class="bg-navy-2 stat-band py-5">
        <div class="container py-3">
            <div class="row gy-4">
                <div class="col-6 col-lg-3 stat-col">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none">
                            <path d="M6 4h9l5 5v11H6z" stroke="currentColor" stroke-width="1.6"
                                stroke-linejoin="round" />
                        </svg></div>
                    <div class="stat-num font-mono">7,689+</div>
                    <div class="stat-label">Past Papers</div>
                </div>
                <div class="col-6 col-lg-3 stat-col">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none">
                            <path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="1.6"
                                stroke-linecap="round" />
                        </svg></div>
                    <div class="stat-num font-mono">350+</div>
                    <div class="stat-label">Worksheets &amp; Booklets</div>
                </div>
                <div class="col-6 col-lg-3 stat-col">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none">
                            <circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.6" />
                            <circle cx="17" cy="9" r="2.4" stroke="currentColor" stroke-width="1.6" />
                            <path d="M3 19c0-3 2.7-5 6-5s6 2 6 5M14 19c0-2.2 1.6-4 4.5-4 1.6 0 2.5.5 2.5 1.4"
                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                        </svg></div>
                    <div class="stat-num font-mono">1,000+</div>
                    <div class="stat-label">Active Students</div>
                </div>
                <div class="col-6 col-lg-3 stat-col">
                    <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z" stroke="currentColor"
                                stroke-width="1.6" stroke-linejoin="round" />
                        </svg></div>
                    <div class="stat-num font-mono">15+</div>
                    <div class="stat-label">Certified Tutors</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= ABOUT ============================= -->
    <section class="section-pad" id="about">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-5 order-lg-2">
                    <span class="eyebrow"><span class="divider-dot"></span> ABOUT US</span>
                    <h2 class="mt-4 mb-4" style="font-size:2.2rem;">Expert-crafted revision resources from Merit Study
                        Resources</h2>
                    <div class="check-item">
                        <span class="check-ico"><svg viewBox="0 0 24 24" fill="none">
                                <path d="M5 13l4 4L19 7" stroke="#fff" stroke-width="2.4" stroke-linecap="round" />
                            </svg></span>
                        <div>
                            <h3 class="h6 mb-1">Exam-board aligned</h3>
                            <p class="lead-muted mb-0">Every guide and paper is mapped to your specific exam board's
                                latest specification.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <span class="check-ico"><svg viewBox="0 0 24 24" fill="none">
                                <path d="M5 13l4 4L19 7" stroke="#fff" stroke-width="2.4" stroke-linecap="round" />
                            </svg></span>
                        <div>
                            <h3 class="h6 mb-1">Affordable subscriptions</h3>
                            <p class="lead-muted mb-0">Plans designed for individual students, families and whole
                                school cohorts alike.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <span class="check-ico"><svg viewBox="0 0 24 24" fill="none">
                                <path d="M5 13l4 4L19 7" stroke="#fff" stroke-width="2.4" stroke-linecap="round" />
                            </svg></span>
                        <div>
                            <h3 class="h6 mb-1">Built by certified tutors</h3>
                            <p class="lead-muted mb-0">Resources are written, checked and graded by qualified,
                                certified subject tutors.</p>
                        </div>
                    </div>
                    <a href="{{ route('resource.category') }}" class="btn-brand mt-3">View All Resources
                        <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                            <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <div class="col-lg-7 order-lg-1">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="card-paper p-4">
                                <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none">
                                        <path d="M6 4h9l5 5v11H6z" stroke="currentColor" stroke-width="1.6"
                                            stroke-linejoin="round" />
                                    </svg></div>
                                <h3 class="h6">Past Papers</h3>
                                <p class="small text-muted-c mb-0">GCSE, iGCSE, A Level &amp; AS Level papers with mark
                                    schemes.</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-paper p-4" style="margin-top:28px;">
                                <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none">
                                        <path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="1.6"
                                            stroke-linecap="round" />
                                    </svg></div>
                                <h3 class="h6">Worksheets</h3>
                                <p class="small text-muted-c mb-0">Targeted practice sheets to build topic-by-topic
                                    confidence.</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-paper p-4">
                                <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none">
                                        <path d="M12 3l9 4.5-9 4.5-9-4.5z" stroke="currentColor" stroke-width="1.6" />
                                    </svg></div>
                                <h3 class="h6">Homework Booklets</h3>
                                <p class="small text-muted-c mb-0">Structured booklets to keep weekly revision on
                                    track.</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-paper p-4" style="margin-top:28px;">
                                <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none">
                                        <rect x="4" y="4" width="16" height="16" rx="2"
                                            stroke="currentColor" stroke-width="1.6" />
                                    </svg></div>
                                <h3 class="h6">Classwork Booklets</h3>
                                <p class="small text-muted-c mb-0">Ready-to-teach sets for classroom or one-to-one
                                    tutoring.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= FEATURE GRID ============================= -->
    <section class="section-pad bg-mint">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width:640px;">
                <span class="eyebrow"><span class="divider-dot"></span> WHY MERIT</span>
                <h2 class="mt-4" style="font-size:2.2rem;">Everything you need to revise smarter</h2>
                <p class="lead-muted">A complete toolkit for students, parents and schools — built around how real
                    exams are actually marked.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card-paper feature-card position-relative">
                        <span class="feature-num">01</span>
                        <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none">
                                <path d="M9 12l2 2 4-4M12 3l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V7z" stroke="currentColor"
                                    stroke-width="1.6" stroke-linejoin="round" />
                            </svg></div>
                        <h3 class="h5">Exam-board aligned</h3>
                        <p class="text-muted-c mb-0">Content checked against the latest AQA, Edexcel, OCR and Cambridge
                            specifications.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-paper feature-card position-relative">
                        <span class="feature-num">02</span>
                        <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none">
                                <circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.6" />
                                <path d="M3 19c0-3 2.7-5 6-5s6 2 6 5" stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" />
                                <path d="M15 4.5c1.4.4 2.4 1.7 2.4 3.2s-1 2.8-2.4 3.2M18 14.3c1.7.6 3 1.9 3 3.7"
                                    stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                            </svg></div>
                        <h3 class="h5">Verified tutors</h3>
                        <p class="text-muted-c mb-0">Every resource is written and reviewed by qualified,
                            background-checked tutors.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-paper feature-card position-relative">
                        <span class="feature-num">03</span>
                        <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 19h14" stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg></div>
                        <h3 class="h5">Instant download</h3>
                        <p class="text-muted-c mb-0">Unlock print-ready PDFs the moment you subscribe — no waiting on
                            shipping.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-paper feature-card position-relative">
                        <span class="feature-num">04</span>
                        <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none">
                                <path d="M3 12a9 9 0 0115-6.7M21 12a9 9 0 01-15 6.7" stroke="currentColor"
                                    stroke-width="1.6" stroke-linecap="round" />
                                <path d="M18 3v4h-4M6 21v-4h4" stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg></div>
                        <h3 class="h5">Updated every term</h3>
                        <p class="text-muted-c mb-0">Libraries refresh each term to match new specimen papers and grade
                            boundaries.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-paper feature-card position-relative">
                        <span class="feature-num">05</span>
                        <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none">
                                <rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor"
                                    stroke-width="1.6" />
                                <path d="M9 7h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                            </svg></div>
                        <h3 class="h5">Works on any device</h3>
                        <p class="text-muted-c mb-0">Read, download and print from desktop, tablet or phone with one
                            account.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-paper feature-card position-relative">
                        <span class="feature-num">06</span>
                        <div class="feature-ico-wrap"><svg viewBox="0 0 24 24" fill="none">
                                <rect x="4" y="10" width="16" height="10" rx="2" stroke="currentColor"
                                    stroke-width="1.6" />
                                <path d="M8 10V7a4 4 0 018 0v3" stroke="currentColor" stroke-width="1.6" />
                            </svg></div>
                        <h3 class="h5">Secure payments</h3>
                        <p class="text-muted-c mb-0">Card payments are encrypted end-to-end, with cancel-anytime
                            billing.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= HOW IT WORKS ============================= -->
    <section class="section-pad">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width:600px;">
                <span class="eyebrow"><span class="divider-dot"></span> GETTING STARTED</span>
                <h2 class="mt-4" style="font-size:2.2rem;">From sign-up to your next top grade</h2>
            </div>
            <div class="row step-track g-4">
                <div class="step-line"></div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="step-circle is-green mx-auto">01</div>
                    <h3 class="h6">Create your account</h3>
                    <p class="text-muted-c small">Sign up in under a minute as a student, parent or school.</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="step-circle mx-auto">02</div>
                    <h3 class="h6">Choose your plan</h3>
                    <p class="text-muted-c small">Pick a school or student plan that fits your year group.</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="step-circle mx-auto">03</div>
                    <h3 class="h6">Browse &amp; download</h3>
                    <p class="text-muted-c small">Search by subject, exam board and year to find what you need.</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="step-circle is-green mx-auto">04</div>
                    <h3 class="h6">Track your progress</h3>
                    <p class="text-muted-c small">Work through papers and booklets, term after term.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= PRICING ============================= -->
    @include('frontend.home.subscription-2')


    <!-- ============================= PRODUCTS ============================= -->
    <section class="section-pad" id="products">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width:640px;">
                <span class="eyebrow"><span class="divider-dot"></span> OUR PRODUCTS</span>
                <h2 class="mt-4" style="font-size:2.2rem;">Featured GCSE, iGCSE, A Level &amp; AS Level products
                </h2>
                <p class="lead-muted">A selection of our high-quality workbooks for Year 10, Year 11 and beyond.</p>
            </div>
            <div class="row g-4">
                @if (!empty($products))
                    @foreach ($products as $product)
                        <div class="col-sm-6 col-lg-3">
                            <div class="product-card">
                                @if (!empty($product->mirror_discount))
                                    <div class="discount-ribbon">{{ number_format($product->actual_discount, 0) }}%
                                        OFF</div>
                                @endif
                                <div class="product-thumb thumb-blue">
                                    <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($product->image)) }}"
                                        alt="{{ $product->name }}">
                                    <span class="year-pill">YEAR 5</span>
                                    <div class="thumb-title">Targeted Questions With Examples</div>
                                </div>
                                <div class="p-3">
                                    <h3 class="h6 mb-1">{{ $product->name }}</h3>
                                    <p class="small text-muted-c mb-2">{{ $product->bookVariant->bookSubject->name }}
                                        · {{ $product->bookVariant->name }}</p>
                                    <div class="stars-row d-flex gap-1 mb-2">
                                        <svg viewBox="0 0 20 20">
                                            <path
                                                d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                        </svg>
                                        <svg viewBox="0 0 20 20">
                                            <path
                                                d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                        </svg>
                                        <svg viewBox="0 0 20 20">
                                            <path
                                                d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                        </svg>
                                        <svg viewBox="0 0 20 20">
                                            <path
                                                d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                        </svg>
                                        <svg viewBox="0 0 20 20">
                                            <path
                                                d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                        </svg>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if (!empty($product->mirror_discount))
                                            <div>
                                                <span class="price-new">£{{ $product->mirror_discount }}</span>
                                                <span class="price-old">£{{ $product->mirror_price }}</span>
                                            </div>
                                        @else
                                            <div>
                                                <span class="price-new">£{{ $product->mirror_price }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('single.product', [$product->slug]) }}"
                                        class="btn-ghost-navy w-100 justify-content-center mt-3"
                                        style="padding:9px 18px;">View Product</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('products') }}" class="btn-brand">View All Products
                    <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================= MARQUEE 2 ============================= -->
    <div class="marquee-wrap">
        <div class="marquee-track">
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M5 4h14v16H5z" stroke="#fff" stroke-width="1.6" />
                </svg> Past Papers</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.6" />
                </svg> Worksheets</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M4 6h16M4 12h16M4 18h10" stroke="#fff" stroke-width="1.6" stroke-linecap="round" />
                </svg> Worksheet Tests</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 3l9 4.5-9 4.5-9-4.5z" stroke="#fff" stroke-width="1.6" />
                </svg> Homework Booklets</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <rect x="4" y="4" width="16" height="16" rx="2" stroke="#fff" stroke-width="1.6" />
                </svg> Classwork Booklets</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M5 4h14v16H5z" stroke="#fff" stroke-width="1.6" />
                </svg> Past Papers</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.6" />
                </svg> Worksheets</div>
            <div class="marquee-item"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M4 6h16M4 12h16M4 18h10" stroke="#fff" stroke-width="1.6" stroke-linecap="round" />
                </svg> Worksheet Tests</div>
        </div>
    </div>

    <!-- ============================= TESTIMONIALS ============================= -->
    <section class="section-pad">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width:600px;">
                <span class="eyebrow"><span class="divider-dot"></span> TESTIMONIALS</span>
                <h2 class="mt-4" style="font-size:2.2rem;">They talk about us</h2>
                <p class="lead-muted">See what students, parents and teachers are saying about Merit Study Resources.
                </p>
            </div>
            <div class="row g-4">
                @if (!empty($testimonials))
                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-6 col-lg-3">
                            <div class="testi-card">
                                <div class="stars-row d-flex gap-1 mb-3">
                                    <svg viewBox="0 0 20 20">
                                        <path
                                            d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                    </svg>
                                    <svg viewBox="0 0 20 20">
                                        <path
                                            d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                    </svg>
                                    <svg viewBox="0 0 20 20">
                                        <path
                                            d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                    </svg>
                                    <svg viewBox="0 0 20 20">
                                        <path
                                            d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                    </svg>
                                    <svg viewBox="0 0 20 20">
                                        <path
                                            d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z" />
                                    </svg>
                                </div>
                                <p class="text-muted-c" style="font-size:.92rem;">
                                    {{ $testimonial->description }}
                                </p>
                                <div class="d-flex align-items-center gap-2 mt-4">
                                    <span class="testi-avatar" data-initial="{{ $testimonial->name }}"
                                        style="background:#3D6BFF;"></span>
                                    <div>
                                        <div class="fw-semibold small">{{ $testimonial->name }}</div>
                                        <div class="text-muted-c" style="font-size:.78rem;">
                                            {{ ucfirst(strtolower(\App\Enums\UserType::from($testimonial->type)->name)) }}
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

    <!-- ============================= FAQ ============================= -->
    <section class="section-pad bg-mint" id="faq">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-5">
                    <span class="eyebrow"><span class="divider-dot"></span> FAQS</span>
                    <h2 class="mt-4 mb-3" style="font-size:2.2rem;">Questions, answered</h2>
                    <p class="lead-muted">Can't find what you're after? Reach out and our support team will get back to
                        you within one working day.</p>
                    <a href="{{ route('contact-us') }}" class="btn-brand mt-2">Contact Support
                        <svg viewBox="0 0 24 24" fill="none" width="16" height="16">
                            <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-msr" id="faqAccordion">
                        @if (!empty($faqs))
                            @foreach ($faqs as $k => $faq)
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button {{ $k == 0 ? '' : 'collapsed' }}" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#f2">
                                            {{ $faq->question }}
                                        </button>
                                    </h3>
                                    <div id="f2" class="accordion-collapse collapse {{ $k == 0 ? 'show' : '' }}"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">{{ $faq->answer }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= NEWSLETTER ============================= -->
    @include('frontend.includes.newsletter')

@endsection
@push('js')
    <script>
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Stop the page from reloading

            const form = this;
            const errorDiv = document.getElementById('form-error');
            const successDiv = document.getElementById('form-success');

            // Hide previous messages
            errorDiv.classList.add('d-none');
            successDiv.classList.add('d-none');

            // Gather form data
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Tells Laravel it's an AJAX request
                    },
                    body: formData
                })
                .then(async response => {
                    const data = await response.json();

                    if (response.ok) {
                        // Success (Status code 200-299)
                        successDiv.textContent = data.message || 'Thank you for subscribing!';
                        successDiv.classList.remove('d-none');
                        form.reset(); // Clear the input field
                    } else if (response.status === 422) {
                        // Laravel Validation Errors
                        let errors = Object.values(data.errors).flat().join(' ');
                        errorDiv.textContent = errors;
                        errorDiv.classList.remove('d-none');
                    } else {
                        // General Errors
                        errorDiv.textContent = data.message || 'Something went wrong. Please try again.';
                        errorDiv.classList.remove('d-none');
                    }
                })
                .catch(error => {
                    console.log('errr: ', error);

                    errorDiv.textContent = 'Network error. Please try again.';
                    errorDiv.classList.remove('d-none');
                });
        });
    </script>
@endpush
