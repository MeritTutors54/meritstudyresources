@extends('layouts.backend')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->

            <?php
            if (isset($product)) {
                $actionUrl = route('admin.products.update', ['product' => $product]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.products.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Products</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.products.index') }}">
                                            Products
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Product</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                @method($method)
                @csrf
                <section class="content">
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">{{ $scope }} Products</h4>
                                </div>
                                @include('layouts.backend.notification')
                                <!-- /.box-header -->
                                @include('backend.ecommerce.product._fields')
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="box">
                                <div class="box-header with-border d-flex align-items-center">
                                    <h4 class="box-title">PDF Sample</h4>
                                    <button
                                        type="button"
                                        id="create-sample-button"
                                        class="ms-auto waves-effect waves-light btn btn-primary btn-sm">
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        <span class="ms-2">
                                            Add More
                                        </span>
                                    </button>
                                </div>
                                @include('backend.ecommerce.product._extra_fields')
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
    <script>
        $("#create-sample-button").on('click', function() {
            console.log('sss')
            let holder = $('#sample-holder');
            holder.append('<input  id="pdf_sample"' +
                'name="pdf_sample[]"' +
                'type="file"' +
                'class="form-control mt-2"' +
                'accept="image/*" ' + '>')
        })
    </script>
@endsection
