@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Privacy Policies - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
  <section class="course-header" aria-labelledby="pageTitle">
    <div class="container">
      <div class="course-header-top">
        <nav aria-label="Breadcrumb"><ol class="breadcrumb course-crumbs"><li class="breadcrumb-item"><a href="index.html">Home</a></li><li class="breadcrumb-item active" aria-current="page">Cookie policy</li></ol></nav>
        <p class="spec-code">Last updated <span>1 September 2026</span></p>
      </div>
      <p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Free resources<span class="eyebrow-sep" aria-hidden="true">/</span> No account needed</p>
      <h1 class="course-title" id="pageTitle">Cookie policy</h1>
      <p class="course-intro">Cookies are small files a site stores on your device. Here is what we use and how to turn the optional ones off.</p>
    </div>
  </section>

  <div class="policy-body">
    <div class="container">
      <div class="row g-4 g-xl-5">

        <div class="col-lg-4 order-lg-2">
          <aside class="post-aside">
            <nav class="toc" aria-label="On this page">
              <h2 class="toc-heading">On this page</h2>
              <ul class="toc-list list-unstyled">
                <li><a href="#why-we-use-cookies">Why we use cookies</a></li>
                <li><a href="#what-we-set">What we set</a></li>
                <li><a href="#managing-your-choice">Managing your choice</a></li>
                <li><a href="#browser-controls">Browser controls</a></li>
                <li><a href="#third-parties">Third parties</a></li>
                <li><a href="#changes">Changes</a></li>
              </ul>
            </nav>
            <div class="aside-card">
              <h2 class="aside-title">Other policies</h2>
              <ul class="aside-links list-unstyled"><li><a href="privacy.html">Privacy policy</a></li><li><a href="terms.html">Terms and conditions</a></li><li><a href="refund.html">Refund policy</a></li></ul>
            </div>
          </aside>
        </div>

        <div class="col-lg-8 order-lg-1">
          <div class="prose policy-prose">
          <section class="policy-section" id="why-we-use-cookies" aria-labelledby="why-we-use-cookies-h">
            <h2 id="why-we-use-cookies-h">Why we use cookies</h2>
            <p>We keep cookies to a minimum: enough to remember your course selection and to understand which resources are being used. We do not use advertising cookies and we do not sell data to advertisers.</p>
          </section>
          <section class="policy-section" id="what-we-set" aria-labelledby="what-we-set-h">
            <h2 id="what-we-set-h">What we set</h2>
            <div class="table-wrap">
              <table class="policy-table">
                <thead><tr><th scope="col">Cookie</th><th scope="col">Type</th><th scope="col">Purpose</th><th scope="col">Expires</th></tr></thead>
                <tbody>
                <tr><td>msr_consent</td><td>Essential</td><td>Remembers your cookie choice</td><td>12 months</td></tr>
                <tr><td>msr_course</td><td>Preferences</td><td>Remembers your qualification, subject and exam board</td><td>6 months</td></tr>
                <tr><td>msr_session</td><td>Essential</td><td>Keeps you signed in during a visit</td><td>When you close the browser</td></tr>
                <tr><td>_ga / _ga_*</td><td>Analytics</td><td>Counts visits and pages viewed (Google Analytics)</td><td>Up to 24 months</td></tr>
                </tbody>
              </table>
            </div>
            <p>Analytics cookies are only set if you accept them.</p>
          </section>
          <section class="policy-section" id="managing-your-choice" aria-labelledby="managing-your-choice-h">
            <h2 id="managing-your-choice-h">Managing your choice</h2>
            <p>Use the cookie banner to accept or reject optional cookies. You can change your mind at any time by clearing this site's data in your browser, which brings the banner back.</p>
          </section>
          <section class="policy-section" id="browser-controls" aria-labelledby="browser-controls-h">
            <h2 id="browser-controls-h">Browser controls</h2>
            <p>Every major browser lets you block or delete cookies in its settings — usually under Privacy or Site settings. Blocking essential cookies may stop parts of the site working, such as staying signed in.</p>
          </section>
          <section class="policy-section" id="third-parties" aria-labelledby="third-parties-h">
            <h2 id="third-parties-h">Third parties</h2>
            <p>Embedded content — for example a video — may set its own cookies. Those are controlled by the provider, and their own policies apply.</p>
          </section>
          <section class="policy-section" id="changes" aria-labelledby="changes-h">
            <h2 id="changes-h">Changes</h2>
            <p>This policy was last updated on 1 September 2026. We will update it if the cookies we use change. See also our <a href="privacy.html">privacy policy</a>.</p>
          </section>
          </div>

          <div class="policy-contact">
            <p><strong>Questions about this page?</strong> Email
              <a href="mailto:hello@meritstudyresources.co.uk">hello@meritstudyresources.co.uk</a> or use the
              <a href="contact.html">contact form</a>.</p>
          </div>
        </div>

      </div>
    </div>
  </div>



    @include('frontend.home.testimonial')
    @include('frontend.home.subscription')
@endsection
