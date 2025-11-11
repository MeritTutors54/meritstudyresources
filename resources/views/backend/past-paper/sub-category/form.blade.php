@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <?php
            if (isset($sub_category)) {
                $actionUrl = route('admin.sub-categories.update', ['sub_category' => $sub_category]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.sub-categories.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>


            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Subcategories</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.sub-categories.index') }}">
                                            Subcategories
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Subcategories</li>
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
                                <h4 class="box-title">{{ $scope }} Subcategory</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <!-- /.box-header -->
                            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method($method)
                                @include('backend.past-paper.sub-category._field')
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
