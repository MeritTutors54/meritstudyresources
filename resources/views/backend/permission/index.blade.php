@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h3 class="page-title">All Permissions</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="mdi mdi-home-outline"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                @include('layouts.backend.notification')
                <div class="row">
                    <div class="col-3">
                        <div class="box">
                            <div class="box-header with-border">
                                <div class="d-flex align-items-center">
                                    <h3 class="box-title">Roles</h3>
                                </div>
                            </div>
                            <div class="box-body">
                                <p>Left side of <code> ::</code> that sign mean the <b>role name</b> and right side is
                                    <b>guard name</b>.</p>
                                <div class="list-group my-3 mx-1">
                                    @if(!empty($roles))
                                        @foreach($roles as $role)
                                            <a href="#{{ $role->name }}::{{ $role->guard_name }}"
                                               data-id="{{ $role->id }}"
                                               class="role-list list-group-item list-group-item-action">
                                                {{ $role->name }} :: {{ $role->guard_name }}
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <form action="{{ route('admin.permission.sync') }}" id="permission-form" method="post">
                            @csrf
                            <input type="hidden" name="role_id" id="role_id" value="">
                            <div id="permission-carrier" class="box d-none">
                                <div class="box-header with-border">
                                    <div class="d-flex align-items-center">
                                        <h3 class="box-title">Permission</h3>
                                        <button type="submit"
                                                class="permission-save ms-auto waves-effect waves-light btn btn-rounded btn-primary mb-5">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <p>Left side of <code> ::</code> that sign mean the <b>role name</b> and right side
                                        is
                                        <b>guard name</b>.</p>
                                    <div class="row">
                                        @if(!empty($permissions))
                                            @foreach($permissions as $title => $subPermission)
                                                <div class="col-md-3 mb-35">
                                                    <h5 class="text-decoration-underline">{{ ucfirst($title) }}</h5>
                                                    @foreach($subPermission as $k => $permission)
                                                        <div class="mt-3 permission-field">
                                                            <input type="checkbox" id="md_checkbox_{{ $title }}_{{ $k }}"
                                                                   name="permissions[]"
                                                                   value="{{ $permission }}"
                                                                   class="filled-in chk-col-primary">
                                                            <label
                                                                for="md_checkbox_{{ $title }}_{{ $k }}"> {{ $permission }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit"
                                            class="permission-save ms-auto waves-effect waves-light btn btn-rounded btn-primary mb-5">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const permissionCarrier = $('#permission-carrier');
        const hiddenRole = $("#role_id");
        const form = $("#permission-form");
        const list = $(".role-list");

        list.on("click", function () {
            let value = $(this).data('id');
            list.removeClass('active text-white');
            $(this).addClass('active text-white');
            hiddenRole.val(value);
            getPermissions(value);
        })

        function getPermissions(role_id) {
            $.ajax({
                url: "{{  url('/admin/get-permissions') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    role_id: role_id,

                },
                dataType: "json",
                success: function (data) {
                    permissionCarrier.removeClass('d-none')
                    console.log(data);
                    if (data.permissions !== null) {
                        $('.permission-field :input').each(function () {
                            let input = $(this);
                            if (data.permissions.includes(input.val())) {
                                input.prop('checked', true);
                            } else {
                                input.prop('checked', false);
                            }
                        });
                    }
                }
            });
        }

        form.on('submit', function (e) {
            e.preventDefault();
            const formDataArray = $(this).serializeArray()

            const formData = {};

            // Handle array fields (like permissions[])
            $.each(formDataArray, function(i, field) {
                // Handle array fields (like permissions[])
                if (field.name.indexOf('[]') !== -1) {
                    const name = field.name.replace('[]', '');
                    if (!formData[name]) {
                        formData[name] = [];
                    }
                    formData[name].push(field.value);
                } else {
                    formData[field.name] = field.value;
                }
            });

            $.ajax({
                url: "{{ url('/admin/sync-permissions') }}",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.code === 200) {
                        Swal.fire({
                            title: "Update Conformation",
                            text: "Permission is update successfully",
                            icon: "success"
                        });
                    }
                },
                error: function (err) {
                    if (err.status === 403) {
                        Swal.fire({
                            title: "Update Failed",
                            text: "You does not have the permission to update",
                            icon: "error"
                        });
                    }
                }
            });

        })

    </script>
@endsection
