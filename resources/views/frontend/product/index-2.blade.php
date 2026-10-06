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
            {{-- <p class="shop-lead">Workbooks written by our tutors, from Year 1 to GCSE and A Level. Buy the book on Amazon, then download the answer book, the tests and the test answers here — free with every book.</p> --}}
            <ul class="list-unstyled shop-checks">
              <li><span class="check-dot"><i class="bi bi-check-lg"></i></span>Free downloads with every book</li>
              <li><span class="check-dot"><i class="bi bi-check-lg"></i></span>Follows the England curriculum</li>
              <li><span class="check-dot"><i class="bi bi-check-lg"></i></span>Year 1 to A Level</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- ===== Subject / year selector (from book_categories + book_subjects) ===== -->
    <section class="shop-selector" aria-label="Choose year and subject">
      <div class="container">
        <div class="selector-row">
          <p class="selector-label" id="yearLabel">Year</p>
          <nav class="selector-pills" aria-labelledby="yearLabel">
            @foreach ($categories as $cat)
              <a class="select-pill {{ $category && $cat->id === $category->id ? 'is-active' : '' }}"
                 href="{{ request()->url() }}?year={{ $cat->slug }}#books"
                 @if ($category && $cat->id === $category->id) aria-current="page" @endif>{{ $cat->name }}</a>
            @endforeach
          </nav>
        </div>

        {{-- subject row only appears when a year has more than one subject --}}
        @if ($subjects->count() > 1)
          <div class="selector-row">
            <p class="selector-label" id="subjectLabel">Subject</p>
            <nav class="selector-pills" aria-labelledby="subjectLabel">
              @foreach ($subjects as $sub)
                <a class="select-pill {{ $subject && $sub->id === $subject->id ? 'is-active' : '' }}"
                   href="{{ request()->url() }}?year={{ $category->slug }}&subject={{ $sub->slug }}#books"
                   @if ($subject && $sub->id === $subject->id) aria-current="page" @endif>{{ $sub->name }}</a>
              @endforeach
            </nav>
          </div>
        @endif
      </div>
    </section>

    <!-- ===== Books ====================================================== -->
    <section class="shop-books" id="books" aria-labelledby="booksTitle">
      <div class="container">
        @php
          $countWords = [1 => 'One book', 2 => 'Two books', 3 => 'Three books', 4 => 'Four books', 5 => 'Five books', 6 => 'Six books'];
          $total = $books->count();
          $basketLive = false; // set to true when on-site sales start — the button then uses your add-to-cart script
        @endphp

        @if (session('lookup_error'))
          <div class="alert alert-warning">{{ session('lookup_error') }}</div>
        @endif

        <div class="books-head">
          <div>
            <h2 class="books-title" id="booksTitle">{{ $category?->name }} {{ $subject?->name }}</h2>
            @if ($total)
              <p class="books-sub">{{ $countWords[$total] ?? $total.' books' }} that cover the whole {{ $category?->name }} curriculum, in order.</p>
            @endif
          </div>
          <span class="books-badge"><i class="bi bi-download"></i>Answers and tests are PDFs — free with the book</span>
        </div>

        @if ($books->isEmpty())
          <p class="empty-state">
            <i class="bi bi-journal-bookmark"></i>
            Books for {{ $category?->name }} {{ $subject?->name }} are coming soon.
          </p>
        @else
          <div class="row g-3">
            @foreach ($books as $book)
              <div class="col-sm-6 col-lg-3">
                <article class="book-card ink-{{ $book['colour'] }}">
                  <div class="book-cover-wrap">
                    <span class="book-cover-photo">
                      <img src="{{ $book['cover'] }}" alt="Cover of {{ $book['title'] }}"
                           width="300" height="400" loading="lazy" decoding="async"
                           onerror="this.onerror=null;this.src='{{ asset('frontend/new/images/books/book-cover-placeholder.svg') }}'">
                    </span>
                  </div>

                  <div class="book-body">
                    <p class="book-eyebrow">Book {{ $book['number'] }} of {{ $total }}</p>
                    <h3 class="book-title">{{ $book['title'] }}</h3>
                    <p class="book-meta">{{ $book['series'] }}</p>
                    @if ($book['description'])
                      <p class="book-desc">{{ $book['description'] }}</p>
                    @endif

                    {{-- chips = solution names (product_solutions via solution_types) --}}
                    @if (count($book['includes']))
                      <ul class="list-unstyled book-includes" aria-label="Free with this book">
                        @foreach ($book['includes'] as $name)
                          <li class="include-chip"><i class="bi bi-check-lg"></i>{{ $name }}</li>
                        @endforeach
                      </ul>
                    @endif

                    <div class="book-actions">
                      @if ($book['amazon'])
                        <a class="btn btn-merit" href="{{ $book['amazon'] }}" target="_blank" rel="noopener">Buy on Amazon <i class="bi bi-box-arrow-up-right"></i><span class="visually-hidden"> (opens in a new tab)</span></a>
                      @else
                        <span class="btn btn-merit disabled" aria-disabled="true">Coming soon to Amazon</span>
                      @endif

                      @if (count($book['downloads']))
                        <button class="btn btn-downloads" type="button" data-bs-toggle="collapse" data-bs-target="#dl-{{ $book['id'] }}" aria-expanded="false" aria-controls="dl-{{ $book['id'] }}">Downloads <i class="bi bi-chevron-down"></i></button>
                        <div class="collapse" id="dl-{{ $book['id'] }}">
                          <ul class="list-unstyled download-list">
                            @foreach ($book['downloads'] as $dl)
                              <li><a href="{{ $dl['url'] }}" target="_blank" rel="noopener" download><i class="bi bi-file-earmark-pdf"></i>{{ $dl['label'] }}<span class="dl-size">PDF</span></a></li>
                            @endforeach
                          </ul>
                        </div>
                      @endif

                      @if ($basketLive)
                        <button class="btn btn-basket addToCartButton" type="button"
                                data-product="{{ $book['id'] }}" data-title="{{ $book['title'] }}">
                          <i class="bi bi-bag"></i>Add to basket @if ($book['price']) · £{{ number_format($book['price'], 2) }} @endif
                        </button>
                      @else
                        <button class="btn btn-basket" type="button" disabled><i class="bi bi-bag"></i>Basket<span class="soon-badge">SOON</span></button>
                      @endif
                    </div>
                  </div>
                </article>
              </div>
            @endforeach
          </div>
        @endif
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
        // Coming from a QR code (?book=ID): scroll to that book and open its downloads
        (function () {
            var id = new URLSearchParams(location.search).get('book');
            var panel = id && document.getElementById('dl-' + id);
            if (!panel) return;
            panel.closest('.book-card').scrollIntoView({ behavior: 'smooth', block: 'center' });
            bootstrap.Collapse.getOrCreateInstance(panel).show();
        })();

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