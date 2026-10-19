@extends('layouts.frontend-3')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@section('content')
@php
    $stats = [
        ['icon' => 'bi-file-earmark-text', 'num' => '7,689+', 'label' => 'Past papers',          'tint' => 'benefit-icon-green'],
        ['icon' => 'bi-journal-text',      'num' => '350+',   'label' => 'Worksheets & booklets', 'tint' => 'benefit-icon-blue'],
        ['icon' => 'bi-people',            'num' => '1,000+', 'label' => 'Active students',       'tint' => 'benefit-icon-teal'],
        ['icon' => 'bi-patch-check',       'num' => '15+',    'label' => 'Certified tutors',      'tint' => 'benefit-icon-navy'],
    ];

    $values = [
        ['class' => 'res-green',  'icon' => 'bi-check2-circle', 'title' => 'Accuracy first',
         'text' => "Every paper and mark scheme is checked against the current syllabus before it's published."],
        ['class' => 'res-rose',   'icon' => 'bi-heart',         'title' => 'Fair pricing',
         'text' => 'Plans built for individual students up to whole-school rollouts, with free resources always available.'],
        ['class' => 'res-purple', 'icon' => 'bi-person-video3', 'title' => 'Taught by real tutors',
         'text' => 'Every guide is written and graded by certified, subject-qualified tutors — never generated content.'],
    ];

    $team = [
        ['initials' => 'RH', 'name' => 'Rachel Hughes', 'role' => 'Founder & Maths Tutor',       'tint' => 'is-blue'],
        ['initials' => 'SK', 'name' => 'Sam Khatri',    'role' => 'Head of Sciences',            'tint' => 'is-amber'],
        ['initials' => 'NT', 'name' => 'Nishat Tasnim', 'role' => 'English & Humanities Lead',   'tint' => 'is-rose'],
        ['initials' => 'DP', 'name' => 'Daniel Price',  'role' => 'Content & Quality Lead',      'tint' => 'is-green'],
    ];

    $boards = ['AQA', 'Edexcel', 'OCR', 'Cambridge iGCSE', 'CIE'];
@endphp

{{-- Needs Bootstrap Icons + style.css and resources.css (Merit tokens) loaded by the layout --}}
<link href="{{ asset('frontend/new/css/about.css') }}" rel="stylesheet">

