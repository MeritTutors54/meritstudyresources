@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Past Papers - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="resources-page-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="resources-page-area">
                        <div class="mb-5">
                            <form action="{{ route('past-paper.search') }}">
                                @csrf
                                <div class="d-flex custom-filter-bar">

                                    <select name="category" id="category-filter">
                                        <option value="">Select Category...</option>
                                        @if(!empty($filter['category']))
                                            @foreach($filter['category'] as $category)
                                                <option
                                                    {{ $category->slug == $value['category'] ? 'selected' : '' }}
                                                    value="{{ $category->slug }}">{{ ucfirst($category->category_name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    <select class="ms-3" id="subcategory-filter">
                                        <option value="">Select Subcategory...</option>
                                        @if(!empty($filter['subcategory']))
                                            @foreach($filter['subcategory'] as $subcategory)
                                                <option
                                                    {{ $subcategory->slug == $value['subcategory'] ? 'selected' : '' }}
                                                    value="{{ $subcategory->slug }}">{{ ucfirst($subcategory->subcategory_name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>

{{--                                    <select class="ms-3">--}}
{{--                                        <option value="">Select Resubcategory...</option>--}}
{{--                                    </select>--}}

                                    <select class="ms-3">
                                        <option value="">Select year...</option>
                                    </select>

                                    <button class="ms-3">Filter</button>
                                </div>
                            </form>
                        </div>

                        {{--                        <div class="search-bar active mb-5">--}}
                        {{--                            <form action="{{ route('past-paper.search') }}">--}}
                        {{--                                @csrf--}}
                        {{--                                <input type="search" name="q" placeholder="search any topic/content">--}}
                        {{--                                <button type="submit">Search</button>--}}

                        {{--                                <img src="{{ asset('frontend/assets/images/all-resources/search.png') }}" alt="">--}}
                        {{--                            </form>--}}
                        {{--                        </div>--}}
                        <div class="resources_page_contents">
                            <!-- Start Left Site -->
                            <div class="resources_page_left_main">
                                <div class="resources_page_left">
                                    {{--                                    <div class="search-bar active">--}}
                                    {{--                                        <form>--}}
                                    {{--                                            <input type="search" placeholder="search any topic/content">--}}
                                    {{--                                            <img src="assets/images/merithub/all-resources/search.png" alt="">--}}
                                    {{--                                        </form>--}}
                                    {{--                                    </div>--}}
                                    <div class="resources_page_left_contents">
                                        @include('frontend.past-papers.filter._left_side')
                                    </div>
                                </div>
                            </div>
                            <!-- End Left Site -->

                            <!-- Start Right Site -->
                            <div class="resources_page_right">
                                @include('frontend.past-papers.filter._right_side')
                            </div>
                            <!-- End Right Site -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

    </script>
    <script>
        let params = 'category=';

        $("#category-filter").on('change', function () {
            const value = $(this).val();
            params += value;

        })



        $("#subcategory-filter").on('change', function() {
            const cat = getUrlParam('category');
            const t = $("#category-filter").val();
            const value = $(this).val();
            params += cat + "&subcategory=" + value;
            callUrl();
        })

        function callUrl() {
            const search_route = "{{ route('past-paper.search') }}";
            window.location.href = search_route + '?' + params
        }

        function getUrlParam(name) {
            const url = new URL(window.location.href);
            return url.searchParams.get(name);
        }
    </script>
@endsection
