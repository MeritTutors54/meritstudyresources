@extends('layouts.backend')
@section('page-css')

@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->

            <?php
            if (isset($stuff)) {
                $actionUrl = route('admin.stuff.permissions.update', ['stuff' => $stuff]);
                $method = 'PATCH';
                $scope = 'Update';
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Stuffs</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.coupons.index') }}">
                                            Stuffs
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Stuff Permission</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">{{ $scope }} Stuff Permission</h4>
                                    <button type="submit" class="btn btn-success pull-right">Submit</button>
                                </div>
                                @include('layouts.backend.notification')
                                <!-- /.box-header -->

                                @method($method)
                                @csrf
                                @include('backend.stuff._permission_field')
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')

@endsection
