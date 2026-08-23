@extends('layouts.frontend-2')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@section('content')
    <!-- Start breadcrumb Area -->
    <header class="page-banner text-center">
        <div class="container">
            <div class="breadcrumb-msr mb-3 text-center"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; FAQs</div>
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


    <section class="section-pad" style="padding-top:0;">
        <div class="container">
            <div class="d-flex flex-wrap gap-2 justify-content-center mb-5" id="faqCats">
                <button class="faq-cat-btn active" data-cat="all">All</button>
                @foreach($cases as $label)
                    <button class="faq-cat-btn" data-cat="{{ $label->name }}">{{ $label->name }}</button>
                @endforeach
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="accordion accordion-msr" id="faqAccordion">
                        @if(!empty($FAQs))
                            @foreach($FAQs as $k => $faq)
                                <div class="accordion-item" data-cat="{{ !empty($faq->genre) ? (is_object($faq->genre) ? $faq->genre->label() : $faq->genre) : '' }}">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#fq-{{ $loop->iteration }}"
                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                aria-controls="fq-{{ $loop->iteration }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h3>
                                    <div id="fq-{{ $loop->iteration }}"
                                         class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                         data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            {!! $faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
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
