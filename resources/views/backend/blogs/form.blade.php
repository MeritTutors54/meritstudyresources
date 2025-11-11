@extends('layouts.backend')
@section('page-css')
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
            if (isset($blog)) {
                $actionUrl = route('admin.blogs.update', [$blog]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.blogs.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Blogs</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.blogs.index') }}">
                                            Blogs
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Blog</li>
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
                                <h4 class="box-title">{{ $scope }} Blog</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                                @method($method)
                                @csrf
                                @include('backend.blogs._fields')
                            </form>
                        </div>
                    </div>

                    @if(!empty($blog))
                        <div class="col-lg-4 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">{{ $scope }} Blog Extra Settings</h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-12">
                                            @if(!empty($blog->cover_image))
                                                <div class="form-label">Blog Cover Image</div>
                                                <img
                                                    src="{{ asset(\Illuminate\Support\Facades\Storage::url($blog->cover_image)) }}"
                                                    alt=""/>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @can('viewBlogComment', Auth::user())
                            <div class="col-lg-8 col-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">{{ $scope }} Blog Comments</h4>
                                    </div>
                                    @include('backend.blogs._extra_fields')
                                </div>
                            </div>
                        @endcan
                    @endif
                </div>
            </section>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
    <script src="{{ asset('backend/assets/vendor_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/editor.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // select2.js implemented
        $('.js-example-basic-single').select2({
            theme: 'bootstrap-5',
            tags: true
        });
    </script>
@endsection
