@extends('layouts.backend')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->

            <?php
            if (isset($year_group)) {
                $actionUrl = route('admin.year-groups.update', ['year_group' => $year_group]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.year-groups.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Year Group</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.book-variants.index') }}">
                                            Year Groups
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $scope }} Year Group
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
                                <h4 class="box-title">{{ $scope }} Year Group</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <!-- /.box-header -->
                            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                                @method($method)
                                @csrf

                                <div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-12">
                                                <div class="form-group">
                                                    <label for="year_name"
                                                           class="form-label">Year Group Name</label>
                                                    <input type="text"
                                                           name="year_name"
                                                           id="year_name"
                                                           value="{{ old('year_name', $year_group->year_name ?? "") }}"
                                                           class="form-control"
                                                           placeholder="Enter book variant name">
                                                    @error('year_name')
                                                    <div class="form-control-feedback text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <a href="{{ route('admin.book-variants.index') }}"
                                           class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-success pull-right">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
