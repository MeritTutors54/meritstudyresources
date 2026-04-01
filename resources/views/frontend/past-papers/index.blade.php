{{-- @extends('layouts.frontend', ['main_title' => $defaultSEO->meta_title ?? 'Past Papers - MeritStudyResources.co.uk' ]) --}}
@extends('layouts.frontend', [
    'main_title' => 
        ($params['category']['category_name'] ?? '') .
        (!empty($params['subcategory']) ? ' - ' . $params['subcategory']['subcategory_name'] : '') .
        (!empty($params['resubcategory']) ? ' - ' . $params['resubcategory']['resubcategory_name'] : '') .
        ' | ' . ($defaultSEO->meta_title ?? 'Past Papers - MeritStudyResources.co.uk')
])
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
                        <div class="search-bar active mb-5">
                            <form action="{{ route('past.papers', [null, null, null]) }}">
                                <input type="search"
                                       name="q" value="{{ old('q', $q ?? '') }}"
                                       placeholder="search any subject">
                                <button type="submit">Search</button>

                                <img src="{{ asset('frontend/assets/images/all-resources/search.png') }}" alt="">
                            </form>
                        </div>
                        <div class="resources_page_contents">
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
    <script>
        document.getElementById("toggleBtn").addEventListener("click", function () {
            const text = document.getElementById("descText");

            if (text.classList.contains("expanded")) {
                text.classList.remove("expanded");
                this.textContent = "See more";
            } else {
                text.classList.add("expanded");
                this.textContent = "See less";
            }
        });
    </script>
    <!-- Fancybox JS -->
    <script>
        $(".past-paper-button").on('click', function () {
            const modal = $("#showPDF");

            const paper_id = $(this).data('paper-id');
            const paper_type = $(this).data('type');

            const url = '{{ route('pdf.view', [':id', ':type']) }}'
            const route = url.replace(':id', paper_id);
            const link = route.replace(':type', paper_type);

            $('#pdfFrame').attr('src', link);
            modal.removeClass('d-none');
        })


        $(document).ready(function () {
            const firstButton = $("#paper-box").find('button').first();
            firstButton.addClass('active')
            firstButton.trigger('click'); // simulates a click
        })

        let accordionDom = $('#past-paper-accordion');

        $(".clickForPastPaper").on('click', function () {
            $(".clickForPastPaper").removeClass('active');
            $(this).addClass('active');

            accordionDom.html("");
            const spinner = $("#waiting-logo");
            spinner.removeClass('d-none');

            const type = $(this).data('type');
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
                    type: type,
                    category_id: categoryID,
                    subcategory_id: subCategoryID,
                    resubcategory_id: reSubCategoryID,
                    title: title
                },
                success: function (data) {

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

                            if(type === "all") {
                                paperLinks += '<div class="d-flex" style="width: 100%"><a href="' + quesLink + '" target="_blank" class="pdf-anchor">' +
                                    '<i class="feather-file-text" style="font-size: 18px; margin-right: 3px"></i>'+ paper.title +'</a>' +
                                    '<a href="' + markLink + '" target="_blank" class="ms-auto pdf-anchor"> ' +
                                    '<i class="feather-file-text" style="font-size: 18px; margin-right: 3px"></i> Mark Scheme</a> </div>'
                            } else {
                                paperLinks += '<a href="' + quesLink + '" target="_blank" class="pdf-anchor">' +
                                    '<i class="feather-file-text" style="font-size: 18px; margin-right: 3px"></i> Question</a>' +
                                    '<a href="' + markLink + '" target="_blank" class="ms-auto pdf-anchor"> ' +
                                    '<i class="feather-file-text" style="font-size: 18px; margin-right: 3px"></i> Mark Scheme</a>'
                            }
                        });

                        accordionDom.append(
                            '<div class="merit-menu-item mb-3 dynamic-base"> ' +
                            '<h2 class="merit-menu-header"> ' +
                            '<button class="menu-button" style="font-size: 24px" type="button" data-area-id="merit-menu-id-' + key + '">' + title +
                            '</button>' +
                            '</h2>' +
                            '<div id="merit-menu-id-' + key + '" class="merit-menu-dropdown-box">' +
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
