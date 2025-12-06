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
                                    <a style="font-size: 20px" href="{{ route('admin.activity.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                                    <h3 class="box-title">{{$log->id}}. {{ $model }} Activity</h3>
                                </div>
                            </div>
                            <div class="box-body">
                                <div>
                                    <h4>Action Completed By: {{ $log->admin->name }}</h4>
                                </div>
                                <div>
                                    <h4>Action: {{ $log->action }}</h4>
                                </div>
                                {{--                                <div class="d-flex align-items-center gap-5">--}}
                                {{--                                    <div>--}}
                                {{--                                        <h4>Old Data:</h4>--}}
                                {{--                                        @foreach ($old as $field => $value)--}}
                                {{--                                            @if (is_array($value))--}}
                                {{--                                                <pre><strong>{{ $field }} : </strong> {{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>--}}
                                {{--                                            @else--}}
                                {{--                                                <p class="m-0"><strong>{{ $field }} : </strong> {{ $value }}</p>--}}
                                {{--                                            @endif--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </div>--}}
                                {{--                                    <div>--}}
                                {{--                                        <h4>New Data:</h4>--}}

                                {{--                                        @foreach ($new as $field => $value)--}}
                                {{--                                            @if (is_array($value))--}}
                                {{--                                                <pre><strong>{{ $field }} : </strong> {{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>--}}
                                {{--                                            @else--}}
                                {{--                                                <p class="m-0"><strong>{{ $field }} : </strong> {{ $value }}</p>--}}
                                {{--                                            @endif--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </div>--}}
                                <div>
                                    <div class="row">
                                        <div class="col-6">
                                            <h4>Old</h4>
                                        </div>
                                        <div class="col-6">
                                            <h4>New</h4>
                                        </div>
                                    </div>
                                    @foreach ($diffStuff as $field => $value)
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="m-0"><strong>{{ $field }}
                                                        : </strong> {{ $value['old'] ?? "n/a" }}</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="m-0"><strong>{{ $field }}
                                                        : </strong> {{ $value['new'] ?? 'n/a' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
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
