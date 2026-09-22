@extends('layouts.frontend-3')
@section('content')
    <!-- ============================================================
    1. COURSE HEADER — breadcrumb, title, course chips, spec code
    Values are filled from the URL query string by js/resources.js
    (e.g. resources.html?qualification=GCSE&subject=Mathematics).
    ============================================================ -->
    <section class="course-header" aria-labelledby="courseTitle">
        <div class="container">

            <div class="course-header-top">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb course-crumbs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#" data-course="qualification-link">{{ $examBoard->category->category_name }}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#" data-course="subject-link">{{ $examBoard->subcategory->subcategory_name }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" data-course="board">{{ $examBoard->resubcategory_name }}</li>
                    </ol>
                </nav>
                <p class="spec-code">Unit Code <span data-course="spec">{{ $examBoard->unit_code }}</span></p>
            </div>

            <div class="course-header-main">
                <div>
                    <p class="eyebrow">
                        <span class="eyebrow-dot" aria-hidden="true"></span> Free resources
                        <span class="eyebrow-sep" aria-hidden="true">/</span> No account needed
                    </p>
                    <h1 class="course-title" id="courseTitle">
                        <span data-course="qualification">{{ $examBoard->category->category_name }}</span>
                        <span data-course="subject">{{ $examBoard->subcategory->subcategory_name }}</span>
                        <span class="course-title-board">(<span data-course="board-name">{{ $examBoard->resubcategory_name }}</span>)</span>
                    </h1>
                    {{-- <p class="course-intro">


                        Every Edexcel GCSE Mathematics resource in one place — past papers with mark schemes,
                        revision notes by topic, practice questions, timed tests, workbooks and worked solutions.
                        Open anything you need — nothing is locked.
                    </p> --}}

                    <ul class="course-chips list-unstyled">
                        <li class="course-chip" data-course="qualification">{{ $examBoard->category->category_name }}</li>
                        <li class="course-chip" data-course="subject">{{ $examBoard->subcategory->subcategory_name }}</li>
                        <li class="course-chip" data-course="board">{{ $examBoard->resubcategory_name }}</li>
                        <li class="course-chip course-chip-tier" data-course="tier">Higher Tier</li>
                    </ul>
                </div>

                {{-- <div class="course-actions">
                    <a class="btn btn-outline-merit" href="index.html#finderHeading">
                        <i class="bi bi-pencil" aria-hidden="true"></i> Change course
                    </a>
                    <a class="btn btn-soft" href="#studyRoute">How to use these <i class="bi bi-arrow-down"
                            aria-hidden="true"></i></a>
                </div> --}}
            </div>

        </div>
    </section>

    <section class="finder-section pt-0" style="padding-bottom: 20px" aria-labelledby="finderHeading">
        <div class="container">
            <div class="finder-panel" data-reveal>

                <div class="row align-items-start g-3 mb-4">
                    <div class="col-lg-7">
                        <div class="finder-title">
                            <span class="finder-title-icon"><i class="bi bi-search" aria-hidden="true"></i></span>
                            <div>
                                <h2 class="section-heading mb-1" id="finderHeading">Find Your Resources</h2>
                                <p class="finder-subtitle mb-0">Select your options below to get started.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        {{-- <p class="finder-help">
                            Not sure which exam board?
                            <span class="help-badge" aria-hidden="true"><i class="bi bi-question-lg"></i></span>
                            <a href="#">Get help here</a>
                        </p> --}}
                    </div>
                </div>

                <form class="row g-3 align-items-end" action="{{ route('board-resources') }}"  id="resourceFinder">
                    <div class="col-12 col-md-6 col-xl">
                        <label class="form-label" for="qualification">Qualification</label>
                        <select class="form-select" id="qualification" name="qualification">
                            <option value="" selected>Select qualification</option>
                            @if (!empty($data['categories']))
                                @foreach ($data['categories'] as $qualification)
                                    <option
                                    @selected(old('qualification',  $data['selectedCategory']) == $qualification->id)
                                    value="{{ $qualification->id }} / {{ $qualification->slug }}">
                                        {{ $qualification->category_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-xl">
                        <label class="form-label" for="subject">Subject</label>
                        <select class="form-select select2" id="subject" name="subject">
                            <option value="" selected>Select subject</option>
                            <!-- add your other <option>s here -->
                            @if (!empty($data['subcategories']))
                                @foreach ($data['subcategories'] as $subject)
                                    <option 
                                    @selected(old('subject',  $data['selectedSubcategory']) == $subject->id)
                                        value="{{ $subject->id }} / {{ $subject->slug }}">
                                        {{ $subject->subcategory_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-xl">
                        <label class="form-label" for="examBoard">Exam Board</label>
                        <select class="form-select" id="examBoard" name="examBoard">
                            <option value="" selected>Select exam board</option>
                            @if (!empty($data['resubcategories']))
                                @foreach ($data['resubcategories'] as $board)
                                    <option 
                                     @selected(old('examBoard',  $data['selectedResubcategory']) == $board->id)
                                    value="{{ $board->id }} / {{ $board->slug }}">
                                        {{ $board->resubcategory_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-xl">
                        <label class="form-label" for="tier">Level / Tier <span class="label-note">(if
                                applicable)</span></label>
                        <select class="form-select" id="tier" name="tier">
                            <option value="" selected hidden>Select level / tier</option>
                            {{--                            <option>Foundation Tier</option> --}}
                            {{--                            <option>Higher Tier</option> --}}
                            {{--                            <option>AS</option> --}}
                            {{--                            <option>A2</option> --}}
                        </select>
                    </div>

                    <div class="col-12 col-xl-auto">
                        <button type="button" id="viewResourceBtn" class="btn btn-merit btn-lg w-100 finder-submit">
                            View Resources <i class="bi bi-arrow-right" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>

                <p class="finder-result" id="finderResult" role="status" aria-live="polite"></p>
            </div>
        </div>
    </section>

    <!-- ============================================================
    2. RESOURCE TYPE TABS
    ============================================================ -->
    <div class="resource-tabs-bar">
        <div class="container">
            <ul class="nav resource-tabs" id="resourceTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-all" data-bs-toggle="tab" data-bs-target="#pane-all"
                        type="button" role="tab" aria-controls="pane-all" aria-selected="true">
                        <i class="bi bi-grid" aria-hidden="true"></i> All resources
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-papers" data-bs-toggle="tab" data-bs-target="#pane-papers"
                        type="button" role="tab" aria-controls="pane-papers" aria-selected="false">
                        <i class="bi bi-file-earmark-text" aria-hidden="true"></i> Past papers
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-notes" data-bs-toggle="tab" data-bs-target="#pane-notes" type="button"
                        role="tab" aria-controls="pane-notes" aria-selected="false">
                        <i class="bi bi-journal-text" aria-hidden="true"></i> Revision notes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-questions" data-bs-toggle="tab" data-bs-target="#pane-questions"
                        type="button" role="tab" aria-controls="pane-questions" aria-selected="false">
                        <i class="bi bi-check2-square" aria-hidden="true"></i> Topic questions
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-tests" data-bs-toggle="tab" data-bs-target="#pane-tests"
                        type="button" role="tab" aria-controls="pane-tests" aria-selected="false">
                        <i class="bi bi-stopwatch" aria-hidden="true"></i> Tests
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-workbooks" data-bs-toggle="tab" data-bs-target="#pane-workbooks"
                        type="button" role="tab" aria-controls="pane-workbooks" aria-selected="false">
                        <i class="bi bi-book-half" aria-hidden="true"></i> Workbooks
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-solutions" data-bs-toggle="tab" data-bs-target="#pane-solutions"
                        type="button" role="tab" aria-controls="pane-solutions" aria-selected="false">
                        <i class="bi bi-lightbulb" aria-hidden="true"></i> Worked solutions
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- ============================================================
    3. RESOURCE BODY — filter rail + tab panes
    All rows below are SAMPLE ENTRIES showing the layout.
    ============================================================ -->
    <section class="resource-body">
        <div class="container">
            <div class="row g-4">

                {{-- <!-- Filter rail -->
                <div class="col-lg-3">
                    <aside class="filter-rail" aria-label="Filter resources">

                        <form class="filter-search" role="search" id="resourceSearchForm" novalidate>
                            <label class="visually-hidden" for="resourceSearch">Search within this course</label>
                            <div class="search-shell search-shell-sm">
                                <i class="bi bi-search search-icon" aria-hidden="true"></i>
                                <input type="search" class="form-control search-input" id="resourceSearch"
                                    placeholder="Search this course..." autocomplete="off">
                            </div>
                        </form>

                        <div class="filter-block">
                            <h2 class="filter-heading">Tier</h2>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tier" id="tier-higher"
                                        value="Higher" checked data-filter="tier">
                                    <label class="form-check-label" for="tier-higher">Higher</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tier" id="tier-foundation"
                                        value="Foundation" data-filter="tier">
                                    <label class="form-check-label" for="tier-foundation">Foundation</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tier" id="tier-both"
                                        value="" data-filter="tier">
                                    <label class="form-check-label" for="tier-both">Show both</label>
                                </div>
                            </div>
                        </div>

                        <div class="filter-block">
                            <h2 class="filter-heading">Exam series</h2>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="series-2024" value="2024"
                                        checked data-filter="series">
                                    <label class="form-check-label" for="series-2024">2024 <span
                                            class="filter-count">3</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="series-2023" value="2023"
                                        checked data-filter="series">
                                    <label class="form-check-label" for="series-2023">2023 <span
                                            class="filter-count">3</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="series-2022" value="2022"
                                        checked data-filter="series">
                                    <label class="form-check-label" for="series-2022">2022 <span
                                            class="filter-count">3</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="filter-block">
                            <h2 class="filter-heading">Paper</h2>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="paper-1" value="Paper 1"
                                        checked data-filter="paper">
                                    <label class="form-check-label" for="paper-1">Paper 1
                                        (non-calculator)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="paper-2" value="Paper 2"
                                        checked data-filter="paper">
                                    <label class="form-check-label" for="paper-2">Paper 2 (calculator)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="paper-3" value="Paper 3"
                                        checked data-filter="paper">
                                    <label class="form-check-label" for="paper-3">Paper 3 (calculator)</label>
                                </div>
                            </div>
                        </div>

                        <div class="filter-block">
                            <h2 class="filter-heading">Source</h2>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="source-board" value="board"
                                        checked data-filter="source">
                                    <label class="form-check-label" for="source-board">Exam board papers</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="source-merit" value="merit"
                                        checked data-filter="source">
                                    <label class="form-check-label" for="source-merit">Merit practice
                                        material</label>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-soft w-100" id="clearFilters">
                            <i class="bi bi-arrow-counterclockwise" aria-hidden="true"></i> Reset filters
                        </button>

                        <p class="filter-note">
                            Counts and entries on this page are illustrative while the library is being loaded.
                        </p>
                    </aside>
                </div> --}}

                <!-- Panes -->
                <div class="col-lg-12">
                    <div class="tab-content" id="resourceTabContent">

                        <!-- ---------- All resources ---------- -->
                        <div class="tab-pane fade show active" id="pane-all" role="tabpanel" aria-labelledby="tab-all"
                            tabindex="0">
                            <div class="pane-head">
                                <h2 class="pane-title">Everything for this course</h2>
                                <p class="pane-sub">Six resource types, all free to open.</p>
                            </div>

                            <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-xl-3">
                                <div class="col">
                                    <button type="button" class="type-card res-rose" data-goto="tab-papers">
                                        <span class="resource-icon"><i class="bi bi-file-earmark-text-fill"
                                                aria-hidden="true"></i></span>
                                        <span class="type-name">Past papers</span>
                                        <span class="type-meta">9 papers · question paper, mark scheme,
                                            solutions</span>
                                        <span class="type-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="button" class="type-card res-blue" data-goto="tab-notes">
                                        <span class="resource-icon"><i class="bi bi-journal-text"
                                                aria-hidden="true"></i></span>
                                        <span class="type-name">Revision notes</span>
                                        <span class="type-meta">6 units · concise notes with examples</span>
                                        <span class="type-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="button" class="type-card res-green" data-goto="tab-questions">
                                        <span class="resource-icon"><i class="bi bi-check2-square"
                                                aria-hidden="true"></i></span>
                                        <span class="type-name">Topic questions</span>
                                        <span class="type-meta">Exam-style questions with answers</span>
                                        <span class="type-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="button" class="type-card res-purple" data-goto="tab-tests">
                                        <span class="resource-icon"><i class="bi bi-stopwatch"
                                                aria-hidden="true"></i></span>
                                        <span class="type-name">Topic tests</span>
                                        <span class="type-meta">Timed mini-assessments with mark schemes</span>
                                        <span class="type-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="button" class="type-card res-teal" data-goto="tab-workbooks">
                                        <span class="resource-icon"><i class="bi bi-book-half"
                                                aria-hidden="true"></i></span>
                                        <span class="type-name">Workbooks</span>
                                        <span class="type-meta">Printable booklets for homework and revision</span>
                                        <span class="type-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="button" class="type-card res-amber" data-goto="tab-solutions">
                                        <span class="resource-icon"><i class="bi bi-lightbulb-fill"
                                                aria-hidden="true"></i></span>
                                        <span class="type-name">Worked solutions</span>
                                        <span class="type-meta">Step-by-step methods, written and on video</span>
                                        <span class="type-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                                    </button>
                                </div>
                            </div>

                            <div class="pane-head pane-head-spaced">
                                <h2 class="pane-title">Recently added</h2>
                                <p class="pane-sub">Sample entries showing the row layout.</p>
                            </div>

                            <ul class="resource-list list-unstyled" data-list>
                                <li class="resource-row" data-series="2024" data-paper="Paper 1" data-tier="Higher"
                                    data-source="board"
                                    data-keywords="june 2024 paper 1 non-calculator higher past paper">
                                    <span class="row-icon"><i class="bi bi-file-earmark-text"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <p class="row-eyebrow">Exam-board past paper · Sample entry</p>
                                        <h3 class="row-title">Mathematics · Paper 1</h3>
                                        <p class="row-meta">Higher · June 2024 · Non-calculator · PDF</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Question Paper <i
                                                class="bi bi-arrow-right" aria-hidden="true"></i></a>
                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                    </div>
                                </li>
                                <li class="resource-row" data-series="2024" data-paper="Paper 2" data-tier="Higher"
                                    data-source="merit" data-keywords="merit practice paper higher calculator">
                                    <span class="row-icon row-icon-merit"><i class="bi bi-file-earmark-text"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <p class="row-eyebrow row-eyebrow-merit">Merit practice material · Sample
                                            entry</p>
                                        <h3 class="row-title">Mathematics · Practice paper 1</h3>
                                        <p class="row-meta">Higher · Calculator · PDF</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Question Paper <i
                                                class="bi bi-arrow-right" aria-hidden="true"></i></a>
                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                    </div>
                                </li>
                                <li class="resource-row" data-series="2024" data-tier="Higher" data-source="merit"
                                    data-keywords="quadratics revision notes algebra">
                                    <span class="row-icon row-icon-note"><i class="bi bi-journal-text"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <p class="row-eyebrow">Revision notes · Sample entry</p>
                                        <h3 class="row-title">Algebra · Quadratics</h3>
                                        <p class="row-meta">Higher · 6 pages · Notes with worked examples</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Open notes <i
                                                class="bi bi-arrow-right" aria-hidden="true"></i></a>
                                        <a class="btn btn-soft" href="#">Topic questions</a>
                                    </div>
                                </li>
                            </ul>
                            <p class="pane-note">Example layout only. Show file buttons only when the matching
                                resources are available.</p>
                        </div>

                        <!-- ---------- Past papers ---------- -->
                        <div class="tab-pane fade" id="pane-papers" role="tabpanel" aria-labelledby="tab-papers"
                            tabindex="0">
                            <div class="pane-head">
                                <h2 class="pane-title">Question papers &amp; answers</h2>
                                <p class="pane-sub">Grouped by exam series. Each row links to the paper, its mark
                                    scheme and a worked solution.</p>
                            </div>

                            <div class="accordion topic-accordion" id="paperSeries">

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#series-june-2024" aria-expanded="true"
                                            aria-controls="series-june-2024">
                                            June 2024 <span class="topic-count">3 papers</span>
                                        </button>
                                    </h3>
                                    <div id="series-june-2024" class="accordion-collapse collapse show"
                                        data-bs-parent="#paperSeries">
                                        <div class="accordion-body">
                                            <ul class="resource-list list-unstyled" data-list>
                                                <li class="resource-row" data-series="2024" data-paper="Paper 1"
                                                    data-tier="Higher" data-source="board"
                                                    data-keywords="june 2024 paper 1 non calculator">
                                                    <span class="row-icon"><i class="bi bi-file-earmark-text"
                                                            aria-hidden="true"></i></span>
                                                    <div class="row-body">
                                                        <h3 class="row-title">Paper 1 · Non-calculator</h3>
                                                        <p class="row-meta">Higher · June 2024 · 1h 30m · 80 marks
                                                        </p>
                                                    </div>
                                                    <div class="row-actions">
                                                        <a class="btn btn-merit btn-sm" href="#">Question
                                                            Paper</a>
                                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                                    </div>
                                                </li>
                                                <li class="resource-row" data-series="2024" data-paper="Paper 2"
                                                    data-tier="Higher" data-source="board"
                                                    data-keywords="june 2024 paper 2 calculator">
                                                    <span class="row-icon"><i class="bi bi-file-earmark-text"
                                                            aria-hidden="true"></i></span>
                                                    <div class="row-body">
                                                        <h3 class="row-title">Paper 2 · Calculator</h3>
                                                        <p class="row-meta">Higher · June 2024 · 1h 30m · 80 marks
                                                        </p>
                                                    </div>
                                                    <div class="row-actions">
                                                        <a class="btn btn-merit btn-sm" href="#">Question
                                                            Paper</a>
                                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                                    </div>
                                                </li>
                                                <li class="resource-row" data-series="2024" data-paper="Paper 3"
                                                    data-tier="Higher" data-source="board"
                                                    data-keywords="june 2024 paper 3 calculator">
                                                    <span class="row-icon"><i class="bi bi-file-earmark-text"
                                                            aria-hidden="true"></i></span>
                                                    <div class="row-body">
                                                        <h3 class="row-title">Paper 3 · Calculator</h3>
                                                        <p class="row-meta">Higher · June 2024 · 1h 30m · 80 marks
                                                        </p>
                                                    </div>
                                                    <div class="row-actions">
                                                        <a class="btn btn-merit btn-sm" href="#">Question
                                                            Paper</a>
                                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#series-june-2023"
                                            aria-expanded="false" aria-controls="series-june-2023">
                                            June 2023 <span class="topic-count">3 papers</span>
                                        </button>
                                    </h3>
                                    <div id="series-june-2023" class="accordion-collapse collapse"
                                        data-bs-parent="#paperSeries">
                                        <div class="accordion-body">
                                            <ul class="resource-list list-unstyled" data-list>
                                                <li class="resource-row" data-series="2023" data-paper="Paper 1"
                                                    data-tier="Higher" data-source="board"
                                                    data-keywords="june 2023 paper 1">
                                                    <span class="row-icon"><i class="bi bi-file-earmark-text"
                                                            aria-hidden="true"></i></span>
                                                    <div class="row-body">
                                                        <h3 class="row-title">Paper 1 · Non-calculator</h3>
                                                        <p class="row-meta">Higher · June 2023 · 1h 30m · 80 marks
                                                        </p>
                                                    </div>
                                                    <div class="row-actions">
                                                        <a class="btn btn-merit btn-sm" href="#">Question
                                                            Paper</a>
                                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                                    </div>
                                                </li>
                                                <li class="resource-row" data-series="2023" data-paper="Paper 2"
                                                    data-tier="Higher" data-source="board"
                                                    data-keywords="june 2023 paper 2">
                                                    <span class="row-icon"><i class="bi bi-file-earmark-text"
                                                            aria-hidden="true"></i></span>
                                                    <div class="row-body">
                                                        <h3 class="row-title">Paper 2 · Calculator</h3>
                                                        <p class="row-meta">Higher · June 2023 · 1h 30m · 80 marks
                                                        </p>
                                                    </div>
                                                    <div class="row-actions">
                                                        <a class="btn btn-merit btn-sm" href="#">Question
                                                            Paper</a>
                                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                                    </div>
                                                </li>
                                                <li class="resource-row" data-series="2023" data-paper="Paper 3"
                                                    data-tier="Foundation" data-source="board"
                                                    data-keywords="june 2023 paper 3 foundation">
                                                    <span class="row-icon"><i class="bi bi-file-earmark-text"
                                                            aria-hidden="true"></i></span>
                                                    <div class="row-body">
                                                        <h3 class="row-title">Paper 3 · Calculator</h3>
                                                        <p class="row-meta">Foundation · June 2023 · 1h 30m · 80
                                                            marks</p>
                                                    </div>
                                                    <div class="row-actions">
                                                        <a class="btn btn-merit btn-sm" href="#">Question
                                                            Paper</a>
                                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#series-june-2022"
                                            aria-expanded="false" aria-controls="series-june-2022">
                                            June 2022 <span class="topic-count">3 papers</span>
                                        </button>
                                    </h3>
                                    <div id="series-june-2022" class="accordion-collapse collapse"
                                        data-bs-parent="#paperSeries">
                                        <div class="accordion-body">
                                            <ul class="resource-list list-unstyled" data-list>
                                                <li class="resource-row" data-series="2022" data-paper="Paper 1"
                                                    data-tier="Higher" data-source="board"
                                                    data-keywords="june 2022 paper 1">
                                                    <span class="row-icon"><i class="bi bi-file-earmark-text"
                                                            aria-hidden="true"></i></span>
                                                    <div class="row-body">
                                                        <h3 class="row-title">Paper 1 · Non-calculator</h3>
                                                        <p class="row-meta">Higher · June 2022 · 1h 30m · 80 marks
                                                        </p>
                                                    </div>
                                                    <div class="row-actions">
                                                        <a class="btn btn-merit btn-sm" href="#">Question
                                                            Paper</a>
                                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                                    </div>
                                                </li>
                                                <li class="resource-row" data-series="2022" data-paper="Paper 2"
                                                    data-tier="Higher" data-source="board"
                                                    data-keywords="june 2022 paper 2">
                                                    <span class="row-icon"><i class="bi bi-file-earmark-text"
                                                            aria-hidden="true"></i></span>
                                                    <div class="row-body">
                                                        <h3 class="row-title">Paper 2 · Calculator</h3>
                                                        <p class="row-meta">Higher · June 2022 · 1h 30m · 80 marks
                                                        </p>
                                                    </div>
                                                    <div class="row-actions">
                                                        <a class="btn btn-merit btn-sm" href="#">Question
                                                            Paper</a>
                                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                                    </div>
                                                </li>
                                                <li class="resource-row" data-series="2022" data-paper="Paper 3"
                                                    data-tier="Higher" data-source="merit"
                                                    data-keywords="practice paper 3 merit">
                                                    <span class="row-icon row-icon-merit"><i
                                                            class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
                                                    <div class="row-body">
                                                        <p class="row-eyebrow row-eyebrow-merit">Merit practice
                                                            material</p>
                                                        <h3 class="row-title">Practice paper · Calculator</h3>
                                                        <p class="row-meta">Higher · Written in the 2022 style · 80
                                                            marks</p>
                                                    </div>
                                                    <div class="row-actions">
                                                        <a class="btn btn-merit btn-sm" href="#">Question
                                                            Paper</a>
                                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                                        <a class="btn btn-soft" href="#">Worked Solution</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <p class="pane-note">Sample entries. Show a file button only when that file exists for
                                the paper.</p>
                        </div>

                        <!-- ---------- Revision notes ---------- -->
                        <div class="tab-pane fade" id="pane-notes" role="tabpanel" aria-labelledby="tab-notes"
                            tabindex="0">
                            <div class="pane-head">
                                <h2 class="pane-title">Revision notes by topic</h2>
                                <p class="pane-sub">Follows the Edexcel specification order. Open a unit to see its
                                    topics.</p>
                            </div>

                            <div class="accordion topic-accordion" id="noteTopics">

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#unit-number" aria-expanded="true"
                                            aria-controls="unit-number">
                                            1. Number <span class="topic-count">8 topics</span>
                                        </button>
                                    </h3>
                                    <div id="unit-number" class="accordion-collapse collapse show"
                                        data-bs-parent="#noteTopics">
                                        <div class="accordion-body">
                                            <ul class="topic-list list-unstyled" data-list>
                                                <li class="topic-item" data-keywords="integers place value number"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        1.1 Integers and place value
                                                        <span class="topic-tag">Notes · Questions</span></a></li>
                                                <li class="topic-item" data-keywords="decimals rounding estimation"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        1.2 Decimals, rounding and
                                                        estimation <span class="topic-tag">Notes ·
                                                            Questions</span></a></li>
                                                <li class="topic-item" data-keywords="indices powers roots surds">
                                                    <a href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        1.3 Indices, powers and
                                                        roots <span class="topic-tag">Notes · Questions ·
                                                            Test</span></a>
                                                </li>
                                                <li class="topic-item" data-keywords="factors multiples primes hcf lcm"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        1.4 Factors, multiples and
                                                        primes <span class="topic-tag">Notes · Questions</span></a>
                                                </li>
                                                <li class="topic-item" data-keywords="standard form"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        1.5 Standard form <span class="topic-tag">Notes ·
                                                            Questions</span></a></li>
                                                <li class="topic-item" data-keywords="surds simplifying rationalising"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        1.6 Surds <span class="topic-tag higher-only">Higher
                                                            only</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#unit-algebra"
                                            aria-expanded="false" aria-controls="unit-algebra">
                                            2. Algebra <span class="topic-count">11 topics</span>
                                        </button>
                                    </h3>
                                    <div id="unit-algebra" class="accordion-collapse collapse"
                                        data-bs-parent="#noteTopics">
                                        <div class="accordion-body">
                                            <ul class="topic-list list-unstyled" data-list>
                                                <li class="topic-item"
                                                    data-keywords="algebraic expressions simplifying expanding"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        2.1 Algebraic expressions
                                                        <span class="topic-tag">Notes · Questions</span></a></li>
                                                <li class="topic-item" data-keywords="quadratics factorising"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        2.2 Quadratics: factorising
                                                        <span class="topic-tag">Notes · Questions · Test</span></a>
                                                </li>
                                                <li class="topic-item" data-keywords="completing the square quadratics"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        2.3 Completing the square
                                                        <span class="topic-tag higher-only">Higher only</span></a>
                                                </li>
                                                <li class="topic-item" data-keywords="quadratic formula discriminant"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        2.4 The quadratic formula
                                                        <span class="topic-tag">Notes · Questions</span></a></li>
                                                <li class="topic-item" data-keywords="simultaneous equations"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        2.5 Simultaneous equations
                                                        <span class="topic-tag">Notes · Questions · Test</span></a>
                                                </li>
                                                <li class="topic-item" data-keywords="inequalities regions"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        2.6 Inequalities <span class="topic-tag">Notes ·
                                                            Questions</span></a></li>
                                                <li class="topic-item" data-keywords="sequences nth term"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        2.7 Sequences and the nth
                                                        term <span class="topic-tag">Notes · Questions</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#unit-ratio" aria-expanded="false"
                                            aria-controls="unit-ratio">
                                            3. Ratio, proportion and rates of change <span class="topic-count">6
                                                topics</span>
                                        </button>
                                    </h3>
                                    <div id="unit-ratio" class="accordion-collapse collapse"
                                        data-bs-parent="#noteTopics">
                                        <div class="accordion-body">
                                            <ul class="topic-list list-unstyled" data-list>
                                                <li class="topic-item" data-keywords="ratio sharing"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        3.1 Ratio <span class="topic-tag">Notes · Questions</span></a></li>
                                                <li class="topic-item" data-keywords="percentages increase decrease"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        3.2 Percentages <span class="topic-tag">Notes · Questions ·
                                                            Test</span></a>
                                                </li>
                                                <li class="topic-item" data-keywords="compound interest growth decay"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        3.3 Growth and decay <span class="topic-tag">Notes ·
                                                            Questions</span></a></li>
                                                <li class="topic-item" data-keywords="direct inverse proportion">
                                                    <a href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        3.4 Direct and inverse
                                                        proportion <span class="topic-tag">Notes ·
                                                            Questions</span></a>
                                                </li>
                                                <li class="topic-item"
                                                    data-keywords="speed density pressure compound measures"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        3.5 Compound measures <span class="topic-tag">Notes ·
                                                            Questions</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#unit-geometry"
                                            aria-expanded="false" aria-controls="unit-geometry">
                                            4. Geometry and measures <span class="topic-count">10 topics</span>
                                        </button>
                                    </h3>
                                    <div id="unit-geometry" class="accordion-collapse collapse"
                                        data-bs-parent="#noteTopics">
                                        <div class="accordion-body">
                                            <ul class="topic-list list-unstyled" data-list>
                                                <li class="topic-item" data-keywords="angles parallel lines polygons"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        4.1 Angles and polygons
                                                        <span class="topic-tag">Notes · Questions</span></a></li>
                                                <li class="topic-item" data-keywords="pythagoras"><a href="#"><span
                                                            class="topic-dot" aria-hidden="true"></span> 4.2 Pythagoras'
                                                        theorem
                                                        <span class="topic-tag">Notes · Questions ·
                                                            Test</span></a></li>
                                                <li class="topic-item"
                                                    data-keywords="trigonometry sohcahtoa sine cosine rule"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        4.3 Trigonometry <span class="topic-tag">Notes · Questions ·
                                                            Test</span></a>
                                                </li>
                                                <li class="topic-item" data-keywords="circle theorems"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        4.4 Circle theorems <span class="topic-tag higher-only">Higher
                                                            only</span></a>
                                                </li>
                                                <li class="topic-item" data-keywords="transformations vectors">
                                                    <a href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        4.5 Transformations and
                                                        vectors <span class="topic-tag">Notes ·
                                                            Questions</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#unit-stats" aria-expanded="false"
                                            aria-controls="unit-stats">
                                            5. Probability and statistics <span class="topic-count">7
                                                topics</span>
                                        </button>
                                    </h3>
                                    <div id="unit-stats" class="accordion-collapse collapse"
                                        data-bs-parent="#noteTopics">
                                        <div class="accordion-body">
                                            <ul class="topic-list list-unstyled" data-list>
                                                <li class="topic-item" data-keywords="probability trees venn"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        5.1 Probability, trees and
                                                        Venn diagrams <span class="topic-tag">Notes ·
                                                            Questions</span></a></li>
                                                <li class="topic-item" data-keywords="averages mean median mode range"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        5.2 Averages and spread
                                                        <span class="topic-tag">Notes · Questions</span></a></li>
                                                <li class="topic-item" data-keywords="cumulative frequency box plots"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        5.3 Cumulative frequency
                                                        and box plots <span class="topic-tag higher-only">Higher
                                                            only</span></a></li>
                                                <li class="topic-item" data-keywords="histograms"><a href="#"><span
                                                            class="topic-dot" aria-hidden="true"></span> 5.4 Histograms
                                                        <span class="topic-tag higher-only">Higher only</span></a>
                                                </li>
                                                <li class="topic-item" data-keywords="scatter graphs correlation"><a
                                                        href="#"><span class="topic-dot" aria-hidden="true"></span>
                                                        5.5 Scatter graphs and
                                                        correlation <span class="topic-tag">Notes ·
                                                            Questions</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <p class="pane-note">Topic list follows the published specification; file availability
                                is being confirmed.</p>
                        </div>

                        <!-- ---------- Topic questions ---------- -->
                        <div class="tab-pane fade" id="pane-questions" role="tabpanel" aria-labelledby="tab-questions"
                            tabindex="0">
                            <div class="pane-head">
                                <h2 class="pane-title">Topic questions</h2>
                                <p class="pane-sub">Exam-style questions grouped by topic, each with a mark
                                    scheme.</p>
                            </div>

                            <ul class="resource-list list-unstyled" data-list>
                                <li class="resource-row" data-tier="Higher" data-source="merit"
                                    data-keywords="quadratics algebra questions">
                                    <span class="row-icon row-icon-green"><i class="bi bi-check2-square"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <h3 class="row-title">Algebra · Quadratics</h3>
                                        <p class="row-meta">Higher · 18 questions · 42 marks</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Questions</a>
                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                    </div>
                                </li>
                                <li class="resource-row" data-tier="Higher" data-source="merit"
                                    data-keywords="trigonometry geometry questions">
                                    <span class="row-icon row-icon-green"><i class="bi bi-check2-square"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <h3 class="row-title">Geometry · Trigonometry</h3>
                                        <p class="row-meta">Higher · 15 questions · 38 marks</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Questions</a>
                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                    </div>
                                </li>
                                <li class="resource-row" data-tier="Foundation" data-source="merit"
                                    data-keywords="percentages ratio questions foundation">
                                    <span class="row-icon row-icon-green"><i class="bi bi-check2-square"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <h3 class="row-title">Ratio &amp; Proportion · Percentages</h3>
                                        <p class="row-meta">Foundation · 20 questions · 40 marks</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Questions</a>
                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                    </div>
                                </li>
                            </ul>
                            <p class="pane-note">Sample entries showing the row layout.</p>
                        </div>

                        <!-- ---------- Tests ---------- -->
                        <div class="tab-pane fade" id="pane-tests" role="tabpanel" aria-labelledby="tab-tests"
                            tabindex="0">
                            <div class="pane-head">
                                <h2 class="pane-title">Topic tests</h2>
                                <p class="pane-sub">Short timed assessments. Print them or work through on paper,
                                    then mark with the scheme.</p>
                            </div>

                            <ul class="resource-list list-unstyled" data-list>
                                <li class="resource-row" data-tier="Higher" data-source="merit"
                                    data-keywords="algebra test 30 minutes">
                                    <span class="row-icon row-icon-purple"><i class="bi bi-stopwatch"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <h3 class="row-title">Algebra · End of unit test</h3>
                                        <p class="row-meta">Higher · 30 minutes · 30 marks</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Start test</a>
                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                    </div>
                                </li>
                                <li class="resource-row" data-tier="Higher" data-source="merit"
                                    data-keywords="number test">
                                    <span class="row-icon row-icon-purple"><i class="bi bi-stopwatch"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <h3 class="row-title">Number · End of unit test</h3>
                                        <p class="row-meta">Higher · 25 minutes · 25 marks</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Start test</a>
                                        <a class="btn btn-soft" href="#">Mark Scheme</a>
                                    </div>
                                </li>
                            </ul>
                            <p class="pane-note">Sample entries showing the row layout.</p>
                        </div>

                        <!-- ---------- Workbooks ---------- -->
                        <div class="tab-pane fade" id="pane-workbooks" role="tabpanel" aria-labelledby="tab-workbooks"
                            tabindex="0">
                            <div class="pane-head">
                                <h2 class="pane-title">Workbooks &amp; booklets</h2>
                                <p class="pane-sub">Printable booklets covering a whole unit, with space to write.
                                </p>
                            </div>

                            <ul class="resource-list list-unstyled" data-list>
                                <li class="resource-row" data-tier="Higher" data-source="merit"
                                    data-keywords="algebra workbook booklet">
                                    <span class="row-icon row-icon-teal"><i class="bi bi-book-half"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <h3 class="row-title">Algebra workbook</h3>
                                        <p class="row-meta">Higher · 24 pages · Answers included</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Download PDF</a>
                                        <a class="btn btn-soft" href="#">Answers</a>
                                    </div>
                                </li>
                                <li class="resource-row" data-tier="Foundation" data-source="merit"
                                    data-keywords="number workbook foundation homework">
                                    <span class="row-icon row-icon-teal"><i class="bi bi-book-half"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <h3 class="row-title">Number homework booklet</h3>
                                        <p class="row-meta">Foundation · 16 pages · Answers included</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Download PDF</a>
                                        <a class="btn btn-soft" href="#">Answers</a>
                                    </div>
                                </li>
                            </ul>
                            <p class="pane-note">Sample entries showing the row layout.</p>
                        </div>

                        <!-- ---------- Worked solutions ---------- -->
                        <div class="tab-pane fade" id="pane-solutions" role="tabpanel"
                            aria-labelledby="tab-solutions" tabindex="0">
                            <div class="pane-head">
                                <h2 class="pane-title">Worked solutions</h2>
                                <p class="pane-sub">Full methods for past papers, written out question by
                                    question.</p>
                            </div>

                            <ul class="resource-list list-unstyled" data-list>
                                <li class="resource-row" data-series="2024" data-paper="Paper 1" data-tier="Higher"
                                    data-source="merit" data-keywords="june 2024 paper 1 solutions">
                                    <span class="row-icon row-icon-amber"><i class="bi bi-lightbulb"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <h3 class="row-title">June 2024 · Paper 1 solutions</h3>
                                        <p class="row-meta">Higher · Full written method · PDF</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Open solutions</a>
                                        <a class="btn btn-soft" href="#">Question Paper</a>
                                    </div>
                                </li>
                                <li class="resource-row" data-series="2023" data-paper="Paper 2" data-tier="Higher"
                                    data-source="merit" data-keywords="june 2023 paper 2 solutions">
                                    <span class="row-icon row-icon-amber"><i class="bi bi-lightbulb"
                                            aria-hidden="true"></i></span>
                                    <div class="row-body">
                                        <h3 class="row-title">June 2023 · Paper 2 solutions</h3>
                                        <p class="row-meta">Higher · Full written method · PDF</p>
                                    </div>
                                    <div class="row-actions">
                                        <a class="btn btn-merit btn-sm" href="#">Open solutions</a>
                                        <a class="btn btn-soft" href="#">Question Paper</a>
                                    </div>
                                </li>
                            </ul>
                            <p class="pane-note">Sample entries showing the row layout.</p>
                        </div>

                    </div>

                    <!-- Shared empty state for search/filter results -->
                    <p class="empty-state" id="emptyState" role="status" aria-live="polite" hidden>
                        <i class="bi bi-search" aria-hidden="true"></i>
                        Nothing matches those filters. Try widening the tier or clearing the search.
                    </p>

                    <!-- Study route -->
                    <div class="study-route" id="studyRoute">
                        <p class="study-route-lead"><strong>Make each topic click.</strong> Follow a simple study
                            route.</p>
                        <ol class="study-steps list-unstyled">
                            <li><span class="step-num">1</span> Revise</li>
                            <li aria-hidden="true" class="step-arrow"><i class="bi bi-arrow-right"></i></li>
                            <li><span class="step-num">2</span> Practise</li>
                            <li aria-hidden="true" class="step-arrow"><i class="bi bi-arrow-right"></i></li>
                            <li><span class="step-num">3</span> Check</li>
                            <li aria-hidden="true" class="step-arrow"><i class="bi bi-arrow-right"></i></li>
                            <li><span class="step-num">4</span> Understand</li>
                        </ol>
                    </div>

                    <p class="free-note">
                        <strong>Free to learn.</strong> Find a resource, open it and get started.
                        <a href="#">Need a hand? Visit Help <i class="bi bi-arrow-right"
                                aria-hidden="true"></i></a>
                    </p>

                </div>
            </div>
        </div>
    </section>
    </body>
@endsection
