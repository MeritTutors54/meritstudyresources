@extends('layouts.frontend-2')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])


@section('content')
    <div class="page-banner">
        <div class="container">
            <div class="breadcrumb-msr mb-3"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; Refund Policy
            </div>
            <span class="eyebrow"><span class="divider-dot"></span> LEGAL</span>
            <h1 class="mt-4 mb-3">Refund <span class="text-green">Policy.</span></h1>
            <p class="lead-muted mb-3" style="max-width:600px;">Please read these refund policies carefully before using Merit
                Study Resources or subscribing to a plan.</p>
            <span class="update-chip">
                <svg viewBox="0 0 24 24" fill="none" width="14" height="14">
                    <path d="M12 7v5l3.5 2" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/>
                    <circle cx="12" cy="12" r="9" stroke="#fff" stroke-width="1.8"/>
                </svg>
                Last updated: 1 July 2026
            </span>
        </div>
    </div>

    <section class="section-pad">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <div class="legal-sidebar">
                        <p class="fw-semibold text-uppercase small text-muted-c mb-3" style="letter-spacing:.08em;">On
                            this page</p>
                        @if(!empty($refunds))
                            @foreach($refunds as $k => $refund)
                                <a class="side-link" href="#{{ $k }}-trem">{{ $k + 1 }}. {{ $refund->title }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="legal-content">
                        <p>These refund policy govern your use of meritstudyresource.co.uk and any
                            subscription, download or service purchased from Merit Study Resources ("we", "us", "our").
                            By creating an account or using the site, you agree to these terms.</p>

                        @if(!empty($refunds))
                            @foreach($refunds as $k => $refund)
                                <h2 id="{{ $k }}-term"><span
                                        class="num-badge">{{ sprintf('%02d', $k + 1) }}</span> {{ $refund->title }}</h2>
                                <p>{!! $refund->description !!}</p>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
