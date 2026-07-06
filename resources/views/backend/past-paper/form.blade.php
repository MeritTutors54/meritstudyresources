@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <?php
            if (isset($past_paper)) {
                $actionUrl = route('admin.past-papers.update', ['past_paper' => $past_paper]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.past-papers.store');
                $method = 'POST';
                $scope = 'Create';
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Past Papers</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('admin.past-papers.index') }}">
                                            Past Papers
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Past Papers</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">{{ $scope }} Past Papers</h4>
                            </div>
                            @include('layouts.backend.notification')
                            <!-- /.box-header -->
                            <form id="pastPaperForm" action="{{ $actionUrl }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method($method)
                                @include('backend.past-paper._field')
                            </form>
                        </div>
                    </div>
                    @if (isset($past_paper))
                        <div class="col-lg-4 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Extra Option</h4>
                                </div>
                                <div>
                                    <div class="box-body">
                                        <div class="row mb-4">
                                            <div class="col-lg-12">
                                                <h5><strong>Question Paper:</strong></h5>
                                                @if (!empty($past_paper->ques_paper))
                                                    <a target="_blank"
                                                        href="{{ asset('uploads/pastpaper/' . $past_paper->ques_paper) }}">
                                                        <img width="50" src="{{ asset('pdf.png') }}" alt="" />
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5><strong>Mark Scheme</strong></h5>
                                                @if (!empty($past_paper->ans_paper))
                                                    <a target="_blank"
                                                        href="{{ asset('uploads/pastpaper/' . $past_paper->ans_paper) }}">
                                                        <img width="50" src="{{ asset('pdf.png') }}" alt="" />
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#video_solution_id').change(function() {
            if ($(this).prop('checked')) {
                $('#video_section').show();
            } else {
                $('#video_section').hide();
            }
        });

        $('#pdf_solution_id').change(function() {
            if ($(this).prop('checked')) {
                $('#pdf_solution_section').show();
            } else {
                $('#pdf_solution_section').hide();
            }
        });

        $('#video_link_id').on('change', function() {
            if ($(this).prop('checked')) {
                $('#video_link_section').show();
                $('#video_uploads_section').hide();
            } else {
                $('#pdf_solution_section').hide();
                $('#video_uploads_section').show();
            }
        });

        $('#video_uploads_id').on('change', function() {
            if ($(this).prop('checked')) {
                $('#video_link_section').hide();
                $('#video_uploads_section').show();
            } else {
                $('#video_link_section').show();
                $('#video_uploads_section').hide();
            }
        });
    </script>

    <script>
        function getSubCategory(el) {
            const category_id = $("#category").val();
            const subCategoryTag = $('#subcategory');

            if (category_id) {
                const route = "{{ route('admin.ajax.getSubCategory', [':category_id']) }}";
                const url = route.replace(':category_id', category_id);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        subCategoryTag.empty();
                        subCategoryTag.append('<option selected disabled>Select</option>');
                        $.each(data, function(index, districtObj) {
                            subCategoryTag.append('<option value="' + districtObj.id + '">' +
                                districtObj.subcategory_name + '</option>');
                        });
                    }
                });
            } else {
                alert('sorry data not found');
            }

        }

        function getReSubCategory(el) {
            const subcategory_id = $("#subcategory").val();
            const resubcategoryTag = $("#resubcategory");

            if (subcategory_id) {
                const route = "{{ route('admin.ajax.getReSubCategory', [':subcategory_id']) }}";
                const url = route.replace(':subcategory_id', subcategory_id);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        resubcategoryTag.empty();
                        resubcategoryTag.append('<option selected disabled>Select</option>');
                        $.each(data, function(index, districtObj) {
                            resubcategoryTag.append('<option value="' + districtObj.id + '">' +
                                districtObj.resubcategory_name + '</option>');
                        });
                    }
                });
            } else {
                alert('sorry data not found');
            }
        }
    </script>


    <script>
        // Get references to the radio buttons and the solutions field
        const yesRadio = document.getElementById('radio_7');
        const noRadio = document.getElementById('radio_9');
        const solutionsField = document.querySelector('.solutions-field');

        // Add event listeners to handle changes in radio button selection
        yesRadio.addEventListener('change', function() {
            if (this.checked) {
                solutionsField.style.display = 'block'; // Show the Solutions field
            }
        });

        noRadio.addEventListener('change', function() {
            if (this.checked) {
                solutionsField.style.display = 'none'; // Hide the Solutions field
            }
        });

        // Initial check in case the page is loaded with "Yes" already selected
        if (yesRadio.checked) {
            solutionsField.style.display = 'block';
        } else {
            solutionsField.style.display = 'none';
        }
    </script>

    <script>
        // File upload progressbar
        document.getElementById('pastPaperForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Stop standard form submission

            const form = this;
            const submitButton = form.querySelector('button[type="submit"]') || form.querySelector(
                'input[type="submit"]');

            // 2. Disable it
            if (submitButton) {
                submitButton.disabled = true;

                // Optional: Change the text so the user knows it's processing
                submitButton.innerText = 'Submitting...';
            }

            const formData = new FormData(form);
            const maxLeftSize = 5 * 1024 * 1024; // 5MB in bytes
            let isValid = true;

            const fileInputs = form.querySelectorAll('.file-input');

            console.log('File Inputs:', fileInputs); // Debugging: Log the file inputs

            // 1. Validate File Sizes
            fileInputs.forEach(input => {
                const file = input.files[0];
                const errorDiv = input.closest('.form-group').querySelector('.size-error');
                const progressBarContainer = input.closest('.form-group').querySelector('.progress');
                const progressBar = progressBarContainer.querySelector('.progress-bar');

                // Reset states
                errorDiv.style.display = 'none';
                errorDiv.innerText = '';
                progressBarContainer.style.display = 'none';
                progressBar.style.width = '0%';
                progressBar.innerText = '0%';

                if (file && file.size > maxLeftSize) {
                    errorDiv.innerText =
                        `The file size exceeds the 5MB limit. (Your file: ${(file.size / (1024 * 1024)).toFixed(2)}MB)`;
                    errorDiv.style.display = 'block';
                    isValid = false;
                }
            });

            if (!isValid) return; // Stop if validation fails

            // 2. Unhide progress bars IMMEDIATELY for fields that have files selected
            fileInputs.forEach(input => {
                if (input.files.length > 0) {
                    const progressBarContainer = input.closest('.form-group').querySelector('.progress');
                    progressBarContainer.setAttribute('style', 'display: flex !important; height: 10px;');
                }
            });

            // 3. Perform the AJAX Upload
            const xhr = new XMLHttpRequest();
            xhr.open(form.method, form.action, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            // Track upload progress dynamically
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);

                    fileInputs.forEach(input => {
                        if (input.files.length > 0) {
                            const progressBarContainer = input.closest('.form-group').querySelector(
                                '.progress');
                            const progressBar = progressBarContainer.querySelector('.progress-bar');

                            progressBar.style.width = percentComplete + '%';
                            progressBar.innerText = percentComplete + '%';
                        }
                    });
                }
            });

            // Handle Server Response
            xhr.onload = function() {
                try {
                    const responseData = JSON.parse(xhr.responseText);

                    if (xhr.status === 200) {
                        // Success Block
                        setTimeout(() => {
                            Swal.fire({
                                title: "Success!",
                                text: responseData.message,
                                icon: "success",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }, 400);

                    } else if (xhr.status === 422) {
                        // Validation Error Block (Unprocessable Entity)
                        let errorMessages = '';

                        // Laravel returns errors grouped by field name, e.g., { title: ["The title field is required."] }
                        if (responseData.errors) {
                            Object.keys(responseData.errors).forEach(field => {
                                errorMessages += `${responseData.errors[field].join('<br>')}<br>`;
                            });
                        } else {
                            errorMessages = responseData.message;
                        }

                        Swal.fire({
                            title: "Validation Error!",
                            html: errorMessages, // Use HTML property to parse line breaks (<br>)
                            icon: "warning",
                        });

                        if (submitButton) {
                            submitButton.disabled = false;

                            // Optional: Change the text so the user knows it's processing
                            submitButton.innerText = 'Submit';
                        }

                    } else {
                        // Other System Errors (500, 403, etc.)
                        Swal.fire({
                            title: "Error!",
                            text: responseData.message || "An unexpected error occurred.",
                            icon: "error",
                        });

                        if (submitButton) {
                            submitButton.disabled = false;

                            // Optional: Change the text so the user knows it's processing
                            submitButton.innerText = 'Submit';
                        }
                    }
                } catch (e) {
                    Swal.fire({
                        title: "Server Error",
                        text: "The server returned an invalid response.",
                        icon: "error",
                    });
                    console.error("Could not parse JSON response: ", xhr.responseText);

                    if (submitButton) {
                        submitButton.disabled = false;

                        // Optional: Change the text so the user knows it's processing
                        submitButton.innerText = 'Submit';
                    }
                }
            };

            xhr.send(formData);
        });
    </script>
@endsection
