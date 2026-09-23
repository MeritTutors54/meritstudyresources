@extends('layouts.frontend-3')

@section('body_class', 'page-resources page-subjects')
@push('css')
    <style>
        /* Re-architect subject-tile into an expandable card container */
        .subject-tile {
            padding: 2px;
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
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

        /* Hidden drawer container */
        .tile-dropdown {
            display: none;
            border-top: 1px solid var(--merit-line);
            background: #fbfdfb;
        }

        .subject-tile.is-open .tile-dropdown {
            display: block;
            animation: fadeIn 180ms cubic-bezier(.4, 0, .2, 1);
        }

        /* Inner links list */
        .resub-list {
            display: flex;
            padding: .5rem;
            gap: .2rem;
        }

        .resub-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .55rem .75rem;
            border-radius: var(--radius-sm);
            color: var(--merit-text);
            font-size: .88rem;
            font-weight: 500;
            text-decoration: none;
            transition: background var(--ease), color var(--ease);
        }

        .resub-bullet {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #ccd9d1;
            transition: background var(--ease);
            flex-shrink: 0;
        }

        .resub-text {
            flex: 1;
        }

        .resub-icon {
            font-size: .75rem;
            color: var(--merit-muted);
            opacity: 0;
            transform: translateX(-4px);
            transition: opacity var(--ease), transform var(--ease);
        }

        .resub-link:hover {
            background: var(--merit-light-green);
            color: var(--merit-dark-green);
            text-decoration: none;
        }

        .resub-link:hover .resub-bullet {
            background: var(--merit-green);
        }

        .resub-link:hover .resub-icon {
            opacity: 1;
            transform: translateX(0);
            color: var(--merit-green);
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


        /* Resubcategory Drawer Wrapper */
        .tile-dropdown {
            display: none;
            border-top: 1px solid var(--merit-line);
            /*[cite: 1] */
            background: #fbfdfb;
            padding: .85rem 1rem 1rem;
        }

        .subject-tile.is-open .tile-dropdown {
            display: block;
            animation: fadeIn 180ms cubic-bezier(.4, 0, .2, 1);
        }

        /* Side-by-side flex container */
        .resub-list {
            display: flex;
            flex-wrap: wrap;
            /* Wraps neatly to next line if there are many items */
            align-items: center;
            gap: .45rem;
            /* Spacing between side-by-side items */
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
            /*[cite: 1] */
            border-radius: var(--radius-pill);
            /*[cite: 1] */
            background: #fff;
            color: var(--merit-navy);
            /*[cite: 1] */
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.4;
            text-decoration: none;
            white-space: nowrap;
            transition: background var(--ease), border-color var(--ease), color var(--ease), transform var(--ease);
            /*[cite: 1] */
        }

        .resub-link i {
            font-size: .75rem;
            color: var(--merit-muted);
            /*[cite: 1] */
            transition: transform var(--ease), color var(--ease);
            /*[cite: 1] */
        }

        /* Hover & Focus state */
        .resub-link:hover {
            background: var(--merit-light-green);
            /*[cite: 1] */
            border-color: #cfe5d8;
            /*[cite: 1] */
            color: var(--merit-dark-green);
            /*[cite: 1] */
            text-decoration: none;
            transform: translateY(-1px);
        }

        .resub-link:hover i {
            color: var(--merit-green);
            /*[cite: 1] */
            transform: translateX(2px);
        }



        .course-header.subjects-header {
            padding-bottom: 1rem !important;
            margin-bottom: 0 !important;
        }

        /* Reduce spacing below the "Showing X subjects" counter */
        .result-count,
        #subjectCount {
            margin-bottom: 0.5rem !important;
        }

        /* Reduce top padding of the subject list container */
        .subject-body {
            padding-top: 1rem !important;
        }

        /* Reduce top spacing above each subject group */
        .subject-group {
            margin-top: 1rem !important;
            padding-top: 0 !important;
        }

        /* Ensure the first group sits neatly below the header */
        .subject-group:first-of-type {
            margin-top: 0.5rem !important;
        }

        .group-head {
            margin-bottom: 1rem !important;
        }
    </style>
