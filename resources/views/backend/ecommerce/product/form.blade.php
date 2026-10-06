@extends('layouts.backend')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->

            <?php
            if (isset($product)) {
                $actionUrl = route('admin.products.update', ['product' => $product]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.products.store');
                $method = 'POST';
                $scope = "Create";
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Products</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.products.index') }}">
                                            Products
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Product</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <form action="{{ $actionUrl }}" method="post" enctype="multipart/form-data">
                @method($method)
                @csrf
                <section class="content">
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">{{ $scope }} Products</h4>
                                </div>
                                @include('layouts.backend.notification')
                                <!-- /.box-header -->
                                @include('backend.ecommerce.product._fields')
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="box">
                                <div class="box-header with-border d-flex align-items-center">
                                    <h4 class="box-title">PDF Sample</h4>
                                    <button
                                        type="button"
                                        id="create-sample-button"
                                        class="ms-auto waves-effect waves-light btn btn-primary btn-sm">
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        <span class="ms-2">
                                            Add More
                                        </span>
                                    </button>
                                </div>
                                @include('backend.ecommerce.product._extra_fields')
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
 


<script>
    $(document).ready(function () {

        $('#year_group_id').on('change', function () {

            let yearGroupId = $(this).val();
            let subjectSelect = $('#subjects');

            // Reset subjects
            subjectSelect.html('<option value="">Loading...</option>');

            if (yearGroupId === '') {
                subjectSelect.html('<option value="">Select...</option>');
                return;
            }

            $.ajax({
                url: "{{ route('get.subjects.by.year') }}",
                type: "GET",
                data: {
                    year_group_id: yearGroupId
                },
                success: function (response) {

                    subjectSelect.html(
                        '<option value="">Select...</option>'
                    );

                    $.each(response.subjects, function (index, subject) {

                        subjectSelect.append(
                            '<option value="' + subject.id + '">' +
                                subject.name +
                            '</option>'
                        );

                    });
                },

                error: function (xhr) {

                    console.log(xhr.responseText);

                    subjectSelect.html(
                        '<option value="">Unable to load subjects</option>'
                    );
                }
            });
        });

    });
</script>

<script>
    $("#create-sample-button").on('click', function () {

        let holder = $('#sample-holder');

        holder.append(`
            <div class="row mt-2">

                <div class="col-lg-6 col-6">
                    <div class="form-group">
                        <select name="solution_type[]" class="form-control">
                            <option value="">Select</option>

                            @php
                                $SOLUTION = DB::table('product_solutions')->get();
                            @endphp

                            @foreach ($SOLUTION as $solu)
                                <option value="{{ $solu->id }}">
                                    {{ $solu->solution_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-5 col-5">
                    <div class="form-group">
                        <input
                            name="pdf_sample[]"
                            type="file"
                            class="form-control"
                            accept=""
                        >
                    </div>
                </div>

                <div class="col-lg-1 col-1">
                    <button type="button"
                            class="btn btn-danger remove-sample">
                        ×
                    </button>
                </div>

            </div>
        `);
    });

    // Remove dynamically added row
    $(document).on('click', '.remove-sample', function () {
        $(this).closest('.sample-row').remove();
    });
</script>
@endsection
