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
                                    <li class="breadcrumb-item active" aria-current="page">Orders</li>
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
                                            <th>Customer</th>
                                            <th>Invoice</th>
                                            <th>(£) Subtotal</th>
                                            <th>(£) Delivery Charge</th>
                                            <th>(£) Discount</th>
                                            <th>(£) Grand Total</th>
                                            <th>Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($orders) && $orders->isNotEmpty())
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->user->name }}</td>
                                                    <td>{{ $order->invoice_number }}</td>
                                                    <td>{{ $order->mirror_subtotal }}</td>
                                                    <td>{{ $order->mirror_delivery }}</td>
                                                    <td>{{ $order->mirror_discount }}</td>
                                                    <td>{{ $order->mirror_total }}</td>
                                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                    <td class="text-center">
                                                        @if($order->status == \App\Enums\PaymentStatus::CONFIRMED->value)
                                                            <span class="badge badge-pill badge-success">
                                                                {{ ucfirst(strtolower(\App\Enums\PaymentStatus::CONFIRMED->name)) }}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-pill badge-danger">
                                                                {{ ucfirst(strtolower(\App\Enums\PaymentStatus::from($order->status)->name)) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @can('viewOrderDetails', Auth::user())
                                                            <a href="{{ route('admin.manage.order.details', [$order]) }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                        @endcan
                                                        {{--                                                        <button type="button"--}}
                                                        {{--                                                                data-route="{{ route('admin.book-categories.destroy', [$category]) }}"--}}
                                                        {{--                                                                data-name="{{ $category->name }}"--}}
                                                        {{--                                                                class="dltButton btn bg-transparent p-0 ms-2">--}}
                                                        {{--                                                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>--}}
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
