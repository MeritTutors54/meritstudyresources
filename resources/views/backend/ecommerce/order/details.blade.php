@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Orders</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.manage.order') }}">
                                            Orders
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Single Order</li>
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
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>(£) Unit Price</th>
                                            <th>Quantity</th>
                                            <th>(£) Subtotal</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($order->items as $item)
                                                <tr>

                                                    <td>{{ $item->product->name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ $item->mirror_price }}</td>
                                                    <td>{{ $order->mirror_subtotal }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Tracking Order</h4>
                        <div class="box-controls pull-right">
                            @can('updateOrderTracking', Auth::user())
                                <button
                                    id="create-new-track"
                                    data-route="{{ route('admin.manage.order.update.track', [$order]) }}"
                                    class="waves-effect waves-light btn btn-secondary btn-sm">
                                    Change Status
                                </button>
                            @endcan
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <th>Admin</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>

                                @foreach($order->trackReports()->latest()->get() as $track)
                                    <tr>
                                        <td>{{ $track->admin->name ?? '' }}</td>
                                        <td>
                                            {{ $track->created_at->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            @if($track->status == \App\Enums\OrderStatus::PENDING->value)
                                                <span class="badge badge-pill badge-danger">
                                                    {{ ucfirst(strtolower(\App\Enums\OrderStatus::PENDING->name)) }}
                                                </span>
                                            @else
                                                <span class="badge badge-pill badge-secondary">
                                                    {{ ucfirst(strtolower(\App\Enums\OrderStatus::from($track->status)->name)) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </section>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('backend/assets/vendor_components/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/data-table.js') }}"></script>

    <script>
        $('#create-new-track').on('click', function () {
            // let name = $(this).data('name');
            let url = $(this).data('route');
            $('#set-action').attr('action', url);
            // $('#element-name').html(name);
            $('#updateTrackModal').modal('show');
        });
    </script>
@endsection
