@extends('layouts.frontend-3')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@section('content')
  <link href="{{ asset('frontend/new/css/bookshop.css') }}" rel="stylesheet">
  <main id="main">

    <!-- ===== Hero ======================================================= -->
    <section class="shop-hero" aria-labelledby="shopTitle">
      <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb course-crumbs">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bookshop</li>
          </ol>
        </nav>

        <div class="row align-items-center g-4">
          <div class="col-lg-7">
            <p class="script-eyebrow">Every book comes with free answers &amp; tests</p>
            <h1 class="shop-title" id="shopTitle">Merit Tutors <span class="shop-title-accent">Bookshop</span></h1>
            <p class="shop-lead">Workbooks written by our tutors, from Year 1 to GCSE and A Level. Buy the book on Amazon, then download the answer book, the tests and the test answers here — free with every book.</p>
            <ul class="list-unstyled shop-checks">
              <li><span class="check-dot"><i class="bi bi-check-lg"></i></span>Free downloads with every book</li>
              <li><span class="check-dot"><i class="bi bi-check-lg"></i></span>Follows the England curriculum</li>
              <li><span class="check-dot"><i class="bi bi-check-lg"></i></span>Year 1 to A Level</li>
            </ul>
          </div>

          {{-- <div class="col-lg-5 col-xl-4 offset-xl-1">
            <form class="qr-card" action="/bookshop/find" method="get" role="search">
              <div class="qr-card-head">
                <span class="qr-icon"><i class="bi bi-qr-code-scan"></i></span>
                <div>
                  <h2 class="qr-title">Scanned the QR code in your book?</h2>
                  <p class="qr-text">Find your book below, or search by its title or code.</p>
                </div>
              </div>
              <label class="visually-hidden" for="bookLookup">Book title or code</label>
              <div class="search-shell">
                <i class="bi bi-search search-icon"></i>
                <input class="form-control search-input" id="bookLookup" name="q" type="search" placeholder="e.g. Year 1 Book 2 or MT-Y1-B2" autocomplete="off">
              </div>
              <button class="btn btn-merit qr-submit" type="submit">Find my downloads</button>
              <p class="qr-note">The code is printed under the QR code inside the front cover.</p>
            </form>
          </div> --}}
        </div>
      </div>
    </section>

    <!-- ===== Subject / year selector =================================== -->
    <section class="shop-selector" aria-label="Choose subject and year">
      <div class="container">
        <div class="selector-row">
          {{-- <p class="selector-label" id="subjectLabel">Subject</p> --}}
          {{-- <div class="selector-pills" role="group" aria-labelledby="subjectLabel">
            <button class="select-pill" type="button" aria-pressed="true">Mathematics</button>
            <span class="selector-hint">More subjects coming soon</span>
          </div> --}}
        </div>
        <div class="selector-row">
          <p class="selector-label" id="yearLabel">Year</p>
          <div class="selector-pills" role="group" aria-labelledby="yearLabel" data-year-pills>
            <button class="select-pill" type="button" aria-pressed="true" data-year="Year 1">Year 1</button>
            <button class="select-pill" type="button" aria-pressed="false" data-year="Year 2">Year 2</button>
            <button class="select-pill" type="button" aria-pressed="false" data-year="Year 3">Year 3</button>
            <button class="select-pill" type="button" aria-pressed="false" data-year="Year 4">Year 4</button>
            <button class="select-pill" type="button" aria-pressed="false" data-year="Year 5">Year 5</button>
            <button class="select-pill" type="button" aria-pressed="false" data-year="Year 6">Year 6</button>
            <button class="select-pill" type="button" aria-pressed="false" data-year="Year 7">Year 7</button>
            <button class="select-pill" type="button" aria-pressed="false" data-year="Year 8">Year 8</button>
            <button class="select-pill" type="button" aria-pressed="false" data-year="Year 9">Year 9</button>
            <button class="select-pill" type="button" aria-pressed="false" data-year="GCSE">GCSE</button>
            <button class="select-pill" type="button" aria-pressed="false" data-year="A Level">A Level</button>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== Books ====================================================== -->
    <section class="shop-books" aria-labelledby="booksTitle">
      <div class="container">
        <div class="books-head">
          <div>
            <h2 class="books-title" id="booksTitle"><span data-year-label>Year 1</span> Mathematics</h2>
            <p class="books-sub">Four books that cover the whole <span data-year-label>Year 1</span> curriculum, in order.</p>
          </div>
          <span class="books-badge"><i class="bi bi-download"></i>Answers and tests are PDFs — free with the book</span>
        </div>

        <div class="row g-3">

          <!-- Book 1 -->
          <div class="col-sm-6 col-lg-3">
            <article class="book-card ink-green">
              <div class="book-cover-wrap">
                <div class="book-cover cover-green" aria-hidden="true">
                  <span class="cover-brand">Merit Tutors</span>
                  <span class="cover-series">Year 1 Mathematics</span>
                  <span class="cover-title">Build Confidence</span>
                  <span class="cover-num">Book 1</span>
                </div>
              </div>
              <div class="book-body">
                <p class="book-eyebrow">Book 1 of 4</p>
                <h3 class="book-title">Build Confidence</h3>
                <p class="book-meta">Year 1 Mathematics · A4 · approx. 150 pages</p>
                <p class="book-desc">The first of the four books. Learn &amp; Try pages introduce each skill before short Practise &amp; Apply sets.</p>
                <ul class="list-unstyled book-includes" aria-label="Free with this book">
                  <li class="include-chip"><i class="bi bi-check-lg"></i>Answer book</li>
                  <li class="include-chip"><i class="bi bi-check-lg"></i>5 tests</li>
                  <li class="include-chip"><i class="bi bi-check-lg"></i>Test answers</li>
                </ul>
                <div class="book-actions">
                  <a class="btn btn-merit" href="#" target="_blank" rel="noopener">Buy on Amazon <i class="bi bi-box-arrow-up-right"></i><span class="visually-hidden"> (opens in a new tab)</span></a>
                  <button class="btn btn-downloads" type="button" data-bs-toggle="collapse" data-bs-target="#dl-y1b1" aria-expanded="false" aria-controls="dl-y1b1">Downloads <i class="bi bi-chevron-down"></i></button>
                  <div class="collapse" id="dl-y1b1">
                    <ul class="list-unstyled download-list">
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Answer book<span class="dl-size">PDF</span></a></li>
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Tests 1–5<span class="dl-size">PDF</span></a></li>
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Test answers<span class="dl-size">PDF</span></a></li>
                    </ul>
                  </div>
                  <button class="btn btn-basket" type="button" disabled><i class="bi bi-bag"></i>Basket<span class="soon-badge">SOON</span></button>
                </div>
              </div>
            </article>
          </div>

          <!-- Book 2 -->
          <div class="col-sm-6 col-lg-3">
            <article class="book-card ink-blue">
              <div class="book-cover-wrap">
                <div class="book-cover cover-blue" aria-hidden="true">
                  <span class="cover-brand">Merit Tutors</span>
                  <span class="cover-series">Year 1 Mathematics</span>
                  <span class="cover-title">Strengthen Skills</span>
                  <span class="cover-num">Book 2</span>
                </div>
              </div>
              <div class="book-body">
                <p class="book-eyebrow">Book 2 of 4</p>
                <h3 class="book-title">Strengthen Skills</h3>
                <p class="book-meta">Year 1 Mathematics · A4 · approx. 150 pages</p>
                <p class="book-desc">Fuller practice on every topic, building fluency across the whole year.</p>
                <ul class="list-unstyled book-includes" aria-label="Free with this book">
                  <li class="include-chip"><i class="bi bi-check-lg"></i>Answer book</li>
                  <li class="include-chip"><i class="bi bi-check-lg"></i>5 tests</li>
                  <li class="include-chip"><i class="bi bi-check-lg"></i>Test answers</li>
                </ul>
                <div class="book-actions">
                  <a class="btn btn-merit" href="#" target="_blank" rel="noopener">Buy on Amazon <i class="bi bi-box-arrow-up-right"></i><span class="visually-hidden"> (opens in a new tab)</span></a>
                  <button class="btn btn-downloads" type="button" data-bs-toggle="collapse" data-bs-target="#dl-y1b2" aria-expanded="false" aria-controls="dl-y1b2">Downloads <i class="bi bi-chevron-down"></i></button>
                  <div class="collapse" id="dl-y1b2">
                    <ul class="list-unstyled download-list">
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Answer book<span class="dl-size">PDF</span></a></li>
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Tests 1–5<span class="dl-size">PDF</span></a></li>
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Test answers<span class="dl-size">PDF</span></a></li>
                    </ul>
                  </div>
                  <button class="btn btn-basket" type="button" disabled><i class="bi bi-bag"></i>Basket<span class="soon-badge">SOON</span></button>
                </div>
              </div>
            </article>
          </div>

          <!-- Book 3 -->
          <div class="col-sm-6 col-lg-3">
            <article class="book-card ink-orange">
              <div class="book-cover-wrap">
                <div class="book-cover cover-orange" aria-hidden="true">
                  <span class="cover-brand">Merit Tutors</span>
                  <span class="cover-series">Year 1 Mathematics</span>
                  <span class="cover-title">Apply Your Skills</span>
                  <span class="cover-num">Book 3</span>
                </div>
              </div>
              <div class="book-body">
                <p class="book-eyebrow">Book 3 of 4</p>
                <h3 class="book-title">Apply Your Skills</h3>
                <p class="book-meta">Year 1 Mathematics · A4 · approx. 150 pages</p>
                <p class="book-desc">Puts the skills to work in word problems and mixed practice.</p>
                <ul class="list-unstyled book-includes" aria-label="Free with this book">
                  <li class="include-chip"><i class="bi bi-check-lg"></i>Answer book</li>
                  <li class="include-chip"><i class="bi bi-check-lg"></i>5 tests</li>
                  <li class="include-chip"><i class="bi bi-check-lg"></i>Test answers</li>
                </ul>
                <div class="book-actions">
                  <a class="btn btn-merit" href="#" target="_blank" rel="noopener">Buy on Amazon <i class="bi bi-box-arrow-up-right"></i><span class="visually-hidden"> (opens in a new tab)</span></a>
                  <button class="btn btn-downloads" type="button" data-bs-toggle="collapse" data-bs-target="#dl-y1b3" aria-expanded="false" aria-controls="dl-y1b3">Downloads <i class="bi bi-chevron-down"></i></button>
                  <div class="collapse" id="dl-y1b3">
                    <ul class="list-unstyled download-list">
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Answer book<span class="dl-size">PDF</span></a></li>
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Tests 1–5<span class="dl-size">PDF</span></a></li>
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Test answers<span class="dl-size">PDF</span></a></li>
                    </ul>
                  </div>
                  <button class="btn btn-basket" type="button" disabled><i class="bi bi-bag"></i>Basket<span class="soon-badge">SOON</span></button>
                </div>
              </div>
            </article>
          </div>

          <!-- Book 4 -->
          <div class="col-sm-6 col-lg-3">
            <article class="book-card ink-purple">
              <div class="book-cover-wrap">
                <div class="book-cover cover-purple" aria-hidden="true">
                  <span class="cover-brand">Merit Tutors</span>
                  <span class="cover-series">Year 1 Mathematics</span>
                  <span class="cover-title">Deepen Understanding</span>
                  <span class="cover-num">Book 4</span>
                </div>
              </div>
              <div class="book-body">
                <p class="book-eyebrow">Book 4 of 4</p>
                <h3 class="book-title">Deepen Understanding</h3>
                <p class="book-meta">Year 1 Mathematics · A4 · approx. 150 pages</p>
                <p class="book-desc">Reasoning and problem solving to secure the full curriculum for the year.</p>
                <ul class="list-unstyled book-includes" aria-label="Free with this book">
                  <li class="include-chip"><i class="bi bi-check-lg"></i>Answer book</li>
                  <li class="include-chip"><i class="bi bi-check-lg"></i>5 tests</li>
                  <li class="include-chip"><i class="bi bi-check-lg"></i>Test answers</li>
                </ul>
                <div class="book-actions">
                  <a class="btn btn-merit" href="#" target="_blank" rel="noopener">Buy on Amazon <i class="bi bi-box-arrow-up-right"></i><span class="visually-hidden"> (opens in a new tab)</span></a>
                  <button class="btn btn-downloads" type="button" data-bs-toggle="collapse" data-bs-target="#dl-y1b4" aria-expanded="false" aria-controls="dl-y1b4">Downloads <i class="bi bi-chevron-down"></i></button>
                  <div class="collapse" id="dl-y1b4">
                    <ul class="list-unstyled download-list">
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Answer book<span class="dl-size">PDF</span></a></li>
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Tests 1–5<span class="dl-size">PDF</span></a></li>
                      <li><a href="#"><i class="bi bi-file-earmark-pdf"></i>Test answers<span class="dl-size">PDF</span></a></li>
                    </ul>
                  </div>
                  <button class="btn btn-basket" type="button" disabled><i class="bi bi-bag"></i>Basket<span class="soon-badge">SOON</span></button>
                </div>
              </div>
            </article>
          </div>

        </div>
      </div>
    </section>

    <!-- ===== How it works =============================================== -->
    <section class="shop-steps" aria-labelledby="stepsTitle">
      <div class="container">
        <p class="script-eyebrow">Simple as 1, 2, 3</p>
        <h2 class="section-heading" id="stepsTitle">How the free downloads work</h2>
        <ol class="row g-3 list-unstyled mb-0">
          <li class="col-md-4">
            <div class="step-card">
              <span class="step-badge">1</span>
              <h3 class="step-title">Buy the book on Amazon</h3>
              <p class="step-text">Each workbook is printed without the answers, so the pupil works through it on their own.</p>
            </div>
          </li>
          <li class="col-md-4">
            <div class="step-card">
              <span class="step-badge">2</span>
              <h3 class="step-title">Scan the QR code inside the cover</h3>
              <p class="step-text">It brings you straight to this page and to the right book. No app needed — your phone camera will do.</p>
            </div>
          </li>
          <li class="col-md-4">
            <div class="step-card">
              <span class="step-badge">3</span>
              <h3 class="step-title">Download what you need</h3>
              <p class="step-text">The answer book, five tests and the test answers — all as PDFs, free, as many times as you like.</p>
            </div>
          </li>
        </ol>
      </div>
    </section>

    <!-- ===== FAQ ======================================================== -->
    <section class="shop-faq" aria-labelledby="faqTitle">
      <div class="container">
        <h2 class="section-heading" id="faqTitle">Questions parents ask</h2>
        <div class="accordion topic-accordion" id="shopFaq">
          <div class="accordion-item">
            <h3 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">Do I need an account to download?</button>
            </h3>
            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#shopFaq">
              <div class="accordion-body"><p>No. Find your book and download — the files are free.</p></div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">Which book should my child start with?</button>
            </h3>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#shopFaq">
              <div class="accordion-body"><p>Start with Book 1 for their school year. The four books follow the curriculum in order, so each one builds on the last.</p></div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">Can I buy directly from Merit Tutors?</button>
            </h3>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#shopFaq">
              <div class="accordion-body"><p>Not yet — books are sold on Amazon for now. Buying through this site is coming soon.</p></div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">Lost the QR code?</button>
            </h3>
            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#shopFaq">
              <div class="accordion-body"><p>No problem. Pick the subject and year above and open Downloads on your book, or search by the code printed inside the front cover.</p></div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

