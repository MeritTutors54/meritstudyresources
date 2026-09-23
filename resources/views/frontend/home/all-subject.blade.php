@extends('layouts.frontend-3')

@section('body_class', 'page-resources page-subjects')

@push('css')
    <style>
        /* Expandable card container */
        .subject-tile {
            padding: 2px;
            position: relative;
            display: flex;
            flex-direction: column;
            height: auto;
            /* Changed from 100% */
            align-self: flex-start;
            /* Prevents stretching to match siblings */
            width: 100%;
            background: #fff;
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            color: var(--merit-navy);
            overflow: hidden;
            transition: border-color var(--ease), box-shadow var(--ease), transform var(--ease);
        }

        .subject-tile:hover {
            border-color: #cfdcd4;
            box-shadow: var(--shadow-sm);
        }

        .subject-tile.is-open {
            border-color: var(--merit-green);
            box-shadow: var(--shadow-sm);
        }

        /* Header button trigger */
        .tile-header {
            width: 100%;
            display: flex;
            align-items: center;
            gap: .9rem;
            padding: 1.05rem 2.4rem 1.05rem 1.05rem;
            background: none;
            border: 0;
            text-align: left;
            cursor: pointer;
            position: relative;
            color: inherit;
        }

        .tile-header:focus-visible {
            outline: 2px solid var(--merit-green);
            outline-offset: -2px;
        }

        /* Arrow rotation when active */
        .tile-header .tile-go {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--merit-muted);
            font-size: .85rem;
            transition: transform var(--ease), color var(--ease);
        }

        .subject-tile.is-open .tile-header .tile-go {
            transform: translateY(-50%) rotate(180deg);
            color: var(--merit-green);
        }

        /* Resubcategory Drawer Wrapper */
        .tile-dropdown {
            display: none;
            border-top: 1px solid var(--merit-line);
            background: #fbfdfb;
            padding: .85rem 1rem 1rem;
        }

        .subject-tile.is-open .tile-dropdown {
            display: block !important;
            animation: fadeIn 180ms cubic-bezier(.4, 0, .2, 1);
        }

        /* Side-by-side flex container */
        .resub-list {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .45rem;
            margin: 0;
            padding: 0;
        }

        /* Side-by-side Chip / Button styling */
        .resub-link {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .35rem .75rem;
            border: 1px solid var(--card-border);
            border-radius: var(--radius-pill);
            background: #fff;
            color: var(--merit-navy);
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.4;
            text-decoration: none;
            white-space: nowrap;
            transition: background var(--ease), border-color var(--ease), color var(--ease), transform var(--ease);
        }

        .resub-link i {
            font-size: .75rem;
            color: var(--merit-muted);
            transition: transform var(--ease), color var(--ease);
        }

        .resub-link:hover {
            background: var(--merit-light-green);
            border-color: #cfe5d8;
            color: var(--merit-dark-green);
            text-decoration: none;
            transform: translateY(-1px);
        }

        .resub-link:hover i {
            color: var(--merit-green);
            transform: translateX(2px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .course-header.subjects-header {
            padding-bottom: 1rem !important;
            margin-bottom: 0 !important;
        }

        .result-count,
        #subjectCount {
            margin-bottom: 0.5rem !important;
        }

        .subject-body {
            padding-top: 1rem !important;
        }

        .subject-group {
            margin-top: 1rem !important;
            padding-top: 0 !important;
        }

        .subject-group:first-of-type {
            margin-top: 0.5rem !important;
        }

        .group-head {
            margin-bottom: 1rem !important;
        }
    </style>
@endpush

@section('content')
    @php
        $totalSubjects = !empty($categories)
            ? $categories->sum(fn($cat) => $cat->subcategories ? $cat->subcategories->count() : 0)
            : 0;
    @endphp

    <section class="course-header subjects-header" aria-labelledby="subjectsTitle">
        <div class="container">
            <div class="course-header-top">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb course-crumbs">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subjects</li>
                    </ol>
                </nav>
                <p class="spec-code"><span>{{ $totalSubjects }}</span> subjects · GCSE to A&nbsp;Level</p>
            </div>

            <p class="eyebrow">
                <span class="eyebrow-dot" aria-hidden="true"></span> Free resources
                <span class="eyebrow-sep" aria-hidden="true">/</span> No account needed
            </p>
            <h1 class="course-title" id="subjectsTitle">Browse <span class="course-title-board">all subjects</span></h1>
            <p class="course-intro">
                Pick a subject to see its past papers, revision notes, topic questions, tests,
                workbooks and worked solutions. You can narrow by qualification first, or search
                if you already know what you need.
            </p>

            <!-- Search + qualification filter -->
            <div class="subject-controls">
                <form class="subject-search" role="search" id="subjectSearchForm" onsubmit="return false;" novalidate>
                    <label class="visually-hidden" for="subjectSearch">Search subjects</label>
                    <div class="search-shell">
                        <i class="bi bi-search search-icon" aria-hidden="true"></i>
                        <input type="search" class="form-control search-input" id="subjectSearch"
                            placeholder="Search subjects — try &quot;chem&quot; or &quot;maths&quot;" autocomplete="off">
                    </div>
                </form>

                <div class="qual-filter" role="group" aria-label="Filter subjects by qualification">
                    <button type="button" class="filter-pill is-active" data-qual="" aria-pressed="true">All</button>
                    @if (!empty($categories))
                        @foreach ($categories as $category)
                            <button type="button" class="filter-pill" data-qual="{{ $category->slug }}"
                                aria-pressed="false">
                                {{ $category->category_name }}
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>

            <p class="result-count" id="subjectCount" role="status" aria-live="polite">
                Showing all {{ $totalSubjects }} subjects
            </p>
        </div>
    </section>

    <div class="subject-body">
        <div class="container">
            @if (!empty($categories))
                @foreach ($categories as $category)
                    <section class="subject-group" id="group-{{ $category->id }}" data-category="{{ $category->slug }}"
                        aria-labelledby="heading-{{ $category->id }}" data-group>
                        <div class="group-head">
                            <h2 class="group-heading" id="heading-{{ $category->id }}">
                                {{ $category->category_name }}
                            </h2>
                            <span class="group-count">{{ $category->subcategories->count() }} subjects</span>
                        </div>
                        <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xl-3">
                            @if ($category->subcategories->isNotEmpty())
                                @foreach ($category->subcategories as $subcategory)
                                    @php
                                        $resubNames = $subcategory->resubcategories
                                            ->pluck('resubcategory_name')
                                            ->implode(' ');
                                        $keywords = strtolower($subcategory->subcategory_name . ' ' . $resubNames);
                                    @endphp
                                    <div class="col">
                                        <div class="subject-tile" data-quals="{{ $category->slug }}"
                                            data-keywords="{{ $keywords }}">

                                            <button type="button" class="tile-header" aria-expanded="false"
                                                aria-controls="subcat-{{ $subcategory->id }}">
                                                <span class="tile-icon tint-sage">
                                                    <i class="bi bi-tree" aria-hidden="true"></i>
                                                </span>
                                                <span class="tile-body">
                                                    <span class="tile-name">{{ $subcategory->subcategory_name }}</span>
                                                    <span class="tile-meta">Past papers · Notes · Questions · Tests</span>
                                                </span>
                                                <span class="tile-go" aria-hidden="true">
                                                    <i class="bi bi-chevron-down"></i>
                                                </span>
                                            </button>

                                            @if ($subcategory->resubcategories->isNotEmpty())
                                                <div class="tile-dropdown" id="subcat-{{ $subcategory->id }}">
                                                    <div class="resub-list">
                                                        @foreach ($subcategory->resubcategories as $resubcategory)
                                                            <a href="{{ route('board-resources', ['cat_id' => $category->id, 'sub_id' => $subcategory->id, 're_id' => $resubcategory->id]) }}"
                                                                class="resub-link">
                                                                <span>{{ $resubcategory->resubcategory_name }}</span>
                                                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </section>
                @endforeach
            @endif

            <p class="empty-state" id="subjectEmpty" role="status" aria-live="polite" hidden>
                <i class="bi bi-search" aria-hidden="true"></i>
                No subject matches that. Try a shorter word, or clear the qualification filter.
            </p>

            <section class="request-panel" aria-labelledby="requestHeading">
                <div>
                    <h2 class="request-heading" id="requestHeading">Can't find your subject?</h2>
                    <p class="request-text">
                        We add subjects as the material is checked and organised. Tell us what you're
                        studying and we'll prioritise it.
                    </p>
                </div>
                <a class="btn btn-merit" href="#">Request a subject <i class="bi bi-arrow-right"
                        aria-hidden="true"></i></a>
            </section>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            if (event) {
                event.preventDefault();
            }

            const $tile = $(this).closest('.subject-tile');
            const $dropdown = $tile.find('.tile-dropdown');

            // If this tile has no child dropdown, do nothing
            if ($dropdown.length === 0) return;

            const isOpen = $tile.toggleClass('is-open').hasClass('is-open');
            $(this).attr('aria-expanded', isOpen ? 'true' : 'false');
        });

        // 2. Filter & Search Logic
        const $filterPills = $('.qual-filter .filter-pill');
        const $searchInput = $('#subjectSearch');
        const $sections = $('section.subject-group');
        const $countDisplay = $('#subjectCount');
        const $emptyState = $('#subjectEmpty');

        let activeQual = '';
        let searchTerm = '';

        function applyFilters() {
            let totalVisibleCards = 0;

            $sections.each(function() {
                const $section = $(this);
                const sectionCategory = ($section.data('category') || '').toString().toLowerCase();
                const $tiles = $section.find('.subject-tile');
                let visibleInThisSection = 0;

                $tiles.each(function() {
                    const $tile = $(this);
                    const tileQuals = ($tile.data('quals') || '').toString().toLowerCase();
                    const tileKeywords = ($tile.data('keywords') || '').toString().toLowerCase();
                    const tileTitle = ($tile.find('.tile-name').text() || '').trim().toLowerCase();

                    const matchesQual = !activeQual ||
                        sectionCategory === activeQual ||
                        tileQuals.split(/\s+/).includes(activeQual);

                    const matchesSearch = !searchTerm ||
                        tileTitle.includes(searchTerm) ||
                        tileKeywords.includes(searchTerm);

                    const isVisible = matchesQual && matchesSearch;
                    $tile.closest('.col').toggle(isVisible);

                    if (isVisible) visibleInThisSection++;
                });

                $section.toggle(visibleInThisSection > 0);
                totalVisibleCards += visibleInThisSection;
            });

            if ($countDisplay.length) {
                $countDisplay.text(`Showing ${totalVisibleCards} subject${totalVisibleCards === 1 ? '' : 's'}`);
            }

            if ($emptyState.length) {
                $emptyState.prop('hidden', totalVisibleCards > 0);
            }
        }

        $filterPills.on('click', function() {
            $filterPills.removeClass('is-active').attr('aria-pressed', 'false');
            $(this).addClass('is-active').attr('aria-pressed', 'true');
            activeQual = ($(this).data('qual') || '').toString().trim().toLowerCase();
            applyFilters();
        });

        $searchInput.on('input', function() {
            searchTerm = $(this).val().trim().toLowerCase();
            applyFilters();
        });

        applyFilters();


        $(document).on('click', '.tile-header', function(event) {
            if (event) {
                event.preventDefault();
            }

            const $tile = $(this).closest('.subject-tile');
            const $dropdown = $tile.find('.tile-dropdown');

            // Do nothing if this tile has no subcategories
            if ($dropdown.length === 0) return;

            const willOpen = !$tile.hasClass('is-open');

            // 1. Close all currently opened tiles across the page
            $('.subject-tile.is-open')
                .removeClass('is-open')
                .find('.tile-header')
                .attr('aria-expanded', 'false');

            // 2. Open this tile if it was previously closed
            if (willOpen) {
                $tile.addClass('is-open');
                $(this).attr('aria-expanded', 'true');
            }
        });
    </script>
@endpush
