@extends('layouts.frontend', ['main_title' => 'Users - MeritStudyResources.co.uk' ])
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
                                        {{--
                                    <div class="rbt-default-sidebar-wrapper">
                                        <div class="section-title mb--20">
                                            <h6 class="rbt-title-style-2">Welcome, Jone Due</h6>
                                        </div>
                                        <nav class="mainmenu-nav">
                                            <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                                                <li><a href="instructor-dashboard.html"><i
                                                            class="feather-home"></i><span>Dashboard</span></a></li>
                                                <li><a href="instructor-profile.html"><i
                                                            class="feather-user"></i><span>My Profile</span></a>
                                                </li>
                                                <li><a href="instructor-enrolled-courses.html"><i
                                                            class="feather-book-open"></i><span>Enrolled
                                                            Courses</span></a></li>
                                                <li><a href="instructor-wishlist.html"><i
                                                            class="feather-bookmark"></i><span>Wishlist</span></a>
                                                </li>
                                                <li><a href="instructor-reviews.html"><i
                                                            class="feather-star"></i><span>Reviews</span></a></li>
                                                <li><a href="instructor-my-quiz-attempts.html"><i
                                                            class="feather-help-circle"></i><span>My Quiz
                                                            Attempts</span></a></li>
                                                <li><a href="instructor-order-history.html"><i
                                                            class="feather-shopping-bag"></i><span>Order
                                                            History</span></a></li>
                                            </ul>
                                        </nav>

                                        <div class="section-title mt--40 mb--20">
                                            <h6 class="rbt-title-style-2">Instructor</h6>
                                        </div>

                                        <nav class="mainmenu-nav">
                                            <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                                                <li><a href="instructor-course.html"><i
                                                            class="feather-monitor"></i><span>My Courses</span></a>
                                                </li>
                                                <li><a href="instructor-announcements.html"><i
                                                            class="feather-volume-2"></i><span>Announcements</span></a>
                                                </li>
                                                <li><a href="instructor-quiz-attempts.html"><i
                                                            class="feather-message-square"></i><span>Quiz
                                                            Attempts</span></a></li>
                                                <li><a href="instructor-assignments.html"><i
                                                            class="feather-list"></i><span>Assignments</span></a>
                                                </li>
                                            </ul>
                                        </nav>

                                        <div class="section-title mt--40 mb--20">
                                            <h6 class="rbt-title-style-2">User</h6>
                                        </div>

                                        <nav class="mainmenu-nav">
                                            <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                                                <li><a href="instructor-settings.html"><i
                                                            class="feather-settings"></i><span>Settings</span></a>
                                                </li>
                                                <li><a href="index.html"><i
                                                            class="feather-log-out"></i><span>Logout</span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                      --}}
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
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3">My Profile</h4>
                                </div>
                                <!-- Start Profile Row  -->
                                <div class="rbt-profile-row row row--15">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="rbt-profile-content b2">Registration Date</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">

                                        <div class="rbt-profile-content b2">{{ Auth::user()->created_at->format('F j, Y g:i a'); }}</div>
                                    </div>
                                </div>
                                <!-- End Profile Row  -->

                                <!-- Start Profile Row  -->
                                <div class="rbt-profile-row row row--15 mt--15">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="rbt-profile-content b2"> Name</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="rbt-profile-content b2">{{ Auth::user()->name }}</div>
                                    </div>
                                </div>

                                <!-- End Profile Row  -->

                                <!-- Start Profile Row  -->
                                <div class="rbt-profile-row row row--15 mt--15">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="rbt-profile-content b2">Email</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="rbt-profile-content b2">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                                <!-- End Profile Row  -->

                                <!-- Start Profile Row  -->
                                <div class="rbt-profile-row row row--15 mt--15">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="rbt-profile-content b2">Phone Number</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="rbt-profile-content b2">{{ Auth::user()->phone }}</div>
                                    </div>
                                </div>
                                <!-- End Profile Row  -->

                                <!-- Start Profile Row  -->
                                <div class="rbt-profile-row row row--15 mt--15">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="rbt-profile-content b2">Address</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="rbt-profile-content b2">{{ Auth::user()->address }}</div>
                                    </div>
                                </div>
                                <!-- End Profile Row  -->

                                <!-- Start Profile Row  -->
                                <div class="rbt-profile-row row row--15 mt--15">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="rbt-profile-content b2">Post Code</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="rbt-profile-content b2">{{ Auth::user()->post_code }}</div>
                                    </div>
                                </div>
                                <div class="rbt-profile-row row row--15 mt--15">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="rbt-profile-content b2">Bio</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="rbt-profile-content b2">{{ Auth::user()->bio }}</div>
                                    </div>
                                </div>
                                <!-- End Profile Row  -->
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
