@extends('layouts.frontend-2', ['main_title' => $defaultSEO->meta_title ?? 'FAQs - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <!-- Start breadcrumb Area -->
    <header class="page-banner text-center">
        <div class="container">
            <div class="breadcrumb-msr mb-3 text-center"><a href="index.html">Home</a> &nbsp;/&nbsp; FAQs</div>
            <span class="eyebrow"><span class="divider-dot"></span> FAQS</span>
            <h1 class="mt-4 mb-3">Questions, <span class="text-green">answered.</span></h1>
            <p class="lead-muted mx-auto mb-4" style="max-width:560px;">Everything you need to know about resources,
                subscriptions and billing. Can't find it here? Our support team replies within one working day.</p>
            <div class="faq-search mx-auto" style="max-width:520px;">
                <svg viewBox="0 0 24 24" fill="none">
                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <input type="text" id="faqSearchInput" placeholder="Search FAQs, e.g. 'refund' or 'exam board'">
            </div>
        </div>
    </header>
    <!-- End Breadcrumb Area -->


    <section class="section-pad" style="padding-top:40px;">
        <div class="container">
            <div class="d-flex flex-wrap gap-2 justify-content-center mb-5" id="faqCats">
                <button class="faq-cat-btn active" data-cat="all">All</button>
                <button class="faq-cat-btn" data-cat="general">General</button>
                <button class="faq-cat-btn" data-cat="billing">Billing</button>
                <button class="faq-cat-btn" data-cat="resources">Resources</button>
                <button class="faq-cat-btn" data-cat="schools">Schools</button>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="accordion accordion-msr" id="faqAccordion">

                        <div class="accordion-item" data-cat="general">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fq1">Which exam boards do you cover?
                                </button>
                            </h3>
                            <div id="fq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">We cover AQA, Edexcel, OCR, Cambridge iGCSE and CIE, with
                                    resources mapped to each board's own specification and grade boundaries.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-cat="general">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fq2">What levels and subjects are available?
                                </button>
                            </h3>
                            <div id="fq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">We publish resources across GCSE, iGCSE, A Level and AS
                                    Level, spanning the core sciences, maths, English and a growing list of humanities
                                    subjects.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-cat="billing">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fq3">Can I cancel my subscription anytime?
                                </button>
                            </h3>
                            <div id="fq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">Yes. All plans are cancel-anytime — you'll keep access until
                                    the end of your current billing period with no extra charge.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-cat="billing">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fq4">Do you offer refunds?
                                </button>
                            </h3>
                            <div id="fq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">We don't offer partial refunds for unused time within a
                                    billing period, but you're welcome to cancel before your next renewal date to avoid
                                    future charges.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-cat="billing">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fq5">What payment methods do you accept?
                                </button>
                            </h3>
                            <div id="fq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">We accept all major debit and credit cards. Payments are
                                    processed securely and we never store your full card details.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-cat="resources">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fq6">How do I download resources?
                                </button>
                            </h3>
                            <div id="fq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">Once subscribed, head to Past Papers or Products, filter by
                                    year and exam board, and download the PDF instantly to print or read on screen.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-cat="resources">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fq7">Is there a free trial?
                                </button>
                            </h3>
                            <div id="fq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">Selected past papers and worksheets are free to download
                                    with no account needed, so you can try the quality before subscribing.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-cat="resources">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fq8">Do mark schemes come with the past papers?
                                </button>
                            </h3>
                            <div id="fq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">Yes, every past paper is paired with its official mark
                                    scheme so you can self-check and understand where marks are gained or lost.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-cat="schools">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fq9">Do you offer school-wide licences?
                                </button>
                            </h3>
                            <div id="fq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">Our School plans support multiple staff accounts and shared
                                    download limits, with a Premium tier built for full department or whole-school
                                    rollout.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-cat="schools">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fq10">Can tutors use these resources with multiple students?
                                </button>
                            </h3>
                            <div id="fq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">Individual plans are licensed for personal use. If you're
                                    tutoring multiple students, our School plan is the right fit and keeps things fully
                                    licensed.
                                </div>
                            </div>
                        </div>

                    </div>
                    <p class="text-center text-muted-c mt-4 d-none" id="faqNoResults">No FAQs match your search — try a
                        different term.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-pad bg-mint">
        @include('frontend.includes.newsletter')
    </section>
@endsection
