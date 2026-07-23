@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Policies</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Policies</li>
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
                                    @can('createPolicy', Auth::user())
                                        <a href="{{ route('admin.policies.create') }}"
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
                                            <th style="width: 20%;">Title</th>
                                            <th style="width: 45%;">Description</th>
                                            <th class="text-center" style="width: 15%;">Policy</th>
                                            <th class="text-center" style="width: 10%;">Status</th>
                                            <th class="text-center" style="width: 10%;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($policies))
                                                @foreach($policies as $data)
                                                    <tr>
                                                        <td><strong>{{ $data->title }}</strong></td>

                                                        <td>
                                                            {{-- strip_tags prevents unclosed HTML tags from breaking table styles --}}
                                                            {{ Str::limit(strip_tags(html_entity_decode($data->description)), 150, '...') }}
                                                        </td>

                                                        {{-- Updated from $data->policy to $data->genre --}}
                                                        <td class="text-center">
                                                            <span class="badge bg-primary">
                                                                {{ $data->policy?->label() ?? 'N/A' }}
                                                            </span>
                                                        </td>

                                                        <td class="text-center">
                                                            <span class="badge badge-{{ $data->status->color() }}">
                                                                {{ $data->status->label() }}
                                                            </span>
                                                        </td>

                                                        <td class="text-center">
                                                            @can('updatePolicy', Auth::user())
                                                                <a href="{{ route('admin.policies.edit', [$data]) }}">
                                                                    <i class="fa fa-edit text-primary" aria-hidden="true"></i>
                                                                </a>
                                                            @endcan
                                                            @can('deletePolicy', Auth::user())
                                                                <button type="button"
                                                                        data-route="{{ route('admin.policies.destroy', [$data]) }}"
                                                                        data-name="{{ $data->title }}"
                                                                        class="dltButton btn btn-sm btn-transparent ms-1">
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
