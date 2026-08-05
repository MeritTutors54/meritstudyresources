@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Subcategories</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Subcategories</li>
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
                                    @can('createPastPaperSubcategory', Auth::user())
                                        <a href="{{ route('admin.sub-categories.create') }}"
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
                                    <table id="sub-category-table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Subcategory Name</th>
                                            <th class="text-center">Most Popular</th>
                                            <th>Category Name</th>
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

    <script>
        $(document).ready(function() {
            $('#sub-category-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.ajax.table.getSubCategory') }}',

                columns: [
                    // Matches DT_RowIndex from addIndexColumn()
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'subcategory_name', name: 'subcategory_name' },
                    { data: 'most_popular', name: 'most_popular', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'category_name', name: 'category.category_name', className: 'text-center' },
                    { data: 'status', name: 'status', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'manage', name: 'manage', orderable: false, searchable: false, className: 'text-center' },
                ],

                dom: 'Blfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                lengthMenu: [
                    [10, 25, 50, 500, 1000, -1],
                    [10, 25, 50, 500, 1000, "All"]
                ],
                pageLength: 10
            });
        });
    </script>

{{--    <script>--}}
{{--        $('#').DataTable({--}}
{{--            lengthMenu: [--}}
{{--                [10, 25, 50, 100, -1],--}}
{{--                [10, 25, 50, 100, "All"]--}}
{{--            ],--}}
{{--            pageLength: 10--}}
{{--        });--}}
{{--    </script>--}}
    <script>
        $('.dltButton').on('click', function () {
            let name = $(this).data('name');
            let url = $(this).data('route');
            $('#set-action').attr('action', url);
            $('#element-name').html(name);
            $('#dltModal').modal('show');
        });

        const dataTable = $('#sub-category-table');

        dataTable.on('change', '.subjectSwitch', function () {
            let checkbox = $(this);
            $(".subjectSwitch").prop('disabled', true);
            let objectID = $(this).data('id');

            // Save previous state BEFORE sending request
            let previousState = !checkbox.is(':checked');

            $.ajax({
                url: '{{ route('admin.ajax.updateStatus') }}',
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    category_id: objectID,
                    model: "SubCategory",
                    column: "most_popular"
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
                    $(".subjectSwitch").prop('disabled', false);
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
                    $(".subjectSwitch").prop('disabled', false);

                }
            });
        });


        dataTable.on('change', '.statusSwitch', function () {
            let checkbox = $(this);
            $(".statusSwitch").prop('disabled', true);
            let categoryID = $(this).data('id');

            // Save previous state BEFORE sending request
            let previousState = !checkbox.is(':checked');

            $.ajax({
                url: '{{ route('admin.ajax.updateStatus') }}',
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    category_id: categoryID,
                    model: "SubCategory",
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

        })
    </script>
@endsection
