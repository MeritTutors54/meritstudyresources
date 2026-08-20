@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">Products Management</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                @include('layouts.backend.notification')

                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border d-flex align-items-center justify-content-between">
                                <h4 class="box-title">All Products</h4>
                                @can('createProduct', Auth::user())
                                    <a href="{{ route('admin.products.create') }}"
                                       class="btn btn-primary btn-sm waves-effect waves-light">
                                        <i class="fa fa-plus-square-o me-1" aria-hidden="true"></i> Create New Product
                                    </a>
                                @endcan
                            </div>

                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1"
                                           class="table table-bordered table-striped table-hover align-middle mb-0">
                                        <thead class="">
                                        <tr>
                                            <th>Product Details</th>
                                            <th>Variant</th>
                                            <th>SKU</th>
                                            <th>Year Group</th>
                                            <th class="text-end">Regular Price</th>
                                            <th class="text-end">Discount Price</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($products) && $products->isNotEmpty())
                                            @foreach($products as $product)
                                                <tr>
                                                    <td>
                                                        <span class="fw-500 text-dark">{{ $product->title }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-info">{{ $product->BookVariant->name ?? 'N/A' }}</span>
                                                    </td>
                                                    <td>
                                                        <code>{{ $product->sku }}</code>
                                                    </td>
                                                    <td>
                                                        {{ $product->yearGroup->year_name ?? '—' }}
                                                    </td>
                                                    <td class="text-end fw-500">
                                                        £{{ number_format((float)($product->mirror_price ?? 0), 2) }}
                                                    </td>
                                                    <td class="text-end">
                                                        @if(!empty($product->mirror_discount))
                                                            <span
                                                                class="text-success fw-500">£{{ number_format((float)$product->mirror_discount, 2) }}</span>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($product->status === \App\Enums\Status::ACTIVE->value)
                                                            <span class="badge badge-success">
                                                                    {{ ucfirst(strtolower(\App\Enums\Status::from($product->status)->name)) }}
                                                                </span>
                                                        @else
                                                            <span class="badge badge-secondary">
                                                                    {{ ucfirst(strtolower(\App\Enums\Status::from($product->status)->name)) }}
                                                                </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            @can('updateProduct', Auth::user())
                                                                <a href="{{ route('admin.products.edit', [$product]) }}"
                                                                   class="btn btn-sm text-primary waves-effect me-1"
                                                                   title="Edit Product">
                                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                                </a>
                                                            @endcan
                                                            @can('deleteProduct', Auth::user())
                                                                <button type="button"
                                                                        data-route="{{ route('admin.products.destroy', [$product]) }}"
                                                                        data-name="{{ $product->title ?? $product->name }}"
                                                                        class="dltButton btn btn-sm text-danger waves-effect"
                                                                        title="Delete Product">
                                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                </button>
                                                            @endcan
                                                        </div>
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
    <script>
        $(document).ready(function () {
            $('#example1').DataTable({
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                pageLength: 10,
                columnDefs: [
                    {orderable: false, targets: [6, 7]}
                ]
            });

            $(document).on('click', '.dltButton', function () {
                let name = $(this).data('name');
                let url = $(this).data('route');
                $('#set-action').attr('action', url);
                $('#element-name').html(name);
                $('#dltModal').modal('show');
            });
        });
    </script>
@endsection
