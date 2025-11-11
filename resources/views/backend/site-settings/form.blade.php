@extends('layouts.backend')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->

            <?php
            if (isset($view) && $view === 'delivery-charge') {
                if (isset($siteSettings)) {
                    $actionUrl = route('admin.delivery-charge.update', ['delivery_charge' => $siteSettings]);
                    $method = 'PATCH';
                    $scope = 'Update';
                }
            } else {
                if (isset($siteSettings)) {
                    $actionUrl = route('admin.site.settings.update', ['siteSettings' => $siteSettings]);
                    $method = 'PATCH';
                    $scope = 'Update';
                }
            }

            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">Site Settings</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Site Settings
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                    @include('layouts.backend.notification')
                    <!-- /.box-header -->
                    @method($method)
                    @csrf
                    <div class="row">

                        <div class="col-lg-8 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">{{ $scope }} Site Settings</h4>
                                </div>

                                @include('backend.site-settings._fields')
                            </div>
                        </div>

                        <div class="col-lg-4 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Extra Settings</h4>
                                </div>
                                @include('backend.site-settings._extra_fields')
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
