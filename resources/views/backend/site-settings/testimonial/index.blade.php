@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Testimonials</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
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
                                    @can('createTestimonial', Auth::user())
                                        <a href="{{ route('admin.testimonials.create') }}"
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
                                            <th>Description</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Rating</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($testimonials) && $testimonials->isNotEmpty())
                                            @foreach($testimonials as $testimonial)
                                                <tr>
                                                    <td>{{ $testimonial->name }}</td>
                                                    <td>{{ \Illuminate\Support\Str::limit($testimonial->description, 30) }}</td>
                                                    <td class="text-center">
                                                        @if($testimonial->type === \App\Enums\UserType::STUDENT->value)
                                                            <span class="badge badge-success">
                                                                {{ ucfirst(strtolower(\App\Enums\UserType::from($testimonial->type)->name)) }}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-secondary">
                                                                {{ ucfirst(strtolower(\App\Enums\UserType::from($testimonial->type)->name)) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <i class="fa fa-star" style="color: gold;"
                                                           aria-hidden="true"></i>
                                                        <i class="fa fa-star" style="color: gold;"
                                                           aria-hidden="true"></i>
                                                        <i class="fa fa-star" style="color: gold;"
                                                           aria-hidden="true"></i>
                                                        <i class="fa fa-star" style="color: gold;"
                                                           aria-hidden="true"></i>
                                                        <i class="fa fa-star" style="color: gold;"
                                                           aria-hidden="true"></i>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('updateTestimonial', Auth::user())
                                                            <a href="{{ route('admin.testimonials.edit', [$testimonial]) }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                        @endcan
                                                        @can('deleteTestimonial', Auth::user())
                                                            <button type="button"
                                                                    data-route="{{ route('admin.testimonials.destroy', [$testimonial]) }}"
                                                                    data-name="{{ $testimonial->name }}"
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
