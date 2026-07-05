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
                                    <h3 class="box-title">Past Papers</h3>
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
                                    <table id="past-paper-table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th class="text-center">Unit Code</th>
                                            <th class="text-center">Series</th>
                                            <th>Category</th>
                                            <th>SubCategory</th>
                                            <th>Resubcategory</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Manage</th>
                                        </tr>
                                        </thead>
                                        <tbody>
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

    <!-- DataTables CSS & JS (you already have) -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor_components/datatable/datatables.min.css') }}">

    <!-- Buttons extension CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#past-paper-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.ajax.getPastPaper") }}',

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'unit_code', name: 'resubcategory_model.unit_code', className: 'text-center'},
                    {data: 'series_name', name: 'series.name', className: 'text-center'},
                    {data: 'category_name', name: 'category_model.category_name'},
                    {data: 'subcategory_name', name: 'subcategory_model.subcategory_name'},
                    {data: 'resubcategory_name', name: 'resubcategory_model.resubcategory_name'},
                    {data: 'status_badge', name: 'status', searchable: false, className: 'text-center'},
                    {data: 'actions', name: 'actions', searchable: false, className: 'text-center'},
                ],

                dom: 'Blfrtip', // ✅ IMPORTANT

                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],

                lengthMenu: [
                    [10, 25, 50, 500, 1000],
                    [10, 25, 50, 500, 1000]
                ],

                pageLength: 10 // default selected
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#past-paper-table').on('change', '.statusSwitch', function() {
                let checkbox = $(this);
                checkbox.prop('disabled', true);
                let ID = $(this).data('id');

                let previousState = !checkbox.is(':checked');

                $.ajax({
                    url: '{{ route('admin.ajax.updateStatus') }}',
                    type: "post",
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        category_id: ID,
                        model: "PastPaper",
                        column: "is_active"
                    },
                    success: function (response) {
                        if (response.success) {
                            // Handle successful login
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                customClass: 'swal-wide',
                            })
                        }
                        $(".statusSwitch").prop('disabled', false);
                    },
                    error: function (error) {
                        if (error.status === 500) {
                            let message = error.responseJSON.message;

                            Swal.fire({
                                title: 'Error!',
                                text: message,
                                icon: 'error',
                                customClass: 'swal-wide',
                                confirmButtonText: 'Close'
                            })
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: "An error occurred. Please try again.",
                                icon: 'error',
                                customClass: 'swal-wide',
                                confirmButtonText: 'Close'
                            })
                        }
                        checkbox.prop('checked', previousState);
                        $(".statusSwitch").prop('disabled', false);

                    }
                });
            });
        })
    </script>
@endsection
