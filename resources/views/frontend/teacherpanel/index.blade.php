@extends('layouts.frontend-3')
@section('title', $course->title . ' — Teacher Library | Merit Study Resources')
@section('meta_description', \Illuminate\Support\Str::limit($course->intro ?: 'Ready-to-teach ' . $course->title . ' lessons: lesson plans, slides, classwork and answers.', 155))
@section('body_class', 'page-teacher')

@push('css')
    <link href="{{ asset('frontend/new/css/teacherspanel.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/new/css/teacherspanel-extra.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        $phase = $course->year->phase;
        $year = $course->year;
        $subject = $course->subject;
        $phaseYears = collect($filters)->firstWhere('slug', $phase->slug)['years'] ?? [];
        $yearSubjects = collect($phaseYears)->firstWhere('slug', $year->slug)['subjects'] ?? [];
        $docLabels = [
            'curriculum_map'  => ['Curriculum map', 'bi-map'],
            'weekly_planning' => ['Weekly planning', 'bi-calendar-week'],
            'term_assessment' => ['Term assessments', 'bi-clipboard-check'],
        ];
        $firstCode = $units->first()?->lessons->first()?->code;
    @endphp

    <!-- ===== Filters ===================================================== -->
    <section class="tl-filters" aria-label="Find resources">
        <div class="container-fluid px-lg-4">
            {{-- Works without JavaScript too: the Show button sends the choice to /teacher-resources --}}
            <form class="tl-filter-row" role="search" method="GET" action="{{ route('teacher-resources.index') }}">
                <div>
                    <label class="tl-field-label" for="fPhase">School phase</label>
                    <select class="form-select tl-select" id="fPhase" name="phase">
                        @foreach ($filters as $p)
                            <option value="{{ $p['slug'] }}" @selected($p['slug'] === $phase->slug)>{{ $p['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="tl-field-label" for="fYear">Year group</label>
                    <select class="form-select tl-select" id="fYear" name="year">
                        @foreach ($phaseYears as $y)
                            <option value="{{ $y['slug'] }}" @selected($y['slug'] === $year->slug)>{{ $y['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="tl-field-label" for="fSubject">Subject</label>
                    <select class="form-select tl-select" id="fSubject" name="subject">
                        @foreach ($yearSubjects as $s)
                            <option value="{{ $s['slug'] }}" @selected($s['slug'] === $subject->slug)>{{ $s['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="tl-search">
                    <label class="tl-field-label" for="fSearch">Search {{ $course->title }}</label>
                    <div class="search-shell">
                        <i class="bi bi-search search-icon" aria-hidden="true"></i>
                        <input class="form-control search-input" id="fSearch" type="search" autocomplete="off"
                               placeholder="Try {{ \Illuminate\Support\Str::lower($units->first()?->title ?? 'a topic') }} or a lesson code">
                        <kbd class="search-kbd">/</kbd>
                    </div>
                </div>
                <noscript><button class="btn btn-merit" type="submit">Show</button></noscript>
            </form>
        </div>
    </section>

    <!-- ===== Library ===================================================== -->
    <div class="tl-body">
        <div class="container-fluid px-lg-4">
            <div class="tl-layout">

                <!-- Topic sidebar -->
                <aside class="tl-sidebar" aria-label="{{ $course->title }} topics">
                    <p class="tl-side-title"><i class="bi bi-caret-down-fill"></i>{{ $year->name }} {{ \Illuminate\Support\Str::lower($subject->name) }} topics</p>
                    <p class="tl-side-sub">Teaching sequence</p>
                    <nav>
                        <ul class="list-unstyled topic-nav" id="topicNav">
                            @foreach ($units as $unit)
                                <li>
                                    <a class="topic-link {{ $loop->first ? 'is-active' : '' }}" href="#unit-{{ $unit->unit_number }}">
                                        <span class="topic-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="topic-name">{{ $unit->title }}</span>
                                        <span class="topic-count">{{ $unit->lessons->count() }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                    <div class="side-help">
                        <p class="side-help-title">Need a different order?</p>
                        <p>Every lesson stands alone, so you can teach the units in the order your school follows.</p>
                        <a href="{{ route('contact-us') }}">Talk to our team <i class="bi bi-arrow-right"></i></a>
                    </div>
                </aside>

                <!-- Main column -->
                <div class="tl-main">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb course-crumbs">
                            <li class="breadcrumb-item"><a href="{{ route('teacher-resources.index') }}">Teacher library</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('teacher-resources.index', ['phase' => $phase->slug]) }}">{{ $phase->name }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('teacher-resources.index', ['phase' => $phase->slug, 'year' => $year->slug]) }}">{{ $year->name }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $subject->name }}</li>
                        </ol>
                    </nav>

                    @if (session('error'))
                        <div class="tl-alert" role="alert"><i class="bi bi-exclamation-circle"></i><span>{{ session('error') }}</span></div>
                    @endif

                    <p class="tl-eyebrow">{{ $course->curriculum_label }}</p>
                    <h1 class="tl-title">{{ $course->title }}</h1>
                    <p class="tl-lead">{{ $course->intro ?: 'Find a topic, open a teaching step and choose the resources you need.' }}</p>
                    <ul class="list-unstyled tl-stats">
                        @if ($course->planned_weeks)
                            <li class="tl-stat"><i class="bi bi-calendar3"></i>{{ $course->planned_weeks }} planned weeks</li>
                        @endif
                        <li class="tl-stat"><i class="bi bi-list-ol"></i>{{ $lessonCount }} teaching {{ \Illuminate\Support\Str::plural('step', $lessonCount) }}</li>
                        @if ($course->has_weekly_homework)
                            <li class="tl-stat"><i class="bi bi-house"></i>Weekly homework</li>
                        @endif
                    </ul>

                    {{-- Course documents: shown only when the admin has uploaded them --}}
                    <div class="tl-tools">
                        @foreach ($docLabels as $type => [$label, $icon])
                            @php $docs = $documents->get($type, collect()); @endphp
                            @if ($docs->count() === 1)
                                <a class="tl-tool" href="{{ route('teacher-resources.document', [$course, $docs->first()]) }}" target="_blank" rel="noopener">
                                    <i class="bi {{ $icon }}"></i>{{ $label }}
                                </a>
                            @elseif ($docs->count() > 1)
                                <div class="dropdown">
                                    <button class="tl-tool dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi {{ $icon }}"></i>{{ $label }}
                                    </button>
                                    <ul class="dropdown-menu tl-tool-menu">
                                        @foreach ($docs as $doc)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('teacher-resources.document', [$course, $doc]) }}" target="_blank" rel="noopener">
                                                    {{ $doc->term ? ucfirst($doc->term) . ' term' : $doc->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if ($units->isEmpty())
                        <div class="lesson-list"><p class="tl-empty"><i class="bi bi-hourglass-split"></i>Lessons for {{ $course->title }} are being added. Please check back soon.</p></div>
                    @endif

                    {{-- One panel per topic. Without JavaScript they all show; the script shows one at a time. --}}
                    @foreach ($units as $unit)
                        <section class="tl-unit" id="unit-{{ $unit->unit_number }}" aria-labelledby="unitTitle{{ $unit->id }}">
                            <div class="unit-head">
                                <div>
                                    <h2 class="unit-title" id="unitTitle{{ $unit->id }}">{{ $unit->title }}</h2>
                                    <p class="unit-meta">
                                        Unit {{ $loop->iteration }}
                                        @if ($unit->first_week)
                                            · {{ $unit->first_week === $unit->last_week ? 'Week ' . $unit->first_week : 'Weeks ' . $unit->first_week . '–' . $unit->last_week }}
                                        @endif
                                    </p>
                                </div>
                                <span class="unit-count">{{ $unit->lessons->count() }} teaching {{ \Illuminate\Support\Str::plural('step', $unit->lessons->count()) }}</span>
                            </div>

                            <ol class="lesson-list">
                                @foreach ($unit->lessons as $lesson)
                                    @php $url = route('teacher-resources.lesson', [$course, $lesson->id, $lesson->slug]); @endphp
                                    <li class="lesson-row" data-search="{{ \Illuminate\Support\Str::lower($lesson->title . ' ' . $lesson->code . ' ' . $unit->title) }}">
                                        <span class="lesson-num" aria-hidden="true">{{ str_pad($lesson->lesson_number, 2, '0', STR_PAD_LEFT) }}</span>
                                        <div>
                                            <span class="lesson-topic-tag">{{ $unit->title }}</span>
                                            <h3 class="lesson-title"><a href="{{ $url }}" data-hl>{{ $lesson->title }}</a></h3>
                                            <p class="lesson-meta">
                                                @if ($lesson->week_number)
                                                    <span class="lesson-week">Week {{ $lesson->week_number }}</span>
                                                @endif
                                                <span class="lesson-code" data-hl>{{ $lesson->code }}</span>
                                                <span class="lesson-dot" aria-hidden="true"></span>
                                                @if ($lesson->file_types->isNotEmpty())
                                                    <span class="lesson-res">
                                                        @foreach ($lesson->file_types as $type)
                                                            <span><i class="bi bi-{{ $type->icon ?: 'file-earmark' }}"></i>{{ $type->name }}</span>
                                                        @endforeach
                                                    </span>
                                                @else
                                                    <span class="lesson-soon">Files coming soon</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="lesson-action">
                                            <a class="btn btn-merit btn-open" href="{{ $url }}">Open lesson <i class="bi bi-arrow-right"></i><span class="visually-hidden">: {{ $lesson->title }}</span></a>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </section>
                    @endforeach

                    {{-- Search results: the script fills this with copies of the matching rows above --}}
                    <section class="tl-results" id="tlResults" hidden aria-live="polite">
                        <div class="unit-head">
                            <div>
                                <h2 class="unit-title">Search results</h2>
                                <p class="unit-meta" id="resultsMeta"></p>
                            </div>
                            <span class="unit-count" id="resultsCount"></span>
                        </div>
                        <ol class="lesson-list is-search" id="resultsList"></ol>
                    </section>

                    @if ($units->isNotEmpty())
                        <div class="unit-foot" id="unitFoot">
                            <p class="unit-note"><i class="bi bi-info-circle"></i> Open a step to see and download its files.</p>
                            <div class="unit-pager">
                                <button class="btn btn-soft" type="button" id="prevUnit"><i class="bi bi-arrow-left"></i>Previous topic</button>
                                <button class="btn btn-soft" type="button" id="nextUnit">Next topic<i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
    (function () {
        // ---- Filters: phase → year → subject. A change opens the matching course.
        var FILTERS = @json($filters);
        var fPhase = document.getElementById('fPhase');
        var fYear = document.getElementById('fYear');
        var fSubject = document.getElementById('fSubject');

        function find(list, slug) { return list.filter(function (x) { return x.slug === slug; })[0]; }
        function go(phaseSlug, yearSlug, subjectSlug) {
            var phase = find(FILTERS, phaseSlug) || FILTERS[0];
            var year = find(phase.years, yearSlug) || phase.years[0];
            var subject = find(year.subjects, subjectSlug) || year.subjects[0];   // keeps the subject when that year has it
            if (subject) window.location.href = subject.url;
        }
        fPhase.addEventListener('change', function () { go(fPhase.value, null, fSubject.value); });
        fYear.addEventListener('change', function () { go(fPhase.value, fYear.value, fSubject.value); });
        fSubject.addEventListener('change', function () { go(fPhase.value, fYear.value, fSubject.value); });

        // ---- Topics: one unit at a time
        var units = Array.prototype.slice.call(document.querySelectorAll('.tl-unit'));
        var search = document.getElementById('fSearch');
        search.closest('form').addEventListener('submit', function (e) { e.preventDefault(); });
        if (!units.length) return;

        var links = Array.prototype.slice.call(document.querySelectorAll('#topicNav .topic-link'));
        var results = document.getElementById('tlResults');
        var resultsList = document.getElementById('resultsList');
        var foot = document.getElementById('unitFoot');
        var prev = document.getElementById('prevUnit');
        var next = document.getElementById('nextUnit');
        var current = 0;

        function setActive(i) {
            links.forEach(function (a, n) {
                a.classList.toggle('is-active', n === i);
                if (n === i) a.setAttribute('aria-current', 'true'); else a.removeAttribute('aria-current');
            });
            if (links[i] && window.innerWidth < 992) links[i].scrollIntoView({ block: 'nearest', inline: 'center' });
        }

        function showTopic(i, updateHash) {
            current = Math.max(0, Math.min(units.length - 1, i));
            search.value = '';
            results.hidden = true;
            units.forEach(function (u, n) { u.hidden = n !== current; });
            foot.hidden = false;
            prev.disabled = current === 0;
            next.disabled = current === units.length - 1;
            setActive(current);
            if (updateHash) history.replaceState(null, '', '#' + units[current].id);
        }

        function esc(s) { return s.replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
        function mark(el, q) {
            var text = el.textContent, i = text.toLowerCase().indexOf(q.toLowerCase());
            if (i > -1) el.innerHTML = esc(text.slice(0, i)) + '<mark>' + esc(text.slice(i, i + q.length)) + '</mark>' + esc(text.slice(i + q.length));
        }

        var COURSE = @json($course->title);
        var EXAMPLE = @json($firstCode ? substr($firstCode, 0, -4) : '');

        function runSearch(q) {
            q = q.trim();
            if (!q) { showTopic(current); return; }
            var hits = Array.prototype.slice.call(document.querySelectorAll('.tl-unit .lesson-row')).filter(function (row) {
                return row.getAttribute('data-search').indexOf(q.toLowerCase()) > -1;
            });
            units.forEach(function (u) { u.hidden = true; });
            foot.hidden = true;
            results.hidden = false;
            document.getElementById('resultsMeta').textContent = 'for “' + q + '” in ' + COURSE;
            document.getElementById('resultsCount').textContent = hits.length + (hits.length === 1 ? ' teaching step' : ' teaching steps');
            resultsList.innerHTML = hits.length ? '' :
                '<li class="tl-empty"><i class="bi bi-search"></i>No teaching steps match “' + esc(q) + '”.' +
                (EXAMPLE ? ' Try a topic name or a code like <strong>' + esc(EXAMPLE) + '</strong>.' : '') + '</li>';
            hits.forEach(function (row) {
                var copy = row.cloneNode(true);
                copy.querySelectorAll('[data-hl]').forEach(function (el) { mark(el, q); });
                resultsList.appendChild(copy);
            });
            links.forEach(function (a) { a.classList.remove('is-active'); a.removeAttribute('aria-current'); });
        }

        links.forEach(function (a, i) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                showTopic(i, true);
                if (window.innerWidth >= 992) units[i].scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
        prev.addEventListener('click', function () { showTopic(current - 1, true); });
        next.addEventListener('click', function () { showTopic(current + 1, true); });

        var timer;
        search.addEventListener('input', function () { clearTimeout(timer); timer = setTimeout(function () { runSearch(search.value); }, 120); });
        document.addEventListener('keydown', function (e) {
            if (e.key === '/' && document.activeElement !== search && !/input|textarea|select/i.test(document.activeElement.tagName)) {
                e.preventDefault(); search.focus();
            }
            if (e.key === 'Escape' && document.activeElement === search) { search.value = ''; runSearch(''); }
        });

        // open the topic named in the address (#unit-4), else the first one
        var start = units.findIndex(function (u) { return '#' + u.id === location.hash; });
        showTopic(start > -1 ? start : 0);
    })();
    </script>
@endpush
