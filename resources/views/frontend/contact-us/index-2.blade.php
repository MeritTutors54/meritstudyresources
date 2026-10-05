@extends('layouts.frontend-3')

@section('title', $defaultSEO->meta_title ?? $global_seo['seo_title'])
@section('meta_description', $defaultSEO->meta_description ?? $global_seo['seo_description'])
@section('meta_keywords', $defaultSEO->meta_keywords ?? $global_seo['seo_keywords'])
@section('meta_author', $defaultSEO->meta_author ?? $global_seo['seo_author'])

@php
    use Illuminate\Support\Facades\Route;

    // Use a named route if it exists, otherwise fall back to a plain URL
    $link = fn ($name, $fallback) => Route::has($name) ? route($name) : url($fallback);

    $faqUrl     = $link('faq', '/faq');
    $termsUrl   = $link('terms', '/terms');
    $privacyUrl = $link('privacy.policy', '/privacy-policy');

    // Topic options — the value is what gets saved as "subject"
    $topics = [
        'A mistake in a resource',
        'Request a subject or paper',
        'A file will not open',
        'Copyright or takedown',
        'Working with us',
        'Something else',
    ];

    $email   = $settings->email ?? null;
    $phone   = $settings->phone ?? null;
    $address = $settings->address ?? null;
@endphp

