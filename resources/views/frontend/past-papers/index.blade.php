@extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Past Papers - MeritStudyResources.co.uk'])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
@section('content')
    <div class="resources-page-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="resources-page-area">
                        <div class="search-bar active">
                            <form action="{{ route('past.papers', [null, null, null]) }}">
                                <input type="search" name="q" value="{{ old('q', $q ?? '') }}"
                                    placeholder="search any subject">
                                <button type="submit">Search</button>

                                <img src="{{ asset('frontend/assets/images/all-resources/search.png') }}" alt="">
                            </form>
                            @if (!empty($q))
                                <div id="mode-buttons" class="d-flex justify-content-center gap-5 mt-2">
                                    <a class="btn_sm_outlook" mode="1"
                                        href="{{ route('past.papers') . '?q=' . $q . '&mode=1' }}">
                                        Past Papers
                                    </a>
                                    <a class="btn_sm_outlook" mode="2"
                                        href="{{ route('past.papers') . '?q=' . $q . '&mode=2' }}">
                                        Categories
                                    </a>
                                    <a class="btn_sm_outlook" mode="3"
                                        href="{{ route('past.papers') . '?q=' . $q . '&mode=3' }}">
                                        Sub Categories
                                    </a>
                                    <a class="btn_sm_outlook" mode="4"
                                        href="{{ route('past.papers') . '?q=' . $q . '&mode=4' }}">
                                        Resub Categories
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="resources_page_contents mt-3">
                            <!-- Start Left Site -->
                            <div class="resources_page_left_main">
                                <div class="resources_page_left">
                                    <div class="resources_page_left_contents">
                                        @include('frontend.past-papers._left_side')
                                    </div>
                                </div>
                            </div>
                            <!-- End Left Site -->

                            <!-- Start Right Site -->
                            <div class="resources_page_right">
                                @include('frontend.past-papers._right_side')
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
    <!-- Fancybox JS -->
    <script>
        $(".past-paper-button").on('click', function() {
            const modal = $("#showPDF");

            const paper_id = $(this).data('paper-id');
            const paper_type = $(this).data('type');

            const url = '{{ route('pdf.view', [':id', ':type']) }}'
            const route = url.replace(':id', paper_id);
            const link = route.replace(':type', paper_type);

            $('#pdfFrame').attr('src', link);
            modal.removeClass('d-none');
        })


        $(document).ready(function() {
            const firstButton = $("#paper-box").find('button').first();
            firstButton.addClass('active')
            firstButton.trigger('click'); // simulates a click

            // this section is responsible for speacial depedency searches
            var anchorMode = getUrlParameter('mode');
            console.log(anchorMode, 'anchorMode');
            if (anchorMode) {
                $('#mode-buttons').find('a').each(function() {
                    if ($(this).attr('mode') === anchorMode) {
                        $(this).addClass('active');
                    } else {
                        $(this).removeClass('active');
                    }
                });
            }
        })

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };

        let accordionDom = $('#past-paper-accordion');

        $(".clickForPastPaper").on('click', function() {
            $(".clickForPastPaper").removeClass('active');
            $(this).addClass('active');

            accordionDom.html("");
            const spinner = $("#waiting-logo");
            spinner.removeClass('d-none');

            const categoryID = $(this).data('category');
            const subCategoryID = $(this).data('subcategory');
            const reSubCategoryID = $(this).data('resubcategory');
            const title = $(this).data('title')

            let key = 0;

            $.ajax({
                type: 'POST',
                dataType: "json",
                url: "{{ route('ajax.get.past.paper') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    category_id: categoryID,
                    subcategory_id: subCategoryID,
                    resubcategory_id: reSubCategoryID,
                    title: title
                },
                success: function(data) {

                    accordionDom.append(
                        '<div class="d-flex justify-content-end mb-4"> ' +
                        '<button class="btn btn-secondary-outline btn-expend">Expend All </button> ' +
                        '</div>'
                    );

                    Object.entries(data).forEach(([title, item]) => {
                        const mainLink = '{{ asset('uploads/pastpaper') }}'
                        let paperLinks = '';
                        item.forEach((paper, i) => {
                            const quesLink = mainLink + '/' + paper.ques_paper ?? '#';
                            const markLink = mainLink + '/' + paper.ans_paper ?? '#';

                            paperLinks += '<a href="' + quesLink +
                                '" target="_blank" class="pdf-anchor">' +
                                '<i class="feather-file-text" style="font-size: 18px; margin-right: 3px"></i> Question</a>' +
                                '<a href="' + markLink +
                                '" target="_blank" class="ms-auto pdf-anchor"> ' +
                                '<i class="feather-file-text" style="font-size: 18px; margin-right: 3px"></i> Mark Scheme</a>'
                        });

                        accordionDom.append(
                            '<div class="merit-menu-item mb-3 dynamic-base"> ' +
                            '<h2 class="merit-menu-header"> ' +
                            '<button class="menu-button" style="font-size: 24px" type="button" data-area-id="merit-menu-id-' +
                            key + '">' + title +
                            '</button>' +
                            '</h2>' +
                            '<div id="merit-menu-id-' + key +
                            '" class="merit-menu-dropdown-box">' +
                            '<div class="merit-menu-body"> ' +
                            '<ul class="rplc_dropdown mt-1"> ' +
                            '<li><h5>Questions and Marksheet</h5></li> ' +
                            '<li><div class="paper-zone">' + paperLinks + '</div></li> ' +
                            '</ul> ' +
                            '</div> ' +
                            '</div> ' +
                            '</div>'
                        );

                        key++;
                    });

                    spinner.addClass('d-none');
                }
            })
        })
    </script>
@endsection
