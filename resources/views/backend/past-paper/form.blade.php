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

            <!-- Modal Overlay and Box -->
            <div id="alertOverlay" class="alert-overlay d-none" role="dialog" aria-modal="true"
                 aria-labelledby="alertTitle">
                <div class="alert-box">
                    <h3 id="alertTitle" class="alert-title">Notice</h3>
                    <p class="alert-message" id="alert-overlay-message"></p>
                    <button id="alertCloseBtn" class="alert-btn">Okay</button>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="box">
                            <div class="box-header with-border custom-blue-bg">
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
                                                        <img width="50" src="{{ asset('pdf.png') }}" alt=""/>
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
                                                        <img width="50" src="{{ asset('pdf.png') }}" alt=""/>
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
        $('#video_solution_id').change(function () {
            if ($(this).prop('checked')) {
                $('#video_section').removeClass('d-none');
            } else {
                $('#video_section').addClass('d-none');
            }
        });

        $('#pdf_solution_id').change(function () {
            if ($(this).prop('checked')) {
                $('#pdf-section').removeClass('d-none');
                $('#pdf_solution_section').show();
            } else {
                $('#pdf-section').addClass('d-none');
                $('#pdf_solution_section').hide();
            }
        });

        $('#video_link_id').on('change', function () {
            if ($(this).prop('checked')) {
                $('#video_link_section').show();
                $('#video_uploads_section').hide();
            } else {
                $('#pdf_solution_section').hide();
                $('#video_uploads_section').show();
            }
        });

        $('#video_uploads_id').on('change', function () {
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
                    success: function (data) {

                        subCategoryTag.empty();
                        subCategoryTag.append('<option selected disabled>Select</option>');
                        $.each(data, function (index, districtObj) {
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
                    success: function (data) {
                        resubcategoryTag.empty();
                        resubcategoryTag.append('<option selected disabled>Select</option>');
                        $.each(data, function (index, districtObj) {
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
        // Have any solution?
        const yesRadio = document.getElementById('radio_7');
        const noRadio = document.getElementById('radio_9');
        const solutionsField = document.querySelector('.solutions-field');

        // Add event listeners to handle changes in radio button selection
        yesRadio.addEventListener('change', function () {
            if (this.checked) {
                solutionsField.style.display = 'block'; // Show the Solutions field
            }
        });

        noRadio.addEventListener('change', function () {
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
        // Global scope variables for AJAX tracking
        let currentXhr = null;
        const overlay = $("#alertOverlay");
        const overlayMessage = $("#alert-overlay-message");

        $('#pastPaperForm').on('submit', function (e) {
            e.preventDefault();

            // Reset error messages and progress UI on submit attempt
            $(".form-control-feedback").addClass('d-none').text('');

            let $form = $(this);
            let formData = new FormData(this);

            currentXhr = $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from processing data
                contentType: false, // Prevent jQuery from setting header

                // Track Upload Progress
                xhr: function () {
                    let xhr = new window.XMLHttpRequest();

                    if (xhr.upload) {
                        let startTime = new Date().getTime();

                        xhr.upload.addEventListener('progress', function (e) {
                            if (e.lengthComputable) {
                                let total = e.total;
                                let loaded = e.loaded;
                                let percent = Math.round((loaded / total) * 100);

                                // Calculate Time Remaining
                                let elapsedTime = (new Date().getTime() - startTime) / 1000;
                                let uploadSpeed = loaded / elapsedTime; // Bytes per sec
                                let remainingBytes = total - loaded;
                                let secondsLeft = Math.round(remainingBytes / uploadSpeed);

                                // Format time left text
                                let timeLeftText = secondsLeft > 0 ? `${secondsLeft}s remaining` : 'Completing...';

                                // Update each upload component UI based on file inputs present
                                $('[data-uploader]').each(function () {
                                    let $uploader = $(this);
                                    let $fileInput = $uploader.find('[data-input]');

                                    // Only animate progress bars for components that have a file selected
                                    if ($fileInput[0].files.length > 0) {
                                        let $progressFill = $uploader.find('[data-fill]');

                                        // Update width & text
                                        $progressFill.css({
                                            'width': percent + '%',
                                            'background-color': '#28a745' // Green color while uploading & at 100%
                                        }).text(percent + '%');

                                        $uploader.find('[data-total]').text(formatBytes(total));
                                        $uploader.find('[data-uploaded]').text(formatBytes(loaded));
                                        $uploader.find('[data-remaining]').text(formatBytes(remainingBytes));
                                        $uploader.find('[data-percent]').text(percent + '%');
                                        $uploader.find('[data-time]').text(timeLeftText);
                                    }
                                });
                            }
                        }, false);
                    }
                    return xhr;
                },

                success: function (response) {
                    // Success alert on successful upload and storage
                    overlay.removeClass('d-none');
                    overlayMessage.html(response.message || 'Files uploaded and stored successfully!');

                    // Reset form and UI elements
                    $form[0].reset();
                    $('[data-uploader]').each(function () {
                        resetFileUI($(this));
                    });
                },

                error: function (xhr, status, error) {
                    // Validation Error Handling (422 Unprocessable Entity)
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function (field, messages) {
                            let $errorContainer = $('#error-' + field);
                            if ($errorContainer.length) {
                                $errorContainer.text(messages[0]).removeClass('d-none');
                            }
                        });
                    } else if (status !== 'abort') {
                        // Fallback for generic errors (500, network issues, etc.)
                        overlay.removeClass('d-none');
                        overlayMessage.html(xhr.responseJSON?.message || 'An error occurred during upload. Please try again.');
                    }

                    // Reset Progress Bar state on Error
                    resetProgressDisplay();
                }
            });
        });

        // Helper function to format Bytes to Human Readable sizes
        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        // Helper to reset progress bars
        function resetProgressDisplay() {
            $('[data-uploader]').each(function () {
                let $uploader = $(this);
                let $progressFill = $uploader.find('[data-fill]');

                $progressFill.css({
                    'width': '0%',
                    'background-color': '' // Reset color back to default CSS value
                }).text('0%');

                $uploader.find('[data-total]').text('0 B');
                $uploader.find('[data-uploaded]').text('0 B');
                $uploader.find('[data-remaining]').text('0 B');
                $uploader.find('[data-percent]').text('0%');
                $uploader.find('[data-time]').text('--');
            });
        }

        // Shared helper function for clearing uploader UI
        function resetFileUI($uploader) {
            let $fileInput = $uploader.find('[data-input]');
            $fileInput.val('');

            // Revoke any Blob objects attached
            let oldUrl = $uploader.data('blobUrl');
            if (oldUrl) {
                URL.revokeObjectURL(oldUrl);
                $uploader.removeData('blobUrl');
            }

            $uploader.find('[data-name]').text('No file chosen');
            $uploader.find('[data-preview]').prop('disabled', true);
            $uploader.find('[data-delete]').prop('disabled', true);
            $uploader.find('[data-status]').text('');

            resetProgressDisplay();
        }

        $(document).ready(function () {
            // Component interactions setup
            $('[data-uploader]').each(function () {
                const $uploader = $(this);
                const $fileInput = $uploader.find('[data-input]');
                const $fileNameDisplay = $uploader.find('[data-name]');
                const $previewBtn = $uploader.find('[data-preview]');
                const $deleteBtn = $uploader.find('[data-delete]');
                const $statusDisplay = $uploader.find('[data-status]');

                // Handle File Selection Change
                $fileInput.on('change', function (e) {
                    const file = e.target.files[0];
                    let fileBlobUrl = $uploader.data('blobUrl');

                    if (fileBlobUrl) {
                        URL.revokeObjectURL(fileBlobUrl);
                        $uploader.removeData('blobUrl');
                    }

                    if (file) {
                        fileBlobUrl = URL.createObjectURL(file);
                        $uploader.data('blobUrl', fileBlobUrl);

                        $fileNameDisplay.text(file.name);
                        $previewBtn.prop('disabled', false);
                        $deleteBtn.prop('disabled', false);
                        $statusDisplay.text(`Selected: ${file.name}`);
                        $uploader.find('.form-control-feedback').addClass('d-none').text('');
                    } else {
                        resetFileUI($uploader);
                    }
                });

                // Handle Preview Button
                $previewBtn.on('click', function () {
                    const file = $fileInput[0].files[0];
                    const fileBlobUrl = $uploader.data('blobUrl');

                    if (file && fileBlobUrl) {
                        $('#viewer').attr('src', fileBlobUrl);
                        $('#previewName').text(file.name);
                        $('#previewModal').modal('show');
                    }
                });

                // Handle Delete Button
                $deleteBtn.on('click', function () {
                    resetFileUI($uploader);
                });
            });

            // Handle Modal Close
            $(document).on('click', '[data-close]', function () {
                $('#previewModal').removeClass('show').attr('aria-hidden', 'true');
                $('#viewer').attr('src', '');
            });

            $("#alertCloseBtn").on('click', function () {
                if (overlay) {
                    overlay.addClass('d-none');
                }
            })

        });
    </script>
@endsection
