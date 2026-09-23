@extends('layouts.frontend-3')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .finder-panel .select2-container--default .select2-selection--single {
            border: 1px solid var(--merit-border);
            border-radius: var(--radius-sm);
            background-color: #fff;
            height: 48px;
            /* Matches the min-height of your form-select */
            display: flex;
            align-items: center;
            transition: border-color var(--ease), box-shadow var(--ease);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 12px;
            right: 8px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            display: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            display: none !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            top: 0 !important;
            right: 0.75rem !important;
            width: 1rem !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: 16px 12px !important;
        }
    </style>
@endpush
@section('body_class', 'page-resources')
@section('content')
    {{-- <!-- ============================================================
    1. COURSE HEADER — breadcrumb, title, course chips, spec code
    Values are filled from the URL query string by js/resources.js
    (e.g. resources.html?qualification=GCSE&subject=Mathematics).
    ============================================================ --> --}}
    <section class="course-header" style="border-bottom: none" aria-labelledby="courseTitle">
        <div class="container">

            <div class="course-header-top">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb course-crumbs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#"
                                data-course="qualification-link">{{ $examBoard->category->category_name }}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#"
                                data-course="subject-link">{{ $examBoard->subcategory->subcategory_name }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" data-course="board">
                            {{ $examBoard->resubcategory_name }}</li>
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
                        <span class="course-title-board">(<span
                                data-course="board-name">{{ $examBoard->resubcategory_name }}</span>)</span>
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

    <section class="finder-section pt-0" style="padding-bottom: 20px; background: #fff" aria-labelledby="finderHeading">
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

                <form class="row g-3 align-items-end" action="{{ route('board-resources') }}" id="resourceFinder">
                    <div class="col-12 col-md-6 col-xl">
                        <label class="form-label" for="qualification">Qualification</label>
                        <select class="form-select" id="qualification" name="qualification">
                            <option value="" selected>Select qualification</option>
                            @if (!empty($data['categories']))
                                @foreach ($data['categories'] as $qualification)
                                    <option @selected(old('qualification', $data['selectedCategory']) == $qualification->id)
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
                                    <option @selected(old('subject', $data['selectedSubcategory']) == $subject->id)
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
                                    <option @selected(old('examBoard', $data['selectedResubcategory']) == $board->id)
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

    {{-- <!-- ============================================================
    2. RESOURCE TYPE TABS
    ============================================================ --> --}}
    <div class="resource-tabs-bar">
        <div class="container">
            <ul class="nav resource-tabs" id="resourceTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-all" data-bs-toggle="tab" data-bs-target="#pane-all"
                        type="button" role="tab" aria-controls="pane-all" aria-selected="true">
                        <i class="bi bi-grid" aria-hidden="true"></i> All resources
                    </button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-papers" data-bs-toggle="tab" data-bs-target="#pane-papers"
                        type="button" role="tab" aria-controls="pane-papers" aria-selected="false">
                        <i class="bi bi-file-earmark-text" aria-hidden="true"></i> Past papers
                    </button>
                </li> --}}

                @if (!empty($syllabus))
                    @foreach ($syllabus as $tabName => $node)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-{{ $tabName }}" data-bs-toggle="tab"
                                data-bs-target="#pane-{{ Str::slug($tabName) }}" type="button" role="tab"
                                aria-controls="pane-{{ $tabName }}" aria-selected="false">
                                {!! $icons[$tabName] !!} {{ $tabName }}
                            </button>
                        </li>
                    @endforeach
                @endif

            </ul>
        </div>
    </div>

    {{-- <!-- ============================================================
    3. RESOURCE BODY — filter rail + tab panes
    All rows below are SAMPLE ENTRIES showing the layout.
    ============================================================ --> --}}
    <section class="resource-body">
        <div class="container">
            <div class="row g-4">
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

                                @if (!empty($syllabus))
                                    @foreach ($syllabus as $tabName => $nodes)
                                        @php
                                            if (!empty($nodes)) {
                                                $allChildCount = 0;
                                                foreach ($nodes as $counterKey => $value) {
                                                    $allChildCount += count($value['children']);
                                                }
                                            }
                                        @endphp
                                        <div class="col">
                                            <button type="button" class="type-card res-blue" data-goto="tab-notes">
                                                <span class="resource-icon">
                                                    {!! $icons[$tabName] !!}
                                                </span>
                                                <span class="type-name">{{ $tabName }}</span>
                                                <span class="type-meta">
                                                    All over {{ $allChildCount ?? 0 }} topics and files conbination
                                                </span>
                                                <span class="type-go" aria-hidden="true">
                                                    <i class="bi bi-arrow-right"></i>
                                                </span>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
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

                        @if (!empty($syllabus))
                            @foreach ($syllabus as $tabName => $nodes)
                                <div class="tab-pane fade" id="pane-{{ Str::slug($tabName) }}"
                                    role="tabpanel" aria-labelledby="tab-{{ Str::slug($tabName) }}" tabindex="0">
                                    <div class="pane-head">
                                        <h2 class="pane-title">{{ $tabName }}</h2>
                                        <p class="pane-sub">Follows the Edexcel specification order. Open a unit to see its
                                            topics.</p>
                                    </div>

                                    @if (!empty($nodes))
                                        <div class="accordion topic-accordion" id="noteTopics-">
                                            @foreach ($nodes as $loopIndex => $node)
                                                <div class="accordion-item">
                                                    <h3 class="accordion-header">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse-{{ $node['id'] }}"
                                                            aria-expanded="{{ $loopIndex === 0 ? 'true' : 'false' }}"
                                                            aria-controls="collapse-{{ $node['id'] }}">
                                                            <span class="fw-bold text-dark">{{ $node['name'] }}</span>
                                                            @php
                                                                $count = count($node['children'] ?? []);
                                                            @endphp

                                                            <span class="topic-count ms-2 badge rounded-pill">
                                                                @if ($count === 1)
                                                                    ({{ $count }} topic)
                                                                @else
                                                                    ({{ $count }} topics)
                                                                @endif
                                                            </span>
                                                        </button>
                                                    </h3>

                                                    {{-- Children Tree View --}}
                                                    <div id="collapse-{{ $node['id'] }}"
                                                        class="accordion-collapse collapse {{ $loopIndex === 0 ? 'show' : '' }}"
                                                        data-bs-parent="#accordion-{{ Str::slug($tabName) }}">
                                                        <div class="accordion-body">
                                                            @if (!empty($node['children']))
                                                                <ul class="topic-list list-unstyled" data-list>
                                                                    @foreach ($node['children'] as $child)
                                                                        @include(
                                                                            'frontend.board-resource.child-tree',
                                                                            [
                                                                                'node' => $node,
                                                                                'item' => $child,
                                                                                'depth' => 1,
                                                                            ]
                                                                        )

                                                                        {{-- @if (!empty($child['children']))
                                                                            @foreach ($child['children'] as $preChild)
                                                                                @include(
                                                                                    'frontend.board-resource.child-tree',
                                                                                    [
                                                                                        'node' => $node,
                                                                                        'item' => $preChild,
                                                                                        'depth' => 2,
                                                                                    ]
                                                                                )
                                                                            @endforeach
                                                                        @endif --}}
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <p class="text-muted p-3 mb-0 text-center">
                                                                    No sub-items available.
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-5 text-muted">
                                            <i
                                                class="fa-solid fa-folder-open display-4 mb-3 text-secondary opacity-50"></i>
                                            <p class="mb-0">No resources found.</p>
                                        </div>


                                        <div class="text-center py-5 text-muted border rounded bg-light">
                                            <i
                                                class="fa-solid fa-folder-open display-4 mb-3 text-secondary opacity-50"></i>
                                            <p class="mb-0">No resources found.</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{-- <p class="free-note">
                        <strong>Free to learn.</strong> Find a resource, open it and get started.
                        <a href="#">Need a hand? Visit Help <i class="bi bi-arrow-right"
                                aria-hidden="true"></i></a>
                    </p> --}}

                </div>
            </div>
        </div>
    </section>

    </body>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                $('#subject').select2({
                    placeholder: 'Select subject',
                    allowClear: true,
                    width: '100%'
                });
            });
        });

        $('#qualification').on('change', function() {
            const qualificationValue = $(this).val();

            const qualificationId = Number(qualificationValue.split(" ")[0]);

            if (!qualificationId) return; // Don't send if empty

            $.ajax({
                url: '{{ route('ajax.get.sub.categories', ':id') }}'.replace(':id',
                    qualificationId),
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {

                    console.log('form sub: ', response)

                    // Example: Populate a subcategory dropdown
                    let subcategorySelect = $('#subject'); // Adjust selector
                    subcategorySelect.empty().append(
                        '<option value="">Select subject</option>');

                    response.forEach(function(item) {
                        subcategorySelect.append(
                            `<option value="${item.id} / ${item.slug}">${item.subcategory_name}</option>`
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('#subject').on('change', function() {
            const subjectValue = $(this).val();

            const subjectId = Number(subjectValue.split(" ")[0]);

            if (!subjectId) return; // Don't send if empty

            $.ajax({
                url: '{{ route('ajax.get.resub.categories', ':id') }}'.replace(':id',
                    subjectId),
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    // Example: Populate a subcategory dropdown
                    let reSubcategorySelect = $('#examBoard'); // Adjust selector
                    reSubcategorySelect.empty().append(
                        '<option value="">Select exam board</option>');

                    response.forEach(function(item) {
                        reSubcategorySelect.append(
                            `<option value="${item.id} / ${item.slug}">${item.resubcategory_name}</option>`
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });


        $('#viewResourceBtn').on('click', function() {

            let qualification = $("#qualification");
            let subject = $("#subject");
            let examBoard = $("#examBoard");

            const toastArea = $("#toast-area");
            const toastAreaMessage = $("#toast-area-message");

            let qualificationValue = qualification.val();
            let subjectValue = subject.val();
            let examBoardValue = examBoard.val();

            let isValid = true;

            function toggleError($element, isEmpty) {
                if (isEmpty) {
                    $element.css('border', '1px solid red');
                    isValid = false;
                } else {
                    $element.css('border', ''); // Reset border if valid
                }
            }

            toggleError(qualification, !qualificationValue);
            toggleError(subject, !subjectValue);
            toggleError(examBoard, !examBoardValue);

            if (!isValid) {
                toastArea.addClass('error show');
                toastAreaMessage.html('Please fill in all required fields marked with an error')
                // alert("Please fill in all required fields before viewing resources.");
                return;
            }

            const categorySlug = qualificationValue.split(" / ")[0].trim();
            const subcategorySlug = subjectValue.split(" / ")[0].trim();
            const reSubcategorySlug = examBoardValue.split(" / ")[0].trim();

            const baseUrl = '{{ route('board-resources') }}';

            // 2. Construct the URL and append the query parameters
            const url = new URL(baseUrl, window.location.origin);
            url.searchParams.append('cat_id', categorySlug);
            url.searchParams.append('sub_id', subcategorySlug);
            url.searchParams.append('re_id', reSubcategorySlug);

            // 3. Redirect the browser
            window.location.href = url.toString();

        })
    </script>
@endpush
