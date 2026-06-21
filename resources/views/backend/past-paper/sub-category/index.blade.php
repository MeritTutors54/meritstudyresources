@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All SubCategories</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">SubCategories</li>
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
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>

                                            <th>SubCategory Name</th>
                                            <th>Most Popular</th>
                                            <th>Category Name</th>
                                            <th>Status</th>
                                            <th>Manage</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($allData) && $allData->isNotEmpty())
                                            @foreach($allData as $data)
                                                <tr>
                                                    <td>{{ $data->subcategory_name }}</td>
{{--                                                    <td>--}}
{{--                                                        @if($data->most_popular == \App\Enums\MostPopular::YES->value)--}}
{{--                                                            <span class="badge badge-success">--}}
{{--                                                                {{ ucfirst(strtolower(\App\Enums\MostPopular::from($data->most_popular)->name)) }}--}}
{{--                                                            </span>--}}
{{--                                                        @else--}}
{{--                                                            <span class="badge badge-secondary">--}}
{{--                                                                {{ ucfirst(strtolower(\App\Enums\MostPopular::from($data->most_popular)->name)) }}--}}
{{--                                                            </span>--}}
{{--                                                        @endif--}}
{{--                                                    </td>--}}

                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" class="subjectSwitch" id="togProp-{{ $data->id }}"
                                                                   data-id="{{ $data->id }}"
                                                                {{ $data->most_popular == 1 ? "checked" : "" }}>
                                                            <div class="slider round"><!--ADDED HTML -->
                                                                <span class="on">Yes</span>
                                                                <span class="off">No</span><!--END-->
                                                            </div>
                                                        </label>
                                                    </td>


                                                    <td>{{ $data->category->category_name ?? '' }}</td>
                                                    <td class="text-center">
                                                        <label class="switch">
                                                            <input type="checkbox" class="statusSwitch" id="togProp-{{ $data->id }}"
                                                                   data-id="{{ $data->id }}"
                                                                {{ $data->is_active == 1 ? "checked" : "" }}>
                                                            <div class="slider round"><!--ADDED HTML -->
                                                                <span class="on">Active</span>
                                                                <span class="off">Inactive</span><!--END-->
                                                            </div>
                                                        </label>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('updatePastPaperSubcategory', Auth::user())
                                                            <a href="{{ route('admin.sub-categories.edit', [$data])}}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                        @endcan

                                                        @can('deletePastPaperSubcategory')
                                                            <button type="button"
                                                                    data-route="{{ route('admin.sub-categories.destroy', [$data->id]) }}"
                                                                    data-name="{{ $data->subcategory_name }}"
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

        $(".subjectSwitch").on('change', function () {
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


        $('.statusSwitch').on('change', function () {
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
