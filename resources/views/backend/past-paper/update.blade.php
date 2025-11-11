@extends('layouts.backend')
@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">ALL PAST PAPERS</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/admin/past-paper/index') }}">PAST PAPERS</a></li>
                                <li class="breadcrumb-item active">PAST PAPERS</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">PAST PAPERS</h4>
                        </div>
                        @include('layouts.backend.notification')
                        <form action="{{ route('admin.past-paper.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="uploads_type" value="Past Paper">
                            <input type="hidden" name="pastpaper_id" value="{{ $edit->id }}">

                            <div class="box-body">
                                <div class="row">

                                    {{-- Title --}}
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="title" class="form-control" value="{{ $edit->title }}" required>
                                            @error('title')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    {{-- Exam Series --}}
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Series</label>
                                            <select name="exam_series" class="form-select" required>
                                                <option disabled>Select...</option>
                                                @foreach ($examSeries as $series)
                                                    <option value="{{ $series->id }}" {{ $edit->exam_series == $series->id ? 'selected' : '' }}>
                                                        {{ $series->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('exam_series')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    {{-- Category --}}
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select name="category" id="category" class="form-select" onchange="getCategory(this)" required>
                                                <option disabled>Select...</option>
                                                @foreach ($allCategory as $category)
                                                    <option value="{{ $category->id }}" {{ $edit->category == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    {{-- Subcategory --}}
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>SubCategory</label>
                                            <select name="subcategory" id="subcategory" class="form-select" onchange="getSubCategory(this)" required>
                                                <option disabled>Select...</option>
                                                @foreach ($subcategoryList as $subcategory)
                                                    <option value="{{ $subcategory->id }}" {{ $edit->subcategory == $subcategory->id ? 'selected' : '' }}>
                                                        {{ $subcategory->subcategory_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('subcategory')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    {{-- ReSubcategory --}}
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>ReSubCategory</label>
                                            <select name="resubcategory" id="resubcategory" class="form-select">
                                                <option disabled>Select...</option>
                                                @foreach ($resubcategoryList as $resubcategory)
                                                    <option value="{{ $resubcategory->id }}" {{ $edit->resubcategory == $resubcategory->id ? 'selected' : '' }}>
                                                        {{ $resubcategory->resubcategory_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('resubcategory')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    {{-- Payment Status --}}
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Payment Status</label>
                                            <select name="is_paid" class="form-select">
                                                <option value="1" {{ $edit->is_paid == 1 ? 'selected' : '' }}>Paid</option>
                                                <option value="0" {{ $edit->is_paid == 0 ? 'selected' : '' }}>Free</option>
                                            </select>
                                            @error('is_paid')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="is_active" class="form-select">
                                                <option value="1" {{ $edit->is_active == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $edit->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('is_active')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    {{-- Question Paper --}}
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Question Paper (PDF) <span ><a target="__blank" href="{{ asset('uploads/pastpaper/'. $edit->ques_paper) }}" style="badge badge-success">Uploaded File Here</a></span></label>
                                            <input type="file" name="ques_paper" accept=".pdf" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Mark Scheme --}}
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Mark Scheme (PDF) <span ><a target="__blank" href="{{ asset('uploads/pastpaper/'. $edit->ans_paper) }}" style="badge badge-success">Uploaded File Here</a></span></label>
                                            <input type="file" name="ans_paper" accept=".pdf" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Have Solutions --}}
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Have Solutions?</label>
                                            <div class="demo-radio-button">
                                                <input type="radio" name="have_solution" id="radio_7" value="1" {{ $edit->have_solution == 1 ? 'checked' : '' }}>
                                                <label for="radio_7">Yes</label>
                                                <input type="radio" name="have_solution" id="radio_9" value="0" {{ $edit->have_solution == 0 ? 'checked' : '' }}>
                                                <label for="radio_9">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Solutions Section --}}
                                    <div class="col-lg-12 solutions-field" style="display: {{ $edit->have_solution == 1 ? 'block' : 'none' }};">
                                        <div class="form-group">
                                            <div class="demo-checkbox">
                                                <input type="checkbox" name="have_video_solution" id="video_solution_id" value="1" onchange="vidioSolution(this)" {{ $edit->have_video_solution == 1 ? 'checked' : '' }}>
                                                <label for="video_solution_id">Video Solution</label>

                                                <input type="checkbox" name="have_pdf_solution" id="pdf_solution_id" value="1" onchange="pdfSolution(this)" {{ $edit->have_pdf_solution == 1 ? 'checked' : '' }}>
                                                <label for="pdf_solution_id">PDF Solutions</label>
                                            </div>
                                        </div>

                                        {{-- Video Section --}}
                                        <div class="form-group" id="video_section" style="display: {{ $edit->have_video_solution == 1 ? 'block' : 'none' }};">
                                            <div class="demo-checkbox">
                                                <input type="radio" name="video_procedure" id="video_link_id" value="1" onchange="videoLink(this)" {{ $edit->video_procedure == 1 ? 'checked' : '' }}>
                                                <label for="video_link_id">Video Link</label>
                                                <input type="radio" name="video_procedure" id="video_uploads_id" value="0" onchange="videoUploads(this)" {{ $edit->video_procedure == 0 ? 'checked' : '' }}>
                                                <label for="video_uploads_id">Upload Video</label>
                                            </div>
                                        </div>

                                        {{-- Video Link Field --}}
                                        <div class="form-group" id="video_link_section" style="display: {{ $edit->video_procedure == 1 ? 'block' : 'none' }};">
                                            <label>Video Links</label>
                                            <input type="text" name="video_links" value="{{ $edit->video_links }}" class="form-control" placeholder="Please enter valid link">
                                        </div>

                                        {{-- Video Upload --}}
                                        <div class="form-group" id="video_uploads_section" style="display: {{ $edit->video_procedure == 0 && $edit->have_video_solution == 1 ? 'block' : 'none' }};">
                                            <label>Video Solutions (Video Only)</label>
                                            <input type="file" name="video_solution" accept="video/*" class="form-control">
                                        </div>

                                        {{-- PDF Solution Upload --}}
                                        <div class="form-group" id="pdf_solution_section" style="display: {{ $edit->have_pdf_solution == 1 ? 'block' : 'none' }};">
                                            <label>Solutions (PDF Only) <span ><a target="__blank" href="{{ asset('uploads/pastpaper/'. $edit->pdf_solution) }}" style="badge badge-success">Uploaded File Here</a></span></label>
                                            <input type="file" name="pdf_solution" accept=".pdf" class="form-control">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="box-footer">
                                <a href="{{ url('/admin/past-paper/index') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-success pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    $('#video_solution_id').change(function() {
        $('#video_section').toggle(this.checked);
    });

    $('#pdf_solution_id').change(function() {
        $('#pdf_solution_section').toggle(this.checked);
    });

    function getCategory(el) {
        var category = $("#category").val();
        if (category) {
            $.ajax({
                url: "{{ url('get/admin/allsubcategory/') }}/" + category,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#subcategory').empty().append('<option disabled>Select...</option>');
                    $.each(data, function(index, obj) {
                        $('#subcategory').append('<option value="' + obj.id + '">' + obj.subcategory_name + '</option>');
                    });
                }
            });
        }
    }

    function getSubCategory(el) {
        var subcategory = $("#subcategory").val();
        if (subcategory) {
            $.ajax({
                url: "{{ url('get/admin/allresubcategory/') }}/" + subcategory,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#resubcategory').empty().append('<option disabled>Select...</option>');
                    $.each(data, function(index, obj) {
                        $('#resubcategory').append('<option value="' + obj.id + '">' + obj.resubcategory_name + '</option>');
                    });
                }
            });
        }
    }

    function vidioSolution(el) {
        $('#video_section').toggle($(el).prop('checked'));
    }

    function pdfSolution(el) {
        $('#pdf_solution_section').toggle($(el).prop('checked'));
    }

    function videoLink(el) {
        $('#video_link_section').show();
        $('#video_uploads_section').hide();
    }

    function videoUploads(el) {
        $('#video_link_section').hide();
        $('#video_uploads_section').show();
    }

    // Initial load visibility
    $(document).ready(function() {
        if ($('#video_solution_id').prop('checked')) $('#video_section').show();
        if ($('#pdf_solution_id').prop('checked')) $('#pdf_solution_section').show();
    });
</script>
<script>
    // Get references to the radio buttons and the solutions field
    const yesRadio = document.getElementById('radio_7');
    const noRadio = document.getElementById('radio_9');
    const solutionsField = document.querySelector('.solutions-field');

    // Add event listeners to handle changes in radio button selection
    yesRadio.addEventListener('change', function() {
        if (this.checked) {
            solutionsField.style.display = 'block';  // Show the Solutions field
        }
    });

    noRadio.addEventListener('change', function() {
        if (this.checked) {
            solutionsField.style.display = 'none';  // Hide the Solutions field
        }
    });

    // Initial check in case the page is loaded with "Yes" already selected
    if (yesRadio.checked) {
        solutionsField.style.display = 'block';
    } else {
        solutionsField.style.display = 'none';
    }


</script>

@endsection
