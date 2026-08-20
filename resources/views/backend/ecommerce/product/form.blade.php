@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header -->
            @php
                $isEdit = isset($product);
                $actionUrl = $isEdit ? route('admin.products.update', ['product' => $product]) : route('admin.products.store');
                $method = $isEdit ? 'PATCH' : 'POST';
                $scope = $isEdit ? 'Update' : 'Create';
            @endphp

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">{{ $scope }} Product</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.products.index') }}">Products</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Form -->
            <section class="content">
                <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                    @method($method)
                    @csrf
                    <div class="row">
                        <!-- Primary Product Fields -->
                        <div class="col-lg-8 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">{{ $scope }} Product Details</h4>
                                </div>
                                @include('backend.ecommerce.product._fields')
                            </div>
                        </div>

                        <!-- Sidebar / Extra Attachments -->
                        <div class="col-lg-4 col-12">
                            <div class="box">
                                <div class="box-header with-border d-flex align-items-center justify-content-between">
                                    <h4 class="box-title">PDF Sample Attachments</h4>
                                    <button
                                        type="button"
                                        id="create-sample-button"
                                        class="btn btn-primary btn-sm waves-effect waves-light">
                                        <i class="fa fa-plus-square-o me-1" aria-hidden="true"></i> Add More
                                    </button>
                                </div>
                                <div class="box-body">
                                    @if($product->getSampleImages->isNotEmpty())
                                        <div class="mb-3">
                                            <label class="form-label text-muted fs-12 fw-bold text-uppercase">Existing Samples</label>
                                            <div class="d-flex flex-wrap gap-2" id="sample-images-container">
                                                @foreach($product->getSampleImages as $sample)
                                                    <div class="position-relative border rounded p-1 bg-light text-center"
                                                         id="sample-image-{{ $sample->id }}"
                                                         style="width: 70px;">

                                                        {{-- Delete Button Badge --}}
                                                        <button type="button"
                                                                class="btn btn-danger btn-sm p-0 position-absolute top-0 end-0 rounded-circle delete-sample-btn"
                                                                data-id="{{ $sample->id }}"
                                                                style="width: 18px; height: 18px; line-height: 1; transform: translate(30%, -30%); font-size: 11px;"
                                                                title="Delete image">
                                                            &times;
                                                        </button>

                                                        <img src="{{ asset('storage/' . $sample->path) }}"
                                                             alt="Sample Image"
                                                             class="img-fluid rounded"
                                                             style="width: 100%; height: 60px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div id="sample-holder">
                                        <div class="form-group mb-2">
                                            <input id="pdf_sample"
                                                   name="pdf_sample[]"
                                                   type="file"
                                                   class="form-control"
                                                   accept="image/*">

                                            @error('pdf_sample')
                                            <div class="form-control-feedback text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            // Set up CSRF token globally for all jQuery AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            // Handle delete click with event delegation
            $(document).on('click', '.delete-sample-btn', function (e) {
                e.preventDefault();

                const $btn = $(this);
                const imageId = $btn.data('id');
                const $container = $(`#sample-image-${imageId}`);
                const url = "{{ route('admin.ajax.product.samples.destroy', [':id']) }}";
                const route = url.replace(':id', imageId);

                if (!confirm('Are you sure you want to delete this sample image?')) {
                    return;
                }

                $btn.prop('disabled', true);

                $.ajax({
                    url: route,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Fade out and remove element from DOM
                            $container.fadeOut(300, function () {
                                $(this).remove();

                                // Hide the wrapper if no images remain
                                if ($('#sample-images-container .position-relative').length === 0) {
                                    $('#sample-images-container').closest('.mb-3').fadeOut(200);
                                }
                            });
                        } else {
                            alert(response.message || 'Failed to delete the image.');
                            $btn.prop('disabled', false);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert(xhr.responseJSON?.message || 'An error occurred while deleting the image.');
                        $btn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#create-sample-button").on('click', function () {
                let holder = $('#sample-holder');
                holder.append(
                    '<div class="form-group mt-2">' +
                    '<input name="pdf_sample[]" type="file" class="form-control" accept="image/*,application/pdf">' +
                    '</div>'
                );
            });
        });
    </script>
@endsection
