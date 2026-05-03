@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Admins Activity</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">All Activities</li>
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
                                <div class="d-flex gap-3">
                                    <a style="font-size: 20px" href="{{ route('admin.activity.index') }}"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i></a>
                                    <h3 class="box-title">{{$log->id}}. {{ $model }} Activity</h3>
                                </div>
                            </div>
                            <div class="box-body">
                                <div>
                                    <h4>Action:
                                        @if($log->action === strtolower(\App\Enums\Activity::CREATED->name))
                                            <span
                                                class="badge badge-primary">{{ \App\Enums\Activity::CREATED->name }}</span>
                                        @elseif($log->action === strtolower(\App\Enums\Activity::DELETED->name))
                                            <span
                                                class="badge badge-danger">{{ \App\Enums\Activity::DELETED->name }}</span>
                                        @else
                                            <span
                                                class="badge badge-warning">{{ \App\Enums\Activity::UPDATE->name }}</span>
                                        @endif
                                        <span class="badge badge-secondary">{{ $log->admin->name }}</span></h4>
                                </div>
                                <hr>
                                <style>
                                    .strike-through {
                                        text-decoration: line-through;
                                        color: #777777;
                                    }

                                    .update-section {
                                        border: 1px solid #d3d3d3;
                                        padding: 1px 5px;
                                        border-radius: 4px;
                                        margin-bottom: 5px;
                                    }
                                </style>
                                <div>
                                    <h4>Details:</h4>
                                    @if($diffStuff)
                                        @foreach ($diffStuff as $field => $value)
                                            <div>
                                                <p class="mb-2">
                                                    <strong>{{ $field }}: </strong>
                                                    <span class="strike-through">{{ $value['old'] ?? "n/a" }}</span>
                                                    <span class="update-section">{{ $value['new'] ?? "n/a" }}</span>
                                                </p>
                                            </div>
                                </div>
                                @endforeach
                                @else
                                    @if($old)
                                        @foreach($old as $key => $value)
                                            <p class="m-0"><strong>{{ $key }}: </strong> {{ $value }}</p>
                                        @endforeach
                                    @endif
                                    @if($new)
                                        @foreach($new as $key => $value)
                                            <p class="m-0"><strong>{{ $key }}: </strong> {{ $value }}</p>
                                        @endforeach
                                    @endif
                                @endif
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
