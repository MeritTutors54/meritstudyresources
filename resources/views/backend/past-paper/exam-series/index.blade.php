@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Exam Series</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Exam Series</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            @include('layouts.backend.notification')
                            <div class="box-header with-border">
                                <div class="d-flex align-items-center">
                                    <h3 class="box-title">Data Table</h3>
                                    @can('createExamSeries', Auth::user())
                                        <a href="{{ route('admin.exam-series.create') }}"
                                           class="ms-auto waves-effect waves-light btn btn-primary">
                                            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                            <span class="ms-2">
                                                Create New
                                            </span>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($series) && $series->isNotEmpty())
                                            @foreach($series as $year)
                                                <tr>
                                                    <td>{{ $year->name }}</td>
                                                    <td class="text-center">
                                                        @if($year->is_active === 1)
                                                            <span class="badge badge-success">
                                                               Active
                                                            </span>
                                                        @else
                                                            <span class="badge badge-secondary">
                                                                 Inactive
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @can('updateExamSeries', Auth::user())
                                                            <a href="{{ route('admin.exam-series.edit', [$year]) }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                        @endcan
                                                        @can('deleteExamSeries', Auth::user())
                                                            <button type="button"
                                                                    data-route="{{ route('admin.exam-series.destroy', [$year]) }}"
                                                                    data-name="{{ $year->name }}"
                                                                    class="dltButton btn bg-transparent p-0 ms-2">
                                                                <i class="fa fa-trash-o text-danger"
                                                                   aria-hidden="true"></i>
                                                            </button>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts.backend.delete-modal')
            </section>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('backend/assets/vendor_components/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/data-table.js') }}"></script>
    <script>
        $('#example1').DataTable({
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            pageLength: 10
        });
    </script>
    <script>
        $('.dltButton').on('click', function () {
            let name = $(this).data('name');
            let url = $(this).data('route');
            $('#set-action').attr('action', url);
            $('#element-name').html(name);
            $('#dltModal').modal('show');
        });
    </script>
@endsection
