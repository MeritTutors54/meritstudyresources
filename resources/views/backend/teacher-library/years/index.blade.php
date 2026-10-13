@extends('layouts.backend')
@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            @include('backend.teacher-library.partials.page-header', [
                'title'  => 'Years',
                'crumbs' => ['Teacher Library' => route('admin.teacher-library.index'), 'Years' => null],
            ])

            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            @include('layouts.backend.notification')
                            <div class="box-header with-border">
                                <div class="d-flex align-items-center">
                                    <h3 class="box-title">All years</h3>
                                 
                                        <a href="{{ route('admin.teacher-library.years.create') }}"
                                           class="ms-auto waves-effect waves-light btn btn-primary">
                                            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                            <span class="ms-2">Create New</span>
                                        </a>
                               
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th style="width: 70px">Order</th>
                                            <th>Phase</th>
<th>Name</th>
                                            <th class="text-center">Courses</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center" style="width: 110px">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($items as $item)
                                            <tr>
                                                <td>{{ $item->sort_order }}</td>
                                                <td>{{ $item->phase?->name }}</td>
<td>{{ $item->name }} <small class="text-fade d-block">{{ $item->slug }}</small></td>
                                                <td class="text-center">{{ $item->courses_count }}</td>
                                                <td class="text-center">@include('backend.teacher-library.partials.status-badge', ['status' => $item->status])</td>
                                                <td class="text-center">
                                                
                                                        <a href="{{ route('admin.teacher-library.years.edit', $item) }}" title="Edit">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </a>
                                                   
                                                        @include('backend.teacher-library.partials.delete-button', [
                                                            'route' => route('admin.teacher-library.years.destroy', $item),
                                                            'name'  => $item->name,
                                                        ])
                                                
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="9" class="text-center text-fade py-4">No years yet.</td></tr>
                                        @endforelse
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
    @include('backend.teacher-library.partials.delete-script')
@endsection
