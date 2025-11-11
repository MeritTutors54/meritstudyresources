@extends('layouts.frontend', ['main_title' => 'Create User - MeritStudyResources.co.uk' ])
@section('page-seo')
    <meta name="description" content="{{ $defaultSEO->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $defaultSEO->meta_keywords ?? '' }}">
    <meta name="author" content="{{ $defaultSEO->meta_author ?? '' }}">
@endsection
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
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">
                                    <div class="section-title d-flex">
                                        <h4 class="rbt-title-style-3">Create New User</h4>
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
                                            <form action="{{ route('users.store') }}"
                                                  class="rbt-profile-row rbt-default-form row row--15" method="POST">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="rbt-form-group">
                                                        @csrf
                                                        <label for="firstname">Name</label>
                                                        <input id="firstname"
                                                               placeholder="Enter name"
                                                               name="name" type="text" value="">
                                                        @error('name')
                                                        <div class="form-control-feedback text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="phonenumber">Email</label>
                                                        <input id="phonenumber"
                                                               placeholder="Enter mail"
                                                               name="email" type="email" value="">
                                                        @error('email')
                                                        <div class="form-control-feedback text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="password">Password</label>
                                                        <input id="password"
                                                               placeholder="Enter Password"
                                                               name="password" type="text" value="">
                                                        @error('password')
                                                        <div class="form-control-feedback text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 mt--20">
                                                    <div class="rbt-form-group">
                                                        <button type="submit" class="rbt-btn btn-gradient" href="#">
                                                            Create User
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- End Profile Row  -->
                                        </div>

                                        <div class="tab-pane fade" id="password" role="tabpanel"
                                             aria-labelledby="password-tab">
                                            <!-- Start Profile Row  -->
                                            <form action="{{ url('profile-password-update') }}"
                                                  class="rbt-profile-row rbt-default-form row row--15" method="POST">
                                                <div class="col-12">
                                                    <div class="rbt-form-group">
                                                        @csrf
                                                        <label for="currentpassword">Current Password</label>
                                                        <input id="currentpassword" type="password"
                                                               placeholder="Current Password" name="old_password">
                                                        @error('old_password')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="newpassword">New Password</label>
                                                        <input id="newpassword" type="password"
                                                               placeholder="New Password" name="password">
                                                        @error('password')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="retypenewpassword">Re-type New Password</label>
                                                        <input id="retypenewpassword" type="password"
                                                               placeholder="Re-type New Password"
                                                               name="password_confirmation">
                                                        @error('confirmed')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 mt--10">
                                                    <div class="rbt-form-group">
                                                        <button type="submit" class="rbt-btn btn-gradient" href="#">
                                                            Update Password
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- End Profile Row  -->
                                        </div>

                                        <div class="tab-pane fade" id="social" role="tabpanel"
                                             aria-labelledby="social-tab">
                                            <!-- Start Profile Row  -->
                                            <form action="#" class="rbt-profile-row rbt-default-form row row--15">


                                                <div class="col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="linkedin"><i class="feather-linkedin"></i>
                                                            Linkedin</label>
                                                        <input id="linkedin" type="text"
                                                               placeholder="https://linkedin.com/">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="website"><i class="feather-globe"></i>
                                                            Website</label>
                                                        <input id="website" type="text"
                                                               placeholder="https://website.com/">
                                                    </div>
                                                </div>

                                                <div class="col-12 mt--10">
                                                    <div class="rbt-form-group">
                                                        <a class="rbt-btn btn-gradient" href="#">Update Profile</a>
                                                    </div>
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
