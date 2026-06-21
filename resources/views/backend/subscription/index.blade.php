@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Subscriptions</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
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
                                    <h3 class="box-title">Subscription Table</h3>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Stipe Price ID</th>
                                            <th>(£)Price</th>
                                            <th>Payment</th>
                                            <th>Options</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($allPlans->isNotEmpty())
                                            @foreach($allPlans as $plan)
                                                <tr>
                                                    <td>{{ ucfirst($plan->name) }}</td>
                                                    <td>{{ $plan->description ?? 'n/a' }}</td>
                                                    <td>{{ $plan->stripe_price_id }}</td>
                                                    <td>{{ number_format($plan->price, 2) }}</td>
                                                    <td>{{ \App\Enums\SubscriptionDuration::from($plan->duration)->name }}</td>
                                                    <td>
                                                        <ul>
                                                            <li>User Limit: {{ $plan->user_limit }}</li>
                                                            <li>Package Download Limit: {{ $plan->download_limit }}</li>
                                                            <li>Weekly Download Limit: {{ $plan->weekly_limit }}</li>
                                                            <li>Has Full Access: {{ \App\Enums\Statement::from($plan->has_full_access)->name }}</li>
                                                            <li>Trial Days: {{ $plan->trial_days }}</li>
                                                        </ul>
                                                    </td>
                                                    <td>{{ \App\Enums\SubscriptionType::from($plan->type)->name }}</td>
                                                    <td class="text-center">
                                                        @if($plan->status === \App\Enums\Status::ACTIVE->value)
                                                            <span class="badge badge-success">
                                                                {{ ucfirst(strtolower(\App\Enums\Status::from($plan->status)->name)) }}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-secondary">
                                                                {{ ucfirst(strtolower(\App\Enums\Status::from($plan->status)->name)) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                       @can('updateSubscriptionPlan', Auth::user())
                                                            <a href="{{ route('admin.subscription-plans.edit', [$plan]) }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                       @endcan
{{--                                                        <button type="button"--}}
{{--                                                                data-route="{{ route('admin.subscription-plans.destroy', [$plan]) }}"--}}
{{--                                                                data-name="{{ $plan->name }}"--}}
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
        $('.dltButton').on('click', function() {
            let name = $(this).data('name');
            let url = $(this).data('route');
            $('#set-action').attr('action', url);
            $('#element-name').html(name);
            $('#dltModal').modal('show');
        });
    </script>
@endsection
