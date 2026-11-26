@extends('layouts.backend')
@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>

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
                                    <li class="breadcrumb-item active" aria-current="page">Missing Past Papers</li>
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
                                    <h3 class="box-title">
                                        Missing Past Paper Files ({{ $missingFiles->count() }})
                                    </h3>
                                    @can('createPastPaper', Auth::user())
                                        <a href="{{ route('admin.past-papers.create') }}"
                                           class="ms-auto waves-effect waves-light btn btn-primary">
                                            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                            <span class="ms-2">Create New</span>
                                        </a>
                                    @endcan
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Category</th>
                                                <th>Series</th>
                                                <th>Question Paper</th>
                                                <th>Answer Paper</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($missingFiles as $key => $paper)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $paper->id }}</td>
                                                    <td>{{ $paper->category_model->name ?? '-' }}</td>
                                                    <td>{{ $paper->series->name ?? '-' }}</td>
                                                    <td>
                                                        {{ $paper->ques_paper ?: '-' }}
                                                        @if($paper->ques_missing)
                                                            <span class="badge bg-danger">Not found</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $paper->ans_paper ?: '-' }}
                                                        @if($paper->ans_missing)
                                                            <span class="badge bg-danger">Not found</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @can('editPastPaper', Auth::user())
                                                            <a href="{{ route('admin.past-papers.edit', $paper->id) }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                        @endcan

                                                        @can('deletePastPaper', Auth::user())
                                                            <button type="button"
                                                                    data-route="{{ route('admin.past-papers.destroy', $paper->id) }}"
                                                                    data-name="{{ $paper->title }}"
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

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                order: [[1, 'desc']],
                pageLength: 25,
                columnDefs: [
                    { orderable: false, targets: [0, 6] }
                ],
                language: {
                    emptyTable: "All files exist in the folder."
                }
            });
        });
    </script>
@endsection