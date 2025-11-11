@extends('layouts.frontend', ['main_title' => 'All Resource - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $seoCore['description'] ?? $defaultSEO->meta_description ?? '' }}">
    <meta name="title" content="{{ $seoCore['title'] ?? $defaultSEO->title ?? '' }}">
    <meta name="keywords" content="{{ $seoCore['keywords'] ?? $defaultSEO->meta_keywords ?? '' }}">
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
                                       placeholder="search any topic/content">
                                <button type="submit">Search</button>
                                <img src="{{ asset("frontend/assets/images/all-resources/search.png")}}" alt="">
                            </form>
                        </div>
                        <div class="resources_page_contents">
                            <!-- Start Left Site -->
                            @include('frontend.resource.support._left_side')

                            <!-- End Left Site -->

                            <!-- Start Right Site -->
                            @include('frontend.resource.support._right_side')
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


        $(".third-child-button").on('click', function (e) {
            $('.third-child-button').removeClass('active');
            $('.third-child-box').addClass('d-none');

            $(this).addClass('active');

            let target = $(this).attr('href');
            $(target + '-third-box').removeClass('d-none').hide().fadeIn(100);

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
