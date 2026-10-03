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
        <nav aria-label="Breadcrumb"><ol class="breadcrumb course-crumbs"><li class="breadcrumb-item"><a href="index.html">Home</a></li><li class="breadcrumb-item"><a href="faq.html">Help</a></li><li class="breadcrumb-item active" aria-current="page">FAQs</li></ol></nav>
        <p class="spec-code"><span>17</span> questions</p>
      </div>
      <p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Free resources<span class="eyebrow-sep" aria-hidden="true">/</span> No account needed</p>
      <h1 class="course-title" id="pageTitle">Frequently asked <span class="course-title-board">questions</span></h1>
      <p class="course-intro">How the site works, what we cover, and what to do when something is not right. If your question is not here, just ask us.</p>
    </div>
  </section>

  <div class="faq-search-bar">
    <div class="container">
      <form class="faq-search" role="search" onsubmit="return false">
        <label class="visually-hidden" for="faqSearch">Search the FAQs</label>
        <div class="search-shell">
          <i class="bi bi-search search-icon" aria-hidden="true"></i>
          <input type="search" class="form-control search-input" id="faqSearch"
                 placeholder="Search questions — try &quot;print&quot; or &quot;exam board&quot;">
        </div>
      </form>
      <nav aria-label="Jump to a question category">
        <ul class="jump-list list-unstyled"><li><a class="jump-chip" href="#using-the-site">Using the site <span class="jump-count">4</span></a></li><li><a class="jump-chip" href="#resources-and-exam-boards">Resources and exam boards <span class="jump-count">5</span></a></li><li><a class="jump-chip" href="#accounts">Accounts <span class="jump-count">3</span></a></li><li><a class="jump-chip" href="#downloads-and-printing">Downloads and printing <span class="jump-count">3</span></a></li><li><a class="jump-chip" href="#tutoring-and-contact">Tutoring and contact <span class="jump-count">2</span></a></li></ul>
      </nav>
    </div>
  </div>

  <div class="subject-body">
    <div class="container">

      <section class="subject-group faq-group" id="using-the-site" aria-labelledby="using-the-site-h" data-group>
        <div class="group-head">
          <h2 class="group-heading" id="using-the-site-h">Using the site</h2>
          <span class="group-count">4 questions</span>
        </div>
        <div class="accordion topic-accordion">
            <div class="accordion-item faq-item" data-keywords="is everything really free?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-1" aria-expanded="false" aria-controls="faq-1">
                  Is everything really free?
                </button>
              </h3>
              <div id="faq-1" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Yes. Every past paper, revision note, topic question, test, workbook and worked solution on this site is free to open and download. There is no paywall and no trial that expires.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="do i need an account?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-2" aria-expanded="false" aria-controls="faq-2">
                  Do I need an account?
                </button>
              </h3>
              <div id="faq-2" class="accordion-collapse collapse">
                <div class="accordion-body"><p>No. You can browse and download everything without signing up. An account only adds convenience — it remembers your course and saves resources you want to come back to.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="how do i find resources for my course?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-3" aria-expanded="false" aria-controls="faq-3">
                  How do I find resources for my course?
                </button>
              </h3>
              <div id="faq-3" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Use the finder on the <a href="index.html">homepage</a>: choose your qualification, subject and exam board, then <em>View resources</em>. Or start from the <a href="subjects.html">subjects page</a> and narrow down from there.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="can teachers use these with a class?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-4" aria-expanded="false" aria-controls="faq-4">
                  Can teachers use these with a class?
                </button>
              </h3>
              <div id="faq-4" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Yes. Teachers and tutors are welcome to print and share our own material with their students. Please leave the source on the page and do not sell it or put it behind a paywall.</p></div>
              </div>
            </div>
        </div>
      </section>
      <section class="subject-group faq-group" id="resources-and-exam-boards" aria-labelledby="resources-and-exam-boards-h" data-group>
        <div class="group-head">
          <h2 class="group-heading" id="resources-and-exam-boards-h">Resources and exam boards</h2>
          <span class="group-count">5 questions</span>
        </div>
        <div class="accordion topic-accordion">
            <div class="accordion-item faq-item" data-keywords="which exam boards do you cover?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-5" aria-expanded="false" aria-controls="faq-5">
                  Which exam boards do you cover?
                </button>
              </h3>
              <div id="faq-5" class="accordion-collapse collapse">
                <div class="accordion-body"><p>AQA, Pearson Edexcel, OCR, Cambridge (CIE), WJEC/Eduqas and others depending on the subject. The exam board is shown on every resource, so check it matches what your school entered you for.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="are you connected to the exam boards?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-6" aria-expanded="false" aria-controls="faq-6">
                  Are you connected to the exam boards?
                </button>
              </h3>
              <div id="faq-6" class="accordion-collapse collapse">
                <div class="accordion-body"><p>No. We are independent. Past papers and mark schemes remain the copyright of the awarding body and we provide them for study only. Always check the board's own specification as the definitive source.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="how current is the material?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-7" aria-expanded="false" aria-controls="faq-7">
                  How current is the material?
                </button>
              </h3>
              <div id="faq-7" class="accordion-collapse collapse">
                <div class="accordion-body"><p>We work from the current specification for each subject and add new papers after each exam series. Where a specification has changed, older papers are labelled so you know what still applies.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="i found a mistake — what should i do?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-8" aria-expanded="false" aria-controls="faq-8">
                  I found a mistake — what should I do?
                </button>
              </h3>
              <div id="faq-8" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Please tell us. Use the <a href="contact.html">contact form</a> with the resource name and the question number, and we will check and correct it.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="can you add my subject?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-9" aria-expanded="false" aria-controls="faq-9">
                  Can you add my subject?
                </button>
              </h3>
              <div id="faq-9" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Probably. Send a request through the <a href="subjects.html">subjects page</a> and we will prioritise what people ask for most.</p></div>
              </div>
            </div>
        </div>
      </section>
      <section class="subject-group faq-group" id="accounts" aria-labelledby="accounts-h" data-group>
        <div class="group-head">
          <h2 class="group-heading" id="accounts-h">Accounts</h2>
          <span class="group-count">3 questions</span>
        </div>
        <div class="accordion topic-accordion">
            <div class="accordion-item faq-item" data-keywords="how do i create an account?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-10" aria-expanded="false" aria-controls="faq-10">
                  How do I create an account?
                </button>
              </h3>
              <div id="faq-10" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Go to <a href="register.html">register</a> and give a name, email and password. That is all we ask for.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="i have forgotten my password.">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-11" aria-expanded="false" aria-controls="faq-11">
                  I have forgotten my password.
                </button>
              </h3>
              <div id="faq-11" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Use the <em>Forgot password</em> link on the <a href="login.html">sign-in page</a> and we will email you a reset link.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="how do i delete my account?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-12" aria-expanded="false" aria-controls="faq-12">
                  How do I delete my account?
                </button>
              </h3>
              <div id="faq-12" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Email us and we will delete it and the data attached to it. See the <a href="privacy.html">privacy policy</a> for what we hold and for how long.</p></div>
              </div>
            </div>
        </div>
      </section>
      <section class="subject-group faq-group" id="downloads-and-printing" aria-labelledby="downloads-and-printing-h" data-group>
        <div class="group-head">
          <h2 class="group-heading" id="downloads-and-printing-h">Downloads and printing</h2>
          <span class="group-count">3 questions</span>
        </div>
        <div class="accordion topic-accordion">
            <div class="accordion-item faq-item" data-keywords="what format are the files in?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-13" aria-expanded="false" aria-controls="faq-13">
                  What format are the files in?
                </button>
              </h3>
              <div id="faq-13" class="accordion-collapse collapse">
                <div class="accordion-body"><p>PDF, so they open on any device and print the same way everywhere.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="a file will not open.">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-14" aria-expanded="false" aria-controls="faq-14">
                  A file will not open.
                </button>
              </h3>
              <div id="faq-14" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Try downloading it rather than viewing it in the browser, and make sure your PDF reader is up to date. If it still fails, tell us which file and we will re-upload it.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="can i print the workbooks?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-15" aria-expanded="false" aria-controls="faq-15">
                  Can I print the workbooks?
                </button>
              </h3>
              <div id="faq-15" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Yes. They are designed to print double-sided on A4, with space to write.</p></div>
              </div>
            </div>
        </div>
      </section>
      <section class="subject-group faq-group" id="tutoring-and-contact" aria-labelledby="tutoring-and-contact-h" data-group>
        <div class="group-head">
          <h2 class="group-heading" id="tutoring-and-contact-h">Tutoring and contact</h2>
          <span class="group-count">2 questions</span>
        </div>
        <div class="accordion topic-accordion">
            <div class="accordion-item faq-item" data-keywords="do you offer tutoring as well?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-16" aria-expanded="false" aria-controls="faq-16">
                  Do you offer tutoring as well?
                </button>
              </h3>
              <div id="faq-16" class="accordion-collapse collapse">
                <div class="accordion-body"><p>This site is the free resource library. For tuition, use the <a href="contact.html">contact form</a> and we will point you in the right direction.</p></div>
              </div>
            </div>
            <div class="accordion-item faq-item" data-keywords="how quickly do you reply?">
              <h3 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq-17" aria-expanded="false" aria-controls="faq-17">
                  How quickly do you reply?
                </button>
              </h3>
              <div id="faq-17" class="accordion-collapse collapse">
                <div class="accordion-body"><p>Within two working days for most messages. Corrections to resources are usually faster.</p></div>
              </div>
            </div>
        </div>
      </section>

      <p class="empty-state" id="faqEmpty" role="status" aria-live="polite" hidden>
        <i class="bi bi-search" aria-hidden="true"></i>
        Nothing matches that. Try a shorter word, or <a href="contact.html">ask us directly</a>.
      </p>

      <section class="request-panel" aria-labelledby="stillHeading">
        <div>
          <h2 class="request-heading" id="stillHeading">Still stuck?</h2>
          <p class="request-text">Send us the details and we will get back to you within two working days.</p>
        </div>
        <a class="btn btn-merit" href="{{ url('/contact') }}">Contact us <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
      </section>

    </div>
  </div>
