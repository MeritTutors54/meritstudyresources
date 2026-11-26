@extends('layouts.frontend-3')

@section('content')
@php
    /* ------------------------------------------------------------------
     | Data: $category, $subcategory, $resubcategory, $totalPapers,
     |       $totalSessions, $groupedPapers (series => papers)
     | Paper fields: title, ques_paper, ans_paper
     * ------------------------------------------------------------------ */
    $groupedPapers = collect($groupedPapers ?? []);
    $allPapers     = $groupedPapers->flatten(1)->filter();
    $paperNames    = $allPapers->pluck('title')->filter()->unique()->values();

    $fileUrl  = fn ($file) => filled($file) ? asset('uploads/pastpaper/' . $file) : null;
    $msCount  = $allPapers->filter(fn ($p) => filled($p->ans_paper))->count();
    $siblings = $subcategory?->resubcategories ?? collect();

    $subject  = $subcategory->subcategory_name ?? '';
    $board    = $resubcategory->resubcategory_name ?? '';
    $code     = $resubcategory->unit_code ?? '';
    $level    = $category->category_name ?? '';
    $levelUrl = route('past.papers') . '?level=' . ($category->slug ?? '');

    $paperKey  = fn ($title) => trim(preg_replace('/[^a-z0-9]+/', '-', mb_strtolower((string) $title)), '-');
    $openFirst = 2; // series open on page load

    /* ---------- icons ---------- */
    $icons = [
        'arrow'   => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'back'    => '<path d="M19 12H5M11 6l-6 6 6 6"/>',
        'chevron' => '<path d="M6 9l6 6 6-6"/>',
        'clock'   => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'file'    => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h4"/>',
        'pdf'     => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M12 11v6M9.5 14.5 12 17l2.5-2.5"/>',
        'check'   => '<path d="M20 6 9 17l-5-5"/>',
        'info'    => '<circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/>',
        'expand'  => '<path d="M7 15l5 5 5-5M7 9l5-5 5 5"/>',
        'layers'  => '<path d="M12 3l9 5-9 5-9-5z"/><path d="M3 13l9 5 9-5"/>',
        'shield'  => '<path d="M12 3l8 3v6c0 4.5-3.4 8.3-8 9-4.6-.7-8-4.5-8-9V6z"/><path d="M9 12l2 2 4-4"/>',
        'target'  => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/>',
        'timer'   => '<circle cx="12" cy="13" r="8"/><path d="M12 9v4l2 2M9 2h6"/>',
        'pen'     => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
        'help'    => '<circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 0 1 4.9.8c0 1.7-2.4 2.2-2.4 3.7M12 17h.01"/>',
    ];
    $icon = fn (string $n, string $class = '') =>
        '<svg class="mp-ico ' . $class . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" '
        . 'stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . ($icons[$n] ?? '') . '</svg>';

    /* ---------- exam board badge ---------- */
    $boardBadge = function (string $name) {
        $n = mb_strtolower($name);
        $tone = match (true) {
            str_contains($n, 'aqa')                                     => 'purple',
            str_contains($n, 'edexcel') || str_contains($n, 'pearson') => 'blue',
            str_contains($n, 'ocr')                                     => 'teal',
            str_contains($n, 'cie') || str_contains($n, 'cambridge') || str_contains($n, 'caie') => 'rose',
            str_contains($n, 'wjec') || str_contains($n, 'eduqas')     => 'amber',
            default                                                     => 'navy',
        };
        $first = preg_split('/\s+/', trim($name))[0] ?? $name;
        $label = (mb_strtoupper($first) === $first && mb_strlen($first) <= 4) ? $first : mb_strtoupper(mb_substr($first, 0, 2));
        return [$label, $tone];
    };
    [$boardAbbr, $boardTone] = $boardBadge($board ?: '—');
@endphp

