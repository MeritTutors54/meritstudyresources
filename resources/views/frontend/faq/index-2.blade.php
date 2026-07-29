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


    <section class="section-pad" style="padding-top:40px;">
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
                                <div class="accordion-item" data-cat="{{ !empty($faq->genre) ? $faq->genre->label() : "" }}">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button {{ $k == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#fq1">
                                            {{ $faq->question }}
                                        </button>
                                    </h3>
                                    <div id="fq1" class="accordion-collapse collapse {{ $k == 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">We cover AQA, Edexcel, OCR, Cambridge iGCSE and CIE, with
                                            resources mapped to each board's own specification and grade boundaries.
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
        document.querySelectorAll('.faq-cat-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.faq-cat-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const cat = btn.dataset.cat;
                document.querySelectorAll('#faqAccordion .accordion-item').forEach(item => {
                    item.style.display = (cat === 'all' || item.dataset.cat === cat) ? '' : 'none';
                });
                filterFaqSearch();
            });
        });

        // FAQ live search
        const faqInput = document.getElementById('faqSearchInput');

        function filterFaqSearch() {
            const term = faqInput.value.trim().toLowerCase();
            let visibleCount = 0;

            document.querySelectorAll('#faqAccordion .accordion-item').forEach(item => {
                // Removed: if(item.style.display === 'none') return;

                const text = item.textContent.toLowerCase();
                const match = term === '' || text.includes(term);

                item.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            document.getElementById('faqNoResults').classList.toggle('d-none', visibleCount !== 0);
        }

        faqInput.addEventListener('input', filterFaqSearch);
    </script>
@endpush
