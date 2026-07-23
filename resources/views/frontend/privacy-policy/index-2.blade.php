@extends('layouts.frontend-2', ['main_title' => $defaultSEO->meta_title ?? 'Privacy Policies - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')

    <header class="page-banner">
        <div class="container">
            <div class="breadcrumb-msr mb-3"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; Privacy Policy</div>
            <span class="eyebrow"><span class="divider-dot"></span> LEGAL</span>
            <h1 class="mt-4 mb-3">Privacy <span class="text-green">Policy.</span></h1>
            <p class="lead-muted mb-3" style="max-width:600px;">How Merit Study Resources collects, uses and protects
                your personal information.</p>
            <span class="update-chip">
                <svg viewBox="0 0 24 24" fill="none" width="14" height="14"><path d="M12 7v5l3.5 2" stroke="#fff"
                                                                                  stroke-width="1.8"
                                                                                  stroke-linecap="round"/><circle
                        cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.8"/></svg>
                Last updated: 1 July 2026
            </span>
        </div>
    </header>

    <!-- ============================= LEGAL CONTENT ============================= -->
    <section class="section-pad">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <div class="legal-sidebar">
                        <p class="fw-semibold text-uppercase small text-muted-c mb-3" style="letter-spacing:.08em;">On
                            this page</p>
                        @if(!empty($privacyPolicy))
                            @foreach($privacyPolicy as $k => $policy)
                                <a class="side-link" href="#{{ $k}}">{{ $k + 1 }}. {{ $policy->title }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="legal-content">
                        <p>Merit Study Resources ("we", "us", "our") provides past papers, worksheets and revision
                            resources to students, parents, tutors and schools across the UK. This Privacy Policy
                            explains what personal data we collect through meritstudyresource.co.uk, why we collect it,
                            and the choices you have.</p>

                        @if(!empty($privacyPolicy))
                            @foreach($privacyPolicy as $k => $policy)
                                <h2 id="{{ $k }}"><span class="num-badge">{{ sprintf('%02d', $k + 1) }}</span> {{ $policy->title }}</h2>
                                <p>{{ $policy->description }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
