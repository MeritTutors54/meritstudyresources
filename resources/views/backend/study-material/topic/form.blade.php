@extends('layouts.backend')

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding: 4px 0;
        }
    </style>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->

            <?php
            if (isset($topic)) {
                $actionUrl = route('admin.topics.update', ['topic' => $topic]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.topics.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Topics</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.topics.index') }}">
                                            Topics
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Topic</li>
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
                                <h4 class="box-title">{{ $scope }} Topic</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                                @method($method)
                                @csrf
                                @include('backend.study-material.topic._fields')
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // select2.js implemented
        $('.js-example-basic-single').select2({
            theme: 'bootstrap-5',
            tags: true
        });

        $('#education_level_id').select2({
            theme: 'bootstrap-5',
        });

        $("#subject_id").select2({
            theme: 'bootstrap-5',
        })

        $('#parent_id').select2({
            theme: 'bootstrap-5',
        })

        $("#education_level_id").on('change', function () {
            let value = $(this).val();
            const url = '{{ route('admin.ajax.getSubjects') }}';

            $.ajax({
                url: url,
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    education_level_id: value
                },
                success: function (data) {
                    const subCategorySelect = $("#subject_id");
                    subCategorySelect.find('option').remove();
                    subCategorySelect.append('<option value="">Select...</option>')
                    data.forEach((item, i) => {
                        subCategorySelect.append('<option value="' + item?.id + '">' + item?.name + '</option>')
                    })
                }
            });

        })
    </script>
@endsection