@endsection
@push('js')
    <script>
        function showCartToast(name){
            const toast = document.getElementById('cartToast');
            if(!toast) return;
            document.getElementById('cartToastText').textContent = `Added "${name}" to cart`;
            toast.classList.add('show');
            clearTimeout(window._cartToastTimer);
            window._cartToastTimer = setTimeout(() => toast.classList.remove('show'), 2800);
        }

        function increaseCartCount(amount) {
            const counter = document.getElementById('cartCount');
            if (counter) {
                counter.innerHTML = amount;
            }
        }

        document.querySelectorAll('.addToCartButton').forEach(button => {
            button.addEventListener('click', async function (e) {
                e.preventDefault();

                const currentButton = this;
                const loader = document.getElementById('merit-loader');
                const productID = currentButton.dataset.product;
                const productTitle = currentButton.dataset.title;

                // Show loader & disable button
                if (loader) loader.classList.remove('hidden');
                currentButton.disabled = true;

                try {
                    const response = await fetch("{{ route('ajax.add.cart') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            product_id: productID
                        })
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showCartToast(productTitle);

                        increaseCartCount(data.count);
                    } else if (response.status === 401) {
                        window.location.href = "{{ route('login') }}";
                    } else if (response.status === 422) {
                        // Handle Laravel validation errors
                        let errorMessages = Object.values(data.errors)
                            .flatMap(val => val)
                            .join(' ');
                    } else {
                        throw new Error('Server error');
                    }
                } catch (error) {
                    // Catches network failures or unexpected server responses
                    // Swal.fire({
                    //     title: 'Error!',
                    //     text: "An error occurred. Please try again.",
                    //     icon: 'error',
                    //     customClass: 'swal-wide',
                    //     confirmButtonText: 'Close'
                    // });
                    console.log(error)
                } finally {
                    // Always hide loader and re-enable button when done
                    if (loader) loader.classList.add('hidden');
                    currentButton.disabled = false;
                }
            });
        });
    </script>
@endpush
