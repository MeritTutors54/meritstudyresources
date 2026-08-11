@extends('layouts.frontend-2')
@section('content')
    <header class="pp-hero">
        <div class="container">
            <div class="breadcrumb-msr mb-3">
                <a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp;
                <a href="{{ route('past.papers') }}">Past Papers</a> &nbsp;/&nbsp;
                {{ $resubcategory->resubcategory_name }} {{ $subcategory->subcategory_name }}
                ({{ $resubcategory->unit_code }})
            </div>
            <span class="eyebrow">
                <span class="divider-dot"></span>
                    {{ strtoupper($category->category_name) }}
                {{ strtoupper($subcategory->subcategory_name) }}
            </span>

            <div class="pl-title-row">
                <div>
                    <h1 class="mt-3 mb-3">
                        {{ $resubcategory->resubcategory_name }}
                        {{ strtoupper($subcategory->subcategory_name) }}
                        ({{ $resubcategory->unit_code }})
                        <span class="text-green">Past Papers</span></h1>
                    <p class="pl-sub mb-0">Full past papers and mark schemes for AQA A Level Accounting, sorted by exam
                        session.</p>
                </div>
                <span class="pl-board-chip">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                    Exam Board: {{ $resubcategory->resubcategory_name ?? "n/a" }}
                </span>
            </div>
            <nav class="breadcrumb-pill-row">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
            </nav>
            <div class="pl-stat-row">
                <div class="pl-stat">
                    <span class="ps-ico">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M6 4h9l5 5v11H6z" stroke="currentColor" stroke-width="1.6"
                                  stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <div>
                        <div class="ps-num">{{ $totalPapers }} Papers</div>
                        <div class="ps-label">Available to download</div>
                    </div>
                </div>
                <div class="pl-stat">
                    <span class="ps-ico">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 7v5l3.5 2"
                                  stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <circle
                                cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                    </span>
                    <div>
                        <div class="ps-num">{{ $totalSessions }} Sessions</div>
                        <div class="ps-label">Sorted by series</div>
                    </div>
                </div>
                <div class="pl-stat">
                    <span class="ps-ico">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z" stroke="currentColor"
                                  stroke-width="1.6" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <div>
                        <div class="ps-num">Included</div>
                        <div class="ps-label">Every mark scheme</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ============================= MAIN CONTENT ============================= -->
    <section class="section-pad" style="padding-top:24px;">
        <div class="container">
            <div class="row gy-4">

                <!-- SIDEBAR -->
                <div class="col-lg-3">
                    <div class="pp-sidebar">
                        <p class="pp-sidebar-title">Filter by level</p>
                        {{--    @dd($categories)--}}
                        @if(!empty($category))
                            <div class="pp-level-group">
                                <button class="pp-level-toggle" aria-expanded="true"
                                        data-target="lvl-{{ $category->id }}">
                                    <span class="ltl">
                                        <span class="lt-ico">
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M12 3l9 5-9 5-9-5z"
                                                      stroke="currentColor" stroke-width="1.7"
                                                      stroke-linejoin="round"/>
                                                <path d="M6 11v5c0 1.4 2.7 2.5 6 2.5s6-1.1 6-2.5v-5"
                                                      stroke="currentColor" stroke-width="1.7"/>
                                            </svg>
                                        </span>
                                        {{ $category->category_name }}
                                    </span>
                                    <svg class="lt-chev" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                              stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                <div class="pp-level-body-cs" id="lvl-{{ $category->id }}"
                                     style="display: block">
                                    @if(!empty($subcategory))
                                        @if($subcategory->most_popular === 1)
                                            <p class="pp-most-popular">Most Popular</p>
                                            <button class="pp-subject-row active"
                                                    data-target="subBio-{{$subcategory->id}}">
                                                <span class="pp-subject-name"
                                                      title="{{ $subcategory->subcategory_name }}">
                                                    {{ $subcategory->subcategory_name }}
                                                </span>
                                                <svg viewBox="0 0 24 24" fill="none">
                                                    <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                                          stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        @endif

                                        @if(!empty($resubcategory))
                                            <ul class="pp-board-list" id="subBio-{{$subcategory->id}}"
                                                style="display: block;">
                                                <li>
                                                    <a class="active" href="#">
                                                        {{ $resubcategory->resubcategory_name }}
                                                        ({{ $resubcategory->unit_code }})
                                                    </a>
                                                </li>
                                            </ul>
                                        @endif
                                    @endif

                                    @if(!empty($subcategory))
                                        <p class="pp-most-popular mt-3">All Subject</p>
                                        <button class="pp-subject-row active"
                                                data-target="subBio-{{$subcategory->id}}">
                                                <span class="pp-subject-name"
                                                      title="{{ $subcategory->subcategory_name }}">
                                                    {{ $subcategory->subcategory_name }}
                                                </span>
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                        @if(!empty($resubcategory))
                                            <ul class="pp-board-list" id="subBio-{{$subcategory->id}}"
                                                style="display: block;">
                                                <li>
                                                    <a class="active" href="#">
                                                        {{ $resubcategory->resubcategory_name }}
                                                        ({{ $resubcategory->unit_code }})
                                                    </a>
                                                </li>
                                            </ul>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- SUBJECT GRID -->
                <div class="col-lg-9">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div class="papers-tab-row mb-0" id="paperTabs">
                            <button class="papers-tab-btn active" data-filter="all-paper">All Papers</button>
                            @foreach($paperGroups as $key => $paper)
                                @php
                                    $anotherPaperSlug =  strtolower(str_replace(' ', '-', $paper));
                                @endphp
                                <button class="papers-tab-btn" data-filter="{{ $anotherPaperSlug }}-{{ $key }}">
                                    {{ $paper }}
                                </button>
                            @endforeach
                        </div>
                        <button class="expand-all-btn" id="expandAllBtn" onclick="toggleExpandAll()">
                            Expand All
                        </button>
                    </div>

                    <div id="sessionList">
                        <div class="tab-view" id="all-paper">
                            @if($groupedPapers->isNotEmpty())
                                @foreach($groupedPapers as $series => $past_papers)
                                    @php
                                        $slug = strtolower(str_replace(' ', '-', $series));
                                    @endphp
                                    <div class="session-block">
                                        <button class="session-header" data-target="{{ $slug }}">
                                        <span class="sh-left">
                                            <span class="sh-ico">
                                                <svg viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="1.8"
                                                          stroke-linecap="round"/>
                                                    <circle cx="12" cy="12" r="9" stroke="currentColor"
                                                            stroke-width="1.8"/>
                                                </svg>
                                            </span>
                                            {{ $series }}
                                            <span class="sh-count">{{ count($past_papers) }} papers</span>
{{--                                            <span class="sh-latest">Latest</span>--}}
                                        </span>
                                            <svg class="sh-chev" viewBox="0 0 24 24" fill="none">
                                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                        <div class="session-body" id="{{ $slug }}">
                                            @if(!empty($past_papers))
                                                @foreach($past_papers as $paper)
                                                    @php
                                                        $paperSlug = strtolower(str_replace(' ', '-', $paper->title));
                                                        $paperSlug .= '-' . $paper->category . '-' . $paper->exam_series . '-' . $paper->subcategory . '-' . $paper->resubcategory;
                                                    @endphp
                                                    <div class="paper-row" data-paper="{{ $paperSlug }}">
                                                        <a href="{{ asset('uploads/pastpaper') . '/' . $paper->ques_paper }}"
                                                           target="_blank"
                                                           class="paper-link">
                                                            <svg class="pl-ico" viewBox="0 0 24 24" fill="none">
                                                                <path d="M6 4h9l5 5v11H6z" stroke="currentColor"
                                                                      stroke-width="1.6"
                                                                      stroke-linejoin="round"/>
                                                                <path d="M9 12h6M9 15h6M9 9h2" stroke="currentColor"
                                                                      stroke-width="1.6"
                                                                      stroke-linecap="round"/>
                                                            </svg>
                                                            {{ $paper->title }}
                                                        </a>
                                                        <a href="{{ asset('uploads/pastpaper') . '/' . $paper->ans_paper }}"
                                                           target="_blank" class="ms-link">
                                                            <svg viewBox="0 0 24 24" fill="none">
                                                                <path d="M6 4h9l5 5v11H6z" stroke="currentColor"
                                                                      stroke-width="1.6"
                                                                      stroke-linejoin="round"/>
                                                            </svg>
                                                            Mark Scheme
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @foreach($paperGroups as $key => $paperTitle)
                            @php
                                $anotherPaperSlugInBottom = strtolower(str_replace(' ', '-', $paperTitle));
                            @endphp
                            <div class="tab-view d-none" id="{{ $anotherPaperSlugInBottom }}-{{ $key }}">
                                @if($groupedPapers->isNotEmpty())
                                    @foreach($groupedPapers as $series => $past_papers)
                                        @php
                                            $anotherSeriesSlug = strtolower(str_replace(' ', '-', $series));

                                            $finalSlug = $anotherPaperSlugInBottom . '-' . $key . '-' . $anotherSeriesSlug;
                                        @endphp
                                        <div class="session-block">
                                            <button class="session-header" data-target="{{ $finalSlug }}">
                                                <span class="sh-left">
                                                    <span class="sh-ico">
                                                        <svg viewBox="0 0 24 24" fill="none">
                                                            <path d="M12 7v5l3.5 2" stroke="currentColor"
                                                                  stroke-width="1.8"
                                                                  stroke-linecap="round"/>
                                                            <circle cx="12" cy="12" r="9" stroke="currentColor"
                                                                    stroke-width="1.8"/>
                                                        </svg>
                                                    </span>
                                                    {{ $series }}
                                                </span>
                                                <svg class="sh-chev" viewBox="0 0 24 24" fill="none">
                                                    <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                                          stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                            <div class="session-body" id="{{ $finalSlug }}">
                                                @if(!empty($past_papers))
                                                    @foreach($past_papers as $paper)
                                                        @if($paper->title === $paperTitle)
                                                            <div class="paper-row">
                                                                <a href="{{ asset('uploads/pastpaper') . '/' . $paper->ques_paper }}"
                                                                   target="_blank" class="paper-link">
                                                                    <svg class="pl-ico" viewBox="0 0 24 24" fill="none">
                                                                        <path d="M6 4h9l5 5v11H6z" stroke="currentColor"
                                                                              stroke-width="1.6"
                                                                              stroke-linejoin="round"/>
                                                                        <path d="M9 12h6M9 15h6M9 9h2"
                                                                              stroke="currentColor"
                                                                              stroke-width="1.6"
                                                                              stroke-linecap="round"/>
                                                                    </svg>
                                                                    Question
                                                                </a>
                                                                <a href="{{ asset('uploads/pastpaper') . '/' . $paper->ans_paper }}"
                                                                   target="_blank" class="ms-link">
                                                                    <svg viewBox="0 0 24 24" fill="none">
                                                                        <path d="M6 4h9l5 5v11H6z" stroke="currentColor"
                                                                              stroke-width="1.6"
                                                                              stroke-linejoin="round"/>
                                                                    </svg>
                                                                    Mark Scheme
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        document.querySelectorAll('.papers-tab-btn').forEach((tabBtn) => {
            tabBtn.addEventListener('click', () => {
                const clickedBtn = tabBtn;

                document.querySelectorAll('.papers-tab-btn').forEach((otherTabBtn) => {
                    const otherElement = document.getElementById(otherTabBtn.dataset.filter);
                    otherElement.classList.add('d-none');
                    otherTabBtn.classList.remove('active');
                });

                const element = document.getElementById(clickedBtn.dataset.filter);
                element.classList.remove('d-none');
                tabBtn.classList.add('active');
            })
        })
    </script>
    <script>
        document.querySelectorAll('.session-header').forEach((btn) => {
            btn.addEventListener('click', () => {
                console.log('hehe: ', btn.dataset.target);
                const target = document.getElementById(btn.dataset.target);
                console.log("dom: ", target);
                btn.classList.toggle('session-open');
                target.classList.toggle('open');
            })
        })
    </script>
    <script>
        function toggleExpandAll() {
            const blocks = document.querySelectorAll('#sessionList .session-block');

            // Check if at least one block is currently closed
            const shouldExpand = Array.from(blocks).some(block => {
                const header = block.querySelector('.session-header');
                return header && !header.classList.contains('session-open');
            });

            // Apply the target state to headers and bodies within each block
            blocks.forEach(block => {
                const header = block.querySelector('.session-header');
                const body = block.querySelector('.session-body');

                if (header) header.classList.toggle('session-open', shouldExpand);
                if (body) body.classList.toggle('open', shouldExpand);
            });
        }
    </script>
@endpush
