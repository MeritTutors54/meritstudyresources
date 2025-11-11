@extends('layouts.frontend', ['main_title' => 'Edit Profile - MeritStudyResources.co.uk' ])
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
                            @include('layouts.frontend.notification')
                            <!-- Start Instructor Profile  -->
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Settings</h4>
                                    </div>

                                    <div class="advance-tab-button mb--30">
                                        <ul class="nav nav-tabs tab-button-style-2 justify-content-start"
                                            id="settinsTab-4" role="tablist">
                                            <li role="presentation">
                                                <a href="#" class="tab-button {{ old('tab', $tab ?? "") == 1 ? 'active' : '' }}" id="profile-tab"
                                                   data-bs-toggle="tab" data-bs-target="#profile" role="tab"
                                                   aria-controls="profile" aria-selected="true">
                                                    <span class="title">Profile</span>
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#" class="tab-button {{ old('tab', $tab ?? "") == 2 ? 'active' : '' }}" id="password-tab" data-bs-toggle="tab"
                                                   data-bs-target="#password" role="tab" aria-controls="password"
                                                   aria-selected="false">
                                                    <span class="title">Password</span>
                                                </a>
                                            </li>
                                            @if(Auth::user()->type == \App\Enums\UserType::SCHOOL->value)
                                                <li role="presentation">
                                                    <a href="#" class="tab-button {{ old('tab', $tab ?? "") == 3 ? 'active' : '' }}" id="team-tab" data-bs-toggle="tab"
                                                       data-bs-target="#team" role="tab" aria-controls="team"
                                                       aria-selected="false">
                                                        <span class="title">Team</span>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade {{ old('tab', $tab ?? "") == 1 ? 'active show' : '' }}" id="profile" role="tabpanel"
                                             aria-labelledby="profile-tab">

                                            <!-- Start Profile Row  -->
                                            <form action="{{ route('user.profile.update') }}"
                                                  class="rbt-profile-row rbt-default-form row row--15" method="POST">
                                                @csrf

                                                <input type="hidden" name="tab" value="1">

                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="name">Name</label>
                                                        <input id="name" name="name" type="text"
                                                               value="{{ Auth::user()->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="email">Email</label>
                                                        <input readonly id="email" name="email" type="email"
                                                               value="{{ Auth::user()->email }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="phone">Phone Number</label>
                                                        <input id="phone" type="text" name="phone"
                                                               value="{{ Auth::user()->phone }}">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="address">Address</label>
                                                        <textarea id="address" name="address" cols="20"
                                                                  rows="5">{{ Auth::user()->address }} </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="post_code">Post Code</label>
                                                        <input id="post_code" type="text" name="post_code"
                                                               value="{{ Auth::user()->post_code }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="bio">Bio</label>
                                                        <textarea id="bio" name="bio" cols="20"
                                                                  rows="5">{{ Auth::user()->bio }} </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt--20">
                                                    <div class="rbt-form-group">
                                                        <button type="submit" class="rbt-btn btn-gradient" href="#">
                                                            Update Info
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- End Profile Row  -->
                                        </div>

                                        <div class="tab-pane fade {{ old('tab', $tab ?? "") == 2 ? 'active show' : '' }}" id="password" role="tabpanel"
                                             aria-labelledby="password-tab">
                                            <!-- Start Profile Row  -->
                                            <form action="{{ route('user.password.update') }}"
                                                  class="rbt-profile-row rbt-default-form row row--15" method="POST">
                                                @csrf


                                                <input type="hidden" name="tab" value="2">

                                                <div class="col-12">
                                                    <div class="rbt-form-group">
                                                        <label for="old_password">Current Password</label>
                                                        <input id="old_password" type="password" class="mb-0"
                                                               placeholder="Current Password" name="old_password">
                                                        @error('old_password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="rbt-form-group mt-3">
                                                        <label for="password">New Password</label>
                                                        <input id="password" type="password" class="mb-0"
                                                               placeholder="New Password" name="password">
                                                        @error('password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="rbt-form-group mt-3">
                                                        <label for="password_confirmation">Re-type New Password</label>
                                                        <input id="password_confirmation" type="password"
                                                               placeholder="Re-type New Password" class="mb-0"
                                                               name="password_confirmation">
                                                        @error('password_confirmation')
                                                        <div class="text-danger">{{ $message }}</div>
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

                                        <div class="tab-pane fade {{ old('tab', $tab ?? "") == 3 ? 'active show' : '' }}" id="team" role="tabpanel"
                                             aria-labelledby="team-tab">
                                            <!-- Start Profile Row  -->
                                            <form action="{{ route('user.update.team') }}" method="post"
                                                  class="rbt-profile-row rbt-default-form row row--15">
                                                @csrf

                                                <input type="hidden" name="tab" value="3">

                                                <div class="col-6">
                                                    <div class="rbt-form-group">
                                                        <label for="website">
                                                            Update Team Name
                                                        </label>
                                                        <input
                                                            name="team_name"
                                                            value="{{ $team->name ?? '' }}"
                                                            placeholder="Update team name here"
                                                            type="text"
                                                        >
                                                    </div>
                                                </div>

                                                <div class="col-12 mt--10">
                                                    <button class="rbt-btn btn-sm">Update Profile</button>
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
