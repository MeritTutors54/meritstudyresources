@extends('layouts.frontend-2', ['main_title' => $defaultSEO->meta_title ?? 'Contact Us - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <!-- ============================= PAGE HEADER ============================= -->
    <header class="page-banner text-center">
        <div class="container">
            <div class="breadcrumb-msr mb-3 text-center"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; Contact Us</div>
            <span class="eyebrow"><span class="divider-dot"></span> GET IN TOUCH</span>
            <h1 class="mt-4 mb-3">We'd love to hear <span class="text-green">from you.</span></h1>
            <p class="lead-muted mx-auto mb-0" style="max-width:560px;">Questions about a plan, a missing paper, or a school partnership — our team replies within one working day.</p>
        </div>
    </header>

    <!-- ============================= CONTACT INFO CARDS ============================= -->
    <section class="section-pad" style="padding-top:50px;padding-bottom:20px;">
        <div class="container">
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="contact-info-card">
                        <span class="ci-ico"><svg viewBox="0 0 24 24" fill="none"><path d="M3 6h18v12H3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></span>
                        <h3>Email Us</h3>
                        <p>We reply within 24 hours</p>
                        <a href="mailto:{{ $settings->email ?? '' }}">{{ $settings->email ?? '' }}</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="contact-info-card">
                        <span class="ci-ico"><svg viewBox="0 0 24 24" fill="none"><path d="M6.6 10.8a15.5 15.5 0 006.6 6.6l2.2-2.2a1.2 1.2 0 011.2-.3c1.3.4 2.7.6 4.1.6a1.2 1.2 0 011.2 1.2v3.7a1.2 1.2 0 01-1.2 1.2C10.6 21.6 2.4 13.4 2.4 3.2A1.2 1.2 0 013.6 2h3.7a1.2 1.2 0 011.2 1.2c0 1.4.2 2.8.6 4.1.1.4 0 .9-.3 1.2l-2.2 2.3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></span>
                        <h3>Call Us</h3>
                        <p>Mon–Fri, 9am–5pm GMT</p>
                        <a href="tel:{{$settings->phone ?? ''}}">{{ $settings->phone ?? '' }}</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="contact-info-card">
                        <span class="ci-ico"><svg viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-4.4-9.5-9C.7 8 2.6 4.5 6 4c2-.3 3.6.6 4.9 2 1.3-1.4 2.9-2.3 4.9-2 3.4.5 5.3 4 3.5 8-2.5 4.6-9.5 9-9.5 9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></span>
                        <h3>Visit Us</h3>
                        <p>Merit Tutors, Exam Centre</p>
                        <a href="#officeMap">{!! $settings->address ?? '' !!}</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="contact-info-card">
                        <span class="ci-ico"><svg viewBox="0 0 24 24" fill="none"><path d="M21 11.5a8.4 8.4 0 01-8.9 8.4 8.6 8.6 0 01-3.4-.7L3 20l1-5.5a8.4 8.4 0 1117-3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></span>
                        <h3>Live Chat</h3>
                        <p>Available on paid plans</p>
                        <a href="#">Open Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================= FORM + OFFICE PANEL ============================= -->
    <section class="section-pad" style="padding-top:24px;">
        <div class="container">
            <div class="row g-4">
                <!-- CONTACT FORM -->
                <div class="col-lg-7">
                    <div class="contact-form-panel">
                        <span class="eyebrow"><span class="divider-dot"></span> SEND A MESSAGE</span>
                        <h2 class="mt-3 mb-4" style="font-size:1.5rem;">Fill in the form below</h2>
                        @if(Session::has('success'))
                            <div class="alert alert-success background-success">
                                <p class="m-0"><strong>Success!</strong> {{ Session::get('success') }}</p>
                            </div>
                        @endif
                        <form
                            method="POST">
                            @csrf
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <label class="form-label-msr" for="cName">Full name</label>
                                    <input value="{{ old('name') }}"
                                           name="name"
                                           type="text" id="cName" class="form-control-msr" placeholder="Jane Doe">
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-msr" for="cEmail">Email address</label>
                                    <input type="email"
                                           value="{{ old('email') }}"
                                           name="email"
                                           id="cEmail" class="form-control-msr" placeholder="you@example.com">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-1">
                                <div class="col-md-12">
                                    <label class="form-label-msr" for="phone">Phone Number</label>
                                    <input value="{{ old('phone') }}"
                                           name="phone"
                                           type="text" id="phone" class="form-control-msr" placeholder="+123 456 7890">
                                    @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-1 mt-3">
                                <label class="form-label-msr" for="cSubject">I'm getting in touch about</label>
                                <select id="cSubject" name="subject" class="form-control-msr">
                                    <option value="" selected disabled>Select a topic</option>
                                    <option value="General enquiry">General enquiry</option>
                                    <option value="Billing and subscriptions">Billing &amp; subscriptions</option>
                                    <option value="Missing or incorrect paper">Missing or incorrect paper</option>
                                    <option value="School or bulk licensing">School / bulk licensing</option>
                                    <option value="Technical issue">Technical issue</option>
                                    <option value="Something else">Something else</option>
                                </select>
                                @error('subject')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-1 mt-3">
                                <label class="form-label-msr" for="cMessage">Message</label>
                                <textarea id="cMessage"
                                          name="message"
                                          class="form-control-msr" placeholder="Tell us a little about what you need..."></textarea>
                                @error('message')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <label class="form-check-msr my-3">
                                <input type="checkbox" name="agree_check"> I agree to the
                                <a href="{{ route('privacy.policy') }}"
                                   style="color:var(--green-dark);font-weight:600;margin-left:4px;">
                                    Privacy Policy
                                </a>
                                @error('agree_check')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </label>

                            <button type="submit" class="btn-brand btn-brand-block">
                                Send Message
                                <svg viewBox="0 0 24 24" fill="none" width="16" height="16"><path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <p id="contactSuccess" class="text-center mt-3 mb-0 d-none" style="color:var(--green-dark);font-weight:600;font-size:.9rem;">
                                ✓ Thanks — your message has been sent. We'll be in touch soon.
                            </p>
                        </form>
                    </div>
                </div>

                <!-- OFFICE PANEL -->
                <div class="col-lg-5">
                    <div class="office-panel" id="officeMap">
                        <div class="office-map">
                            <svg viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-4.4-9.5-9C.7 8 2.6 4.5 6 4c2-.3 3.6.6 4.9 2 1.3-1.4 2.9-2.3 4.9-2 3.4.5 5.3 4 3.5 8-2.5 4.6-9.5 9-9.5 9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        </div>

                        <div class="office-row">
                            <span class="or-ico"><svg viewBox="0 0 24 24" fill="none"><path d="M12 21s-7-4.4-9.5-9C.7 8 2.6 4.5 6 4c2-.3 3.6.6 4.9 2 1.3-1.4 2.9-2.3 4.9-2 3.4.5 5.3 4 3.5 8-2.5 4.6-9.5 9-9.5 9z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></span>
                            <div><h4>Head Office</h4><p>Merit Tutors, Exam Centre London, {!! $settings->address ?? '' !!}</p></div>
                        </div>
                        <div class="office-row">
                            <span class="or-ico"><svg viewBox="0 0 24 24" fill="none"><path d="M3 6h18v12H3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></span>
                            <div><h4>Email</h4><p>{{ $settings->email ?? '' }}</p></div>
                        </div>
                        <div class="office-row">
                            <span class="or-ico"><svg viewBox="0 0 24 24" fill="none"><path d="M6.6 10.8a15.5 15.5 0 006.6 6.6l2.2-2.2a1.2 1.2 0 011.2-.3c1.3.4 2.7.6 4.1.6a1.2 1.2 0 011.2 1.2v3.7a1.2 1.2 0 01-1.2 1.2C10.6 21.6 2.4 13.4 2.4 3.2A1.2 1.2 0 013.6 2h3.7a1.2 1.2 0 011.2 1.2c0 1.4.2 2.8.6 4.1.1.4 0 .9-.3 1.2l-2.2 2.3z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg></span>
                            <div><h4>Phone</h4><p>{{ $settings->phone ?? '' }}</p></div>
                        </div>

                        <div class="office-hours">
                            <p class="fw-semibold mb-2" style="color:#fff;font-size:.85rem;">Support hours</p>
                            <div class="office-hours-row"><span>Monday – Friday</span><span>9:00 – 17:00</span></div>
                            <div class="office-hours-row"><span>Saturday</span><span>10:00 – 14:00</span></div>
                            <div class="office-hours-row"><span>Sunday</span><span>Closed</span></div>
                        </div>

{{--                        <div class="office-social">--}}
{{--                            <a href="#" class="social-ico"><svg viewBox="0 0 24 24" fill="#fff"><path d="M13.5 9H15V6.5h-1.5C12 6.5 11 7.6 11 9.5V11H9.5v2.3H11V18h2.3v-4.7h1.7l.3-2.3h-2V9.6c0-.4.2-.6.6-.6z"/></svg></a>--}}
{{--                            <a href="#" class="social-ico"><svg viewBox="0 0 24 24" fill="#fff"><path d="M21 5.9c-.7.3-1.5.5-2.3.6.8-.5 1.4-1.3 1.7-2.3-.8.5-1.7.8-2.6 1A3.7 3.7 0 0012 7.6c0 .3 0 .6.1.9C8.9 8.4 6 6.8 4 4.4c-.4.6-.6 1.3-.6 2.1 0 1.4.7 2.6 1.8 3.4-.7 0-1.3-.2-1.9-.5 0 2 1.4 3.6 3.2 4-.4.1-.7.1-1.1.1-.3 0-.5 0-.8-.1.5 1.6 2 2.8 3.8 2.8a7.5 7.5 0 01-4.6 1.6c-.3 0-.6 0-.9-.1A10.5 10.5 0 0010 19.5c6.4 0 9.9-5.3 9.9-9.9v-.5c.7-.5 1.3-1.2 1.8-1.9-.6.3-1.3.5-2 .6z"/></svg></a>--}}
{{--                            <a href="#" class="social-ico"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="none" stroke="#fff" stroke-width="1.6"/><circle cx="12" cy="12" r="3.4" fill="none" stroke="#fff" stroke-width="1.6"/><circle cx="16.6" cy="7.4" r="1" fill="#fff"/></svg></a>--}}
{{--                        </div>--}}
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================= FAQ TEASER ============================= -->
    <section class="section-pad bg-mint" style="padding-top:50px;">
        <div class="container text-center">
            <span class="eyebrow"><span class="divider-dot"></span> STILL UNSURE?</span>
            <h2 class="mt-3 mb-3" style="font-size:1.7rem;">Check our frequently asked questions first</h2>
            <p class="lead-muted mx-auto mb-4" style="max-width:480px;">Many billing, subscription and download questions are already answered there.</p>
            <a href="faq.html" class="btn-brand">
                Visit FAQs
                <svg viewBox="0 0 24 24" fill="none" width="16" height="16"><path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
        </div>
    </section>
@endsection
