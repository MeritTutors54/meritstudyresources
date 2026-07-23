@extends('layouts.frontend-2', ['main_title' => $defaultSEO->meta_title ?? 'Terms & Conditions - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <div class="page-banner">
        <div class="container">
            <div class="breadcrumb-msr mb-3"><a href="index.html">Home</a> &nbsp;/&nbsp; Terms &amp; Conditions</div>
            <span class="eyebrow"><span class="divider-dot"></span> LEGAL</span>
            <h1 class="mt-4 mb-3">Terms &amp; <span class="text-green">Conditions.</span></h1>
            <p class="lead-muted mb-3" style="max-width:600px;">Please read these terms carefully before using Merit Study Resources or subscribing to a plan.</p>
            <span class="update-chip">
                <svg viewBox="0 0 24 24" fill="none" width="14" height="14"><path d="M12 7v5l3.5 2" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.8"/></svg>
                Last updated: 1 July 2026
            </span>
        </div>
    </div>

    <section class="section-pad">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <div class="legal-sidebar">
                        <p class="fw-semibold text-uppercase small text-muted-c mb-3" style="letter-spacing:.08em;">On this page</p>
                        <a class="side-link" href="#accounts">1. Accounts &amp; eligibility</a>
                        <a class="side-link" href="#subscriptions">2. Subscriptions &amp; billing</a>
                        <a class="side-link" href="#refunds">3. Cancellations &amp; refunds</a>
                        <a class="side-link" href="#usage">4. Acceptable use</a>
                        <a class="side-link" href="#ip">5. Intellectual property</a>
                        <a class="side-link" href="#liability">6. Limitation of liability</a>
                        <a class="side-link" href="#termination">7. Termination</a>
                        <a class="side-link" href="#law">8. Governing law</a>
                        <a class="side-link" href="#contact">9. Contact us</a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="legal-content">
                        <p>These Terms &amp; Conditions govern your use of meritstudyresource.co.uk and any subscription, download or service purchased from Merit Study Resources ("we", "us", "our"). By creating an account or using the site, you agree to these terms.</p>

                        <h2 id="accounts"><span class="num-badge">01</span> Accounts &amp; eligibility</h2>
                        <p>You must provide accurate information when creating an account. If you are under 18, an account should be set up with the involvement of a parent, guardian or school. You're responsible for keeping your login details secure and for all activity under your account.</p>

                        <h2 id="subscriptions"><span class="num-badge">02</span> Subscriptions &amp; billing</h2>
                        <p>Subscription plans are billed monthly or yearly as selected at checkout. Prices are shown in GBP and include VAT where applicable. We may change subscription pricing with reasonable notice; continued use after a price change constitutes acceptance.</p>

                        <h2 id="refunds"><span class="num-badge">03</span> Cancellations &amp; refunds</h2>
                        <p>You can cancel your subscription at any time from your account settings — you'll keep access until the end of your current billing period with no further charges. We don't offer partial refunds for unused time within a billing period, except where required by law.</p>

                        <h2 id="usage"><span class="num-badge">04</span> Acceptable use</h2>
                        <ul>
                            <li>Downloaded resources are for personal, or your school's internal, educational use only</li>
                            <li>You may not resell, redistribute or publicly share past papers, worksheets or booklets</li>
                            <li>School and Premium plans permit use across the licensed number of staff seats only</li>
                            <li>You may not attempt to bypass access controls or scrape content from the site</li>
                        </ul>

                        <h2 id="ip"><span class="num-badge">05</span> Intellectual property</h2>
                        <p>All worksheets, mark schemes, booklets and site content created by Merit Study Resources are our intellectual property or that of our licensors. Past exam papers remain the property of their respective exam boards and are provided for revision purposes under fair use.</p>

                        <h2 id="liability"><span class="num-badge">06</span> Limitation of liability</h2>
                        <p>Resources are provided to support revision and are not a guarantee of exam results. To the fullest extent permitted by law, Merit Study Resources is not liable for indirect or consequential losses arising from use of the site or its materials.</p>

                        <h2 id="termination"><span class="num-badge">07</span> Termination</h2>
                        <p>We may suspend or terminate accounts that breach these terms, including unauthorised sharing of paid content. You may close your account at any time by contacting support.</p>

                        <h2 id="law"><span class="num-badge">08</span> Governing law</h2>
                        <p>These terms are governed by the laws of England and Wales, and any disputes will be subject to the exclusive jurisdiction of the courts of England and Wales.</p>

                        <h2 id="contact"><span class="num-badge">09</span> Contact us</h2>
                        <p>Questions about these Terms &amp; Conditions can be sent to <a href="mailto:info@meritstudyresource.co.uk" class="text-green fw-semibold">info@meritstudyresource.co.uk</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
