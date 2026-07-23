@extends('layouts.frontend-2', ['main_title' => $defaultSEO->meta_title ?? 'Privacy Policies - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')

    <header class="page-banner">
        <div class="container">
            <div class="breadcrumb-msr mb-3"><a href="index.html">Home</a> &nbsp;/&nbsp; Privacy Policy</div>
            <span class="eyebrow"><span class="divider-dot"></span> LEGAL</span>
            <h1 class="mt-4 mb-3">Privacy <span class="text-green">Policy.</span></h1>
            <p class="lead-muted mb-3" style="max-width:600px;">How Merit Study Resources collects, uses and protects your personal information.</p>
            <span class="update-chip">
                <svg viewBox="0 0 24 24" fill="none" width="14" height="14"><path d="M12 7v5l3.5 2" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.8"/></svg>
                Last updated: 1 July 2026
            </span>
        </div>
    </header>

    <!-- ============================= LEGAL CONTENT ============================= -->
    <section class="section-pad">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <div class="legal-sidebar">
                        <p class="fw-semibold text-uppercase small text-muted-c mb-3" style="letter-spacing:.08em;">On this page</p>
                        <a class="side-link" href="#collect">1. Information we collect</a>
                        <a class="side-link" href="#use">2. How we use your data</a>
                        <a class="side-link" href="#sharing">3. Sharing &amp; disclosure</a>
                        <a class="side-link" href="#cookies">4. Cookies &amp; tracking</a>
                        <a class="side-link" href="#security">5. Data security</a>
                        <a class="side-link" href="#rights">6. Your rights</a>
                        <a class="side-link" href="#children">7. Children's privacy</a>
                        <a class="side-link" href="#changes">8. Changes to this policy</a>
                        <a class="side-link" href="#contact">9. Contact us</a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="legal-content">
                        <p>Merit Study Resources ("we", "us", "our") provides past papers, worksheets and revision resources to students, parents, tutors and schools across the UK. This Privacy Policy explains what personal data we collect through meritstudyresource.co.uk, why we collect it, and the choices you have.</p>

                        <h2 id="collect"><span class="num-badge">01</span> Information we collect</h2>
                        <p>We collect information you give us directly, such as your name, email address and payment details when you register for an account or subscribe to a plan. We also collect information automatically, including your IP address, browser type, device information and pages visited, through cookies and similar technologies.</p>
                        <ul>
                            <li>Account details: name, email, school or year group (optional)</li>
                            <li>Billing details: processed securely by our payment provider — we never store full card numbers</li>
                            <li>Usage data: pages viewed, downloads, time on site</li>
                            <li>Support communications: messages sent through our contact form or email</li>
                        </ul>

                        <h2 id="use"><span class="num-badge">02</span> How we use your data</h2>
                        <p>We use your information to provide and improve our services, process subscriptions and payments, respond to support requests, send account and billing notifications, and — where you've opted in — send updates about new resources and offers. We may also use aggregated, anonymised usage data to understand which resources are most helpful.</p>

                        <h2 id="sharing"><span class="num-badge">03</span> Sharing &amp; disclosure</h2>
                        <p>We do not sell your personal data. We share information only with trusted service providers who help us run the site — such as payment processors and email delivery services — under agreements that require them to protect your data, or where required by law.</p>

                        <h2 id="cookies"><span class="num-badge">04</span> Cookies &amp; tracking</h2>
                        <p>We use essential cookies to keep you logged in and remember your preferences, and analytics cookies to understand how the site is used. You can control or disable non-essential cookies through your browser settings at any time.</p>

                        <h2 id="security"><span class="num-badge">05</span> Data security</h2>
                        <p>We use industry-standard safeguards, including encryption in transit, to protect your data against unauthorised access, alteration or loss. No method of transmission over the internet is completely secure, so we cannot guarantee absolute security.</p>

                        <h2 id="rights"><span class="num-badge">06</span> Your rights</h2>
                        <p>Under UK GDPR, you have the right to access, correct, or delete your personal data, object to or restrict certain processing, and request a copy of your data in a portable format. To exercise any of these rights, contact us using the details below.</p>

                        <h2 id="children"><span class="num-badge">07</span> Children's privacy</h2>
                        <p>Many of our users are students under 18. Where a user is under 13, an account may only be created by a parent, guardian or school on their behalf. We collect only the information necessary to provide our educational resources.</p>

                        <h2 id="changes"><span class="num-badge">08</span> Changes to this policy</h2>
                        <p>We may update this Privacy Policy from time to time. Material changes will be notified via email or a notice on our site, and the "last updated" date at the top of this page will reflect the most recent revision.</p>

                        <h2 id="contact"><span class="num-badge">09</span> Contact us</h2>
                        <p>If you have questions about this Privacy Policy or how we handle your data, email us at <a href="mailto:info@meritstudyresource.co.uk" class="text-green fw-semibold">info@meritstudyresource.co.uk</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