<div class="page-about">

    <!-- ============================= HERO ============================= -->
    <section class="hero about-hero">
        <div class="container">
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb course-crumbs mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About us</li>
                </ol>
            </nav>

            <div class="row align-items-center gy-4">
                <div class="col-lg-7">
                    <p class="eyebrow"><span class="eyebrow-dot"></span>Our story</p>
                    <h1 class="hero-heading">
                        Built by teachers, trusted by <span class="hero-heading-accent">thousands of students.</span>
                    </h1>
                    <p class="hero-lead">
                        Merit Study Resources started with a simple idea: revision materials should be exam-board
                        accurate, affordable, and written by people who actually teach the subject.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('products') }}" class="btn btn-merit about-cta">
                            Browse resources <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#team" class="btn-outline-merit">Meet the team</a>
                    </div>
                </div>

                <!-- CSS book stack (from style.css) -->
                <div class="col-lg-5 d-none d-md-block">
                    <div class="hero-art about-art" aria-hidden="true">
                        <p class="script-note script-note-left">written by<br>real tutors</p>
                        <div class="book-stack">
                            <span class="book book-navy" style="--book-index:5">Maths</span>
                            <span class="book book-green" style="--book-index:4">Biology</span>
                            <span class="book book-blue" style="--book-index:3">Physics</span>
                            <span class="book book-amber" style="--book-index:2">Chemistry</span>
                            <span class="book book-rose" style="--book-index:1">English</span>
                            <span class="book book-purple" style="--book-index:0">History</span>
                        </div>
                        <span class="desk-line"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= STATS ============================= -->
    <section class="about-stats" aria-label="Merit in numbers">
        <div class="container">
            <ul class="about-stat-grid list-unstyled">
                @foreach($stats as $s)
                    <li class="about-stat">
                        <span class="benefit-icon {{ $s['tint'] }}"><i class="bi {{ $s['icon'] }}"></i></span>
                        <span>
                            <span class="about-stat-num">{{ $s['num'] }}</span>
                            <span class="about-stat-label">{{ $s['label'] }}</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <!-- ============================= OUR STORY ============================= -->
    <section class="section about-section">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6 order-lg-2">
                    <p class="eyebrow"><span class="eyebrow-dot"></span>How we started</p>
                    <h2 class="about-h2">From a tutoring centre in London to a UK-wide revision library</h2>
                    <p class="about-text">
                        Merit Study Resources grew out of Merit Tutors, a London exam centre where our founding tutors
                        kept rebuilding the same worksheets and past-paper packs year after year for their students.
                    </p>
                    <p class="about-text">
                        We decided to put that library online, mapped precisely to AQA, Edexcel, OCR, Cambridge iGCSE
                        and CIE specifications, so every student — not just the ones we tutor in person — could revise
                        with confidence.
                    </p>
                    <ul class="about-boards list-unstyled">
                        @foreach($boards as $b)
                            <li>{{ $b }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('products') }}" class="btn btn-merit about-cta">
                        Browse resources <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="col-lg-6 order-lg-1">
                    <ol class="story-steps list-unstyled">
                        <li class="story-step">
                            <span class="story-dot"><i class="bi bi-building"></i></span>
                            <div>
                                <p class="story-label">Where it began</p>
                                <p class="story-title">Merit Tutors, London</p>
                                <p class="story-text">Tutors build worksheets and past-paper packs for their own students.</p>
                            </div>
                        </li>
                        <li class="story-step">
                            <span class="story-dot"><i class="bi bi-diagram-3"></i></span>
                            <div>
                                <p class="story-label">The idea</p>
                                <p class="story-title">Map everything to the spec</p>
                                <p class="story-text">Each resource aligned to its exam board, tier and topic.</p>
                            </div>
                        </li>
                        <li class="story-step is-now">
                            <span class="story-dot"><i class="bi bi-globe2"></i></span>
                            <div>
                                <p class="story-label">Today</p>
                                <p class="story-title">A UK-wide revision library</p>
                                <p class="story-text">Open to every student, school and tutor — online.</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= VALUES ============================= -->
    <section class="why-section about-values">
        <div class="container">
            <div class="about-head">
                <p class="eyebrow justify-content-center"><span class="eyebrow-dot"></span>What we stand for</p>
                <h2 class="about-h2">The values behind every resource</h2>
                <p class="about-text mb-0">These principles guide how we write, check and price everything we publish.</p>
            </div>
            <div class="row g-3">
                @foreach($values as $v)
                    <div class="col-md-4">
                        <div class="resource-card {{ $v['class'] }}">
                            <span class="resource-icon"><i class="bi {{ $v['icon'] }}"></i></span>
                            <h3 class="resource-title">{{ $v['title'] }}</h3>
                            <p class="resource-text mb-0">{{ $v['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================= TEAM ============================= -->
    <section class="section about-section" id="team">
        <div class="container">
            <div class="about-head">
                <p class="eyebrow justify-content-center"><span class="eyebrow-dot"></span>Meet the team</p>
                <h2 class="about-h2">Certified tutors behind the resources</h2>
            </div>
            <div class="row g-3">
                @foreach($team as $m)
                    <div class="col-6 col-lg-3">
                        <div class="team-tile">
                            <span class="team-initials {{ $m['tint'] }}" aria-hidden="true">{{ $m['initials'] }}</span>
                            <h3 class="team-name">{{ $m['name'] }}</h3>
                            <p class="team-role">{{ $m['role'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================= NEWSLETTER ============================= -->
    <section class="about-newsletter">
        @include('frontend.includes.newsletter')
    </section>

</div>
@endsection