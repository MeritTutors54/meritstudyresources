@extends('layouts.frontend-3')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@section('content')

  <section class="course-header" aria-labelledby="pageTitle">
    <div class="container">
      <div class="course-header-top">
        <nav aria-label="Breadcrumb"><ol class="breadcrumb course-crumbs"><li class="breadcrumb-item"><a href="index.html">Home</a></li><li class="breadcrumb-item active" aria-current="page">Terms and conditions</li></ol></nav>
        <p class="spec-code">Last updated <span>1 September 2026</span></p>
      </div>
      <p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Free resources<span class="eyebrow-sep" aria-hidden="true">/</span> No account needed</p>
      <h1 class="course-title" id="pageTitle">Terms and conditions</h1>
      <p class="course-intro">These terms cover your use of Merit Study Resources. By using the site you accept them.</p>
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
                <li><a href="#about-us">About us</a></li>
                <li><a href="#using-the-site">Using the site</a></li>
                <li><a href="#our-resources-and-your-licence">Our resources and your licence</a></li>
                <li><a href="#exam-board-material">Exam board material</a></li>
                <li><a href="#accounts">Accounts</a></li>
                <li><a href="#acceptable-use">Acceptable use</a></li>
                <li><a href="#accuracy-and-results">Accuracy and results</a></li>
                <li><a href="#links-to-other-sites">Links to other sites</a></li>
                <li><a href="#availability">Availability</a></li>
                <li><a href="#our-liability">Our liability</a></li>
                <li><a href="#changes-and-governing-law">Changes and governing law</a></li>
              </ul>
            </nav>
            <div class="aside-card">
              <h2 class="aside-title">Other policies</h2>
              <ul class="aside-links list-unstyled"><li><a href="privacy.html">Privacy policy</a></li><li><a href="refund.html">Refund policy</a></li><li><a href="cookies.html">Cookie policy</a></li></ul>
            </div>
          </aside>
        </div>

        <div class="col-lg-8 order-lg-1">
          <div class="prose policy-prose">
          <section class="policy-section" id="about-us" aria-labelledby="about-us-h">
            <h2 id="about-us-h">About us</h2>
            <p>Merit Study Resources is operated by [Registered company name] (company number [Company number]). You can reach us at hello@meritstudyresources.co.uk.</p>
          </section>
          <section class="policy-section" id="using-the-site" aria-labelledby="using-the-site-h">
            <h2 id="using-the-site-h">Using the site</h2>
            <p>The site is free to use and no account is needed to open resources. You may use the material for your own study, or — if you are a teacher — with your own students.</p>
          </section>
          <section class="policy-section" id="our-resources-and-your-licence" aria-labelledby="our-resources-and-your-licence-h">
            <h2 id="our-resources-and-your-licence-h">Our resources and your licence</h2>
            <p>Revision notes, topic questions, tests, workbooks and worked solutions written by us are our copyright. You may download, print and share them for non-commercial educational use, with the source left intact.</p>
            <ul>
              <li>You may not sell our material, or include it in a paid product or service.</li>
              <li>You may not republish it on another website or app, in whole or in part.</li>
              <li>You may not remove attribution or present our work as your own.</li>
            </ul>
          </section>
          <section class="policy-section" id="exam-board-material" aria-labelledby="exam-board-material-h">
            <h2 id="exam-board-material-h">Exam board material</h2>
            <p>Past papers and mark schemes are the copyright of the relevant awarding body — AQA, Pearson Edexcel, OCR, Cambridge, WJEC/Eduqas and others. We link to or host them for study purposes only. We are not affiliated with, endorsed by, or connected to any awarding body.</p>
            <p>If you are a rights holder and want material removed, email hello@meritstudyresources.co.uk and we will act promptly.</p>
          </section>
          <section class="policy-section" id="accounts" aria-labelledby="accounts-h">
            <h2 id="accounts-h">Accounts</h2>
            <p>You are responsible for keeping your password safe and for activity on your account. Tell us straight away if you think someone else is using it. We may suspend an account that is used to break these terms.</p>
          </section>
          <section class="policy-section" id="acceptable-use" aria-labelledby="acceptable-use-h">
            <h2 id="acceptable-use-h">Acceptable use</h2>
            <ul>
              <li>Do not attempt to disrupt the site, bypass security, or scrape it at scale.</li>
              <li>Do not upload anything unlawful, offensive, or infringing.</li>
              <li>Do not use the site to impersonate anyone or misrepresent your connection to us.</li>
            </ul>
          </section>
          <section class="policy-section" id="accuracy-and-results" aria-labelledby="accuracy-and-results-h">
            <h2 id="accuracy-and-results-h">Accuracy and results</h2>
            <p>We check our material carefully, but we cannot guarantee it is free of errors, complete, or fully current with a specification. Always check the awarding body's own specification and assessment materials. Using this site does not guarantee any particular grade or outcome.</p>
            <p>If you spot a mistake, please tell us at hello@meritstudyresources.co.uk — corrections help everyone.</p>
          </section>
          <section class="policy-section" id="links-to-other-sites" aria-labelledby="links-to-other-sites-h">
            <h2 id="links-to-other-sites-h">Links to other sites</h2>
            <p>Where we link elsewhere, we do not control that site and are not responsible for its content.</p>
          </section>
          <section class="policy-section" id="availability" aria-labelledby="availability-h">
            <h2 id="availability-h">Availability</h2>
            <p>We aim to keep the site available but may suspend it for maintenance or for reasons outside our control, without notice.</p>
          </section>
          <section class="policy-section" id="our-liability" aria-labelledby="our-liability-h">
            <h2 id="our-liability-h">Our liability</h2>
            <p>Nothing in these terms limits liability for death or personal injury caused by negligence, for fraud, or anything else that cannot be limited by law. Otherwise, to the extent permitted by law, we are not liable for indirect or consequential loss, lost data, or loss arising from reliance on the material on this site.</p>
          </section>
          <section class="policy-section" id="changes-and-governing-law" aria-labelledby="changes-and-governing-law-h">
            <h2 id="changes-and-governing-law-h">Changes and governing law</h2>
            <p>We may update these terms; the version above is dated 1 September 2026. These terms are governed by the law of England and Wales, and the courts of England and Wales have exclusive jurisdiction.</p>
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

@endsection
