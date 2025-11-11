@extends('layouts.backend')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->

            <?php
            if (isset($blogCategory)) {
                $actionUrl = route('admin.blog-categories.update', [$blogCategory]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.blog-categories.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Blog Categories</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.blog-categories.index') }}">
                                            Blog Categories
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Blog Category</li>
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
                                <h4 class="box-title">{{ $scope }} Blog Category</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                                @method($method)
                                @csrf
                                @include('backend.blogs.categories._fields')
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
