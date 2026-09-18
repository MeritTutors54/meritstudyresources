@extends('layouts.backend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container .select2-selection--single {
            height: 35px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px;
        }
        .select2-container--default .select2-selection--single {
            padding: 6px 0 0 6px;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear {
            height: 22px;
        }
    </style>

    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <?php
            if (isset($past_paper)) {
                $actionUrl = route('admin.past-papers.update', ['past_paper' => $past_paper]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.board-resources.store');
                $method = 'POST';
                $scope = 'Create';
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Board Resource</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.board-resources.index') }}">All Board Resources</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Board Resource</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Overlay and Box -->
            <div id="alertOverlay" class="alert-overlay d-none" role="dialog" aria-modal="true"
                 aria-labelledby="alertTitle">
                <div class="alert-box">
                    <h3 id="alertTitle" class="alert-title">Notice</h3>
                    <p class="alert-message" id="alert-overlay-message"></p>
                    <button id="alertCloseBtn" class="alert-btn">Okay</button>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="box-title m-0">{{ $scope }} board resource</h4>
                                </div>
                            </div>
                            @include('layouts.backend.notification')

                            <!-- /.box-header -->
                            <form id="pastPaperForm" action="{{ $actionUrl }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method($method)
                                @include('backend.resource._field')
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#subcategory').select2({
                placeholder: "Select...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    <script>
        function getSubCategory(el) {
            const category_id = $("#category").val();
            const subCategoryTag = $('#subcategory');

            if (category_id) {
                const route = "{{ route('admin.ajax.getSubCategory', [':category_id']) }}";
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

        function getParents() {
            const resubcategoryId = $("#resubcategory").val();
            const parentTag = $('#parent_id');


            if (resubcategoryId) {
                const route = "{{ route('admin.ajax.getParents', [':id']) }}";
                const url = route.replace(':id', resubcategoryId);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        parentTag.empty();
                        parentTag.append('<option selected disabled>Select</option>');
                        $.each(data, function (index, districtObj) {
                            parentTag.append('<option value="' + districtObj.id + '">' +
                                districtObj.name + '</option>');
                        });
                    }
                });
            } else {
                alert('sorry data not found');
            }
        }
    </script>

    <script>
        const fileUploadSection = $("#file-upload-section");
        const parentId = $("#parent_id");
        const isGroup = $("#is_group");
        const presentationType = $("#type");
        const difficultySection = $("#difficulty-section");

        isGroup.on("change", function() {
            if ($(this).val() === "1") {
                fileUploadSection.addClass("d-none");
            } else {
                fileUploadSection.removeClass("d-none");
            }
        });

        presentationType.on("change", function () {
            if($(this).val() === "2") {
                difficultySection.removeClass('d-none');
            } else {
                difficultySection.addClass('d-none');
            }
        })
    </script>
@endsection
