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
                        <a href="#products" class="btn-ghost-navy">
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
@endsection
