@extends('layouts.backend')

@section('page-css')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Study Materials</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Study Materials</li>
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
                                    <h3 class="box-title">Study Material Table</h3>
                                    @can('createStudyMaterialUpload', Auth::user())
                                        <a href="{{ route('admin.resources.create') }}"
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
                                            <th>Topic Title</th>
                                            <th>Main PDF</th>
                                            <th>Page</th>
                                            <th>Paid Resource</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($resources->isNotEmpty())
                                            @foreach($resources as $resource)
                                                <tr>
                                                    <td>{{ $resource->name }}</td>
                                                    <td>{{ $resource->topic?->title }}</td>
                                                    <td class="d-flex align-items-center">
                                                        <a href="{{ asset(\Illuminate\Support\Facades\Storage::url($resource->main_pdf)) }}"
                                                           data-fancybox data-caption="Single image">
                                                            <i style="font-size: 30px"
                                                               class="fa fa-fw fa-file-pdf-o"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ count($resource->allPage) }} Pages
                                                    </td>
                                                    <th>
                                                        @if($resource->is_paid === \App\Enums\Statement::YES->value)
                                                            <span class="badge badge-success">
                                                                {{ \App\Enums\Statement::from($resource->is_paid)->name }}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-danger">
                                                                {{ \App\Enums\Statement::from($resource->is_paid)->name }}
                                                            </span>
                                                        @endif

                                                    </th>
                                                    <td class="text-center">
                                                        @if($resource->status === \App\Enums\Status::ACTIVE->value)
                                                            <span class="badge badge-success">
                                                                {{ ucfirst(strtolower(\App\Enums\Status::from($resource->status)->name)) }}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-secondary">
                                                                {{ ucfirst(strtolower(\App\Enums\Status::from($resource->status)->name)) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                       @can('updateStudyMaterialUpload', Auth::user())
                                                            <a href="{{ route('admin.resources.edit', [$resource]) }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                       @endcan
                                                        @can('deleteStudyMaterialUpload', Auth::user())
                                                               <button type="button"
                                                                       data-route="{{ route('admin.resources.destroy', [$resource]) }}"
                                                                       data-name="{{ $resource->topic?->title }}"
                                                                       class="dltButton btn bg-transparent p-0 ms-2">
                                                                   <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>


    <script>
        $('.dltButton').on('click', function () {
            let name = $(this).data('name');
            let url = $(this).data('route');
            $('#set-action').attr('action', url);
            $('#element-name').html(name);
            $('#dltModal').modal('show');
        });


        Fancybox.bind("[data-fancybox]", {});

    </script>
@endsection
