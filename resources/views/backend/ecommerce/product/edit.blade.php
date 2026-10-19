@extends('layouts.backend')

@section('content')
@php
    /*
    |--------------------------------------------------------------------------
    | Current status (works if $product->status is an enum or 0/1)
    |--------------------------------------------------------------------------
    */
    $currentStatus = old(
        'status',
        $product->status instanceof \BackedEnum ? $product->status->value : $product->status
    );

    /*
    |--------------------------------------------------------------------------
    | Main product file (product_soluition)
    |--------------------------------------------------------------------------
    */
    $mainFile    = $product->product_soluition;
    $mainFileUrl = $mainFile ? asset('storage/' . $mainFile) : null;
    $mainIsImage = $mainFile
        ? in_array(strtolower(pathinfo($mainFile, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])
        : false;
@endphp

<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="container-full">

        <!-- Content Header -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">Edit Product</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.products.index') }}">Products</a>
                                </li>
                                <li class="breadcrumb-item active">Edit: {{ $product->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <form action="{{ route('admin.products.update', ['product' => $product]) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <section class="content">
                <div class="row">

                    <!-- ================= LEFT SIDE ================= -->
                    <div class="col-lg-8 col-12">
                        <div class="box">

                            <div class="box-header with-border">
                                <h4 class="box-title">Product Details</h4>
                            </div>

                            @include('layouts.backend.notification')

                            <div class="box-body">
                                <div class="row">

                                    <!-- Product Name -->
                                    <div class="col-lg-4 col-12">
                                        <div class="form-group">
                                            <label for="title" class="form-label">Product Name</label>
                                            <input type="text" name="title" id="title"
                                                   value="{{ old('title', $product->title) }}"
                                                   class="form-control" placeholder="Enter product title">
                                            @error('title')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- SKU -->
                                    <div class="col-lg-3 col-12">
                                        <div class="form-group">
                                            <label for="sku" class="form-label">Product SKU</label>
                                            <input type="text" name="sku" id="sku"
                                                   value="{{ old('sku', $product->sku) }}"
                                                   class="form-control" placeholder="Enter product SKU">
                                            @error('sku')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Year Group -->
                                    <div class="col-lg-5 col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="year_group_id">Year Group</label>
                                            <select name="year_group_id" id="year_group_id" class="form-select">
                                                <option value="">Select...</option>
                                                @foreach($yearGroups as $group)
                                                    <option value="{{ $group->id }}"
                                                        {{ (string) old('year_group_id', $product->year_group_id) === (string) $group->id ? 'selected' : '' }}>
                                                        {{ ucfirst($group->year_name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('year_group_id')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Subject (loaded by AJAX, saved one pre-selected) -->
                                    <div class="col-lg-4 col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="subjects">Subject</label>
                                            <select name="subjects" id="subjects" class="form-select">
                                                <option value="">Select...</option>
                                            </select>
                                            @error('subjects')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Regular Price -->
                                    <div class="col-lg-4 col-12">
                                        <div class="form-group">
                                            <label for="regular_price" class="form-label">(£) Regular Price</label>
                                            <input type="text" name="regular_price" id="regular_price"
                                                   value="{{ old('regular_price', $product->regular_price) }}"
                                                   class="form-control" placeholder="Enter regular price">
                                            @error('regular_price')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Discount Price -->
                                    <div class="col-lg-4 col-12">
                                        <div class="form-group">
                                            <label for="discount_price" class="form-label">(£) Discount Price</label>
                                            <input type="text" name="discount_price" id="discount_price"
                                                   value="{{ old('discount_price', $product->discount_price) }}"
                                                   class="form-control" placeholder="Enter discount price">
                                            @error('discount_price')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Product Description</label>
                                            <textarea name="description" id="description" class="form-control" rows="4"
                                                      placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Amazon Link -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="amazon_link" class="form-label">Amazon Link</label>
                                            <textarea name="amazon_link" id="amazon_link" class="form-control" rows="2"
                                                      placeholder="Enter product amazon link">{{ old('amazon_link', $product->amazon_link) }}</textarea>
                                            @error('amazon_link')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Product Image (stored in product_soluition) -->
                                    <div class="col-lg-8 col-12">
                                        <div class="form-group">
                                            <label for="file" class="form-label">Product Image</label>
                                            <input id="file" name="file" type="file" class="form-control" accept="image/*">
                                            <small class="text-muted">Leave empty to keep the current file.</small>
                                            @error('file')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror

                                            <!-- Current / new preview -->
                                            <div class="mt-2">
                                                <img id="image-preview"
                                                     src="{{ $mainIsImage ? $mainFileUrl : '' }}"
                                                     alt="Product image"
                                                     class="img-thumbnail {{ $mainIsImage ? '' : 'd-none' }}"
                                                     style="max-height: 160px;">

                                                @if($mainFileUrl)
                                                    <div class="mt-1" id="current-file-link">
                                                        <a href="{{ $mainFileUrl }}" target="_blank">
                                                            <i class="fa fa-external-link"></i>
                                                            {{ $mainIsImage ? 'View full image' : 'View current file' }}
                                                        </a>
                                                    </div>
                                                @else
                                                    <div id="no-image-text" class="text-muted mt-1">No image uploaded yet.</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-lg-4 col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="status">Status</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="">Select...</option>
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status->value }}"
                                                        {{ (string) $currentStatus === (string) $status->value ? 'selected' : '' }}>
                                                        {{ ucfirst(strtolower($status->name)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Footer / Submit -->
                            <div class="box-footer">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-success pull-right">
                                    <i class="fa fa-save"></i> Update Product
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- ================= RIGHT SIDE: PDF SAMPLES ================= -->
                    <div class="col-lg-4 col-12">
                        <div class="box">

                            <div class="box-header with-border d-flex align-items-center">
                                <h4 class="box-title">PDF Sample</h4>
                                <button type="button" id="create-sample-button"
                                        class="ms-auto waves-effect waves-light btn btn-primary btn-sm">
                                    <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                    <span class="ms-2">Add More</span>
                                </button>
                            </div>

                            <div class="box-body">

                                <!-- Existing samples -->
                                <h6 class="mb-2">Existing Samples</h6>

                                @forelse($samples as $sample)
                                    <div class="d-flex align-items-center border rounded p-2 mb-2 existing-sample"
                                         data-index="{{ $sample->index }}">
                                        <div class="me-auto" style="min-width: 0;">
                                            <strong>{{ $sample->solution_name }}</strong><br>
                                            <a href="{{ $sample->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 100%;">
                                                <i class="fa fa-file-pdf-o"></i> {{ basename($sample->path) }}
                                            </a>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm ms-2 delete-existing-sample"
                                                title="Delete sample">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-muted">No samples uploaded yet.</p>
                                @endforelse

                                <!-- Indexes of samples to delete are added here -->
                                <div id="deleted-samples-holder"></div>

                                <hr>

                                <!-- New samples -->
                                <h6 class="mb-2">Add New Samples</h6>

                                <div class="row sample-row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <select name="solution_type[]" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($solution as $sol)
                                                    <option value="{{ $sol->id }}">{{ $sol->solution_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input name="pdf_sample[]" type="file" class="form-control"
                                                   accept="application/pdf">
                                        </div>
                                    </div>
                                </div>

                                @error('pdf_sample.*')
                                    <div class="form-control-feedback text-danger mt-1">{{ $message }}</div>
                                @enderror

                                <div id="sample-holder"></div>

                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </form>

    </div>
</div>

<!-- Template for new sample rows (cloned by JS) -->
<template id="sample-row-template">
    <div class="row mt-2 sample-row">
        <div class="col-6">
            <div class="form-group">
                <select name="solution_type[]" class="form-control">
                    <option value="">Select</option>
                    @foreach($solution as $sol)
                        <option value="{{ $sol->id }}">{{ $sol->solution_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <input name="pdf_sample[]" type="file" class="form-control" accept="application/pdf">
            </div>
        </div>
        <div class="col-1">
            <button type="button" class="btn btn-danger remove-sample">×</button>
        </div>
    </div>
</template>
@endsection


@section('js')
<script>
$(document).ready(function () {

    /* ---------------- YEAR GROUP -> SUBJECT (AJAX) ---------------- */
    let oldSubjectId = @json(old('subjects', $product->subjects));

    function loadSubjects(yearGroupId, selectedSubjectId = '') {
        let subjectSelect = $('#subjects');

        if (!yearGroupId) {
            subjectSelect.html('<option value="">Select...</option>');
            return;
        }

        subjectSelect.html('<option value="">Loading...</option>');

        $.ajax({
            url: "{{ route('get.subjects.by.year') }}",
            type: "GET",
            data: { year_group_id: yearGroupId },
            success: function (response) {
                subjectSelect.html('<option value="">Select...</option>');

                if (response.subjects && response.subjects.length > 0) {
                    $.each(response.subjects, function (index, subject) {
                        let selected = String(subject.id) === String(selectedSubjectId) ? 'selected' : '';
                        subjectSelect.append(
                            '<option value="' + subject.id + '" ' + selected + '>' + subject.name + '</option>'
                        );
                    });
                } else {
                    subjectSelect.html('<option value="">No subjects found</option>');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                subjectSelect.html('<option value="">Unable to load subjects</option>');
            }
        });
    }

    $('#year_group_id').on('change', function () {
        loadSubjects($(this).val(), '');
    });

    // Load the saved subject when the page opens
    let initialYearGroupId = $('#year_group_id').val();
    if (initialYearGroupId) {
        loadSubjects(initialYearGroupId, oldSubjectId);
    }

    /* ---------------- PRODUCT IMAGE LIVE PREVIEW ---------------- */
    $('#file').on('change', function () {
        const file = this.files && this.files[0];
        if (!file || !file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            $('#image-preview').attr('src', e.target.result).removeClass('d-none');
            $('#no-image-text').addClass('d-none');
        };
        reader.readAsDataURL(file);
    });

    /* ---------------- ADD NEW SAMPLE ROW ---------------- */
    $('#create-sample-button').on('click', function () {
        const template = document.getElementById('sample-row-template');
        $('#sample-holder').append(template.content.cloneNode(true));
    });

    /* ---------------- REMOVE NEW (UNSAVED) SAMPLE ROW ---------------- */
    $(document).on('click', '.remove-sample', function () {
        $(this).closest('.sample-row').remove();
    });

    /* ---------------- DELETE EXISTING SAMPLE ----------------
       Hides the row and adds a hidden input with its index.
       The file is deleted when you click "Update Product".     */
    $(document).on('click', '.delete-existing-sample', function () {
        if (!confirm('Delete this sample? It will be removed when you click Update Product.')) {
            return;
        }

        const row = $(this).closest('.existing-sample');
        const index = row.data('index');

        $('#deleted-samples-holder').append(
            '<input type="hidden" name="deleted_samples[]" value="' + index + '">'
        );

        row.fadeOut(200);
    });

});
</script>
@endsection