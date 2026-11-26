@extends('layouts.frontend-3')

@section('content')
@php
    /* ------------------------------------------------------------------
     | Data: $categories (with subcategories.resubcategories)
     | Routes: past.papers.details, ajax.search.past-papers, home
     * ------------------------------------------------------------------ */
    $categories = collect($categories ?? [])->filter();
    $requested  = (string) request('level', '');
    $activeSlug = $categories->firstWhere('slug', $requested)?->slug ?? $categories->first()?->slug;

    $subjectCount = $categories->sum(fn ($c) => $c->subcategories->count());
    $specCount    = $categories->sum(fn ($c) => $c->subcategories->sum(fn ($s) => $s->resubcategories->count()));
    $boardLimit   = 4;

    // trending = popular subjects across all levels (unique names)
    $trending = $categories->flatMap(fn ($c) => $c->subcategories->where('most_popular', 1))
                    ->pluck('subcategory_name')->unique()->take(6)->values();

    /* ---------- icons ---------- */
    $icons = [
        'search'   => '<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>',
        'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'chevron'  => '<path d="M6 9l6 6 6-6"/>',
        'filter'   => '<path d="M4 5h16l-6 8v6l-4-2v-4z"/>',
        'star'     => '<path d="M12 3.5l2.6 5.3 5.9.9-4.2 4.1 1 5.8L12 16.9l-5.3 2.7 1-5.8-4.2-4.1 5.9-.9z"/>',
        'check'    => '<path d="M20 6 9 17l-5-5"/>',
        'trend'    => '<path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/>',
        'file'     => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h4"/>',
        'shield'   => '<path d="M12 3l8 3v6c0 4.5-3.4 8.3-8 9-4.6-.7-8-4.5-8-9V6z"/><path d="M9 12l2 2 4-4"/>',
        'layers'   => '<path d="M12 3l9 5-9 5-9-5z"/><path d="M3 13l9 5 9-5"/>',
        'cap'      => '<path d="M2 9l10-5 10 5-10 5z"/><path d="M6 11v5c0 1.5 2.7 3 6 3s6-1.5 6-3v-5"/>',
        'award'    => '<circle cx="12" cy="9" r="6"/><path d="M8.5 14 7 22l5-3 5 3-1.5-8"/>',
        'globe'    => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/>',
        'book'     => '<path d="M4 5a2 2 0 0 1 2-2h13v16H6a2 2 0 0 0-2 2z"/><path d="M4 19V5M8 7h7"/>',
        'leaf'     => '<path d="M5 19c0-8 6-14 15-14 0 9-6 15-14 15"/><path d="M5 19l8-8"/>',
        'flask'    => '<path d="M9 3h6M10 3v6l-5 9a2 2 0 0 0 1.7 3h10.6a2 2 0 0 0 1.7-3l-5-9V3"/><path d="M7.5 14h9"/>',
        'atom'     => '<circle cx="12" cy="12" r="1.5"/><ellipse cx="12" cy="12" rx="10" ry="4"/><ellipse cx="12" cy="12" rx="10" ry="4" transform="rotate(60 12 12)"/><ellipse cx="12" cy="12" rx="10" ry="4" transform="rotate(120 12 12)"/>',
        'sigma'    => '<path d="M17 5H7l5 7-5 7h10"/>',
        'columns'  => '<path d="M3 21h18M5 21V10M19 21V10M9.7 21V10M14.3 21V10M2 10l10-6 10 6"/>',
        'chart'    => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
        'monitor'  => '<rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4"/>',
        'chat'     => '<path d="M21 12a8 8 0 0 1-11.6 7.1L4 20l1-4.6A8 8 0 1 1 21 12z"/>',
        'people'   => '<circle cx="9" cy="8" r="3"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M16 4a3 3 0 0 1 0 6M21 20c0-2.6-1.7-4.8-4-5.6"/>',
        'palette'  => '<path d="M12 3a9 9 0 1 0 0 18c1.1 0 1.5-.9 1.5-1.7 0-1.3 1-1.8 2-1.8H18a3 3 0 0 0 3-3C21 7 17 3 12 3z"/><circle cx="7.5" cy="11" r="1"/><circle cx="10.5" cy="7.5" r="1"/><circle cx="15" cy="8" r="1"/>',
    ];
    $icon = fn (string $n, string $class = '') =>
        '<svg class="mp-ico ' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" '
        . 'stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . ($icons[$n] ?? '') . '</svg>';

    /* ---------- subject → icon + colour ---------- */
    $subjectMap = [
        'leaf'    => ['biolog', 'environment', 'nature'],
        'flask'   => ['chemi'],
        'atom'    => ['physic', 'science'],
        'sigma'   => ['math', 'statistic', 'further'],
        'book'    => ['english', 'literature', 'reading', 'religio', 'classic'],
        'columns' => ['history', 'politic', 'law', 'government'],
        'globe'   => ['geograph'],
        'chart'   => ['econom', 'business', 'account', 'finance'],
        'monitor' => ['computer', 'ict', 'information'],
        'chat'    => ['french', 'spanish', 'german', 'arabic', 'urdu', 'bengali', 'bangla', 'chinese', 'mandarin', 'italian', 'latin', 'language'],
        'people'  => ['psycholog', 'sociolog'],
        'palette' => ['art', 'design', 'music', 'drama', 'media', 'photograph'],
    ];
    $tones = ['leaf' => 'green', 'flask' => 'blue', 'atom' => 'purple', 'sigma' => 'navy', 'book' => 'rose',
              'columns' => 'amber', 'globe' => 'teal', 'chart' => 'amber', 'monitor' => 'blue', 'chat' => 'rose',
              'people' => 'purple', 'palette' => 'teal', 'file' => 'green'];
    $subjectIcon = function (string $name) use ($subjectMap) {
        $n = mb_strtolower($name);
        foreach ($subjectMap as $key => $words) {
            foreach ($words as $w) {
                if (str_contains($n, $w)) return $key;
            }
        }
        return 'file';
    };

    /* ---------- level → icon ---------- */
    $levelIcon = function (string $name) {
        $n = mb_strtolower($name);
        return match (true) {
            str_contains($n, 'igcse')                              => 'globe',
            str_contains($n, 'as ')  || str_starts_with($n, 'as')  => 'layers',
            str_contains($n, 'a level') || str_contains($n, 'a-level') => 'award',
            str_contains($n, 'gcse')                               => 'book',
            default                                                => 'cap',
        };
    };

    /* ---------- exam board → badge ---------- */
    $boardBadge = function (string $name) {
        $n = mb_strtolower($name);
        $tone = match (true) {
            str_contains($n, 'aqa')                                        => 'purple',
            str_contains($n, 'edexcel') || str_contains($n, 'pearson')    => 'blue',
            str_contains($n, 'ocr')                                        => 'teal',
            str_contains($n, 'cie') || str_contains($n, 'cambridge') || str_contains($n, 'caie') => 'rose',
            str_contains($n, 'wjec') || str_contains($n, 'eduqas')        => 'amber',
            default                                                        => 'navy',
        };
        $first = preg_split('/\s+/', trim($name))[0] ?? $name;
        $label = (mb_strtoupper($first) === $first && mb_strlen($first) <= 4)
            ? $first
            : mb_strtoupper(mb_substr($first, 0, 2));
        return [$label, $tone];
    };
