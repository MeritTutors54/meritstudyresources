@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Past Papers</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Past Papers</li>
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
                                    @can('createPastPaper', Auth::user())
                                        <a href="{{ route('admin.past-papers.create') }}"
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
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Series</th>
                                            <th>Category</th>
                                            <th>SubCategory</th>
                                            <th>Resubcategory</th>
                                            <th>Status</th>
                                            <th>Manage</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($allData as $key => $data)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $data->title }}</td>
                                                <td>{{ $data->series->name }}</td>
                                                <td>{{ $data->category_model->category_name }}</td>
                                                <td>{{ $data->subcategory_model->subcategory_name }}
                                                    -{{ $data->resubcategory_model->unit_code }}
                                                </td>
                                                <td>{{ $data->resubcategory_model->resubcategory_name }}</td>
                                                <td>
                                                    @if ($data->is_active == 1)
                                                        <span class="btn-sm btn-success">Active</span>
                                                    @else
                                                        <span class="btn-sm btn-danger">Deactivate</span>
                                                    @endif
                                                </td>

                                                {{--                                                <td>--}}
                                                {{--                                                     @if ($data->is_active == 1)--}}
                                                {{--                                                        <a class=" bg-success-light" style="color:green"--}}
                                                {{--                                                            data-toggle="tooltip" data-placement="top"--}}
                                                {{--                                                            href="{{ url('admin/past-paper/deactive/' . $data->id) }}"--}}
                                                {{--                                                            data-original-title="Active"><i--}}
                                                {{--                                                                class="fa fa-thumbs-up"></i></a>--}}
                                                {{--                                                    @else--}}
                                                {{--                                                        <a class="bg-danger-light" style="color:red"--}}
                                                {{--                                                            data-toggle="tooltip" data-placement="top"--}}
                                                {{--                                                            href="{{ url('admin/past-paper/active/' . $data->id) }}"--}}
                                                {{--                                                            data-original-title="Deactive"><i--}}
                                                {{--                                                                class="fa fa-thumbs-down"></i></a>--}}
                                                {{--                                                    @endif--}}
                                                {{--                                                    <a class=" bg-primary-light"--}}
                                                {{--                                                       href="{{ route('admin.past-papers.edit', [$data]) }}"--}}
                                                {{--                                                       title="edit"><i class="fas fa-pencil-alt"></i></a>--}}

                                                {{--                                                    <a id="delete" class="bg-danger-light" style="color:red"--}}
                                                {{--                                                       data-toggle="tooltip" data-placement="top"--}}
                                                {{--                                                       href="{{ route('admin.past-papers.destroy', [$data]) }}"--}}
                                                {{--                                                       data-original-title="Delete"> <i class="fa fa-trash"></i></a>--}}
                                                {{--                                                </td>--}}

                                                <td class="text-center">
                                                    @can('editPastPaper', Auth::user())
                                                        <a href="{{ route('admin.past-papers.edit', [$data]) }}">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </a>
                                                    @endcan

                                                    @can('deletePastPaper', Auth::user())
                                                        <button type="button"
                                                                data-route="{{ route('admin.past-papers.destroy', [$data]) }}"
                                                                data-name="{{ $data->title }}"
                                                                class="dltButton btn bg-transparent p-0 ms-2">
                                                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                                                        </button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
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
        {{--$(document).ready(function() {--}}
        {{--    $('#myTable').DataTable({--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        ajax: '{{ route("admin.ajax.getPastPaper") }}',--}}
        {{--        columns: [--}}
        {{--            { data: 'id', name: 'id' },--}}
        {{--            { data: 'title', name: 'title' },--}}
        {{--            { data: 'year', name: 'year'},--}}
        {{--            { data: 'category_name', name: 'category_name'},--}}
        {{--            { data: 'subcategory_name', name: 'subcategory_name'},--}}
        {{--            { data: 'resubcategory_name', name: 'resubcategory_name'},--}}
        {{--            { data: 'status', name: 'status', searchable: false},--}}
        {{--            { data: 'actions', name: 'actions', searchable: false},--}}
        {{--        ],--}}
        {{--        "columnDefs": [--}}
        {{--            {--}}
        {{--                "targets": 'no-sort', // Target columns with the class 'no-sort'--}}
        {{--                "orderable": false--}}
        {{--            }--}}
        {{--        ]--}}
        {{--    });--}}
        {{--});--}}


        $('.dltButton').on('click', function () {
            let name = $(this).data('name');
            let url = $(this).data('route');
            $('#set-action').attr('action', url);
            $('#element-name').html(name);
            $('#dltModal').modal('show');
        });
    </script>
@endsection