</main>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const catButtons = document.querySelectorAll('.faq-cat-btn');
            const faqInput = document.getElementById('faqSearchInput');
            const items = document.querySelectorAll('#faqAccordion .accordion-item');
            const noResults = document.getElementById('faqNoResults');

            let activeCategory = 'all';

            function applyFilters() {
                const searchTerm = faqInput.value.trim().toLowerCase();
                let visibleCount = 0;

                items.forEach(item => {
                    const itemCat = (item.dataset.cat || '').trim();
                    const itemText = item.textContent.toLowerCase();

                    // Check Category Match
                    const matchesCategory = (activeCategory === 'all' || itemCat === activeCategory);

                    // Check Search Query Match
                    const matchesSearch = (searchTerm === '' || itemText.includes(searchTerm));

                    if (matchesCategory && matchesSearch) {
                        item.style.display = '';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                        // Auto-collapse hidden items so open states don't conflict
                        const collapseEl = item.querySelector('.accordion-collapse');
                        if (collapseEl && collapseEl.classList.contains('show')) {
                            bootstrap.Collapse.getInstance(collapseEl)?.hide();
                        }
                    }
                });

                // Toggle "No Results" notice
                noResults.classList.toggle('d-none', visibleCount !== 0);
            }

            // Tab button click listener
            catButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    catButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    activeCategory = btn.dataset.cat;
                    applyFilters();
                });
            });

            // Search input listener
            faqInput.addEventListener('input', applyFilters);

            // Run initial filter on load
            applyFilters();
        });
    </script>
@endpush
