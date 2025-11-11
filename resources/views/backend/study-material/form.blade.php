@extends('layouts.backend')
@section('page-css')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
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
            if (isset($resource)) {
                $actionUrl = route('admin.resources.update', ['resource' => $resource]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.resources.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Resources</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.resources.index') }}">
                                            Resources
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Resource</li>
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
                                <h4 class="box-title">{{ $scope }} Resource</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                                @method($method)
                                @csrf
                                @include('backend.study-material._fields')
                            </form>
                        </div>
                    </div>
                    @if(isset($resource))
                        <div class="col-lg-4 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Resource Preview</h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            PDF Viewer
                                            <a href="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->main_pdf)) }}"
                                               data-fancybox data-caption="Single image">
                                                <i style="font-size: 30px" class="fa fa-fw fa-file-pdf-o"></i>
                                            </a>
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
    <!-- /.content-wrapper -->
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $("#topic_id").select2({
            theme: 'bootstrap-5',
        })

        {{--$("#category_id").on('change', function () {--}}
        {{--    let value = $(this).val();--}}
        {{--    const url = '{{ route('admin.ajax.getSubCategories') }}';--}}

        {{--    $.ajax({--}}
        {{--        url: url,--}}
        {{--        type: "post",--}}
        {{--        dataType: 'json',--}}
        {{--        data: {--}}
        {{--            _token: "{{ csrf_token() }}",--}}
        {{--            category_id: value--}}
        {{--        },--}}
        {{--        success: function (data) {--}}
        {{--            const subCategorySelect = $("#sub_category_id");--}}
        {{--            subCategorySelect.find('option').remove();--}}
        {{--            subCategorySelect.append('<option value="">Select...</option>')--}}
        {{--            data.forEach((item, i) => {--}}
        {{--                subCategorySelect.append('<option value="'+item?.id+'">'+item?.name+'</option>')--}}
        {{--            })--}}
        {{--        }--}}
        {{--    });--}}

        {{--})--}}


        Fancybox.bind("[data-fancybox]", {});
    </script>
@endsection
