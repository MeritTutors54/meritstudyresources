@extends('layouts.backend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container .select2-selection--single {
            height: 35px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px;
        }

        .select2-container--default .select2-selection--single {
            padding: 6px 0 0 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            height: 22px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            color: #ffffff !important;
        }
    </style>

    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <?php
            if (isset($resource)) {
                $actionUrl = route('admin.board-resources.update', ['board_resource' => $resource]);
                $method = 'PATCH';
                $scope = 'Update';
            } else {
                $actionUrl = route('admin.board-resources.store');
                $method = 'POST';
                $scope = 'Create';
            }
            ?>

            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Board Resource</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.board-resources.index') }}">All Board Resources</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Board
                                        Resource</li>
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
                    <div class="col-lg-12 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="box-title m-0">{{ $scope }} board resource</h4>
                                </div>
                            </div>
                            @include('layouts.backend.notification')

                            <!-- /.box-header -->
                            <form id="pastPaperForm" action="{{ $actionUrl }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method($method)
                                @include('backend.resource._field')
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#subcategory').select2({
                placeholder: "Select...",
                allowClear: true,
                width: '100%'
            });
        });

        $(".fileDeleteButton").on("click", function() {
            const $btn = $(this);
            const url = $btn.data('url');

            // Hide the original delete button
            $btn.hide();

            // Create the Confirm and Cancel buttons group
            const $confirmGroup = $(`
                <div class="confirm-cancel-group d-inline-block" style="margin-top: ${$btn.css('margin-top')}">
                    <button type="button" class="btn btn-danger btn-sm confirm-delete-btn">Confirm</button>
                    <button type="button" class="btn btn-secondary btn-sm cancel-delete-btn">Cancel</button>
                </div>
            `);

            $btn.after($confirmGroup);

            // 2. Handle Cancel action
            $confirmGroup.find('.cancel-delete-btn').on('click', function() {
                $confirmGroup
            .remove(); // Remove confirm/cancel buttons$btn.show();            // Show original delete button again
                $btn.show(); // Show original delete button again
            });

            // 3. Handle Confirm action (Directly hits the route via a dynamic form)
            $confirmGroup.find('.confirm-delete-btn').on('click', function() {
                // Create a dynamic form for Laravel DELETE request
                let $form = $('<form>', {
                    'method': 'POST',
                    'action': url
                });

                // Add CSRF token
                let csrfToken = '{{ csrf_token() }}';
                if (csrfToken) {
                    $form.append($('<input>', {
                        'type': 'hidden',
                        'name': '_token',
                        'value': csrfToken
                    }));
                }

                // Add method spoofing for DELETE (standard in Laravel)
                $form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_method',
                    'value': 'DELETE'
                }));

                // Append to body and submit
                $('body').append($form);
                $form.submit();
            });
        });

    </script>
    <script>
        $('#resource_type').on('change', function() {
            $('#category').prop('selectedIndex', 0);

            $('#subcategory')
                .html('<option selected disabled>Select...</option>')
                .trigger('change');
            $('#resubcategory')
                .html('<option selected disabled>Select...</option>')
                .trigger('change');
            $('#parent_id')
                .html('<option selected disabled>Select...</option>')
                .trigger('change');
        });

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
            }
        }

        function getParents() {
            const resubcategoryId = $("#resubcategory").val();
            const resourceType = $("#resource_type").val();
            const parentTag = $('#parent_id');


            if (resubcategoryId) {
                const route = "{{ route('admin.ajax.getParents', [':id', ':type']) }}";
                const url = route.replace(':id', resubcategoryId).replace(':type', resourceType);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        parentTag.empty();
                        parentTag.append('<option selected disabled>Select</option>');
                        $.each(data, function(index, districtObj) {
                            parentTag.append('<option value="' + districtObj.id + '">' +
                                districtObj.name + '</option>');
                        });
                    }
                });
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            const fileUploadSection = $("#file-upload-section");
            const parentId = $("#parent_id");
            const isGroup = $("#is_group");
            const fileOrientation = $("#file_orientation");
            const uploadGroupsContainer = $("#upload-groups-container");
            const allowFiles = $("#allow_files");
            const allowFilesSection = $("#allow_files_section");
            const fileOrientationSection = $("#file_orientation_section");
            const isProSelect = $(".is_pro_select");
            const difficultySelect = $(".difficulty-select");

            allowFiles.on("change", function() {
                if ($(this).val() === "1") {
                    fileUploadSection.removeClass("d-none");
                    fileOrientationSection.removeClass("d-none");
                    isProSelect.prop('disabled', false);
                    difficultySelect.prop('disabled', false);
                } else {
                    fileUploadSection.addClass("d-none");
                    fileOrientationSection.addClass("d-none");
                    isProSelect.prop('disabled', true);
                    difficultySelect.prop('disabled', true);
                }
            });

            // Function to toggle difficulty visibility based on file orientation
            function updateDifficultyVisibility() {
                if (fileOrientation.val() === "2") {
                    difficultySelect.prop('disabled', false);
                    $(".difficulty-section").removeClass('d-none');
                } else {
                    difficultySelect.prop('disabled', true);
                    $(".difficulty-section").addClass('d-none');
                }
            }


            // Handle change on 'file_orientation' dropdown
            fileOrientation.on("change", function() {
                updateDifficultyVisibility();
            });

            // Run immediately on page load to match current state
            updateDifficultyVisibility();

            let uploadIndex = 1; // 0 already used for the first group

            // Add new file row dynamically
            $('#addFileBtn').on('click', function() {
                const templateHtml = $('#upload-group-template').html();
                const $clone = $(templateHtml);

                // Set data-index and update name attributes
                $clone.attr('data-index', uploadIndex);
                $clone.find('[name]').each(function() {
                    const name = $(this).attr('name').replace('__INDEX__', uploadIndex);
                    $(this).attr('name', name);
                });

                // Append the clone to the container
                uploadGroupsContainer.append($clone);

                // Ensure the newly added row respects the current difficulty visibility rule
                updateDifficultyVisibility();

                uploadIndex++;
            });

            // Handle removal of dynamically added groups via event delegation
            uploadGroupsContainer.on('click', '.remove-upload-group', function() {
                $(this).closest('.upload-group-wrapper').remove();
            });
        });
    </script>
@endsection
