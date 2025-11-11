@extends('layouts.frontend', ['main_title' => 'User Permissions - MeritStudyResources.co.uk' ])
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
                        <!-- Start Tutor Information  -->
                        @include('frontend.dashboard.include.header')
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
                            @include('layouts.frontend.notification')
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">
                                    <div class="section-title d-flex">
                                        <h4 class="rbt-title-style-3">User Permissions</h4>
                                        <a class="rbt-btn btn-sm btn-border hover-icon-reverse ms-auto"
                                           href="{{ route('users.index') }}">
                                            <span class="icon-reverse-wrapper">
                                                <span class="btn-text">Back</span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </span>
                                        </a>
                                    </div>
                                    <div>
                                        <div>
                                            <!-- Start Profile Row  -->
                                            <form action="{{ route('user.permission.update', [$user]) }}"
                                                  class="rbt-profile-row rbt-default-form row row--15" method="POST">
                                                @csrf

                                                @if(!empty($permissions))
                                                    @foreach($permissions as $title => $subPermission)
                                                        <div class="col-md-3 mb-35">
                                                            <p class="text-decoration-underline">
                                                                <strong>
                                                                    {{ ucfirst($title) }}
                                                                </strong>
                                                            </p>
                                                            @foreach($subPermission as $k => $permission)
                                                                <div class="mt-3 permission-field">
                                                                    <input type="checkbox"
                                                                           id="md_checkbox_{{ $title }}_{{ $k }}"
                                                                           {{ in_array($permission, $modelHasPermission) ? 'checked' : '' }}
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

                                                <div class="mt--35">
                                                    <button class="rbt-btn">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                            <!-- End Profile Row  -->
                                        </div>
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
