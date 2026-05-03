@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <?php
            if (isset($past_paper)) {
                $actionUrl = route('admin.past-papers.update', ['past_paper' => $past_paper]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.past-papers.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Past Papers</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.past-papers.index') }}">
                                            Past Papers
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Past Papers</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">{{ $scope }} Past Papers</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <!-- /.box-header -->
                            <form action="{{ $actionUrl }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method($method)
                                @include('backend.past-paper._field')
                            </form>
                        </div>
                    </div>
                    @if(isset($past_paper))
                        <div class="col-lg-4 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Extra Option</h4>
                                </div>


                                <div>
                                    <div class="box-body">
                                        <div class="row mb-4">
                                            <div class="col-lg-12">
                                                <h5><strong>Question Paper:</strong></h5>
                                                @if(!empty($past_paper->ques_paper))
                                                    <a target="_blank"
                                                       href="{{  asset('uploads/pastpaper/' . $past_paper->ques_paper) }}">
                                                        <img width="50" src="{{ asset('pdf.png') }}" alt=""/>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5><strong>Mark Scheme</strong></h5>
                                                @if(!empty($past_paper->ans_paper))
                                                    <a target="_blank"
                                                       href="{{  asset('uploads/pastpaper/' . $past_paper->ans_paper) }}">
                                                        <img width="50" src="{{ asset('pdf.png') }}" alt=""/>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#video_solution_id').change(function () {
            if ($(this).prop('checked')) {
                $('#video_section').show();
            } else {
                $('#video_section').hide();
            }
        });

        $('#pdf_solution_id').change(function () {
            if ($(this).prop('checked')) {
                $('#pdf_solution_section').show();
            } else {
                $('#pdf_solution_section').hide();
            }
        });

        $('#video_link_id').on('change', function () {
            if ($(this).prop('checked')) {
                $('#video_link_section').show();
                $('#video_uploads_section').hide();
            } else {
                $('#pdf_solution_section').hide();
                $('#video_uploads_section').show();
            }
        });

        $('#video_uploads_id').on('change', function () {
            if ($(this).prop('checked')) {
                $('#video_link_section').hide();
                $('#video_uploads_section').show();
            } else {
                $('#video_link_section').show();
                $('#video_uploads_section').hide();
            }
        });
    </script>

    <script>
        function getSubCategory(el) {
            const category_id = $("#category").val();
            const subCategoryTag = $('#subcategory');

            if (category_id) {
                const route = "{{  route('admin.ajax.getSubCategory', [":category_id"]) }}";
                const url = route.replace(':category_id', category_id);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {

                        subCategoryTag.empty();
                        subCategoryTag.append('<option selected disabled>Select</option>');
                        $.each(data, function (index, districtObj) {
                            subCategoryTag.append('<option value="' + districtObj.id + '">' +
                                districtObj.subcategory_name + '</option>');
                        });
                    }
                });
            } else {
                alert('sorry data not found');
            }

        }

        function getReSubCategory(el) {
            const subcategory_id = $("#subcategory").val();
            const resubcategoryTag = $("#resubcategory");

            if (subcategory_id) {
                const route = "{{ route('admin.ajax.getReSubCategory', [':subcategory_id']) }}";
                const url = route.replace(':subcategory_id', subcategory_id);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        resubcategoryTag.empty();
                        resubcategoryTag.append('<option selected disabled>Select</option>');
                        $.each(data, function (index, districtObj) {
                            resubcategoryTag.append('<option value="' + districtObj.id + '">' +
                                districtObj.resubcategory_name + '</option>');
                        });
                    }
                });
            } else {
                alert('sorry data not found');
            }
        }
    </script>


    <script>
        // Get references to the radio buttons and the solutions field
        const yesRadio = document.getElementById('radio_7');
        const noRadio = document.getElementById('radio_9');
        const solutionsField = document.querySelector('.solutions-field');

        // Add event listeners to handle changes in radio button selection
        yesRadio.addEventListener('change', function () {
            if (this.checked) {
                solutionsField.style.display = 'block';  // Show the Solutions field
            }
        });

        noRadio.addEventListener('change', function () {
            if (this.checked) {
                solutionsField.style.display = 'none';  // Hide the Solutions field
            }
        });

        // Initial check in case the page is loaded with "Yes" already selected
        if (yesRadio.checked) {
            solutionsField.style.display = 'block';
        } else {
            solutionsField.style.display = 'none';
        }


    </script>

    {{--    <script>--}}
    {{--        $("#video_solution_id").on('change', function (el) {--}}
    {{--            if ($(el).prop('checked')) {--}}
    {{--                $('#video_section').show(); // Show video_section when checkbox is checked--}}
    {{--            } else {--}}
    {{--                $('#video_section').hide(); // Hide video_section when checkbox is unchecked--}}
    {{--            }--}}
    {{--        })--}}

    {{--        function vidioSolution(el) {--}}

    {{--        }--}}
    {{--        function pdfSolution(el){--}}
    {{--            if ($(el).prop('checked')) {--}}
    {{--                $('#pdf_solution_section').show(); // Show video_section when checkbox is checked--}}
    {{--            } else {--}}
    {{--                $('#pdf_solution_section').hide(); // Hide video_section when checkbox is unchecked--}}
    {{--            }--}}
    {{--        }--}}
    {{--
    {{--    </script>--}}
@endsection
