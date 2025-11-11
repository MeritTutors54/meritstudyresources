@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Past Papers - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')

    <div>
        <iframe src="{{ $link }}" style="width:100%; height:80vh; margin-top: 6%" frameborder="0"></iframe>
    </div>

@endsection
@section('js')
    <!-- Fancybox JS -->

@endsection
