@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <?php
            if (isset($resub_category)) {
                $actionUrl = route('admin.resub-categories.update', ['resub_category' => $resub_category]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.resub-categories.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>


            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Resub Categories</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.resub-categories.index') }}">
                                            Resub Categories
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Resub
                                        Categories
                                    </li>
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
                                <h4 class="box-title">{{ $scope }} Resub Categories</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <!-- /.box-header -->
                            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method($method)
                                @include('backend.past-paper.resub-category._field')
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('backend/assets/vendor_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/editor.js')}}"></script>

    <script>
        function getSubCategory(el) {
            const category_id = $("#category_id").val();
            const subCategoryTag = $('#subcategory_id');

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
                            subCategoryTag.append('<option value="' + districtObj.id + '">' + districtObj.subcategory_name + '</option>');
                        });
                    }
                });
            } else {
                alert('sorry data not found');
            }

        }
    </script>

    <script>
        // select2.js implemented
        $('.js-example-basic-single').select2({
            theme: 'bootstrap-5',
            tags: true
        });
    </script>
@endsection
