@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All SEO Information</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">SEO Information</li>
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
                                    @can('createSEO', Auth::user())
                                        <a href="{{ route('admin.seo-settings.create') }}"
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
                                            <th>Page</th>
                                            <th>Meta Tile</th>
                                            <th>Meta Description</th>
                                            <th>Meta Author</th>
                                            <th>Meta Keywords</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(isset($AllSeo) && $AllSeo->isNotEmpty())
                                            @foreach($AllSeo as $seo)
                                                <tr>
                                                    <td>{{ $seo->page_title }}</td>
                                                    <td>{{ $seo->meta_title }}</td>
                                                    <td>{{ $seo->meta_description }}</td>
                                                    <td>{{ $seo->meta_author }}</td>
                                                    <td>{{ $seo->meta_keywords }}</td>
                                                    <td class="text-center">
                                                        @can('updateSEO', Auth::user())
                                                            <a href="{{ route('admin.seo-settings.edit', [$seo]) }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                        @endcan
                                                        @can('deleteSEO', Auth::user())
                                                            <button type="button"
                                                                    data-route="{{ route('admin.seo-settings.destroy', [$seo]) }}"
                                                                    data-name="{{ $seo->page_title }}"
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