@endphp

<div class="mp-page">

    <!-- ============================= HERO ============================= -->
    <section class="mp-hero">
        <div class="mp-hero-bg" aria-hidden="true"></div>
        <div class="container">
            <nav aria-label="Breadcrumb">
                <ol class="mp-crumbs">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li aria-current="page">Past papers</li>
                </ol>
            </nav>

            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="mp-pill">{!! $icon('shield') !!} Exam-board accurate · Mark schemes included</span>
                    <h1 class="mp-title">Every past paper,<br>mapped to <span>your exam board.</span></h1>
                    <p class="mp-lead">Question papers and mark schemes for A Level, AS Level, GCSE and IGCSE — organised by subject and specification so you always practise the right paper.</p>

                    <!-- search -->
                    <div class="mp-search" id="mpSearch">
                        <label class="visually-hidden" for="mpSearchInput">Search past papers</label>
                        <div class="mp-search-bar">
                            {!! $icon('search', 'mp-search-ico') !!}
                            <input type="text" id="mpSearchInput" autocomplete="off" spellcheck="false"
                                   placeholder="Search subject, exam board or unit code…"
                                   role="combobox" aria-expanded="false" aria-controls="mpSearchResults" aria-autocomplete="list">
                            <span class="mp-spinner" id="mpSpinner" hidden></span>
                            <kbd class="mp-kbd" aria-hidden="true">/</kbd>
                            <button type="button" class="mp-search-btn" id="mpSearchBtn">Search</button>
                        </div>
                        <div class="mp-search-panel" id="mpSearchPanel" hidden>
                            <ul class="mp-search-results" id="mpSearchResults" role="listbox" aria-label="Search results"></ul>
                        </div>
                    </div>

                    @if($trending->isNotEmpty())
                        <div class="mp-trending">
                            <span>{!! $icon('trend') !!} Trending:</span>
                            @foreach($trending as $t)
                                <button type="button" class="mp-trend" data-term="{{ $t }}">{{ $t }}</button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- decorative paper stack -->
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="mp-art" aria-hidden="true">
                        <div class="mp-sheet mp-sheet-back">
                            <span class="mp-sheet-tag is-ms">Mark scheme</span>
                            <span class="mp-line w-80"></span><span class="mp-line w-60"></span><span class="mp-line w-70"></span>
                        </div>
                        <div class="mp-sheet mp-sheet-front">
                            <div class="mp-sheet-head">
                                <span class="mp-sheet-tag">Question paper</span>
                                <span class="mp-sheet-code">8461/1H</span>
                            </div>
                            <p class="mp-sheet-title">Biology · Paper 1</p>
                            <p class="mp-sheet-sub">June 2024 · 1 hour 45 minutes</p>
                            <span class="mp-line w-90"></span><span class="mp-line w-70"></span><span class="mp-line w-80"></span>
                            <span class="mp-line w-50"></span>
                            <div class="mp-sheet-marks"><span></span><span></span><span></span><b>[6 marks]</b></div>
                        </div>
                        <div class="mp-float mp-float-a">{!! $icon('check') !!} Mark scheme ready</div>
                        <div class="mp-float mp-float-b"><strong>{{ number_format($specCount) }}</strong> specifications</div>
                    </div>
                </div>
            </div>

            <ul class="mp-stats list-unstyled">
                <li><strong>{{ $categories->count() }}</strong> qualification levels</li>
                <li><strong>{{ number_format($subjectCount) }}</strong> subjects</li>
                <li><strong>{{ number_format($specCount) }}</strong> exam-board specifications</li>
            </ul>
        </div>
    </section>

    @if($categories->isNotEmpty())
        <!-- ============================= LIBRARY ============================= -->
        <div class="container mp-body">
            <div class="row g-4">

                <!-- SIDEBAR -->
                <div class="col-lg-4 col-xl-3">
                    <aside class="mp-side" aria-label="Browse by level">
                        <p class="mp-side-title">Browse by level</p>

                        @foreach($categories as $category)
                            @php
                                $isActive     = $category->slug === $activeSlug;
                                $sideSubjects = $category->subcategories->sortBy('subcategory_name', SORT_NATURAL | SORT_FLAG_CASE)->values();
                                $sideGroups   = [
                                    ['p', 'Most popular', 'star', $sideSubjects->where('most_popular', 1)],
                                    ['a', 'All subjects', 'book', $sideSubjects],
                                ];
                            @endphp
                            <div class="mp-acc {{ $isActive ? 'is-open' : '' }}">
                                <button type="button" class="mp-level" id="tab-{{ $category->slug }}"
                                        aria-controls="panel-{{ $category->slug }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                                        data-level="{{ $category->slug }}">
                                    <span class="mp-level-ico">{!! $icon($levelIcon($category->category_name)) !!}</span>
                                    <span class="mp-level-text">
                                        <span class="mp-level-name">{{ $category->category_name }}</span>
                                        <span class="mp-level-count">{{ $category->subcategories->count() }} {{ $category->subcategories->count() === 1 ? 'subject' : 'subjects' }}</span>
                                    </span>
                                    {!! $icon('chevron', 'mp-level-chev') !!}
                                </button>

                                <div class="mp-acc-body" @if(!$isActive) hidden @endif>
                                    @foreach($sideGroups as [$gKey, $gLabel, $gIcon, $gList])
                                        @if($gList->isNotEmpty())
                                            <p class="mp-acc-label">{!! $icon($gIcon) !!} {{ $gLabel }}</p>
                                            <ul class="mp-subj-list">
                                                @foreach($gList as $sub)
                                                    @php $bid = 'side-' . $gKey . '-' . $sub->id; @endphp
                                                    <li>
                                                        @if($sub->resubcategories->isNotEmpty())
                                                            <button type="button" class="mp-subj" aria-expanded="false" aria-controls="{{ $bid }}">
                                                                <span class="mp-subj-name" title="{{ $sub->subcategory_name }}">{{ $sub->subcategory_name }}</span>
                                                                <span class="mp-subj-count">{{ $sub->resubcategories->count() }}</span>
                                                                {!! $icon('chevron', 'mp-subj-chev') !!}
                                                            </button>
                                                            <ul class="mp-subj-boards" id="{{ $bid }}" hidden>
                                                                @foreach($sub->resubcategories as $board)
                                                                    @php [$abbr, $btone] = $boardBadge($board->resubcategory_name); @endphp
                                                                    <li>
                                                                        <a href="{{ route('past.papers.details', [$category->slug, $sub->slug, $board->slug]) }}">
                                                                            <span class="mp-avatar mp-avatar-sm tone-{{ $btone }}">{{ $abbr }}</span>
                                                                            <span class="mp-subj-board-name">{{ $board->resubcategory_name }}</span>
                                                                            @if($board->unit_code)<span class="mp-code">{{ $board->unit_code }}</span>@endif
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <span class="mp-subj is-soon">
                                                                <span class="mp-subj-name">{{ $sub->subcategory_name }}</span>
                                                                <span class="mp-subj-soon">Soon</span>
                                                            </span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </aside>
                </div>

                <!-- SUBJECT GRID -->
                <div class="col-lg-8 col-xl-9">
            <div class="mp-toolbar">
                <div>
                    <h2 class="mp-h2" id="mpHeading"></h2>
                    <p class="mp-count" id="mpCount" aria-live="polite"></p>
                </div>
                <div class="mp-filter">
                    {!! $icon('filter') !!}
                    <label class="visually-hidden" for="mpFilter">Filter subjects</label>
                    <input type="text" id="mpFilter" placeholder="Filter subjects…" autocomplete="off">
                </div>
            </div>

            @foreach($categories as $category)
                @php
                    $isActive = $category->slug === $activeSlug;
                    $subjects = $category->subcategories->sortBy('subcategory_name', SORT_NATURAL | SORT_FLAG_CASE)->values();
                    $popular  = $subjects->where('most_popular', 1);
                @endphp
                <section class="mp-panel" role="region" id="panel-{{ $category->slug }}" aria-labelledby="tab-{{ $category->slug }}"
                         data-level-name="{{ $category->category_name }}" @if(!$isActive) hidden @endif>

                    @if($popular->isNotEmpty())
                        <div class="mp-popular">
                            <span class="mp-popular-label">{!! $icon('star') !!} Most popular</span>
                            @foreach($popular as $sub)
                                @php $ik = $subjectIcon($sub->subcategory_name); @endphp
                                <a class="mp-popular-link tone-{{ $tones[$ik] }}" href="#subject-{{ $sub->id }}" data-jump="subject-{{ $sub->id }}">
                                    {!! $icon($ik) !!} {{ $sub->subcategory_name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @if($subjects->isNotEmpty())
                        <div class="mp-grid">
                            @foreach($subjects as $sub)
                                @php
                                    $boards = $sub->resubcategories;
                                    $ik     = $subjectIcon($sub->subcategory_name);
                                    $hay    = mb_strtolower(implode(' ', array_merge(
                                        [$sub->subcategory_name],
                                        $boards->pluck('resubcategory_name')->all(),
                                        $boards->pluck('unit_code')->all()
                                    )));
                                @endphp
                                <article class="mp-card tone-{{ $tones[$ik] }}" id="subject-{{ $sub->id }}" data-search="{{ $hay }}">
                                    <header class="mp-card-head">
                                        <span class="mp-card-ico">{!! $icon($ik) !!}</span>
                                        <div class="mp-card-titles">
                                            <h3 class="mp-card-name">{{ $sub->subcategory_name }}</h3>
                                            <p class="mp-card-meta">
                                                {{ $boards->count() }} {{ $boards->count() === 1 ? 'specification' : 'specifications' }}
                                            </p>
                                        </div>
                                        @if((int) $sub->most_popular === 1)
                                            <span class="mp-badge">{!! $icon('star') !!} Popular</span>
                                        @endif
                                    </header>

                                    @if($boards->isNotEmpty())
                                        <ul class="mp-boards">
                                            @foreach($boards as $board)
                                                @php [$abbr, $btone] = $boardBadge($board->resubcategory_name); @endphp
                                                <li @if($loop->index >= $boardLimit) class="is-extra" hidden @endif>
                                                    <a class="mp-board" href="{{ route('past.papers.details', [$category->slug, $sub->slug, $board->slug]) }}">
                                                        <span class="mp-avatar tone-{{ $btone }}">{{ $abbr }}</span>
                                                        <span class="mp-board-name">{{ $board->resubcategory_name }}</span>
                                                        @if($board->unit_code)
                                                            <span class="mp-code">{{ $board->unit_code }}</span>
                                                        @endif
                                                        {!! $icon('arrow', 'mp-board-go') !!}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @if($boards->count() > $boardLimit)
                                            <button type="button" class="mp-more" aria-expanded="false" data-more="Show all {{ $boards->count() }} boards">
                                                <span>Show all {{ $boards->count() }} boards</span> {!! $icon('chevron') !!}
                                            </button>
                                        @endif
                                    @else
                                        <p class="mp-soon">{!! $icon('file') !!} Papers coming soon</p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    @endif

                    <div class="mp-empty" data-empty @if($subjects->isNotEmpty()) hidden @endif>
                        <span class="mp-empty-ico">{!! $icon('search') !!}</span>
                        <p class="mp-empty-title">No subjects found</p>
                        <p>Try another spelling, or search every level with the search bar above.</p>
                    </div>
                </section>
            @endforeach

                </div>
            </div>

            <!-- CTA -->
            <aside class="mp-cta">
                <div class="mp-cta-copy">
                    <p class="mp-cta-title">Can't find your specification?</p>
                    <p>Tell us the level, subject and exam board — our tutors will add the papers to the library.</p>
                </div>
                <a class="mp-cta-btn" href="{{ url('contact') }}">Request papers {!! $icon('arrow') !!}</a>
            </aside>
        </div>
    @else
        <div class="container mp-body">
            <div class="mp-empty">
                <span class="mp-empty-ico">{!! $icon('file') !!}</span>
                <p class="mp-empty-title">Past papers are on their way</p>
                <p>We're adding papers to the library — please check back soon.</p>
            </div>
        </div>
    @endif
</div>

<style>
/* =====================================================================
   Merit — Past papers library (self-contained; all classes prefixed mp-)
   ===================================================================== */
.mp-page {
  --mp-green: #168a45; --mp-green-2: #1fb15a; --mp-green-dark: #0e6d39; --mp-green-soft: #eaf6ef;
  --mp-navy: #0f2a44; --mp-navy-2: #0a1e32; --mp-text: #203344; --mp-muted: #667a8a; --mp-ink-2: #4a5f70;
  --mp-line: #e5ebe8; --mp-soft: #f6f9f7; --mp-border: #dde5e1;
  --mp-r-sm: 10px; --mp-r: 14px; --mp-r-lg: 20px;
  --mp-ease: 180ms cubic-bezier(.4, 0, .2, 1);
  --tone: #168a45; --tone-bg: #eaf6ef;
  color: var(--mp-text);
  background: #fafbfb;
  font-feature-settings: "cv05", "ss01";
}
.mp-page *, .mp-page *::before, .mp-page *::after { box-sizing: border-box; }
.mp-page [hidden] { display: none !important; }
.mp-page .visually-hidden { position: absolute !important; width: 1px !important; height: 1px !important; overflow: hidden !important; clip: rect(0,0,0,0) !important; white-space: nowrap !important; border: 0 !important; padding: 0 !important; margin: -1px !important; }
.mp-page a:focus-visible, .mp-page button:focus-visible { outline: 2px solid var(--mp-green-2); outline-offset: 2px; border-radius: 8px; }
.mp-ico { width: 1em; height: 1em; flex: none; }

/* tones */
.tone-green  { --tone: #168a45; --tone-bg: #e6f5ec; }
.tone-blue   { --tone: #1f6fd1; --tone-bg: #e8f1fd; }
.tone-purple { --tone: #6a43c2; --tone-bg: #f0ebfb; }
.tone-amber  { --tone: #c27a14; --tone-bg: #fdf2e1; }
.tone-rose   { --tone: #c2385a; --tone-bg: #fdecf0; }
.tone-teal   { --tone: #0f8a80; --tone-bg: #e3f5f3; }
.tone-navy   { --tone: #24476b; --tone-bg: #e9eff6; }

/* ---------- hero ---------- */
.mp-hero { position: relative; overflow: hidden; padding: 1.75rem 0 3rem; color: #fff; background: linear-gradient(160deg, var(--mp-navy) 0%, var(--mp-navy-2) 100%); }
.mp-hero-bg {
  position: absolute; inset: 0; pointer-events: none;
  background:
    radial-gradient(600px 380px at 85% 20%, rgba(31, 177, 90, .28), transparent 70%),
    radial-gradient(500px 300px at 0% 100%, rgba(31, 111, 209, .22), transparent 70%),
    radial-gradient(rgba(255, 255, 255, .07) 1px, transparent 1.2px) 0 0 / 24px 24px;
  mask-image: linear-gradient(180deg, #000 60%, transparent);
}
.mp-hero .container { position: relative; }
.mp-crumbs { display: flex; flex-wrap: wrap; gap: .4rem; margin: 0 0 2.25rem; padding: 0; list-style: none; font-size: .84rem; color: #c9d6e2; }
.mp-crumbs li { display: inline-flex; align-items: center; gap: .4rem; }
.mp-crumbs li + li::before { content: "›"; color: #5e7a93; }
.mp-crumbs a { color: #94aabd; text-decoration: none; }
.mp-crumbs a:hover { color: #fff; }

.mp-pill {
  display: inline-flex; align-items: center; gap: .45rem;
  padding: .38rem .85rem; margin-bottom: 1.25rem;
  border: 1px solid rgba(255, 255, 255, .14); border-radius: 999px;
  background: rgba(255, 255, 255, .06); backdrop-filter: blur(6px);
  font-size: .8rem; font-weight: 600; color: #cfe9da;
}
.mp-pill .mp-ico { color: #4fd18b; }
.mp-title { margin: 0 0 1rem; font-size: clamp(2.1rem, 1.2rem + 3vw, 3.4rem); font-weight: 800; line-height: 1.06; letter-spacing: -.035em; color: #fff; }
.mp-title span { background: linear-gradient(90deg, #4fd18b, #a6eec4); -webkit-background-clip: text; background-clip: text; color: transparent; }
.mp-lead { max-width: 34rem; margin: 0 0 1.75rem; font-size: 1.05rem; line-height: 1.65; color: #b6c6d5; }

/* search */
.mp-search { position: relative; z-index: 30; max-width: 40rem; }
.mp-search-bar {
  display: flex; align-items: center; gap: .7rem; height: 62px; padding: 0 .45rem 0 1.15rem;
  border-radius: 16px; background: #fff;
  box-shadow: 0 1px 2px rgba(0, 0, 0, .1), 0 18px 40px -12px rgba(0, 0, 0, .45);
  transition: box-shadow var(--mp-ease);
}
.mp-search-bar:focus-within { box-shadow: 0 0 0 4px rgba(79, 209, 139, .35), 0 18px 40px -12px rgba(0, 0, 0, .45); }
.mp-search-ico { font-size: 1.2rem; color: #8ea1ae; }
.mp-search-bar input { flex: 1 1 auto; min-width: 0; height: 100%; border: 0; outline: 0; background: transparent; font-size: 1rem; color: var(--mp-text); }
.mp-search-bar input::placeholder { color: #98a8b3; }
.mp-kbd { padding: .1rem .45rem; border: 1px solid var(--mp-border); border-radius: 6px; background: var(--mp-soft); box-shadow: none; font-family: inherit; font-size: .72rem; font-weight: 600; color: var(--mp-muted); }
.mp-search-btn {
  height: 48px; padding: 0 1.5rem; border: 0; border-radius: 12px;
  background: linear-gradient(180deg, var(--mp-green-2), var(--mp-green));
  font-size: .95rem; font-weight: 700; color: #fff; cursor: pointer;
  box-shadow: 0 6px 14px -6px rgba(22, 138, 69, .7);
  transition: transform var(--mp-ease), box-shadow var(--mp-ease);
}
.mp-search-btn:hover { transform: translateY(-1px); box-shadow: 0 10px 18px -8px rgba(22, 138, 69, .8); }
.mp-spinner { width: 18px; height: 18px; border: 2px solid #dbe5df; border-top-color: var(--mp-green); border-radius: 50%; animation: mp-spin .7s linear infinite; }
@keyframes mp-spin { to { transform: rotate(360deg); } }

.mp-search-panel { position: absolute; top: calc(100% + 8px); left: 0; right: 0; max-height: 22rem; overflow-y: auto; border-radius: 14px; background: #fff; box-shadow: 0 24px 50px -12px rgba(10, 30, 50, .45); color: var(--mp-text); }
.mp-search-results { margin: 0; padding: .4rem; list-style: none; }
.mp-result { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: .7rem .85rem; border-radius: 10px; text-decoration: none; color: inherit; }
.mp-result:hover, .mp-result.is-active { background: var(--mp-green-soft); text-decoration: none; color: inherit; }
.mp-result-main { display: flex; flex-direction: column; min-width: 0; }
.mp-result-title { font-size: .95rem; font-weight: 700; color: var(--mp-navy); }
.mp-result-level { font-size: .78rem; color: var(--mp-muted); }
.mp-result-tags { display: flex; align-items: center; gap: .4rem; flex: none; }
.mp-result-board { padding: .12rem .55rem; border-radius: 999px; background: var(--mp-soft); border: 1px solid var(--mp-border); font-size: .76rem; font-weight: 600; color: var(--mp-navy); }
.mp-result-empty { padding: 1rem .85rem; font-size: .9rem; color: var(--mp-muted); }

.mp-trending { display: flex; flex-wrap: wrap; align-items: center; gap: .45rem; margin-top: 1.1rem; font-size: .84rem; color: #8fa6ba; }
.mp-trending > span { display: inline-flex; align-items: center; gap: .35rem; margin-right: .2rem; font-weight: 600; }
.mp-trend { padding: .3rem .8rem; border: 1px solid rgba(255, 255, 255, .16); border-radius: 999px; background: rgba(255, 255, 255, .05); font-size: .82rem; font-weight: 600; color: #e3edf5; cursor: pointer; transition: background var(--mp-ease), border-color var(--mp-ease); }
.mp-trend:hover { background: rgba(79, 209, 139, .16); border-color: rgba(79, 209, 139, .5); color: #fff; }

.mp-stats { display: flex; flex-wrap: wrap; gap: .75rem 2.5rem; margin: 2.75rem 0 0; padding: 1.25rem 0 0; border-top: 1px solid rgba(255, 255, 255, .1); font-size: .9rem; color: #9fb3c5; }
.mp-stats strong { margin-right: .3rem; font-size: 1.25rem; font-weight: 800; letter-spacing: -.02em; color: #fff; font-variant-numeric: tabular-nums; }

/* decorative paper stack */
.mp-art { position: relative; height: 340px; }
.mp-sheet { position: absolute; width: 270px; padding: 1.25rem; border-radius: 14px; background: #fff; color: var(--mp-text); box-shadow: 0 30px 60px -20px rgba(0, 0, 0, .55); }
.mp-sheet-back { top: 10px; right: 20px; height: 300px; transform: rotate(7deg); background: #eef6f1; }
.mp-sheet-front { top: 30px; right: 95px; height: 300px; transform: rotate(-4deg); }
.mp-sheet-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: .9rem; }
.mp-sheet-tag { display: inline-block; padding: .15rem .55rem; border-radius: 999px; background: #e8f1fd; font-size: .66rem; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; color: #1f6fd1; }
.mp-sheet-tag.is-ms { display: block; width: max-content; margin: 0 0 1rem auto; background: #d7efe1; color: var(--mp-green-dark); }
.mp-sheet-code { font-family: ui-monospace, Menlo, monospace; font-size: .72rem; color: var(--mp-muted); }
.mp-sheet-title { margin: 0; font-size: 1.05rem; font-weight: 800; color: var(--mp-navy); }
.mp-sheet-sub { margin: .15rem 0 1rem; font-size: .75rem; color: var(--mp-muted); }
.mp-line { display: block; height: 8px; margin-bottom: .55rem; border-radius: 4px; background: #e9eef0; }
.mp-sheet-back .mp-line { background: #cfe5d8; }
.w-50 { width: 50%; } .w-60 { width: 60%; } .w-70 { width: 70%; } .w-80 { width: 80%; } .w-90 { width: 90%; }
.mp-sheet-marks { display: flex; align-items: center; gap: .35rem; margin-top: 1.1rem; }
.mp-sheet-marks span { width: 22px; height: 22px; border: 1.5px solid #cfd9d4; border-radius: 5px; }
.mp-sheet-marks b { margin-left: auto; font-size: .72rem; color: var(--mp-muted); }
.mp-float { position: absolute; display: inline-flex; align-items: center; gap: .45rem; padding: .6rem .9rem; border-radius: 12px; background: #fff; box-shadow: 0 18px 34px -14px rgba(0, 0, 0, .5); font-size: .82rem; font-weight: 700; color: var(--mp-navy); animation: mp-bob 5s ease-in-out infinite; }
.mp-float-a { left: 10px; bottom: 50px; }
.mp-float-a .mp-ico { padding: 3px; width: 20px; height: 20px; border-radius: 50%; background: var(--mp-green); color: #fff; }
.mp-float-b { right: 0; top: -6px; animation-delay: -2.5s; }
.mp-float-b strong { font-size: 1.05rem; color: var(--mp-green); }
@keyframes mp-bob { 50% { transform: translateY(-8px); } }

/* ---------- sidebar ---------- */
.mp-side {
  position: sticky; top: 1.5rem; max-height: calc(100vh - 3rem); overflow-y: auto; scrollbar-width: thin;
  padding: .75rem; border: 1px solid var(--mp-line); border-radius: var(--mp-r-lg); background: #fff;
  box-shadow: 0 1px 2px rgba(16, 44, 70, .04), 0 14px 30px -22px rgba(16, 44, 70, .35);
}
.mp-side-title { margin: .2rem .5rem .6rem; font-size: .7rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--mp-muted); }
.mp-acc + .mp-acc { margin-top: .2rem; }
.mp-level {
  display: flex; align-items: center; gap: .75rem; width: 100%; padding: .55rem .6rem;
  border: 1px solid transparent; border-radius: 12px; background: transparent; text-align: left; cursor: pointer;
  transition: background var(--mp-ease), border-color var(--mp-ease);
}
.mp-level:hover { background: var(--mp-soft); }
.mp-level-ico { display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; flex: none; border-radius: 10px; background: var(--mp-soft); font-size: 1.1rem; color: var(--mp-navy); transition: background var(--mp-ease), color var(--mp-ease); }
.mp-level-text { display: flex; flex-direction: column; flex: 1 1 auto; min-width: 0; }
.mp-level-name { font-size: .95rem; font-weight: 800; letter-spacing: -.01em; color: var(--mp-navy); }
.mp-level-count { font-size: .76rem; color: var(--mp-muted); }
.mp-level-chev { color: var(--mp-muted); transition: transform var(--mp-ease); }
.mp-acc.is-open > .mp-level { background: var(--mp-green-soft); }
.mp-acc.is-open .mp-level-ico { background: linear-gradient(160deg, var(--mp-green-2), var(--mp-green)); color: #fff; }
.mp-acc.is-open .mp-level-chev { transform: rotate(180deg); color: var(--mp-green-dark); }

.mp-acc-body { padding: .2rem .15rem .5rem .35rem; }
.mp-acc-label { display: flex; align-items: center; gap: .35rem; margin: .8rem .45rem .3rem; font-size: .66rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: var(--mp-muted); }
.mp-acc-label .mp-ico { font-size: .8rem; }
.mp-acc-label:first-child .mp-ico { color: #e0a030; }
.mp-subj-list { display: grid; gap: 1px; margin: 0; padding: 0; list-style: none; }
.mp-subj {
  display: flex; align-items: center; gap: .5rem; width: 100%; padding: .45rem .5rem;
  border: 0; border-radius: 8px; background: transparent; text-align: left; cursor: pointer;
  font-size: .87rem; font-weight: 600; color: var(--mp-text);
  transition: background var(--mp-ease), color var(--mp-ease);
}
.mp-subj:hover { background: var(--mp-soft); color: var(--mp-navy); }
.mp-subj[aria-expanded="true"] { background: var(--mp-green-soft); color: var(--mp-green-dark); }
.mp-subj-name { flex: 1 1 auto; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.mp-subj-count { min-width: 22px; padding: .05rem .4rem; border-radius: 999px; background: #eef2f0; text-align: center; font-size: .68rem; font-weight: 700; color: var(--mp-muted); }
.mp-subj-chev { font-size: .85rem; color: #a6b5ad; transition: transform var(--mp-ease); }
.mp-subj[aria-expanded="true"] .mp-subj-chev { transform: rotate(180deg); color: var(--mp-green); }
.mp-subj.is-soon { cursor: default; color: var(--mp-muted); }
.mp-subj.is-soon:hover { background: transparent; color: var(--mp-muted); }
.mp-subj-soon { font-size: .68rem; font-weight: 700; color: #a6b5ad; }
.mp-subj-boards { display: grid; gap: 1px; margin: .15rem 0 .4rem .75rem; padding: 0 0 0 .55rem; list-style: none; border-left: 2px solid var(--mp-line); }
.mp-subj-boards a { display: flex; align-items: center; gap: .5rem; padding: .35rem .45rem; border-radius: 8px; font-size: .82rem; font-weight: 500; text-decoration: none; color: var(--mp-text); transition: background var(--mp-ease), color var(--mp-ease); }
.mp-subj-boards a:hover { background: var(--mp-soft); color: var(--mp-navy); text-decoration: none; }
.mp-subj-board-name { flex: 1 1 auto; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.mp-subj-boards .mp-code { font-size: .66rem; }
.mp-avatar-sm { min-width: 30px; height: 22px; border-radius: 6px; font-size: .56rem; }

/* ---------- body ---------- */
.mp-body { padding-top: 2.25rem; padding-bottom: 4.5rem; }
.mp-toolbar { display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem; }
.mp-h2 { margin: 0 0 .2rem; font-size: 1.5rem; font-weight: 800; letter-spacing: -.025em; color: var(--mp-navy); }
.mp-count { margin: 0; font-size: .9rem; color: var(--mp-muted); }
.mp-count strong { color: var(--mp-navy); }
.mp-filter { display: flex; align-items: center; gap: .5rem; height: 46px; padding: 0 .9rem; border: 1px solid var(--mp-border); border-radius: 12px; background: #fff; color: #8ea1ae; transition: border-color var(--mp-ease), box-shadow var(--mp-ease); }
.mp-filter:focus-within { border-color: var(--mp-green); box-shadow: 0 0 0 4px rgba(22, 138, 69, .1); }
.mp-filter input { width: 16rem; border: 0; outline: 0; background: transparent; font-size: .9rem; color: var(--mp-text); }

.mp-popular { display: flex; flex-wrap: wrap; align-items: center; gap: .5rem; margin-bottom: 1.75rem; }
.mp-popular-label { display: inline-flex; align-items: center; gap: .35rem; margin-right: .3rem; font-size: .72rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: var(--mp-muted); }
.mp-popular-label .mp-ico { color: #e0a030; }
.mp-popular-link { display: inline-flex; align-items: center; gap: .45rem; padding: .4rem .9rem .4rem .45rem; border: 1px solid var(--mp-line); border-radius: 999px; background: #fff; font-size: .86rem; font-weight: 600; text-decoration: none; color: var(--mp-navy); transition: border-color var(--mp-ease), transform var(--mp-ease), box-shadow var(--mp-ease); }
.mp-popular-link .mp-ico { width: 26px; height: 26px; padding: 5px; border-radius: 50%; background: var(--tone-bg); color: var(--tone); }
.mp-popular-link:hover { transform: translateY(-1px); border-color: var(--tone); box-shadow: 0 6px 16px -10px rgba(16, 44, 70, .4); color: var(--mp-navy); text-decoration: none; }

/* subject cards */
.mp-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; }
@media (min-width: 1400px) { .mp-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
.mp-card {
  position: relative; display: flex; flex-direction: column; padding: 1.2rem 1.2rem 1rem;
  border: 1px solid var(--mp-line); border-radius: var(--mp-r-lg); background: #fff; overflow: hidden;
  scroll-margin-top: 6rem;
  transition: transform var(--mp-ease), box-shadow var(--mp-ease), border-color var(--mp-ease);
}
.mp-card::before { content: ""; position: absolute; inset: 0 0 auto; height: 3px; background: var(--tone); opacity: 0; transition: opacity var(--mp-ease); }
.mp-card:hover { transform: translateY(-4px); border-color: #d5e0da; box-shadow: 0 22px 40px -24px rgba(16, 44, 70, .45); }
.mp-card:hover::before { opacity: 1; }
.mp-card.is-flash { animation: mp-flash 1.8s ease; }
@keyframes mp-flash { 0%, 45% { border-color: var(--tone); box-shadow: 0 0 0 5px var(--tone-bg); } }
.mp-card-head { display: flex; align-items: flex-start; gap: .85rem; margin-bottom: 1rem; }
.mp-card-ico { display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; flex: none; border-radius: 14px; background: var(--tone-bg); font-size: 1.35rem; color: var(--tone); transition: transform var(--mp-ease); }
.mp-card:hover .mp-card-ico { transform: rotate(-6deg) scale(1.05); }
.mp-card-titles { min-width: 0; flex: 1 1 auto; }
.mp-card-name { margin: .1rem 0 .15rem; font-size: 1.08rem; font-weight: 800; line-height: 1.25; letter-spacing: -.015em; color: var(--mp-navy); }
.mp-card-meta { margin: 0; font-size: .8rem; color: var(--mp-muted); }
.mp-badge { display: inline-flex; align-items: center; gap: .25rem; flex: none; padding: .15rem .55rem; border-radius: 999px; background: #fff5df; font-size: .68rem; font-weight: 800; color: #9a6200; }
.mp-badge .mp-ico { color: #e0a030; }

.mp-boards { margin: 0; padding: 0; list-style: none; display: grid; gap: .2rem; }
.mp-board { display: flex; align-items: center; gap: .65rem; padding: .5rem .55rem; border-radius: 10px; font-size: .9rem; font-weight: 600; text-decoration: none; color: var(--mp-text); transition: background var(--mp-ease), color var(--mp-ease); }
.mp-board:hover { background: var(--mp-soft); color: var(--mp-navy); text-decoration: none; }
.mp-avatar { display: inline-flex; align-items: center; justify-content: center; min-width: 34px; height: 30px; padding: 0 .35rem; flex: none; border-radius: 8px; background: var(--tone-bg); font-size: .66rem; font-weight: 800; letter-spacing: .03em; color: var(--tone); }
.mp-board-name { flex: 1 1 auto; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.mp-code { padding: .1rem .45rem; border-radius: 6px; background: #f1f4f3; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: .72rem; font-weight: 500; color: var(--mp-ink-2); white-space: nowrap; }
.mp-board-go { color: #b7c5bd; transition: transform var(--mp-ease), color var(--mp-ease); }
.mp-board:hover .mp-board-go { color: var(--mp-green); transform: translateX(3px); }
.mp-more { display: inline-flex; align-items: center; gap: .35rem; margin: .5rem .55rem 0; padding: 0; border: 0; background: none; font-size: .82rem; font-weight: 700; color: var(--mp-green-dark); cursor: pointer; }
.mp-more .mp-ico { transition: transform var(--mp-ease); }
.mp-more[aria-expanded="true"] .mp-ico { transform: rotate(180deg); }
.mp-soon { display: flex; align-items: center; gap: .45rem; margin: 0; padding: .85rem; border: 1px dashed var(--mp-border); border-radius: 10px; font-size: .84rem; color: var(--mp-muted); }

/* empty */
.mp-empty { padding: 3.5rem 1.5rem; border: 1px dashed #cddbd3; border-radius: var(--mp-r-lg); background: #fff; text-align: center; color: var(--mp-muted); }
.mp-empty-ico { display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; margin-bottom: .85rem; border-radius: 50%; background: var(--mp-green-soft); font-size: 1.5rem; color: var(--mp-green); }
.mp-empty-title { margin: 0 0 .3rem; font-size: 1.1rem; font-weight: 800; color: var(--mp-navy); }
.mp-empty p { margin-bottom: 0; }

/* CTA */
.mp-cta {
  position: relative; overflow: hidden; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.25rem 2rem;
  margin-top: 3.5rem; padding: 2rem 2.25rem; border-radius: var(--mp-r-lg);
  background: linear-gradient(120deg, var(--mp-green-dark), var(--mp-green) 55%, var(--mp-green-2)); color: #fff;
}
.mp-cta::before, .mp-cta::after { content: ""; position: absolute; border-radius: 50%; background: rgba(255, 255, 255, .08); }
.mp-cta::before { width: 260px; height: 260px; right: -60px; top: -120px; }
.mp-cta::after { width: 160px; height: 160px; right: 160px; bottom: -110px; }
.mp-cta-copy { position: relative; max-width: 36rem; }
.mp-cta-title { margin: 0 0 .3rem; font-size: 1.35rem; font-weight: 800; letter-spacing: -.02em; }
.mp-cta p:not(.mp-cta-title) { margin: 0; font-size: .95rem; color: #d6f0e0; }
.mp-cta-btn { position: relative; display: inline-flex; align-items: center; gap: .5rem; padding: .85rem 1.4rem; border-radius: 12px; background: #fff; font-size: .95rem; font-weight: 700; text-decoration: none; color: var(--mp-green-dark); box-shadow: 0 10px 22px -10px rgba(0, 0, 0, .4); transition: transform var(--mp-ease); }
.mp-cta-btn:hover { transform: translateY(-2px); color: var(--mp-green-dark); text-decoration: none; }

/* ---------- responsive ---------- */
@media (max-width: 991.98px) {
  /* sidebar becomes a swipeable row of level chips */
  .mp-side { position: static; display: flex; gap: .5rem; max-height: none; overflow-x: auto; scrollbar-width: none; padding: 2px; border: 0; background: none; box-shadow: none; }
  .mp-side::-webkit-scrollbar { display: none; }
  .mp-side-title, .mp-acc-body, .mp-level-chev { display: none !important; }
  .mp-acc { flex: none; }
  .mp-acc + .mp-acc { margin-top: 0; }
  .mp-level { width: auto; padding: .45rem .9rem .45rem .45rem; border-color: var(--mp-line); background: #fff; }
  .mp-acc.is-open > .mp-level { border-color: var(--mp-green); }
}
@media (max-width: 767.98px) {
  .mp-grid { grid-template-columns: 1fr; }
  .mp-toolbar { flex-direction: column; align-items: stretch; }
  .mp-filter input { width: 100%; }
  .mp-kbd { display: none; }
  .mp-search-bar { height: 56px; }
  .mp-search-btn { height: 42px; padding: 0 1rem; }
  .mp-stats { gap: .5rem 1.5rem; margin-top: 2rem; }
  .mp-cta { padding: 1.5rem; }
  .mp-cta-btn { width: 100%; justify-content: center; }
}
@media (max-width: 575.98px) {
  .mp-search-btn { display: none; }
}
@media (prefers-reduced-motion: reduce) {
  .mp-page *, .mp-page *::before, .mp-page *::after { animation: none !important; transition: none !important; }
}
</style>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tabs    = Array.prototype.slice.call(document.querySelectorAll('.mp-level[data-level]'));
    var filter  = document.getElementById('mpFilter');
    var countEl = document.getElementById('mpCount');
    var headEl  = document.getElementById('mpHeading');

    function activePanel() { return document.querySelector('.mp-panel:not([hidden])'); }

    /* ---------- filter + counts ---------- */
    function applyFilter() {
        var panel = activePanel();
        if (!panel) return;
        var terms = (filter ? filter.value : '').toLowerCase().trim().split(/\s+/).filter(Boolean);
        var shown = 0;
        panel.querySelectorAll('.mp-card').forEach(function (card) {
            var hay = card.getAttribute('data-search') || '';
            var ok = terms.every(function (t) { return hay.indexOf(t) !== -1; });
            card.hidden = !ok;
            if (ok) shown++;
        });
        var empty = panel.querySelector('[data-empty]');
        if (empty) empty.hidden = shown !== 0;
        var level = panel.getAttribute('data-level-name') || '';
        if (headEl) headEl.textContent = level + ' subjects';
        if (countEl) countEl.innerHTML = '<strong>' + shown + '</strong> ' + (shown === 1 ? 'subject' : 'subjects') +
            (terms.length ? ' match your filter' : ' — choose an exam board to see its papers');
    }

    /* ---------- levels (sidebar) ---------- */
    function selectTab(tab, updateUrl) {
        tabs.forEach(function (t) {
            var on = t === tab;
            var acc = t.closest('.mp-acc');
            acc.classList.toggle('is-open', on);
            t.setAttribute('aria-expanded', on ? 'true' : 'false');
            var body = acc.querySelector('.mp-acc-body');
            if (body) body.hidden = !on;
            var p = document.getElementById(t.getAttribute('aria-controls'));
            if (p) p.hidden = !on;
        });
        if (updateUrl && history.replaceState) {
            var url = new URL(window.location.href);
            url.searchParams.set('level', tab.dataset.level);
            url.hash = '';
            history.replaceState(null, '', url);
        }
        if (filter && filter.value) filter.value = '';
        applyFilter();
        // on phones, bring the subjects into view after picking a level
        if (updateUrl && window.innerWidth < 992 && headEl) headEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () { selectTab(tab, true); });
    });

    /* ---------- sidebar subject -> exam boards ---------- */
    document.querySelectorAll('.mp-subj[aria-controls]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var list = document.getElementById(btn.getAttribute('aria-controls'));
            var open = btn.getAttribute('aria-expanded') !== 'true';
            btn.closest('.mp-acc-body').querySelectorAll('.mp-subj[aria-expanded="true"]').forEach(function (other) {
                if (other === btn) return;
                other.setAttribute('aria-expanded', 'false');
                var l = document.getElementById(other.getAttribute('aria-controls'));
                if (l) l.hidden = true;
            });
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            if (list) list.hidden = !open;
        });
    });
    if (filter) filter.addEventListener('input', applyFilter);
    applyFilter();

    /* ---------- show all boards ---------- */
    document.querySelectorAll('.mp-more').forEach(function (btn) {
        var label = btn.querySelector('span');
        btn.addEventListener('click', function () {
            var open = btn.getAttribute('aria-expanded') !== 'true';
            btn.closest('.mp-card').querySelectorAll('.is-extra').forEach(function (li) { li.hidden = !open; });
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            label.textContent = open ? 'Show fewer' : btn.dataset.more;
        });
    });

    /* ---------- popular jump ---------- */
    document.querySelectorAll('[data-jump]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            var card = document.getElementById(link.dataset.jump);
            if (!card) return;
            e.preventDefault();
            if (filter && filter.value) { filter.value = ''; applyFilter(); }
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            card.classList.remove('is-flash'); void card.offsetWidth; card.classList.add('is-flash');
        });
    });

    /* ---------- AJAX search ---------- */
    var input = document.getElementById('mpSearchInput');
    var panel = document.getElementById('mpSearchPanel');
    var list = document.getElementById('mpSearchResults');
    var spinner = document.getElementById('mpSpinner');
    var timer = null, controller = null, active = -1;

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }
    function setOpen(open) {
        panel.hidden = !open;
        input.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (!open) { active = -1; input.removeAttribute('aria-activedescendant'); }
    }
    function highlight(i) {
        var items = list.querySelectorAll('.mp-result');
        items.forEach(function (el, n) { el.classList.toggle('is-active', n === i); el.setAttribute('aria-selected', n === i ? 'true' : 'false'); });
        active = i;
        if (items[i]) { input.setAttribute('aria-activedescendant', items[i].id); items[i].scrollIntoView({ block: 'nearest' }); }
    }
    function render(data, q) {
        list.innerHTML = '';
        if (!Array.isArray(data) || !data.length) {
            list.innerHTML = '<li class="mp-result-empty">No papers found for “' + esc(q) + '”. Try a subject name or unit code.</li>';
            setOpen(true);
            return;
        }
        data.forEach(function (item, i) {
            var li = document.createElement('li');
            li.innerHTML =
                '<a class="mp-result" id="mp-result-' + i + '" role="option" aria-selected="false" href="' + esc(item.url) + '">' +
                    '<span class="mp-result-main"><span class="mp-result-title">' + esc(item.subcategory_name) + '</span>' +
                    '<span class="mp-result-level">' + esc(item.category_name) + '</span></span>' +
                    '<span class="mp-result-tags">' +
                        (item.resubcategory_name ? '<span class="mp-result-board">' + esc(item.resubcategory_name) + '</span>' : '') +
                        (item.unit_code ? '<span class="mp-code">' + esc(item.unit_code) + '</span>' : '') +
                    '</span></a>';
            list.appendChild(li);
        });
        setOpen(true);
    }
    function search(q) {
        clearTimeout(timer);
        if (controller) controller.abort();
        if (q.length < 2) { list.innerHTML = ''; setOpen(false); spinner.hidden = true; return; }
        timer = setTimeout(function () {
            controller = new AbortController();
            spinner.hidden = false;
            fetch("{{ route('ajax.search.past-papers') }}", {
                method: 'POST',
                signal: controller.signal,
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                body: JSON.stringify({ q: q })
            })
            .then(function (r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
            .then(function (data) { render(data, q); })
            .catch(function (err) {
                if (err.name === 'AbortError') return;
                list.innerHTML = '<li class="mp-result-empty">Search is unavailable right now. Please try again.</li>';
                setOpen(true);
            })
            .finally(function () { spinner.hidden = true; });
        }, 250);
    }

    if (input) {
        input.addEventListener('input', function () { search(input.value.trim()); });
        input.addEventListener('keydown', function (e) {
            var items = list.querySelectorAll('.mp-result');
            if (e.key === 'ArrowDown' && items.length) { e.preventDefault(); setOpen(true); highlight((active + 1) % items.length); }
            else if (e.key === 'ArrowUp' && items.length) { e.preventDefault(); highlight((active - 1 + items.length) % items.length); }
            else if (e.key === 'Enter' && items.length) { e.preventDefault(); window.location.href = items[Math.max(active, 0)].href; }
            else if (e.key === 'Escape') { setOpen(false); }
        });
        input.addEventListener('focus', function () { if (list.children.length && input.value.trim().length >= 2) setOpen(true); });
        document.addEventListener('click', function (e) { if (!e.target.closest('#mpSearch')) setOpen(false); });

        var btn = document.getElementById('mpSearchBtn');
        if (btn) btn.addEventListener('click', function () {
            var first = list.querySelector('.mp-result');
            if (first && !panel.hidden) { window.location.href = (list.querySelector('.mp-result.is-active') || first).href; }
            else { input.focus(); search(input.value.trim()); }
        });

        document.querySelectorAll('.mp-trend').forEach(function (chip) {
            chip.addEventListener('click', function () {
                input.value = chip.dataset.term;
                input.focus();
                search(input.value);
            });
        });
    }

    document.addEventListener('keydown', function (e) {
        var tag = document.activeElement ? document.activeElement.tagName : '';
        if (e.key === '/' && input && ['INPUT', 'TEXTAREA', 'SELECT'].indexOf(tag) === -1) { e.preventDefault(); input.focus(); }
    });
});
</script>
@endpush