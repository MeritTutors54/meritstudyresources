@extends('layouts.frontend', ['main_title' => 'All Users - MeritStudyResources.co.uk' ])
@section('content')
    <div class="rbt-page-banner-wrapper">
        <!-- Start Banner BG Image  -->
        <div class="rbt-banner-image"></div>
        <!-- End Banner BG Image  -->
    </div>
    <div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Start Dashboard Top  -->
                    <div class="rbt-dashboard-content-wrapper">
                        @include('frontend.dashboard.include.header')
                        <!-- Start Tutor Information  -->

                        <!-- End Tutor Information  -->
                    </div>
                    <!-- End Dashboard Top  -->
                    <div class="row g-5">
                        <div class="col-lg-3">
                            <!-- Start Dashboard Sidebar  -->
                            <div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
                                <div class="inner">
                                    <div class="content-item-content">
                                        @include('frontend.dashboard.include.menu')
                                    </div>
                                </div>
                            </div>
                            <!-- End Dashboard Sidebar  -->
                        </div>
                        <div class="col-lg-9">
                            <!-- Start Instructor Profile  -->
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">
                                    @include('layouts.frontend.notification')
                                    <div class="section-title d-flex" style="border-bottom: 2px solid #e6e3f14f">
                                        <h4 class="rbt-title-style-3" style="border: none">All Users
                                            ({{ count($users) }})</h4>
                                        <a class="rbt-btn btn-sm btn-border hover-icon-reverse ms-auto"
                                           href="{{ route('users.create') }}">
                                            <span class="icon-reverse-wrapper">
                                                <span class="btn-text">Create New User</span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="rbt-dashboard-table table-responsive mobile-table-750">
                                        <table class="rbt-table table table-borderless">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Team Name</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @if(!empty($users))
                                                @foreach($users as $user)
                                                    <tr id="uid-{{ $user->id }}">
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->getCurrentTeam->name }}</td>
                                                        <td>
                                                            <button
                                                                data-id="{{ $user->id }}"
                                                                data-route="{{ route('users.destroy', [$user]) }}"
                                                                class="dlt-button btn btn-danger">
                                                                Delete
                                                            </button>
                                                            <a class="btn btn-primary"
                                                               href="{{ route('user.permission', [$user]) }}">
                                                                Show
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <!-- End Instructor Profile  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.dlt-button').on('click', function () {
            const uid = $(this).data('id');
            const route = $(this).data('route');

            Swal.fire({
                icon: "question",
                title: "Do you want delete the user?",
                showDenyButton: true,
                confirmButtonText: "Delete",
                denyButtonText: `Cancel`,
                width: 500,
                customClass: 'universal-modal'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: route,   // Laravel DELETE route
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            if (response.status === 200) {
                                Swal.fire({
                                    icon: "success",
                                    title: "User has been removed.",
                                    width: 500,
                                    customClass: 'universal-modal'
                                });

                                // Optionally remove row from table
                                $('#uid-' + uid).remove();
                            }
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    });
                }
            });
        })
    </script>
@endsection
