@extends('layouts.backend')
@section('content')
    @php
        if (isset($past_paper)) {
            $actionUrl = route('admin.past-papers.update', ['past_paper' => $past_paper]);
            $method = 'PATCH';
            $scope = 'Update';
        } else {
            $actionUrl = route('admin.pastpapers-uploads-store');
            $method = 'POST';
            $scope = 'Create';
        }
    @endphp

    <style>
        .pp-card{background:#fff;border-radius:12px;box-shadow:0 2px 14px rgba(15,23,42,.06);overflow:hidden;border:1px solid #eef0f4}
        .pp-card-header{padding:16px 22px;background:linear-gradient(135deg,#3b5bdb,#4c6ef5);color:#fff}
        .pp-card-header h4{margin:0;font-weight:600;font-size:17px;color:#fff}
        .pp-body{padding:22px}
        .pp-section{padding-bottom:20px;margin-bottom:20px;border-bottom:1px dashed #e3e6ee}
        .pp-section:last-child{border-bottom:0;margin-bottom:0;padding-bottom:0}
        .pp-section-title{font-weight:600;font-size:14px;color:#3b5bdb;text-transform:uppercase;letter-spacing:.4px;margin-bottom:14px}
        .pp-section-title i{font-size:18px;vertical-align:-2px;margin-right:4px}
        .pp-label{display:block;font-weight:500;font-size:13px;color:#495057;margin-bottom:6px}
        .pp-input{width:100%;height:42px;padding:8px 12px;border:1px solid #dfe3ea;border-radius:8px;background:#fafbfc;font-size:14px;transition:.15s}
        .pp-input:focus{outline:0;border-color:#4c6ef5;background:#fff;box-shadow:0 0 0 3px rgba(76,110,245,.15)}
        .pp-input.is-invalid,.pp-file.is-invalid{border-color:#e03131}
        .pp-error{color:#e03131;font-size:12px;margin-top:5px}

        .pp-file{display:flex;align-items:center;gap:12px;padding:14px;border:2px dashed #d0d7e2;border-radius:10px;background:#f8f9fc;cursor:pointer;transition:.15s;margin:0}
        .pp-file:hover{border-color:#4c6ef5;background:#f1f4ff}
        .pp-file.has-file{border-style:solid;border-color:#37b24d;background:#f1fbf3}
        .pp-file-input{display:none}
        .pp-file-icon{width:42px;height:42px;flex:0 0 42px;border-radius:8px;background:#e7ecff;color:#3b5bdb;display:flex;align-items:center;justify-content:center;font-size:22px}
        .pp-file.has-file .pp-file-icon{background:#d3f9d8;color:#2b8a3e}
        .pp-file-text{display:flex;flex-direction:column;min-width:0}
        .pp-file-name{font-size:14px;color:#343a40;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .pp-file-text small{color:#868e96;font-size:12px}

        .pp-pills{display:flex;flex-wrap:wrap;gap:10px}
        .pp-pill{margin:0;cursor:pointer}
        .pp-pill input{position:absolute;opacity:0;pointer-events:none}
        .pp-pill span{display:inline-block;padding:8px 18px;border:1px solid #dfe3ea;border-radius:50px;font-size:13px;font-weight:500;color:#495057;background:#fff;transition:.15s}
        .pp-pill input:checked + span{background:#4c6ef5;border-color:#4c6ef5;color:#fff;box-shadow:0 2px 8px rgba(76,110,245,.3)}
        .pp-pill:hover span{border-color:#4c6ef5}

        .pp-subcard{margin-top:16px;padding:16px;border-radius:10px;background:#f8f9fc;border:1px solid #eef0f4}
        .pp-subcard-title{font-weight:600;font-size:13px;color:#343a40;margin-bottom:12px}

        .pp-footer{display:flex;justify-content:flex-end;gap:10px;padding:16px 22px;background:#fafbfc;border-top:1px solid #eef0f4}
        .pp-btn{min-width:110px;border-radius:8px;font-weight:500}

        .pp-side-item{display:flex;align-items:center;gap:12px;padding:12px;border:1px solid #eef0f4;border-radius:10px;margin-bottom:12px;text-decoration:none;color:#343a40}
        .pp-side-item:hover{background:#f8f9fc;color:#3b5bdb}
        .pp-side-item img{width:36px}
    </style>

    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Past Papers</h3>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.past-papers.index') }}">Past Papers</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $scope }} Past Paper</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="row">
                    <div class="{{ isset($past_paper) ? 'col-lg-8' : 'col-lg-10' }} col-12">
                        <div class="pp-card">
                            <div class="pp-card-header">
                                <h4>{{ $scope }} Past Paper</h4>
                            </div>
                            @include('layouts.backend.notification')

                            <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method($method)
                                @include('backend.pastpaperupdate.create')
                            </form>
                        </div>
                    </div>

                    @if (isset($past_paper))
                        <div class="col-lg-4 col-12">
                            <div class="pp-card">
                                <div class="pp-card-header"><h4>Current Files</h4></div>
                                <div class="pp-body">
                                    @if (!empty($past_paper->ques_paper))
                                        <a class="pp-side-item" target="_blank" href="{{ asset('uploads/pastpaper/' . $past_paper->ques_paper) }}">
                                            <img src="{{ asset('pdf.png') }}" alt="PDF">
                                            <span><strong>Question Paper</strong><br><small class="text-muted">Click to view</small></span>
                                        </a>
                                    @endif
                                    @if (!empty($past_paper->ans_paper))
                                        <a class="pp-side-item" target="_blank" href="{{ asset('uploads/pastpaper/' . $past_paper->ans_paper) }}">
                                            <img src="{{ asset('pdf.png') }}" alt="PDF">
                                            <span><strong>Mark Scheme</strong><br><small class="text-muted">Click to view</small></span>
                                        </a>
                                    @endif
                                    @if (empty($past_paper->ques_paper) && empty($past_paper->ans_paper))
                                        <p class="text-muted mb-0">No files uploaded yet.</p>
                                    @endif
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
        $(function () {
            // Show chosen file name on the drop box
            $('.pp-file-input').on('change', function () {
                const $box = $(this).closest('.pp-file');
                const file = this.files[0];
                if (file) {
                    $box.addClass('has-file').find('.pp-file-name').text(file.name);
                } else {
                    $box.removeClass('has-file').find('.pp-file-name').text('Click to choose a file');
                }
            });

            // Have solutions? Yes / No
            $('input[name="have_solution"]').on('change', function () {
                $('.solutions-field').toggleClass('d-none', $('#radio_7:checked').length === 0);
            });

            // Video / PDF solution checkboxes
            $('#video_solution_id').on('change', function () {
                $('#video_section').toggleClass('d-none', !this.checked);
            });
            $('#pdf_solution_id').on('change', function () {
                $('#pdf-section').toggleClass('d-none', !this.checked);
            });

            // Video link vs upload
            $('input[name="video_procedure"]').on('change', function () {
                const isLink = $('#video_link_id').is(':checked');
                $('#video_link_section').toggleClass('d-none', !isLink);
                $('#video_uploads_section').toggleClass('d-none', isLink);
            });
        });

        function getSubCategory() {
            const categoryId = $('#category').val();
            if (!categoryId) return;
            const url = "{{ route('admin.ajax.getSubCategory', [':category_id']) }}".replace(':category_id', categoryId);

            $.getJSON(url, function (data) {
                const $sub = $('#subcategory').empty().append('<option value="" selected disabled>Select...</option>');
                $('#resubcategory').empty().append('<option value="" selected disabled>Select...</option>');
                $.each(data, function (i, item) {
                    $sub.append('<option value="' + item.id + '">' + item.subcategory_name + '</option>');
                });
            });
        }

        function getReSubCategory() {
            const subId = $('#subcategory').val();
            if (!subId) return;
            const url = "{{ route('admin.ajax.getReSubCategory', [':subcategory_id']) }}".replace(':subcategory_id', subId);

            $.getJSON(url, function (data) {
                const $re = $('#resubcategory').empty().append('<option value="" selected disabled>Select...</option>');
                $.each(data, function (i, item) {
                    $re.append('<option value="' + item.id + '">' + item.resubcategory_name + '</option>');
                });
            });
        }
    </script>
@endsection