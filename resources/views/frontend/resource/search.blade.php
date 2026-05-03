@extends('layouts.frontend', ['main_title' => 'Search - Resource - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('page-css')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />
@endsection
@section('content')
    <div class="resources-page-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="resources-page-area">
                        <div class="search-bar active mb-5">
                            <form action="{{ route('resource.search') }}">
                                <input type="search"
                                       name="q"
                                       value="{{ old('q', $q ?? '') }}"
                                       placeholder="search any topic/content">
                                <button type="submit">Search</button>
                                <img src="{{ asset("frontend/assets/images/all-resources/search.png")}}" alt="">
                            </form>
                        </div>
                        <div class="resources_page_contents">
                            <!-- Start Left Site -->
                            <div class="resources_page_left_main">
                                <div class="resources_page_left">
                                    <div class="resources_page_left_contents">
                                        @if(!empty($tree))
                                            @foreach($tree as $keyOne => $branchOne)
                                                <div class="rplc_title">
                                                    <h6><i>{{ ucfirst($branchOne['_meta']['name']) }}</i></h6>
                                                </div>
                                                @foreach($branchOne['subjects'] as $branchTwo)
                                                    <p>{{ ucfirst($branchTwo['_meta']['name']) }} WorkSheet</p>
                                                    @php $key = 0 @endphp
                                                    <div class="merit-menu-box mt-3" style="margin-bottom: 2.5rem">
                                                        @foreach($branchTwo['groups'] as $branchThree)
                                                            <div class="merit-menu-item">
                                                                <h2 class="merit-menu-header">
                                                                    <button
                                                                        class="menu-button active"
                                                                        type="button"
                                                                        data-bs-toggle="merit-div-id-{{$key}}">
                                                                        {{ ucfirst($branchThree['_meta']['name']) }}
                                                                    </button>
                                                                </h2>
                                                                <div id="merit-div-id-{{$key}}"
                                                                     class="merit-menu-dropdown-box show">
                                                                    <div class="merit-menu-body">
{{--                                                                        <ul class="rplc_dropdown mt-1">--}}
{{--                                                                            @if(isset($branchThree['parents']))--}}
{{--                                                                                @foreach($branchThree['parents'] as $branchFour)--}}
{{--                                                                                    <li>--}}
{{--                                                                                        <a href="#" class="active">--}}
{{--                                                                                            {{ $branchFour['_meta']['name'] }}--}}
{{--                                                                                            <i class="fa-solid fa-angle-down"></i>--}}
{{--                                                                                        </a>--}}
{{--                                                                                        <ul class="rplc_dropdown_items">--}}
{{--                                                                                            @foreach($branchFour['topics'] as $branchFive)--}}
{{--                                                                                                <li>--}}
{{--                                                                                                    <a class="active"--}}
{{--                                                                                                        href="{{ route('resources.topic', [$branchOne['_meta']['slug'], $branchTwo['_meta']['slug'], $branchThree['_meta']['slug'], $branchFour['_meta']['slug'], $branchFive['_meta']['slug']]) }}"--}}
{{--                                                                                                    >--}}
{{--                                                                                                        {{ $branchFive['_meta']['name'] }}--}}
{{--                                                                                                    </a>--}}
{{--                                                                                                </li>--}}
{{--                                                                                            @endforeach--}}
{{--                                                                                        </ul>--}}
{{--                                                                                    </li>--}}
{{--                                                                                @endforeach--}}
{{--                                                                            @else--}}
{{--                                                                                @foreach($branchThree['topics'] as $branchFour)--}}
{{--                                                                                    <li>--}}
{{--                                                                                        <a class="active link"--}}
{{--                                                                                            href="{{ route('resources.topic', [$branchOne['_meta']['slug'], $branchTwo['_meta']['slug'], $branchThree['_meta']['slug'], $branchFour['_meta']['slug']]) }}"--}}
{{--                                                                                        >--}}
{{--                                                                                            {{ $branchFour['_meta']['name'] }}--}}
{{--                                                                                        </a>--}}
{{--                                                                                    </li>--}}
{{--                                                                                @endforeach--}}
{{--                                                                            @endif--}}
{{--                                                                        </ul>--}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    @php $key++ @endphp
                                                @endforeach
                                            @endforeach
                                            @endforeach
                                        @else
                                            <div>
                                                Nothing found
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- End Left Site -->

                            <!-- Start Right Site -->
                            <div class="resources_page_right">
                                <div class="resources_page_right_items_all mt-0">
                                    <div class="rpri_title">
                                        <h3>Search Results For "{{ $q ?? '' }}"</h3>
                                    </div>
{{--                                    <div class="resources_page_right_items">--}}
{{--                                        @if(!empty($resources))--}}
{{--                                            @foreach($resources as $resource)--}}
{{--                                                <div class="rpr_single_item clickable"--}}
{{--                                                     data-link="{{ route("resources.topic.details", [$resource, $resource->slug]) }}"--}}
{{--                                                >--}}
{{--                                                    <img--}}
{{--                                                        src="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->thumbnail_image)) }}"--}}
{{--                                                        alt="">--}}
{{--                                                    <a href="#" class="rpri_pages">--}}
{{--                                                        <img--}}
{{--                                                            src="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->thumbnail_image)) }}"--}}
{{--                                                            alt="">--}}
{{--                                                        {{ $resource->allPage->count() }}--}}
{{--                                                    </a>--}}

{{--                                                    <div class="rpri_writen">--}}
{{--                                                        <h6>{{ ucfirst($resource->name) }}</h6>--}}
{{--                                                        <p>{{ ucfirst($resource->description) }}</p>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
                                </div>
                                {{--                                @endif--}}
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
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind("[data-fancybox]", {});

        function downloadFile(url, filename) {
            console.log(url)
            // Create a temporary anchor element
            var a = document.createElement('a');
            a.href = url;
            a.download = filename + '.pdf' || 'download.pdf';

            // Trigger the click programmatically
            document.body.appendChild(a);
            a.click();

            // Clean up
            document.body.removeChild(a);
            $(".downloadFile").prop("disabled", false);
        }

        $(".downloadFile").on('click', function () {
            $(".downloadFile").prop("disabled", true);
            let slug = $(this).data('slug');
            let name = $(this).data('name');
            const url = '{{ route('user.ajax.download.pdf') }}';

            $.ajax({
                url: url, // your actual filename
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    _slug: slug
                },
                success: function (response) {
                    if (response.fileUrl) {
                        downloadFile(response.fileUrl, response.filename);
                    }
                },
                error: function (error) {
                    $(".downloadFile").prop("disabled", false);
                    alert(error.responseJSON.message);
                }
            });
        });

        $(".clickable").on("click", function () {
            let href = $(this).data('link');
            window.location.replace(href);
        })

        {{--$("#topic_input").on('input', function() {--}}
        {{--    let value =  $(this).val();--}}

        {{--    if (value.length > 2) {--}}
        {{--        $.ajax({--}}
        {{--            url: "{{ route('search-all') }}",--}}
        {{--            type: "post",--}}
        {{--            dataType: 'json',--}}
        {{--            data: {--}}
        {{--                _token: "{{ csrf_token() }}",--}}
        {{--                q: value--}}
        {{--            },--}}
        {{--            success: function (data) {--}}
        {{--                console.log(data)--}}
        {{--                $(".resources_page_left_contents").html("");--}}

        {{--            }--}}
        {{--        });--}}
        {{--    }--}}
        {{--})--}}
    </script>
@endsection
