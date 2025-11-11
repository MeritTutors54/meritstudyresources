@extends('layouts.backend')
@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->

            <?php
            if (isset($testimonial)) {
                $actionUrl = route('admin.testimonials.update', ['testimonial' => $testimonial]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.testimonials.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Testimonials</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.testimonials.index') }}">
                                            Testimonials
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Testimonial</li>
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
                                <h4 class="box-title">{{ $scope }} Testimonial</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <!-- /.box-header -->
                            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                                @method($method)
                                @csrf
                                @include('backend.site-settings.testimonial._fields')
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

@endsection
