@extends('layouts.frontend-3')
@section('title', 'Teacher Library | Merit Study Resources')
@section('body_class', 'page-teacher')

@push('css')
    <link href="{{ asset('frontend/new/css/teacherspanel.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/new/css/teacherspanel-extra.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="tl-body">
        <div class="container py-5">
            <div class="lesson-list tl-coming">
                <p class="tl-empty">
                    <i class="bi bi-journal-bookmark"></i>
                    <strong>The Teacher Library is coming soon.</strong><br>
                    Ready-to-teach lessons, slides and worksheets are being added.
                    <br><a href="{{ route('contact-us') }}">Ask us about it <i class="bi bi-arrow-right"></i></a>
                </p>
            </div>
        </div>
    </div>
@endsection
