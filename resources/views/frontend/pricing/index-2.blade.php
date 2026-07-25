@extends('layouts.frontend-2', ['main_title' => $defaultSEO->meta_title ?? 'Pricing - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <!-- ============================= PAGE HEADER ============================= -->
    <header class="page-banner text-center">
        <div class="container">
            <div class="breadcrumb-msr mb-3 text-center"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; Pricing
            </div>
            <span class="eyebrow"><span class="divider-dot"></span> PRICING</span>
            <h1 class="mt-4 mb-3">Simple, transparent pricing for <span class="text-green">schools and students.</span>
            </h1>
            <p class="lead-muted mx-auto mb-0" style="max-width:560px;">Every plan includes full mark schemes and
                cancel-anytime billing — pick the option that fits how you study.</p>
        </div>
    </header>

    <!-- ============================= SCHOOL PRICING ============================= -->




    <section class="section-pad" id="schoolPricing" style="padding-top:50px;">
        <div class="container pricing-section">
            <div class="pricing-head-row">
                <div>
                    <span class="tag-pill-mini">School Pricing</span>
                    <h2>Pricing for school</h2>
                </div>
                <div class="seg-toggle" data-scope="school">
                    <button class="seg-btn active" data-mode="yearly"
                            onclick="setBillingScoped('school','yearly',this)">Yearly Plan
                    </button>
                    <button class="seg-btn" data-mode="monthly" onclick="setBillingScoped('school','monthly',this)">
                        Monthly Plan
                    </button>
                </div>
            </div>



{{--            @include('frontend.home.subscription-2')--}}

            <div class="row g-4 justify-content-center" data-scope="school">
                {{--                @dd($subscriptionPricing)--}}
                @if(!empty($subscriptionPricing))
                    @foreach($subscriptionPricing as $k => $plan)
                        {{--                        @dd($subscriptionType['school'])--}}
                        <div class="col-md-6 col-lg-4">
                            <div class="price-card {{ $k == 'standard' ? 'featured' : '' }} ">
                                @if($k == 'standard')
                                    <span class="featured-tag">Most popular</span>
                                @endif
                                <h3 class="h6 text-muted-c text-uppercase"
                                    style="font-size:.8rem;letter-spacing:.06em;">
                                    {{ $plan['school']['yearly'][0]->name }}
                                </h3>
                                <div class="price-amount ink-flip">
                                    <span class="price-display"
                                          data-yearly="£{{ $plan['school']['yearly'][0]->price }}"
                                          data-monthly="£{{ $plan['school']['monthly'][0]->price }}">
                                        £{{ $plan['school']['yearly'][0]->price }}
                                    </span>
                                    <span class="fs-6 text-muted-c">/<span class="period-label">yearly</span>
                                    </span>
                                </div>
                                {{--                                <p class="lead-muted" style="font-size:.88rem;">For small departments getting started.</p>--}}
                                <div class="ticket-cut"></div>
                                    <ul class="price-list">
                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                      stroke-linecap="round" />
                                            </svg>
                                            User limit :
                                            <span class="dynamic-value"
                                                  data-yearly="{{ $plan['school']['yearly'][0]->user_limit }}"
                                                  data-monthly="{{ $plan['school']['monthly'][0]->user_limit }}">
                                                {{ $plan['school']['yearly'][0]->user_limit }}
                                            </span>
                                        </li>
                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                      stroke-linecap="round" />
                                            </svg>
                                            Package Download Limit :
                                            <span class="dynamic-value"
                                                  data-yearly="{{ $plan['school']['yearly'][0]->download_limit }}"
                                                  data-monthly="{{ $plan['school']['monthly'][0]->download_limit }}">
                                                {{ $plan['school']['yearly'][0]->download_limit }}
                                            </span>
                                        </li>
                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                      stroke-linecap="round" />
                                            </svg>
                                            Weekly Download Limit :
                                            <span class="dynamic-value"
                                                  data-yearly="{{ $plan['school']['yearly'][0]->weekly_limit }}"
                                                  data-monthly="{{ $plan['school']['monthly'][0]->weekly_limit }}">
                                                {{ $plan['school']['yearly'][0]->weekly_limit }}
                                            </span>
                                        </li>
                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                      stroke-linecap="round" />
                                            </svg>
                                            Has Full Access :
                                            <span class="dynamic-value"
                                                  data-yearly="{{ \App\Enums\Statement::from($plan['school']['yearly'][0]->has_full_access)->name }}"
                                                  data-monthly="{{ \App\Enums\Statement::from($plan['school']['monthly'][0]->has_full_access)->name }}">
                                                {{ \App\Enums\Statement::from($plan['school']['yearly'][0]->has_full_access)->name }}
                                            </span>
                                        </li>
                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                      stroke-linecap="round" />
                                            </svg>
                                            Trial Days :
                                            <span class="dynamic-value"
                                                  data-yearly="{{ $plan['school']['yearly'][0]->trial_days }}"
                                                  data-monthly="{{ $plan['school']['monthly'][0]->trial_days }}">
                                                {{ $plan['school']['yearly'][0]->trial_days }}
                                            </span>
                                        </li>
                                    </ul>

                                @if($k == 'standard')
                                    <a href="register.html" class="btn-brand w-100 justify-content-center mt-4">
                                        Purchase Plan
                                        <svg viewBox="0 0 24 24" fill="none" width="15" height="15">
                                            <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                @else
                                    <a href="#" class="btn-ghost-navy w-100 justify-content-center mt-4">
                                        Purchase Plan
                                        <svg viewBox="0 0 24 24" fill="none" width="15" height="15">
                                            <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor"
                                                  stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- ============================= STUDENT PRICING ============================= -->
        <div class="container pricing-section">
            <div class="pricing-head-row">
                <div>
                    <span class="tag-pill-mini" style="background:#EDE7FB;color:#7A4FE0;">Student Pricing</span>
                    <h2>Pricing for Students</h2>
                </div>
                <div class="seg-toggle" data-scope="student">
                    <button class="seg-btn active" data-mode="yearly"
                            onclick="setBillingScoped('student','yearly',this)">Yearly Plan
                    </button>
                    <button class="seg-btn" data-mode="monthly" onclick="setBillingScoped('student','monthly',this)">
                        Monthly Plan
                    </button>
                </div>
            </div>

            <div class="row g-4 justify-content-center" data-scope="student">
                @if ($subscriptionPricing->isNotEmpty())
                    @foreach ($subscriptionPricing as $k => $plan)
                        <div class="col-md-6 col-lg-4">
                            <div class="price-card {{ $k == 'standard' ? 'featured' : '' }}">
                                @if ($k == 'standard')
                                    <span class="featured-tag">Most popular</span>
                                @endif
                                <h3 class="h6 text-muted-c text-uppercase"
                                    style="font-size:.8rem;letter-spacing:.06em;">
                                    {{ $plan['student']['yearly'][0]->name }}
                                </h3>
                                <div class="price-amount">
                                        <span class="price-display"
                                              data-yearly="£{{ $plan['student']['yearly'][0]->price }}"
                                              data-monthly="£{{ $plan['student']['monthly'][0]->price }}">
                                            £{{ $plan['student']['yearly'][0]->price }}
                                        </span>
                                    <span class="fs-6 text-muted-c">/
                                            <span class="period-label">yearly</span>
                                        </span>
                                </div>
                                <p class="lead-muted" style="font-size:.88rem;">Full access for whole-school
                                    rollout.
                                </p>
                                <div class="ticket-cut"></div>
                                <ul class="price-list">
                                    <li>
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                  stroke-linecap="round" />
                                        </svg>
                                        User limit :
                                        <span class="dynamic-value"
                                              data-yearly="{{ $plan['student']['yearly'][0]->user_limit }}"
                                              data-monthly="{{ $plan['student']['monthly'][0]->user_limit }}">
                                                {{ $plan['student']['yearly'][0]->user_limit }}
                                            </span>
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                  stroke-linecap="round" />
                                        </svg>
                                        Package Download Limit :
                                        <span class="dynamic-value"
                                              data-yearly="{{ $plan['student']['yearly'][0]->download_limit }}"
                                              data-monthly="{{ $plan['student']['monthly'][0]->download_limit }}">
                                                {{ $plan['student']['yearly'][0]->download_limit }}
                                            </span>
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                  stroke-linecap="round" />
                                        </svg>
                                        Weekly Download Limit :
                                        <span class="dynamic-value"
                                              data-yearly="{{ $plan['student']['yearly'][0]->weekly_limit }}"
                                              data-monthly="{{ $plan['student']['monthly'][0]->weekly_limit }}">
                                                {{ $plan['student']['yearly'][0]->weekly_limit }}
                                            </span>
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                  stroke-linecap="round" />
                                        </svg>
                                        Has Full Access :
                                        <span class="dynamic-value"
                                              data-yearly="{{ \App\Enums\Statement::from($plan['student']['yearly'][0]->has_full_access)->name }}"
                                              data-monthly="{{ \App\Enums\Statement::from($plan['student']['monthly'][0]->has_full_access)->name }}">
                                                {{ \App\Enums\Statement::from($plan['student']['yearly'][0]->has_full_access)->name }}
                                            </span>
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2"
                                                  stroke-linecap="round" />
                                        </svg>
                                        Trial Days :
                                        <span class="dynamic-value"
                                              data-yearly="{{ $plan['student']['yearly'][0]->trial_days }}"
                                              data-monthly="{{ $plan['student']['monthly'][0]->trial_days }}">
                                                {{ $plan['student']['yearly'][0]->trial_days }}
                                            </span>
                                    </li>
                                </ul>
                                <a href="{{ route('user.subscription.checkout', ['q' => $plan['student']['yearly'][0]->slug]) }}"
                                   data-yearly="{{ route('user.subscription.checkout', ['q' => $plan['student']['yearly'][0]->slug]) }}"
                                   data-monthly="{{ route('user.subscription.checkout', ['q' => $plan['student']['monthly'][0]->slug]) }}"
                                   class="plan-link btn-brand {{ $k == 'standard' ? 'btn-brand' : 'btn-ghost-navy' }} w-100 justify-content-center mt-4">
                                    Select Package
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- ============================= TESTIMONIALS ============================= -->
    <section class="section-pad bg-mint">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width:600px;">
                <span class="eyebrow"><span class="divider-dot"></span> TESTIMONIALS</span>
                <h2 class="mt-4" style="font-size:2.2rem;">They talk about <span class="text-green"
                                                                                 style="text-decoration:underline;">us</span>
                </h2>
                <p class="lead-muted">See what students and teachers are saying about Merit Study Resources!</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="testi-card">
                        <div class="stars-row d-flex gap-1 mb-3">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                        </div>
                        <p class="text-muted-c" style="font-size:.92rem;">If you're a student in the UK, Merit Study
                            Resources is the site you need. Their past papers and resources are very well-organised. It
                            made my revision so much easier.</p>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <span class="testi-avatar" style="background:#3D6BFF;">ME</span>
                            <div>
                                <div class="fw-semibold small">Medina</div>
                                <div class="text-muted-c" style="font-size:.78rem;">School</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="testi-card">
                        <div class="stars-row d-flex gap-1 mb-3">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                        </div>
                        <p class="text-muted-c" style="font-size:.92rem;">Merit Study Resources has been a game-changer
                            for me. I found all the past papers I needed in one place, and the free resources are such a
                            big help. Highly recommended for every student preparing for exams.</p>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <span class="testi-avatar" style="background:#F3A93C;">RA</span>
                            <div>
                                <div class="fw-semibold small">Rahil</div>
                                <div class="text-muted-c" style="font-size:.78rem;">Student</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="testi-card">
                        <div class="stars-row d-flex gap-1 mb-3">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                        </div>
                        <p class="text-muted-c" style="font-size:.92rem;">I love how easy it is to find past papers and
                            books here. The site is simple, fast and reliable. Merit Study Resources really helped me
                            focus better on my studies without wasting time searching.</p>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <span class="testi-avatar" style="background:#1F9E59;">SI</span>
                            <div>
                                <div class="fw-semibold small">Simon</div>
                                <div class="text-muted-c" style="font-size:.78rem;">Teacher</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="testi-card">
                        <div class="stars-row d-flex gap-1 mb-3">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                        </div>
                        <p class="text-muted-c" style="font-size:.92rem;">What I like most about Merit Study Resources
                            is that they provide free past papers along with helpful study materials. Not many websites
                            give such quality resources for free.</p>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <span class="testi-avatar" style="background:#E45B7A;">NT</span>
                            <div>
                                <div class="fw-semibold small">Nishat Tasnim</div>
                                <div class="text-muted-c" style="font-size:.78rem;">Student</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="testi-card">
                        <div class="stars-row d-flex gap-1 mb-3">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                        </div>
                        <p class="text-muted-c" style="font-size:.92rem;">If you're a student in the UK, Merit Study
                            Resources is the site you need. Their past papers and resources are very well-organised. It
                            made my revision so much easier.</p>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <span class="testi-avatar" style="background:#3D6BFF;">ME</span>
                            <div>
                                <div class="fw-semibold small">Medina</div>
                                <div class="text-muted-c" style="font-size:.78rem;">School</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="testi-card">
                        <div class="stars-row d-flex gap-1 mb-3">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                        </div>
                        <p class="text-muted-c" style="font-size:.92rem;">Merit Study Resources has been a game-changer
                            for me. I found all the past papers I needed in one place, and the free resources are such a
                            big help. Highly recommended for every student preparing for exams.</p>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <span class="testi-avatar" style="background:#F3A93C;">RA</span>
                            <div>
                                <div class="fw-semibold small">Rahil</div>
                                <div class="text-muted-c" style="font-size:.78rem;">Student</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="testi-card">
                        <div class="stars-row d-flex gap-1 mb-3">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                        </div>
                        <p class="text-muted-c" style="font-size:.92rem;">I love how easy it is to find past papers and
                            books here. The site is simple, fast and reliable. Merit Study Resources really helped me
                            focus better on my studies without wasting time searching.</p>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <span class="testi-avatar" style="background:#1F9E59;">SI</span>
                            <div>
                                <div class="fw-semibold small">Simon</div>
                                <div class="text-muted-c" style="font-size:.78rem;">Teacher</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="testi-card">
                        <div class="stars-row d-flex gap-1 mb-3">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                            <svg viewBox="0 0 20 20">
                                <path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.9 4.4 18l1.4-6.2L1 7.5l6.4-.6z"/>
                            </svg>
                        </div>
                        <p class="text-muted-c" style="font-size:.92rem;">What I like most about Merit Study Resources
                            is that they provide free past papers along with helpful study materials. Not many websites
                            give such quality resources for free.</p>
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <span class="testi-avatar" style="background:#E45B7A;">NT</span>
                            <div>
                                <div class="fw-semibold small">Nishat Tasnim</div>
                                <div class="text-muted-c" style="font-size:.78rem;">Student</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= DEALS / SUBSCRIBE ============================= -->
    <section class="section-pad">
        <div class="container">
            <div class="deals-box bg-navy-2 text-white">
                <span class="eyebrow eyebrow-light" style="position:relative;z-index:1;"><span
                        class="divider-dot"></span> DEALS. UPDATES. RESOURCES.</span>
                <h2 class="text-white mt-4 mb-4"
                    style="font-size:1.9rem;max-width:640px;margin-left:auto;margin-right:auto;position:relative;z-index:1;">
                    Unlock Special Offers &amp; Must-Have Resources! Subscribe <span style="text-decoration:underline;">Now</span>
                    — It's Free!</h2>
                <form class="deals-input-row">
                    <input type="email" placeholder="Enter your email">
                    <button type="submit" class="btn-circle-green" aria-label="Subscribe">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2.2"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        // Billing toggle (yearly / monthly)
        function setBilling(mode) {
            document.getElementById('yearlyBtn').classList.toggle('active', mode === 'yearly');
            document.getElementById('monthlyBtn').classList.toggle('active', mode === 'monthly');
            document.querySelectorAll('.price-display').forEach(el => {
                el.textContent = mode === 'yearly' ? el.dataset.yearly : el.dataset.monthly;
            });
            document.querySelectorAll('.period-label').forEach(el => {
                el.textContent = mode === 'yearly' ? 'yearly' : 'monthly';
            });
            document.querySelectorAll('.price-list .dynamic-value').forEach(el => {
                el.textContent = mode === 'yearly' ? el.dataset.yearly : el.dataset.monthly;
            });
            document.querySelectorAll('.plan-link').forEach(el => {
                el.href = mode === 'yearly' ? el.dataset.yearly : el.dataset.monthly;
            });
        }

        function setBillingScoped(scope, mode, btn) {
            const toggle = document.querySelector(`.seg-toggle[data-scope="${scope}"]`);
            toggle.querySelectorAll('.seg-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const row = document.querySelector(`.row[data-scope="${scope}"]`);
            row.querySelectorAll('.price-display').forEach(el => {
                el.textContent = mode === 'yearly' ? el.dataset.yearly : el.dataset.monthly;
            });
            row.querySelectorAll('.period-label').forEach(el => {
                el.textContent = mode === 'yearly' ? 'yearly' : 'monthly';
            });
        }
    </script>
@endpush