@endpush
@section('content')


    {{-- <!-- ============================================================
       1. PAGE HEADER
    ============================================================ --> --}}
    <section class="course-header subjects-header" aria-labelledby="subjectsTitle">
        <div class="container">

            <div class="course-header-top">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb course-crumbs">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subjects</li>
                    </ol>
                </nav>
                <p class="spec-code"><span>26</span> subjects · GCSE to A&nbsp;Level</p>
            </div>

            <p class="eyebrow">
                <span class="eyebrow-dot" aria-hidden="true"></span> Free resources
                <span class="eyebrow-sep" aria-hidden="true">/</span> No account needed
            </p>
            <h1 class="course-title" id="subjectsTitle">Browse <span class="course-title-board">all
                    subjects</span></h1>
            <p class="course-intro">
                Pick a subject to see its past papers, revision notes, topic questions, tests,
                workbooks and worked solutions. You can narrow by qualification first, or search
                if you already know what you need.
            </p>

            <!-- Search + qualification filter -->
            <div class="subject-controls">
                <form class="subject-search" role="search" id="subjectSearchForm" novalidate>
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

            <p class="result-count" id="subjectCount" role="status" aria-live="polite">Showing all 26 subjects
            </p>

        </div>
    </section>

    {{-- <!-- ============================================================
       2. CATEGORY JUMP BAR
    ============================================================ --> --}}


    {{-- <!-- ============================================================
       3. SUBJECT GROUPS
       Tiles link to resources.html?subject=… which fills the course
       context on the resource page.
    ============================================================ --> --}}
    <div class="subject-body">
        <div class="container">
            {{-- <section class="subject-group" id="core" aria-labelledby="core-heading" data-group>
                <div class="group-head">
                    <h2 class="group-heading" id="core-heading">Core</h2>
                    <span class="group-count">5 subjects</span>
                </div>
                <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xl-3">
                    <div class="col">
                        <a class="subject-tile" href="resources.html?subject=Mathematics" data-quals="gcse igcse alevel"
                            data-keywords="maths numeracy algebra">
                            <span class="tile-icon tint-mint"><i class="bi bi-calculator" aria-hidden="true"></i></span>
                            <span class="tile-body">
                                <span class="tile-name">Mathematics</span>
                                <span class="tile-meta">Past papers · Notes · Questions · Tests</span>
                                <span class="tile-quals"><span class="qual-chip">GCSE</span><span
                                        class="qual-chip">IGCSE</span><span class="qual-chip">A
                                        Level</span></span>
                            </span>
                            <span class="tile-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                        </a>
                    </div>
                    <div class="col">
                        <a class="subject-tile" href="resources.html?subject=Further+Mathematics" data-quals="gcse alevel"
                            data-keywords="further maths fp1 additional">
                            <span class="tile-icon tint-mint"><i class="bi bi-plus-slash-minus"
                                    aria-hidden="true"></i></span>
                            <span class="tile-body">
                                <span class="tile-name">Further Mathematics</span>
                                <span class="tile-meta">Past papers · Notes · Questions · Tests</span>
                                <span class="tile-quals"><span class="qual-chip">GCSE</span><span class="qual-chip">A
                                        Level</span></span>
                            </span>
                            <span class="tile-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                        </a>
                    </div>
                    <div class="col">
                        <a class="subject-tile" href="resources.html?subject=Statistics" data-quals="gcse alevel"
                            data-keywords="stats data probability">
                            <span class="tile-icon tint-mint"><i class="bi bi-bar-chart-line"
                                    aria-hidden="true"></i></span>
                            <span class="tile-body">
                                <span class="tile-name">Statistics</span>
                                <span class="tile-meta">Past papers · Notes · Questions · Tests</span>
                                <span class="tile-quals"><span class="qual-chip">GCSE</span><span class="qual-chip">A
                                        Level</span></span>
                            </span>
                            <span class="tile-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                        </a>
                    </div>
                    <div class="col">
                        <a class="subject-tile" href="resources.html?subject=English+Language" data-quals="gcse igcse"
                            data-keywords="english language writing comprehension">
                            <span class="tile-icon tint-blush"><i class="bi bi-chat-square-text"
                                    aria-hidden="true"></i></span>
                            <span class="tile-body">
                                <span class="tile-name">English Language</span>
                                <span class="tile-meta">Past papers · Notes · Questions · Tests</span>
                                <span class="tile-quals"><span class="qual-chip">GCSE</span><span
                                        class="qual-chip">IGCSE</span></span>
                            </span>
                            <span class="tile-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                        </a>
                    </div>
                    <div class="col">
                        <a class="subject-tile" href="resources.html?subject=English+Literature"
                            data-quals="gcse igcse alevel" data-keywords="english literature poetry shakespeare novels">
                            <span class="tile-icon tint-blush"><i class="bi bi-book" aria-hidden="true"></i></span>
                            <span class="tile-body">
                                <span class="tile-name">English Literature</span>
                                <span class="tile-meta">Past papers · Notes · Questions · Tests</span>
                                <span class="tile-quals"><span class="qual-chip">GCSE</span><span
                                        class="qual-chip">IGCSE</span><span class="qual-chip">A
                                        Level</span></span>
                            </span>
                            <span class="tile-go" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </section> --}}

            @if (!empty($categories))
                @foreach ($categories as $category)
                    <section class="subject-group" id="sciences" data-category="{{ $category->slug }}"
                        aria-labelledby="sciences-heading" data-group>
                        <div class="group-head">
                            <h2 class="group-heading" id="sciences-heading">
                                {{ $category->category_name }}
                            </h2>
                            <span class="group-count">{{ count($category->subcategories) }} subjects</span>
                        </div>
                        <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xl-3">

                            @if ($category->subcategories->isNotEmpty())
                                @foreach ($category->subcategories as $subcategory)
                                    {{-- <div class="col">
                                        <div class="subject-tile" data-quals="gcse igcse alevel"
                                            data-keywords="biology cells genetics ecology">
                                            <span class="tile-icon tint-sage">
                                                <i class="bi bi-tree" aria-hidden="true"></i>
                                            </span>
                                            <span class="tile-body">
                                                <span class="tile-name">{{ $subcategory->subcategory_name }}</span>
                                                <span class="tile-meta">Past papers · Notes · Questions · Tests</span>
                                            </span>
                                            <span class="tile-go" aria-hidden="true">
                                                <i class="bi bi-arrow-right"></i>
                                            </span>

                                            @if ($subcategory->resubcategories->isNotEmpty())
                                                @foreach ($subcategory->resubcategories as $resubcategory)
                                                    <a href="">{{ $resubcategory->resubcategory_name }}</a>
                                                @endforeach
                                            @endif
                                            <span>

                                            </span>
                                        </div>
                                    </div> --}}


                                    <div class="col">
                                        <div class="subject-tile" data-quals="{{ $category->slug }}"
                                            data-keywords="biology cells genetics ecology">

                                            <!-- Clickable Header that toggles the dropdown -->
                                            <button type="button" class="tile-header" aria-expanded="false"
                                                aria-controls="subcat-{{ $subcategory->id ?? 1 }}">
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

                                            <!-- Collapsible Resubcategory Drawer -->
                                            @if ($subcategory->resubcategories->isNotEmpty())
                                                <div class="tile-dropdown" id="subcat-{{ $subcategory->id ?? 1 }}">
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

            <!-- Request a subject -->
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
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.tile-header').forEach((button) => {
                button.addEventListener('click', () => {
                    const tile = button.closest('.subject-tile');
                    const isOpen = tile.classList.toggle('is-open');
                    button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });
            });
        });



        $(function() {
            // -----------------------------------------------------------------
            // 1. Accordion Drawer Toggle
            // -----------------------------------------------------------------
            $(document).on('click', '.tile-header', function() {
                const $tile = $(this).closest('.subject-tile');
                const isOpen = $tile.toggleClass('is-open').hasClass('is-open');
                $(this).attr('aria-expanded', isOpen ? 'true' : 'false');
            });

            // -----------------------------------------------------------------
            // 2. Filter & Search Elements
            // -----------------------------------------------------------------
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
                        const tileKeywords = ($tile.data('keywords') || '').toString()
                            .toLowerCase();
                        const tileTitle = ($tile.find('.tile-name').text() || '').trim()
                            .toLowerCase();

                        // Qualification match: matches "All", category slug on section, or quals on card
                        const matchesQual = !activeQual ||
                            sectionCategory === activeQual ||
                            tileQuals.split(/\s+/).includes(activeQual);

                        // Search match
                        const matchesSearch = !searchTerm ||
                            tileTitle.includes(searchTerm) ||
                            tileKeywords.includes(searchTerm);

                        const isVisible = matchesQual && matchesSearch;
                        const $colWrapper = $tile.closest('.col').length ? $tile.closest('.col') :
                            $tile;

                        $colWrapper.toggle(isVisible);

                        if (isVisible) {
                            visibleInThisSection++;
                        }
                    });

                    // Hide the entire category section if it has no matching subjects
                    $section.toggle(visibleInThisSection > 0);
                    totalVisibleCards += visibleInThisSection;
                });

                // Update count status
                if ($countDisplay.length) {
                    $countDisplay.text(`Showing ${totalVisibleCards} subject${totalVisibleCards === 1 ? '' : 's'}`);
                }

                // Toggle empty state message
                if ($emptyState.length) {
                    $emptyState.prop('hidden', totalVisibleCards > 0);
                }
            }

            // Qualification pill click handlers
            $filterPills.on('click', function() {
                $filterPills.removeClass('is-active').attr('aria-pressed', 'false');

                $(this).addClass('is-active').attr('aria-pressed', 'true');

                activeQual = ($(this).data('qual') || '').toString().trim().toLowerCase();
                applyFilters();
            });

            // Search input handler
            $searchInput.on('input', function() {
                searchTerm = $(this).val().trim().toLowerCase();
                applyFilters();
            });

            // Run once on load to sync counts
            applyFilters();
        });
    </script>
@endpush