@section('content')
<main id="main">

    {{-- ===================== HEADER ===================== --}}
    <section class="course-header" aria-labelledby="pageTitle">
        <div class="container">
            <div class="course-header-top">
                <nav aria-label="Breadcrumb">
                    <ol class="breadcrumb course-crumbs">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
                    </ol>
                </nav>
                <p class="spec-code">Replies within <span>2 working days</span></p>
            </div>
            <p class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Free resources<span class="eyebrow-sep" aria-hidden="true">/</span> No account needed</p>
            <h1 class="course-title" id="pageTitle">Contact <span class="course-title-board">us</span></h1>
            <p class="course-intro">Corrections, requests for a subject, or a question about a resource — this is the fastest way to reach us. We reply within two working days.</p>
        </div>
    </section>

    <div class="contact-body">
        <div class="container">
            <div class="row g-4">

                {{-- ===================== FORM ===================== --}}
                <div class="col-lg-7">
                    <div class="auth-card contact-card">
                        <h2 class="pane-title">Send us a message</h2>
                        <p class="pane-sub">Fields marked with * are required.</p>

                        @if (session('success'))
                            <p class="form-status d-block" role="status" aria-live="polite">
                                <i class="bi bi-check-circle" aria-hidden="true"></i> {{ session('success') }}
                            </p>
                        @endif

                        @if (session('error'))
                            <p class="field-error d-block mb-3" role="alert">{{ session('error') }}</p>
                        @endif

                        <form class="auth-form" action="{{ url()->current() }}" method="POST" novalidate>
                            @csrf

                            <div class="row g-3">
                                {{-- Name --}}
                                <div class="col-md-6">
                                    <div class="form-field">
                                        <label class="form-label" for="name">Your name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}"
                                               autocomplete="name" required
                                               @error('name') aria-invalid="true" aria-describedby="nameError" @enderror>
                                        @error('name')
                                            <p class="field-error d-block" id="nameError">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <div class="form-field">
                                        <label class="form-label" for="email">Email address *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}"
                                               autocomplete="email" required
                                               @error('email') aria-invalid="true" aria-describedby="emailError" @enderror>
                                        @error('email')
                                            <p class="field-error d-block" id="emailError">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Phone (kept from the old form) --}}
                            <div class="form-field">
                                <label class="form-label" for="phone">Phone number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}"
                                       autocomplete="tel" placeholder="+44 7700 900000"
                                       @error('phone') aria-invalid="true" aria-describedby="phoneError" @enderror>
                                @error('phone')
                                    <p class="field-error d-block" id="phoneError">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Topic (saved as "subject") --}}
                            <div class="form-field">
                                <label class="form-label" for="subject">What is it about? *</label>
                                <select class="form-select @error('subject') is-invalid @enderror"
                                        id="subject" name="subject" required
                                        @error('subject') aria-invalid="true" aria-describedby="subjectError" @enderror>
                                    <option value="" @selected(!old('subject'))>Choose a topic</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic }}" @selected(old('subject') === $topic)>{{ $topic }}</option>
                                    @endforeach
                                </select>
                                @error('subject')
                                    <p class="field-error d-block" id="subjectError">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Message --}}
                            <div class="form-field">
                                <label class="form-label" for="message">Message *</label>
                                <textarea class="form-control @error('message') is-invalid @enderror"
                                          id="message" name="message" rows="6" required
                                          placeholder="If it is about a specific resource, include the subject, board and paper."
                                          @error('message') aria-invalid="true" aria-describedby="messageError" @enderror>{{ old('message') }}</textarea>
                                <p class="field-hint">The more specific you are, the faster we can fix it.</p>
                                @error('message')
                                    <p class="field-error d-block" id="messageError">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Consent (saved as "agree_check") --}}
                            <div class="form-check form-check-inline-row">
                                <input class="form-check-input @error('agree_check') is-invalid @enderror"
                                       type="checkbox" id="agree_check" name="agree_check" value="1" required
                                       @checked(old('agree_check'))>
                                <label class="form-check-label" for="agree_check">
                                    I am happy for you to use my details to reply. See the <a href="{{ $privacyUrl }}">privacy policy</a>. *
                                </label>
                                @error('agree_check')
                                    <p class="field-error d-block">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-merit btn-lg">Send message <i class="bi bi-arrow-right" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>

                {{-- ===================== SIDE TILES ===================== --}}
                <div class="col-lg-5">
                    <div class="contact-side">

                        @if($email)
                            <div class="contact-tile">
                                <span class="resource-icon res-green-chip"><i class="bi bi-envelope" aria-hidden="true"></i></span>
                                <div>
                                    <h2 class="contact-tile-title">Email us</h2>
                                    <p class="contact-tile-text"><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                                </div>
                            </div>
                        @endif

                        @if($phone)
                            <div class="contact-tile">
                                <span class="resource-icon res-green-chip"><i class="bi bi-telephone" aria-hidden="true"></i></span>
                                <div>
                                    <h2 class="contact-tile-title">Call us</h2>
                                    <p class="contact-tile-text"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}">{{ $phone }}</a></p>
                                </div>
                            </div>
                        @endif

                        <div class="contact-tile">
                            <span class="resource-icon res-blue-chip"><i class="bi bi-clock" aria-hidden="true"></i></span>
                            <div>
                                <h2 class="contact-tile-title">When we reply</h2>
                                <p class="contact-tile-text">Monday to Friday, within two working days. Corrections to resources are usually same-day.</p>
                            </div>
                        </div>

                        <div class="contact-tile">
                            <span class="resource-icon res-amber-chip"><i class="bi bi-shield-check" aria-hidden="true"></i></span>
                            <div>
                                <h2 class="contact-tile-title">Copyright and takedowns</h2>
                                <p class="contact-tile-text">Rights holders: email us with the resource and we will act promptly. See the <a href="{{ $termsUrl }}">terms</a>.</p>
                            </div>
                        </div>

                        @if($address)
                            <div class="contact-tile">
                                <span class="resource-icon res-purple-chip"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
                                <div>
                                    <h2 class="contact-tile-title">Postal address</h2>
                                    <p class="contact-tile-text">{!! $address !!}</p>
                                </div>
                            </div>
                        @endif

                        <div class="request-panel contact-faq">
                            <div>
                                <h2 class="request-heading">Try the FAQs first</h2>
                                <p class="request-text">Most questions — file formats, exam boards, accounts — are answered there.</p>
                            </div>
                            <a class="btn btn-soft" href="{{ $faqUrl }}">Read the FAQs <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection