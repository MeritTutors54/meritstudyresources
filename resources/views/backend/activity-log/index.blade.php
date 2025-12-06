@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">Admins Activity</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Activities</li>
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
                                <div class="d-flex align-center">
                                    <h3 class="box-title">All Admins Activity</h3>
                                    <div class="form-group ms-auto w-25">
                                        <select data-route="{{ route('admin.activity.index') }}"
                                                id="admin-filter"
                                                class="form-select">
                                            <option value="">Select a admin...</option>
                                            @if(!empty($admins))
                                                @foreach($admins as $admin)
                                                    <option
                                                        {{ $q === (string)$admin->id ? 'selected' : '' }}
                                                        value="{{ $admin->id }}">
                                                        {{ $admin->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Admin Name</th>
                                            <th class="">Model Name</th>
                                            <th class="text-center">Action</th>
                                            <th class="text-center">Date & Time</th>
                                            <th></th>
{{--                                            <th class="text-center">Old Data</th>--}}
{{--                                            <th class="text-center">New Data</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($activityLogs->isNotEmpty())
                                            @foreach($activityLogs as $log)
                                                <tr>
                                                    <td><strong>
                                                            {{ $log->name }}
                                                        </strong>
                                                    </td>
                                                    <td class="">{{ $log->model_type }}</td>
                                                    <td class="text-center">
                                                        @if($log->action == 'created')
                                                            <span
                                                                class="badge badge-primary">{{ ucfirst($log->action) }}</span>
                                                        @elseif($log->action == 'updated')
                                                            <span
                                                                class="badge badge-success">{{ ucfirst($log->action) }}</span>
                                                        @else
                                                            <span
                                                                class="badge badge-danger">{{ ucfirst($log->action) }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $log->created_at->format('d/m/Y H:i a' ) }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.activity.show', [$log]) }}">See More...</a>
                                                    </td>
{{--                                                    <td>--}}
{{--                                                        @if(!empty($log->new_data))--}}
{{--                                                            <ul class="mt-2 text-sm">--}}
{{--                                                                @foreach ($log->new_data as $field => $value)--}}
{{--                                                                    <li>--}}
{{--                                                                        <strong>{{ ucfirst($field) }}:</strong>--}}
{{--                                                                        {{ is_array($value) ? json_encode($value) : $value }}--}}
{{--                                                                    </li>--}}
{{--                                                                @endforeach--}}
{{--                                                            </ul>--}}
{{--                                                        @endif--}}
{{--                                                    </td>--}}
{{--                                                    <td>--}}
{{--                                                        @if(!empty($log->old_data))--}}
{{--                                                            <ul class="mt-2 text-sm">--}}
{{--                                                                @foreach ($log->old_data as $field => $value)--}}
{{--                                                                    <li>--}}
{{--                                                                        <strong>{{ ucfirst($field) }}:</strong>--}}
{{--                                                                        {{ is_array($value) ? json_encode($value) : $value }}--}}
{{--                                                                    </li>--}}
{{--                                                                @endforeach--}}
{{--                                                            </ul>--}}
{{--                                                        @endif--}}
{{--                                                    </td>--}}
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
            </section>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('backend/assets/vendor_components/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/data-table.js') }}"></script>
    <script>
        $("#admin-filter").on('change', function () {
            let value = $(this).val();
            if (value !== "") {
                let route = $(this).data('route');
                window.location.replace(route + "?admin_id=" + value);
            }
        })
    </script>
@endsection
