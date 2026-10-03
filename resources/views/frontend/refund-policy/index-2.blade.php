@extends('layouts.frontend-3')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])
@section('content')
  <main id="main">
  <section class="course-header" aria-labelledby="pageTitle">
    <div class="container">
      <div class="course-header-top">
        <nav aria-label="Breadcrumb"><ol class="breadcrumb course-crumbs"><li class="breadcrumb-item"><a href="index.html">Home</a></li><li class="breadcrumb-item active" aria-current="page">Refund policy</li></ol></nav>
        <p class="spec-code">Last updated <span>1 September 2026</span></p>
      </div>
      <p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Free resources<span class="eyebrow-sep" aria-hidden="true">/</span> No account needed</p>
      <h1 class="course-title" id="pageTitle">Refund policy</h1>
      <p class="course-intro">Almost everything here is free. This policy covers the few things that are paid — printed workbooks and any paid digital download.</p>
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
                <li><a href="#free-resources">Free resources</a></li>
                <li><a href="#printed-workbooks">Printed workbooks</a></li>
                <li><a href="#faulty-damaged-or-wrong-items">Faulty, damaged or wrong items</a></li>
                <li><a href="#paid-digital-downloads">Paid digital downloads</a></li>
                <li><a href="#books-bought-on-amazon">Books bought on Amazon</a></li>
                <li><a href="#how-to-request-a-refund">How to request a refund</a></li>
                <li><a href="#questions">Questions</a></li>
              </ul>
            </nav>
            <div class="aside-card">
              <h2 class="aside-title">Other policies</h2>
              <ul class="aside-links list-unstyled"><li><a href="privacy.html">Privacy policy</a></li><li><a href="terms.html">Terms and conditions</a></li><li><a href="cookies.html">Cookie policy</a></li></ul>
            </div>
          </aside>
        </div>

        <div class="col-lg-8 order-lg-1">
          <div class="prose policy-prose">
          <section class="policy-section" id="free-resources" aria-labelledby="free-resources-h">
            <h2 id="free-resources-h">Free resources</h2>
            <p>Past papers, revision notes, topic questions, tests and worked solutions on this site are free. There is nothing to refund, and we will never ask for card details to open them.</p>
          </section>
          <section class="policy-section" id="printed-workbooks" aria-labelledby="printed-workbooks-h">
            <h2 id="printed-workbooks-h">Printed workbooks</h2>
            <p>Where you buy a printed workbook directly from us, you have 14 days from delivery to change your mind, and a further 14 days to return the item. It should be unused and in resaleable condition. We refund the purchase price and standard outbound delivery within 14 days of receiving the return.</p>
            <p>Return postage is yours to pay unless the item is faulty, damaged or not what you ordered.</p>
          </section>
          <section class="policy-section" id="faulty-damaged-or-wrong-items" aria-labelledby="faulty-damaged-or-wrong-items-h">
            <h2 id="faulty-damaged-or-wrong-items-h">Faulty, damaged or wrong items</h2>
            <p>Email hello@meritstudyresources.co.uk within 30 days with your order number and a photo. We will replace the item or refund it in full, including postage both ways. This does not affect your statutory rights under the Consumer Rights Act 2015.</p>
          </section>
          <section class="policy-section" id="paid-digital-downloads" aria-labelledby="paid-digital-downloads-h">
            <h2 id="paid-digital-downloads-h">Paid digital downloads</h2>
            <p>For a paid download, you agree that access begins immediately and the 14-day cancellation right ends once the file is downloaded. If a file is corrupt, will not open, or is not what was described, we will fix it or refund it.</p>
          </section>
          <section class="policy-section" id="books-bought-on-amazon" aria-labelledby="books-bought-on-amazon-h">
            <h2 id="books-bought-on-amazon-h">Books bought on Amazon</h2>
            <p>Workbooks bought through Amazon are sold by Amazon, so their returns process applies — start a return in <em>Your Orders</em>. We cannot refund an Amazon purchase directly, but tell us if something is wrong with the book itself so we can correct it.</p>
          </section>
          <section class="policy-section" id="how-to-request-a-refund" aria-labelledby="how-to-request-a-refund-h">
            <h2 id="how-to-request-a-refund-h">How to request a refund</h2>
            <ul>
              <li>Email hello@meritstudyresources.co.uk with your order number and what went wrong.</li>
              <li>We reply within 2 working days.</li>
              <li>Approved refunds go back to the original payment method within 14 days.</li>
            </ul>
          </section>
          <section class="policy-section" id="questions" aria-labelledby="questions-h">
            <h2 id="questions-h">Questions</h2>
            <p>Anything not covered here, ask us at hello@meritstudyresources.co.uk and we will sort it out.</p>
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
</main> 
@endsection