<div class="mp-page">

    <!-- ============================= HERO ============================= -->
    <section class="mp-hero">
        <div class="mp-hero-bg" aria-hidden="true"></div>
        <div class="container">
            <nav aria-label="Breadcrumb">
                <ol class="mp-crumbs">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('past.papers') }}">Past papers</a></li>
                    <li><a href="{{ $levelUrl }}">{{ $level }}</a></li>
                    <li aria-current="page">{{ $subject }}</li>
                </ol>
            </nav>

            <div class="row align-items-end g-4">
                <div class="col-lg-7">
                    <span class="mp-pill">{!! $icon('layers') !!} {{ $level }} · {{ $subject }}</span>
                    <h1 class="mp-title">
                        {{ $board }} {{ $subject }}
                        @if($code)<span class="mp-title-code">({{ $code }})</span>@endif
                        <span class="mp-title-accent">past papers</span>
                    </h1>
                    <ul class="mp-spec list-unstyled">
                        <li><span class="mp-avatar tone-{{ $boardTone }}">{{ $boardAbbr }}</span> <span><small>Exam board</small>{{ $board ?: 'n/a' }}</span></li>
                        @if($code)<li><span class="mp-spec-ico">#</span> <span><small>Unit code</small><code>{{ $code }}</code></span></li>@endif
                        <li><span class="mp-spec-ico">{!! $icon('layers') !!}</span> <span><small>Level</small>{{ $level }}</span></li>
                    </ul>
                </div>

                <div class="col-lg-5">
                    <dl class="mp-stat-grid">
                        <div class="mp-stat">
                            <span class="mp-stat-ico">{!! $icon('file') !!}</span>
                            <dt>Papers</dt><dd>{{ number_format($totalPapers ?? $allPapers->count()) }}</dd>
                        </div>
                        <div class="mp-stat">
                            <span class="mp-stat-ico">{!! $icon('clock') !!}</span>
                            <dt>Exam series</dt><dd>{{ number_format($totalSessions ?? $groupedPapers->count()) }}</dd>
                        </div>
                        <div class="mp-stat">
                            <span class="mp-stat-ico">{!! $icon('check') !!}</span>
                            <dt>Mark schemes</dt><dd>{{ number_format($msCount) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if(!empty($resubcategory->description))
                <details class="mp-about">
                    <summary>
                        {!! $icon('info') !!} About this specification
                        {!! $icon('chevron', 'mp-about-chev') !!}
                    </summary>
                    <div class="mp-about-body">{!! $resubcategory->description !!}</div>
                </details>
            @endif
        </div>
    </section>

    <!-- ============================= BODY ============================= -->
    <div class="container mp-body">
        <div class="row g-4">

            <!-- SIDEBAR -->
            <div class="col-lg-4 col-xl-3 order-2 order-lg-1">
                <aside class="mp-side">
                    @if($siblings->isNotEmpty())
                        <div class="mp-side-card">
                            <p class="mp-side-title">{{ $subject }} · exam boards</p>
                            <ul class="mp-side-list list-unstyled">
                                @foreach($siblings as $sib)
                                    @php
                                        $isCurrent = $sib->id === $resubcategory->id;
                                        [$sAbbr, $sTone] = $boardBadge($sib->resubcategory_name);
                                    @endphp
                                    <li>
                                        <a class="{{ $isCurrent ? 'is-current' : '' }}" @if($isCurrent) aria-current="page" @endif
                                           href="{{ route('past.papers.details', [$category->slug, $subcategory->slug, $sib->slug]) }}">
                                            <span class="mp-avatar mp-avatar-sm tone-{{ $sTone }}">{{ $sAbbr }}</span>
                                            <span class="mp-side-name">{{ $sib->resubcategory_name }}</span>
                                            @if($sib->unit_code)<span class="mp-code">{{ $sib->unit_code }}</span>@endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mp-side-card mp-tips">
                        <p class="mp-side-title">Get the most from each paper</p>
                        <ol class="list-unstyled">
                            <li><span>{!! $icon('timer') !!}</span><div><strong>Sit it timed</strong>Work in exam conditions, no notes.</div></li>
                            <li><span>{!! $icon('pen') !!}</span><div><strong>Mark it honestly</strong>Use the mark scheme line by line.</div></li>
                            <li><span>{!! $icon('target') !!}</span><div><strong>Fix the gaps</strong>Revise the topics you dropped marks on.</div></li>
                        </ol>
                    </div>

                    <a class="mp-back" href="{{ $levelUrl }}">{!! $icon('back') !!} All {{ $level }} subjects</a>
                </aside>
            </div>

            <!-- PAPERS -->
            <div class="col-lg-8 col-xl-9 order-1 order-lg-2">
                @if($groupedPapers->isNotEmpty())
                    <div class="mp-toolbar">
                        @if($paperNames->count() > 1)
                            <div class="mp-seg" role="group" aria-label="Show papers">
                                <button type="button" class="is-active" data-paper="all" aria-pressed="true">All papers</button>
                                @foreach($paperNames as $name)
                                    <button type="button" data-paper="{{ $paperKey($name) }}" aria-pressed="false">{{ $name }}</button>
                                @endforeach
                            </div>
                        @else
                            <p class="mp-count"><strong>{{ $allPapers->count() }}</strong> {{ $allPapers->count() === 1 ? 'paper' : 'papers' }}</p>
                        @endif
                        <button type="button" class="mp-ghost" id="mpExpandAll">{!! $icon('expand') !!} <span>Expand all</span></button>
                    </div>

                    <div id="mpSeriesList">
                        @foreach($groupedPapers as $series => $papers)
                            @php
                                $papers = collect($papers)->filter();
                                $sid    = 'series-' . $paperKey($series) . '-' . $loop->index;
                                $open   = $loop->index < $openFirst;
                            @endphp
                            @if($papers->isNotEmpty())
                                <section class="mp-series {{ $open ? 'is-open' : '' }}">
                                    <h2 class="mp-series-h">
                                        <button type="button" class="mp-series-head" aria-expanded="{{ $open ? 'true' : 'false' }}" aria-controls="{{ $sid }}">
                                            <span class="mp-series-ico">{!! $icon('clock') !!}</span>
                                            <span class="mp-series-title">{{ $series }}</span>
                                            <span class="mp-series-count" data-count>{{ $papers->count() }} {{ $papers->count() === 1 ? 'paper' : 'papers' }}</span>
                                            {!! $icon('chevron', 'mp-series-chev') !!}
                                        </button>
                                    </h2>
                                    <div class="mp-series-body" id="{{ $sid }}" @if(!$open) hidden @endif>
                                        <table class="mp-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Paper</th>
                                                    <th scope="col" class="mp-col-file">Question paper</th>
                                                    <th scope="col" class="mp-col-file">Mark scheme</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($papers as $paper)
                                                    @php
                                                        $qp = $fileUrl($paper->ques_paper);
                                                        $ms = $fileUrl($paper->ans_paper);
                                                    @endphp
                                                    <tr data-paper="{{ $paperKey($paper->title) }}">
                                                        <td class="mp-paper">
                                                            <span class="mp-paper-ico">{!! $icon('file') !!}</span>
                                                            <span class="mp-paper-text">
                                                                <span class="mp-paper-title">{{ $paper->title }}</span>
                                                                <span class="mp-paper-sub">{{ $series }}</span>
                                                            </span>
                                                        </td>
                                                        <td class="mp-col-file">
                                                            @if($qp)
                                                                <a class="mp-file is-qp" href="{{ $qp }}" target="_blank" rel="noopener"
                                                                   aria-label="Question paper: {{ $paper->title }}, {{ $series }} (PDF, opens in a new tab)">
                                                                    {!! $icon('pdf') !!} Question paper
                                                                </a>
                                                            @else
                                                                <span class="mp-none">Not available</span>
                                                            @endif
                                                        </td>
                                                        <td class="mp-col-file">
                                                            @if($ms)
                                                                <a class="mp-file is-ms" href="{{ $ms }}" target="_blank" rel="noopener"
                                                                   aria-label="Mark scheme: {{ $paper->title }}, {{ $series }} (PDF, opens in a new tab)">
                                                                    {!! $icon('check') !!} Mark scheme
                                                                </a>
                                                            @else
                                                                <span class="mp-none">Not available</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="mp-empty">
                        <span class="mp-empty-ico">{!! $icon('file') !!}</span>
                        <p class="mp-empty-title">No papers uploaded yet</p>
                        <p>Papers for {{ $board }} {{ $subject }} are on their way — check back soon.</p>
                        <a class="mp-cta-btn is-dark" href="{{ $levelUrl }}">Browse other subjects {!! $icon('arrow') !!}</a>
                    </div>
                @endif

                <p class="mp-footnote">{!! $icon('shield') !!} Past papers and mark schemes remain the copyright of their exam boards and are provided for private revision.</p>
            </div>
        </div>
    </div>
</div>

<style>
/* =====================================================================
   Merit — Past paper detail page (self-contained; classes prefixed mp-)
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
}
.mp-page *, .mp-page *::before, .mp-page *::after { box-sizing: border-box; }
.mp-page [hidden] { display: none !important; }
.mp-page a:focus-visible, .mp-page button:focus-visible, .mp-page summary:focus-visible { outline: 2px solid var(--mp-green-2); outline-offset: 2px; border-radius: 8px; }
.mp-ico { width: 1em; height: 1em; flex: none; }

.tone-green  { --tone: #168a45; --tone-bg: #e6f5ec; }
.tone-blue   { --tone: #1f6fd1; --tone-bg: #e8f1fd; }
.tone-purple { --tone: #6a43c2; --tone-bg: #f0ebfb; }
.tone-amber  { --tone: #c27a14; --tone-bg: #fdf2e1; }
.tone-rose   { --tone: #c2385a; --tone-bg: #fdecf0; }
.tone-teal   { --tone: #0f8a80; --tone-bg: #e3f5f3; }
.tone-navy   { --tone: #24476b; --tone-bg: #e9eff6; }

.mp-avatar { display: inline-flex; align-items: center; justify-content: center; min-width: 38px; height: 34px; padding: 0 .4rem; flex: none; border-radius: 9px; background: var(--tone-bg); font-size: .7rem; font-weight: 800; letter-spacing: .03em; color: var(--tone); }
.mp-avatar-sm { min-width: 32px; height: 26px; border-radius: 7px; font-size: .6rem; }
.mp-code { padding: .1rem .45rem; border-radius: 6px; background: #f1f4f3; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: .72rem; font-weight: 500; color: var(--mp-ink-2); white-space: nowrap; }

/* ---------- hero ---------- */
.mp-hero { position: relative; overflow: hidden; padding: 1.75rem 0 2.75rem; color: #fff; background: linear-gradient(160deg, var(--mp-navy) 0%, var(--mp-navy-2) 100%); }
.mp-hero-bg {
  position: absolute; inset: 0; pointer-events: none;
  background:
    radial-gradient(560px 360px at 88% 10%, rgba(31, 177, 90, .26), transparent 70%),
    radial-gradient(480px 300px at 0% 100%, rgba(31, 111, 209, .2), transparent 70%),
    radial-gradient(rgba(255, 255, 255, .07) 1px, transparent 1.2px) 0 0 / 24px 24px;
  mask-image: linear-gradient(180deg, #000 60%, transparent);
}
.mp-hero .container { position: relative; }
.mp-crumbs { display: flex; flex-wrap: wrap; gap: .4rem; margin: 0 0 2rem; padding: 0; list-style: none; font-size: .84rem; color: #d5e1eb; }
.mp-crumbs li { display: inline-flex; align-items: center; gap: .4rem; }
.mp-crumbs li + li::before { content: "›"; color: #5e7a93; }
.mp-crumbs a { color: #94aabd; text-decoration: none; }
.mp-crumbs a:hover { color: #fff; }

.mp-pill { display: inline-flex; align-items: center; gap: .45rem; padding: .38rem .85rem; margin-bottom: 1.1rem; border: 1px solid rgba(255, 255, 255, .14); border-radius: 999px; background: rgba(255, 255, 255, .06); font-size: .8rem; font-weight: 600; color: #cfe9da; }
.mp-pill .mp-ico { color: #4fd18b; }
.mp-title { margin: 0 0 1.4rem; font-size: clamp(1.9rem, 1.2rem + 2.4vw, 3rem); font-weight: 800; line-height: 1.08; letter-spacing: -.035em; color: #fff; }
.mp-title-code { font-weight: 600; color: #9fb3c5; }
.mp-title-accent { display: block; background: linear-gradient(90deg, #4fd18b, #a6eec4); -webkit-background-clip: text; background-clip: text; color: transparent; }

.mp-spec { display: flex; flex-wrap: wrap; gap: .6rem; margin: 0; }
.mp-spec li { display: inline-flex; align-items: center; gap: .6rem; padding: .45rem .9rem .45rem .45rem; border: 1px solid rgba(255, 255, 255, .12); border-radius: 14px; background: rgba(255, 255, 255, .06); backdrop-filter: blur(6px); font-size: .92rem; font-weight: 700; color: #fff; }
.mp-spec li > span:last-child { display: flex; flex-direction: column; line-height: 1.2; }
.mp-spec small { font-size: .66rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: #93a9bc; }
.mp-spec code { padding: 0; background: none; font-size: .9rem; color: #fff; }
.mp-spec-ico { display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 9px; background: rgba(255, 255, 255, .1); font-size: .95rem; font-weight: 800; color: #a6eec4; }

.mp-stat-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: .75rem; margin: 0; }
.mp-stat { padding: 1rem; border: 1px solid rgba(255, 255, 255, .12); border-radius: var(--mp-r); background: rgba(255, 255, 255, .06); backdrop-filter: blur(6px); }
.mp-stat-ico { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; margin-bottom: .65rem; border-radius: 9px; background: rgba(79, 209, 139, .16); font-size: 1rem; color: #4fd18b; }
.mp-stat dt { font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #93a9bc; }
.mp-stat dd { margin: .15rem 0 0; font-size: 1.75rem; font-weight: 800; line-height: 1; letter-spacing: -.03em; color: #fff; font-variant-numeric: tabular-nums; }

.mp-about { margin-top: 1.75rem; border: 1px solid rgba(255, 255, 255, .12); border-radius: var(--mp-r); background: rgba(255, 255, 255, .05); }
.mp-about summary { display: flex; align-items: center; gap: .55rem; padding: .85rem 1.1rem; font-size: .92rem; font-weight: 700; color: #fff; cursor: pointer; list-style: none; }
.mp-about summary::-webkit-details-marker { display: none; }
.mp-about summary > .mp-ico:first-child { color: #4fd18b; }
.mp-about-chev { margin-left: auto; transition: transform var(--mp-ease); }
.mp-about[open] .mp-about-chev { transform: rotate(180deg); }
.mp-about-body { padding: 0 1.1rem 1.1rem 2.6rem; font-size: .94rem; line-height: 1.7; color: #c4d2de; }
.mp-about-body a { color: #a6eec4; }
.mp-about-body > :last-child { margin-bottom: 0; }

/* ---------- body ---------- */
.mp-body { padding-top: 2.25rem; padding-bottom: 4.5rem; }

/* sidebar */
.mp-side { position: sticky; top: 1.5rem; display: grid; gap: 1rem; }
.mp-side-card { padding: .9rem; border: 1px solid var(--mp-line); border-radius: var(--mp-r-lg); background: #fff; box-shadow: 0 1px 2px rgba(16, 44, 70, .04), 0 14px 30px -24px rgba(16, 44, 70, .35); }
.mp-side-title { margin: .1rem .35rem .65rem; font-size: .68rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: var(--mp-muted); }
.mp-side-list { display: grid; gap: 2px; margin: 0; }
.mp-side-list a { display: flex; align-items: center; gap: .6rem; padding: .45rem .5rem; border-radius: 10px; font-size: .9rem; font-weight: 600; text-decoration: none; color: var(--mp-text); transition: background var(--mp-ease), color var(--mp-ease); }
.mp-side-list a:hover { background: var(--mp-soft); color: var(--mp-navy); text-decoration: none; }
.mp-side-list a.is-current { background: var(--mp-green-soft); color: var(--mp-green-dark); box-shadow: inset 3px 0 0 var(--mp-green); }
.mp-side-name { flex: 1 1 auto; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.mp-side-list .mp-code { font-size: .66rem; }

.mp-tips ol { display: grid; gap: .8rem; margin: 0; padding: 0 .35rem .2rem; }
.mp-tips li { display: flex; gap: .7rem; font-size: .82rem; line-height: 1.45; color: var(--mp-muted); }
.mp-tips li > span { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; flex: none; border-radius: 9px; background: var(--mp-green-soft); font-size: .95rem; color: var(--mp-green); }
.mp-tips strong { display: block; font-size: .88rem; color: var(--mp-navy); }

.mp-back { display: inline-flex; align-items: center; gap: .45rem; padding: 0 .4rem; font-size: .88rem; font-weight: 700; text-decoration: none; color: var(--mp-green-dark); }
.mp-back:hover { color: var(--mp-green); text-decoration: none; }
.mp-back .mp-ico { transition: transform var(--mp-ease); }
.mp-back:hover .mp-ico { transform: translateX(-3px); }

/* toolbar */
.mp-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem 1rem; margin-bottom: 1.1rem; }
.mp-count { margin: 0; font-size: .95rem; color: var(--mp-muted); }
.mp-count strong { color: var(--mp-navy); }
.mp-seg { display: flex; gap: 3px; max-width: 100%; padding: 4px; overflow-x: auto; scrollbar-width: none; border: 1px solid var(--mp-line); border-radius: 12px; background: #fff; box-shadow: 0 1px 2px rgba(16, 44, 70, .04); }
.mp-seg::-webkit-scrollbar { display: none; }
.mp-seg button { flex: none; padding: .5rem 1rem; border: 0; border-radius: 9px; background: transparent; font-size: .86rem; font-weight: 700; white-space: nowrap; color: var(--mp-muted); cursor: pointer; transition: background var(--mp-ease), color var(--mp-ease), box-shadow var(--mp-ease); }
.mp-seg button:hover { color: var(--mp-navy); background: var(--mp-soft); }
.mp-seg button.is-active { background: linear-gradient(180deg, var(--mp-green-2), var(--mp-green)); color: #fff; box-shadow: 0 6px 14px -8px rgba(22, 138, 69, .8); }
.mp-ghost { display: inline-flex; align-items: center; gap: .45rem; height: 42px; padding: 0 1rem; border: 1px solid var(--mp-line); border-radius: 12px; background: #fff; font-size: .86rem; font-weight: 700; color: var(--mp-navy); cursor: pointer; transition: border-color var(--mp-ease), background var(--mp-ease); }
.mp-ghost:hover { border-color: var(--mp-green); background: var(--mp-green-soft); }

/* series */
.mp-series { border: 1px solid var(--mp-line); border-radius: var(--mp-r-lg); background: #fff; overflow: hidden; transition: box-shadow var(--mp-ease), border-color var(--mp-ease); }
.mp-series + .mp-series { margin-top: .9rem; }
.mp-series.is-open { border-color: #d5e0da; box-shadow: 0 22px 40px -30px rgba(16, 44, 70, .45); }
.mp-series-h { margin: 0; font-size: inherit; }
.mp-series-head { display: flex; align-items: center; gap: .85rem; width: 100%; padding: 1rem 1.25rem; border: 0; background: #fff; text-align: left; cursor: pointer; transition: background var(--mp-ease); }
.mp-series-head:hover { background: var(--mp-soft); }
.mp-series-ico { display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; flex: none; border-radius: 11px; background: var(--mp-soft); font-size: 1.05rem; color: var(--mp-navy); transition: background var(--mp-ease), color var(--mp-ease); }
.mp-series.is-open .mp-series-ico { background: linear-gradient(160deg, var(--mp-green-2), var(--mp-green)); color: #fff; }
.mp-series-title { flex: 1 1 auto; font-size: 1.05rem; font-weight: 800; letter-spacing: -.015em; color: var(--mp-navy); }
.mp-series-count { padding: .15rem .6rem; border-radius: 999px; background: #eef2f0; font-size: .74rem; font-weight: 700; color: var(--mp-muted); }
.mp-series-chev { color: var(--mp-muted); transition: transform var(--mp-ease); }
.mp-series.is-open .mp-series-chev { transform: rotate(180deg); color: var(--mp-green-dark); }
.mp-series.is-open .mp-series-head { border-bottom: 1px solid var(--mp-line); }

.mp-table { width: 100%; border-collapse: collapse; }
.mp-table th { padding: .65rem 1.25rem; background: #fbfcfc; border-bottom: 1px solid var(--mp-line); font-size: .66rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; text-align: left; color: var(--mp-muted); }
.mp-table td { padding: .85rem 1.25rem; border-bottom: 1px solid #eef2f0; vertical-align: middle; }
.mp-table tbody tr:last-child td { border-bottom: 0; }
.mp-table tbody tr { transition: background var(--mp-ease); }
.mp-table tbody tr:hover { background: #fafcfb; }
.mp-col-file { width: 12rem; }

.mp-paper-ico { display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; margin-right: .8rem; border-radius: 10px; background: #e8f1fd; font-size: 1.05rem; color: #1f6fd1; vertical-align: middle; }
.mp-paper-text { display: inline-flex; flex-direction: column; vertical-align: middle; }
.mp-paper-title { font-size: .97rem; font-weight: 800; color: var(--mp-navy); }
.mp-paper-sub { font-size: .76rem; color: var(--mp-muted); }

.mp-file { display: inline-flex; align-items: center; gap: .45rem; padding: .5rem .85rem; border: 1px solid transparent; border-radius: 10px; font-size: .84rem; font-weight: 700; white-space: nowrap; text-decoration: none; transition: transform var(--mp-ease), box-shadow var(--mp-ease), background var(--mp-ease), color var(--mp-ease); }
.mp-file .mp-ico { font-size: 1rem; }
.mp-file.is-qp { background: #e8f1fd; color: #1f5fb8; }
.mp-file.is-ms { background: var(--mp-green-soft); color: var(--mp-green-dark); }
.mp-file:hover { transform: translateY(-1px); color: #fff; text-decoration: none; }
.mp-file.is-qp:hover { background: #1f6fd1; box-shadow: 0 8px 16px -10px rgba(31, 111, 209, .9); }
.mp-file.is-ms:hover { background: var(--mp-green); box-shadow: 0 8px 16px -10px rgba(22, 138, 69, .9); }
.mp-none { font-size: .82rem; color: #a9b6ae; }

/* empty + footnote */
.mp-empty { padding: 3.5rem 1.5rem; border: 1px dashed #cddbd3; border-radius: var(--mp-r-lg); background: #fff; text-align: center; color: var(--mp-muted); }
.mp-empty-ico { display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; margin-bottom: .85rem; border-radius: 50%; background: var(--mp-green-soft); font-size: 1.5rem; color: var(--mp-green); }
.mp-empty-title { margin: 0 0 .3rem; font-size: 1.1rem; font-weight: 800; color: var(--mp-navy); }
.mp-empty p { margin-bottom: 1.1rem; }
.mp-cta-btn.is-dark { display: inline-flex; align-items: center; gap: .5rem; padding: .75rem 1.25rem; border-radius: 12px; background: linear-gradient(180deg, var(--mp-green-2), var(--mp-green)); font-weight: 700; text-decoration: none; color: #fff; }
.mp-cta-btn.is-dark:hover { color: #fff; text-decoration: none; }
.mp-footnote { display: flex; align-items: flex-start; gap: .5rem; margin: 2rem 0 0; padding-top: 1.25rem; border-top: 1px solid var(--mp-line); font-size: .8rem; line-height: 1.5; color: var(--mp-muted); }
.mp-footnote .mp-ico { margin-top: .15rem; color: var(--mp-green); }

/* ---------- responsive ---------- */
@media (max-width: 991.98px) {
  .mp-side { position: static; }
  .mp-stat-grid { margin-top: .5rem; }
}
@media (max-width: 767.98px) {
  .mp-hero { padding-bottom: 2rem; }
  .mp-stat { padding: .8rem; }
  .mp-stat dd { font-size: 1.35rem; }
  .mp-stat-ico { width: 28px; height: 28px; margin-bottom: .45rem; }
  .mp-spec li { flex: 1 1 auto; }
  .mp-toolbar { flex-direction: column; align-items: stretch; }
  .mp-ghost { align-self: flex-start; }

  .mp-table thead { display: none; }
  .mp-table, .mp-table tbody, .mp-table tr, .mp-table td { display: block; width: 100%; }
  .mp-table tr { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; padding: 1rem; border-bottom: 1px solid #eef2f0; }
  .mp-table tbody tr:last-child { border-bottom: 0; }
  .mp-table td { padding: 0; border: 0; }
  .mp-table td.mp-paper { grid-column: 1 / -1; display: flex; align-items: center; }
  .mp-col-file { width: auto; }
  .mp-file { width: 100%; justify-content: center; }
  .mp-none { display: block; padding: .5rem 0; text-align: center; }
}
@media (max-width: 575.98px) {
  .mp-stat-grid { gap: .5rem; }
  .mp-stat dt { font-size: .6rem; }
}
@media (prefers-reduced-motion: reduce) {
  .mp-page *, .mp-page *::before, .mp-page *::after { animation: none !important; transition: none !important; }
}
</style>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var series    = Array.prototype.slice.call(document.querySelectorAll('.mp-series'));
    var expandBtn = document.getElementById('mpExpandAll');

    function setOpen(section, open) {
        section.classList.toggle('is-open', open);
        section.querySelector('.mp-series-head').setAttribute('aria-expanded', open ? 'true' : 'false');
        section.querySelector('.mp-series-body').hidden = !open;
    }
    function visibleSeries() { return series.filter(function (s) { return !s.hidden; }); }
    function syncExpandLabel() {
        if (!expandBtn) return;
        var vis = visibleSeries();
        var allOpen = vis.length && vis.every(function (s) { return s.classList.contains('is-open'); });
        expandBtn.querySelector('span').textContent = allOpen ? 'Collapse all' : 'Expand all';
    }

    // open / close one series
    series.forEach(function (s) {
        s.querySelector('.mp-series-head').addEventListener('click', function () {
            setOpen(s, !s.classList.contains('is-open'));
            syncExpandLabel();
        });
    });

    // expand / collapse all
    if (expandBtn) {
        expandBtn.addEventListener('click', function () {
            var vis = visibleSeries();
            var open = !vis.every(function (s) { return s.classList.contains('is-open'); });
            vis.forEach(function (s) { setOpen(s, open); });
            syncExpandLabel();
        });
    }

    // paper filter: All papers / Paper 1 / Paper 2 ...
    var segButtons = document.querySelectorAll('.mp-seg button');
    segButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var key = btn.dataset.paper;
            segButtons.forEach(function (b) {
                var on = b === btn;
                b.classList.toggle('is-active', on);
                b.setAttribute('aria-pressed', on ? 'true' : 'false');
            });
            series.forEach(function (s) {
                var shown = 0;
                s.querySelectorAll('tbody tr').forEach(function (row) {
                    var ok = key === 'all' || row.dataset.paper === key;
                    row.hidden = !ok;
                    if (ok) shown++;
                });
                s.hidden = shown === 0;
                var c = s.querySelector('[data-count]');
                if (c) c.textContent = shown + (shown === 1 ? ' paper' : ' papers');
            });
            syncExpandLabel();
        });
    });

    syncExpandLabel();
});
</script>
@endpush