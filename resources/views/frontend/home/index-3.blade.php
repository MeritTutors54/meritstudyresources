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
            margin-right: 0px;
        }
    </style>
@endpush
@section('content')
    <!-- ============================================================
                    2. HERO
                ============================================================ -->
    <section class="hero" aria-labelledby="heroHeading">
        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">

                <div class="col-lg-6">
                    <h1 class="hero-heading" id="heroHeading">
                        What are you<br>
                        <span class="hero-heading-accent">studying today?</span>
                    </h1>
                    <p class="hero-lead">
                        Find free past papers, revision notes and practice resources
                        for GCSE, IGCSE, AS and A&nbsp;Level.
                    </p>

                    <ul class="hero-benefits list-unstyled">
                        <li class="hero-benefit">
                            <span class="benefit-icon benefit-icon-green"><i class="bi bi-check-circle-fill"
                                    aria-hidden="true"></i></span>
                            <span><strong>100% Free</strong><br>for All Students</span>
                        </li>
                        <li class="hero-benefit">
                            <span class="benefit-icon benefit-icon-blue"><i class="bi bi-mortarboard-fill"
                                    aria-hidden="true"></i></span>
                            <span><strong>Exam-Specific</strong><br>Resources</span>
                        </li>
                        <li class="hero-benefit">
                            <span class="benefit-icon benefit-icon-navy"><i class="bi bi-book-half"
                                    aria-hidden="true"></i></span>
                            <span><strong>Organised by</strong><br>Topic</span>
                        </li>
                        <li class="hero-benefit">
                            <span class="benefit-icon benefit-icon-teal"><i class="bi bi-people-fill"
                                    aria-hidden="true"></i></span>
                            <span><strong>Trusted by</strong><br>Students &amp; Teachers</span>
                        </li>
                    </ul>
                </div>

                <!-- Decorative study-desk illustration, built with CSS (no third-party artwork) -->
                <div class="col-lg-6">
                    <div class="hero-art" role="img"
                        aria-label="Illustration of a stack of study books labelled past papers, revision notes, practice questions, worksheets, mark schemes and worked solutions.">
                        <p class="script-note script-note-left" aria-hidden="true">Your Course<br>All in One Place</p>
                        <p class="script-note script-note-right" aria-hidden="true">Same<br>Students<br>Brighter<br>Futures
                            <span class="script-smiley">☺</span>
                        </p>

                        <div class="book-stack" aria-hidden="true">
                            <span class="book book-navy">Past Papers</span>
                            <span class="book book-green">Revision Notes</span>
                            <span class="book book-blue">Practice Questions</span>
                            <span class="book book-amber">Worksheets</span>
                            <span class="book book-rose">Mark Schemes</span>
                            <span class="book book-purple">Worked Solutions</span>
                        </div>

                        <div class="pencil-pot" aria-hidden="true">
                            <span class="pencil pencil-1"></span>
                            <span class="pencil pencil-2"></span>
                            <span class="pencil pencil-3"></span>
                            <span class="pot"></span>
                        </div>

                        <div class="desk-line" aria-hidden="true"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================
                    3. FIND YOUR RESOURCES — resource finder
                ============================================================ -->
    <section class="finder-section" aria-labelledby="finderHeading">
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
                        <p class="finder-help">
                            Not sure which exam board?
                            <span class="help-badge" aria-hidden="true"><i class="bi bi-question-lg"></i></span>
                            <a href="#">Get help here</a>
                        </p>
                    </div>
                </div>

                <form class="row g-3 align-items-end">
                    <div class="col-12 col-md-6 col-xl">
                        <label class="form-label" for="qualification">Qualification</label>
                        <select class="form-select" id="qualification" name="qualification">
                            <option value="" selected>Select qualification</option>
                            @if (!empty($qualifications))
                                @foreach ($qualifications as $qualification)
                                    <option value="{{ $qualification->id }} / {{ $qualification->slug }}">
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
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-xl">
                        <label class="form-label" for="examBoard">Exam Board</label>
                        <select class="form-select" id="examBoard" name="examBoard">
                            <option value="" selected>Select exam board</option>
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
                                                         3b. EXAM BOARD STRIP — continuous marquee, pauses on hover/focus
                                                         Board list is illustrative; edit to match the boards you cover.
                                                         ============================================================ -->
    <section class="boards" aria-labelledby="boardsHeading">
        <div class="container">
            <div class="boards-inner">
                <h2 class="boards-label" id="boardsHeading">Covering the major exam boards</h2>
                <div class="marquee" data-marquee>
                    <ul class="marquee-track list-unstyled">
                        <li>AQA</li>
                        <li>Edexcel</li>
                        <li>OCR</li>
                        <li>Cambridge&nbsp;(CIE)</li>
                        <li>WJEC&nbsp;/&nbsp;Eduqas</li>
                        <li>Oxford&nbsp;AQA</li>
                        <li>CCEA</li>
                    </ul>
                    <ul class="marquee-track list-unstyled" aria-hidden="true">
                        <li>AQA</li>
                        <li>Edexcel</li>
                        <li>OCR</li>
                        <li>Cambridge&nbsp;(CIE)</li>
                        <li>WJEC&nbsp;/&nbsp;Eduqas</li>
                        <li>Oxford&nbsp;AQA</li>
                        <li>CCEA</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
                                                         4. BROWSE BY SUBJECT
                                                         ============================================================ -->
    <section class="section" id="subjects" aria-labelledby="subjectsHeading">
        <div class="container">
            <div class="section-head" data-reveal>
                <h2 class="section-heading" id="subjectsHeading">Browse by Subject</h2>
                <a class="section-link" href="#">View all subjects <i class="bi bi-arrow-right"
                        aria-hidden="true"></i></a>
            </div>

            <div class="row g-3 row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5" data-reveal-group>
                <div class="col">
                    <a class="subject-card tint-mint" href="#">
                        <span class="subject-icon"><i class="bi bi-calculator" aria-hidden="true"></i></span>
                        <span class="subject-name">Mathematics</span>
                    </a>
                </div>
                <div class="col">
                    <a class="subject-card tint-blush" href="#">
                        <span class="subject-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
                        <span class="subject-name">English</span>
                    </a>
                </div>
                <div class="col">
                    <a class="subject-card tint-sage" href="#">
                        <span class="subject-icon"><i class="bi bi-tree" aria-hidden="true"></i></span>
                        <span class="subject-name">Biology</span>
                    </a>
                </div>
                <div class="col">
                    <a class="subject-card tint-cream" href="#">
                        <span class="subject-icon"><i class="bi bi-thermometer-half" aria-hidden="true"></i></span>
                        <span class="subject-name">Chemistry</span>
                    </a>
                </div>
                <div class="col">
                    <a class="subject-card tint-sky" href="#">
                        <span class="subject-icon"><i class="bi bi-asterisk" aria-hidden="true"></i></span>
                        <span class="subject-name">Physics</span>
                    </a>
                </div>
                <div class="col">
                    <a class="subject-card tint-lilac" href="#">
                        <span class="subject-icon"><i class="bi bi-bar-chart-fill" aria-hidden="true"></i></span>
                        <span class="subject-name">Economics</span>
                    </a>
                </div>
                <div class="col">
                    <a class="subject-card tint-mint" href="#">
                        <span class="subject-icon"><i class="bi bi-globe-americas" aria-hidden="true"></i></span>
                        <span class="subject-name">Geography</span>
                    </a>
                </div>
                <div class="col">
                    <a class="subject-card tint-blush" href="#">
                        <span class="subject-icon"><i class="bi bi-lightbulb" aria-hidden="true"></i></span>
                        <span class="subject-name">Psychology</span>
                    </a>
                </div>
                <div class="col">
                    <a class="subject-card tint-periwinkle" href="#">
                        <span class="subject-icon"><i class="bi bi-display" aria-hidden="true"></i></span>
                        <span class="subject-name">Computer Science</span>
                    </a>
                </div>
                <div class="col">
                    <a class="subject-card tint-grey" href="#">
                        <span class="subject-icon"><i class="bi bi-grid" aria-hidden="true"></i></span>
                        <span class="subject-name">View All Subjects</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
                                                         5. EXPLORE RESOURCES
                                                    ============================================================ -->
    <section class="section" id="past-papers" aria-labelledby="resourcesHeading">
        <div class="container">
            <div class="section-head" data-reveal>
                <h2 class="section-heading" id="resourcesHeading">Explore Resources</h2>
            </div>

            <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-6" data-reveal-group>
                <div class="col">
                    <article class="resource-card res-rose">
                        <span class="resource-icon"><i class="bi bi-file-earmark-text-fill"
                                aria-hidden="true"></i></span>
                        <h3 class="resource-title">Past Papers</h3>
                        <p class="resource-text">Official past papers organised by year and paper.</p>
                        <a class="btn btn-soft" href="#">Browse Past Papers <i class="bi bi-arrow-right"
                                aria-hidden="true"></i></a>
                    </article>
                </div>
                <div class="col">
                    <article class="resource-card res-blue">
                        <span class="resource-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
                        <h3 class="resource-title">Revision Notes</h3>
                        <p class="resource-text">Clear and concise notes by topic.</p>
                        <a class="btn btn-soft" href="#">Browse Revision Notes <i class="bi bi-arrow-right"
                                aria-hidden="true"></i></a>
                    </article>
                </div>
                <div class="col">
                    <article class="resource-card res-green">
                        <span class="resource-icon"><i class="bi bi-check2-square" aria-hidden="true"></i></span>
                        <h3 class="resource-title">Topic Questions</h3>
                        <p class="resource-text">Practice questions organised by topic.</p>
                        <a class="btn btn-soft" href="#">Browse Questions <i class="bi bi-arrow-right"
                                aria-hidden="true"></i></a>
                    </article>
                </div>
                <div class="col">
                    <article class="resource-card res-purple">
                        <span class="resource-icon"><i class="bi bi-stopwatch" aria-hidden="true"></i></span>
                        <h3 class="resource-title">Topic Tests</h3>
                        <p class="resource-text">Timed tests to check your progress.</p>
                        <a class="btn btn-soft" href="#">Browse Topic Tests <i class="bi bi-arrow-right"
                                aria-hidden="true"></i></a>
                    </article>
                </div>
                <div class="col">
                    <article class="resource-card res-teal">
                        <span class="resource-icon"><i class="bi bi-book-half" aria-hidden="true"></i></span>
                        <h3 class="resource-title">Workbooks</h3>
                        <p class="resource-text">Structured workbooks and homework booklets.</p>
                        <a class="btn btn-soft" href="#">Browse Workbooks <i class="bi bi-arrow-right"
                                aria-hidden="true"></i></a>
                    </article>
                </div>
                <div class="col">
                    <article class="resource-card res-amber">
                        <span class="resource-icon"><i class="bi bi-lightbulb-fill" aria-hidden="true"></i></span>
                        <h3 class="resource-title">Worked Solutions</h3>
                        <p class="resource-text">Step-by-step solutions to help you learn.</p>
                        <a class="btn btn-soft" href="#">Browse Solutions <i class="bi bi-arrow-right"
                                aria-hidden="true"></i></a>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
                                                         6. POPULAR THIS WEEK
                                                         Sample/illustrative content only — replace with real data.
                                                    ============================================================ -->
    <section class="section" aria-labelledby="popularHeading">
        <div class="container">
            <div class="section-head" data-reveal>
                <h2 class="section-heading" id="popularHeading">Popular This Week</h2>

                <div class="filter-pills" role="group" aria-label="Filter popular resources by type">
                    <button type="button" class="filter-pill is-active" data-filter="past-papers"
                        aria-pressed="true">Past Papers</button>
                    <button type="button" class="filter-pill" data-filter="revision-notes"
                        aria-pressed="false">Revision Notes</button>
                    <button type="button" class="filter-pill" data-filter="topic-questions" aria-pressed="false">Topic
                        Questions</button>
                    <button type="button" class="filter-pill" data-filter="topic-tests" aria-pressed="false">Topic
                        Tests</button>
                </div>
            </div>

            <!-- Sample rows: titles and metadata below are illustrative placeholders -->
            <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xl-3" id="popularList" data-reveal-group>
                <div class="col">
                    <div class="popular-card">
                        <span class="popular-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
                        <div class="popular-body">
                            <h3 class="popular-title">GCSE Maths <span class="popular-board">(Edexcel)</span></h3>
                            <p class="popular-meta">Higher Tier · Paper 1 · June 2024</p>
                        </div>
                        <a class="btn btn-merit btn-sm popular-btn" href="#"
                            aria-label="View GCSE Maths Edexcel Higher Tier Paper 1 June 2024">View</a>
                    </div>
                </div>
                <div class="col">
                    <div class="popular-card">
                        <span class="popular-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
                        <div class="popular-body">
                            <h3 class="popular-title">A Level Maths <span class="popular-board">(Edexcel)</span></h3>
                            <p class="popular-meta">Paper 1 · June 2024</p>
                        </div>
                        <a class="btn btn-merit btn-sm popular-btn" href="#"
                            aria-label="View A Level Maths Edexcel Paper 1 June 2024">View</a>
                    </div>
                </div>
                <div class="col">
                    <div class="popular-card">
                        <span class="popular-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
                        <div class="popular-body">
                            <h3 class="popular-title">GCSE Chemistry <span class="popular-board">(OCR)</span></h3>
                            <p class="popular-meta">Higher Tier · Paper 1 · June 2024</p>
                        </div>
                        <a class="btn btn-merit btn-sm popular-btn" href="#"
                            aria-label="View GCSE Chemistry OCR Higher Tier Paper 1 June 2024">View</a>
                    </div>
                </div>
                <div class="col">
                    <div class="popular-card">
                        <span class="popular-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
                        <div class="popular-body">
                            <h3 class="popular-title">GCSE Biology <span class="popular-board">(AQA)</span></h3>
                            <p class="popular-meta">Higher Tier · Paper 2 · June 2024</p>
                        </div>
                        <a class="btn btn-merit btn-sm popular-btn" href="#"
                            aria-label="View GCSE Biology AQA Higher Tier Paper 2 June 2024">View</a>
                    </div>
                </div>
                <div class="col">
                    <div class="popular-card">
                        <span class="popular-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
                        <div class="popular-body">
                            <h3 class="popular-title">GCSE English Language <span class="popular-board">(AQA)</span></h3>
                            <p class="popular-meta">Paper 1 · June 2024</p>
                        </div>
                        <a class="btn btn-merit btn-sm popular-btn" href="#"
                            aria-label="View GCSE English Language AQA Paper 1 June 2024">View</a>
                    </div>
                </div>
                <div class="col">
                    <div class="popular-card">
                        <span class="popular-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
                        <div class="popular-body">
                            <h3 class="popular-title">A Level Physics <span class="popular-board">(AQA)</span></h3>
                            <p class="popular-meta">Paper 2 · June 2024</p>
                        </div>
                        <a class="btn btn-merit btn-sm popular-btn" href="#"
                            aria-label="View A Level Physics AQA Paper 2 June 2024">View</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
                                                         7. WHY USE MERIT STUDY RESOURCES
                                                    ============================================================ -->
    <section class="why-section" aria-labelledby="whyHeading">
        <div class="container">
            <h2 class="section-heading text-center mb-4 mb-lg-5" id="whyHeading" data-reveal>Why Use Merit Study
                Resources?</h2>

            <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-lg-4" data-reveal-group>
                <div class="col">
                    <div class="why-item">
                        <span class="why-icon why-icon-green"><i class="bi bi-gift-fill" aria-hidden="true"></i></span>
                        <div>
                            <h3 class="why-title">Completely Free</h3>
                            <p class="why-text">No subscription required</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="why-item">
                        <span class="why-icon why-icon-blue"><i class="bi bi-bullseye" aria-hidden="true"></i></span>
                        <div>
                            <h3 class="why-title">Exam Focused</h3>
                            <p class="why-text">Resources matched to your syllabus</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="why-item">
                        <span class="why-icon why-icon-purple"><i class="bi bi-people-fill"
                                aria-hidden="true"></i></span>
                        <div>
                            <h3 class="why-title">Student Friendly</h3>
                            <p class="why-text">Easy to find and use</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="why-item">
                        <span class="why-icon why-icon-amber"><i class="bi bi-bar-chart-fill"
                                aria-hidden="true"></i></span>
                        <div>
                            <h3 class="why-title">Supporting Your Success</h3>
                            <p class="why-text">Helping you study with confidence</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
        });
    </script>
@endpush
