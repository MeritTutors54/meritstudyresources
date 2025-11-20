@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Tags</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Tags</li>
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
                                    <h3 class="box-title">Tag List</h3>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Tag Name</th>
                                            <th>Blog Title</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($tags) && $tags->isNotEmpty())
                                            @foreach($tags as $blog_tag)
                                                <tr>
                                                    <td>{{ $blog_tag->name }}</td>
                                                    @if($blog_tag->blogs()->count() > 0)
                                                        <td>
                                                            @foreach($blog_tag->blogs as $blog)
                                                                {{ $blog->title }}
                                                                <br>
                                                            @endforeach
                                                        </td>
                                                    @endif
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.blog-tags.edit', [$blog_tag]) }}">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </a>

{{--                                                        <button type="button"--}}
{{--                                                                data-route="{{ route('admin.blogs.destroy', [$blog_tag]) }}"--}}
{{--                                                                data-name="{{ $blog_tag->title }}"--}}
{{--                                                                class="dltButton btn bg-transparent p-0 ms-2">--}}
{{--                                                            <i class="fa fa-trash-o text-danger"--}}
{{--                                                               aria-hidden="true"></i>--}}
{{--                                                        </button>--}}
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
        $('.dltButton').on('click', function () {
            let name = $(this).data('name');
            let url = $(this).data('route');
            $('#set-action').attr('action', url);
            $('#element-name').html(name);
            $('#dltModal').modal('show');
        });
    </script>
@endsection
