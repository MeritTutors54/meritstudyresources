@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Contact Us - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')

<div class="rbt-conatct-area bg-gradient-11 rbt-section-gap">
    <div class="container base-margin-top">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center mb--60">
                    <span class="subtitle bg-secondary-opacity">Contact Us</span>
                    <h2 class="title">
                        {{ $settings->name ?? '' }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="150"
                data-sal-duration="800">
                <div class="rbt-address">
                    <div class="icon">
                        <i class="feather-headphones"></i>
                    </div>
                    <div class="inner">
                        <h4 class="title">Contact Phone Number</h4>
                        <p><a href="tel:{{$settings->phone ?? ''}}">{{ $settings->phone ?? '' }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="200"
                data-sal-duration="800">
                <div class="rbt-address">
                    <div class="icon">
                        <i class="feather-mail"></i>
                    </div>
                    <div class="inner">
                        <h4 class="title">Our Email Address</h4>
                        <p><a href="mailto:{{ $settings->email ?? '' }}">{{ $settings->email ?? '' }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="250"
                data-sal-duration="800">
                <div class="rbt-address">
                    <div class="icon">
                        <i class="feather-map-pin"></i>
                    </div>
                    <div class="inner">
                        <h4 class="title">Our Location</h4>
                        <p>{!! $settings->address ?? '' !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="rbt-contact-address">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-lg-8">
                @include('layouts.frontend.notification')
                <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                    <div class="section-title text-start">
                        <span class="subtitle bg-primary-opacity">EDUCATION FOR EVERYONE</span>
                    </div>
                    <h3 class="title">Get a Free Course You Can Contact With Me</h3>
                    <form  method="POST" action="{{ url('/contact') }}"
                        class=" max-width-auto">
                        <div class="form-group">
                            @csrf
                            <input  name="name"
                                    value="{{ old('name') }}"
                                    id="contact-name" type="text">
                            <label>Name</label>
                            <span class="focus-border"></span>
                            @if ($errors->has('name'))
                                <div class="required text-danger mt-2">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <input name="email"
                                   value="{{ old('email') }}"
                                   type="email">
                            <label>Email</label>
                            <span class="focus-border"></span>
                            @if ($errors->has('email'))
                                <div class="required text-danger mt-2">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="text" value="{{ old('phone') }}" name="phone">
                            <label>Phone</label>
                            <span class="focus-border"></span>
                            @if ($errors->has('phone'))
                                <div class="required text-danger mt-2">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="text" id="subject" value="{{ old('subject') }}" name="subject">
                            <label>Your Subject</label>
                            <span class="focus-border"></span>
                            @if ($errors->has('subject'))
                                <div class="required text-danger mt-2">{{ $errors->first('subject') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <textarea name="message" id="contact-message">{{ old('message') }}</textarea>
                            <label>Message</label>
                            <span class="focus-border"></span>
                            @if ($errors->has('message'))
                                <div class="required text-danger mt-2">{{ $errors->first('message') }}</div>
                            @endif
                        </div>
                        <div class="form-submit-group">
                            <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">GET IT NOW</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
