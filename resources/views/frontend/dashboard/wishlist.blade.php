@extends('layouts.frontend')
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
                                    <h4 class="rbt-title-style-3">Wishlist</h4>
                                </div>
                                <div class="row g-5">
                                    <!-- Start Single Course  -->
                                    {{-- <div class="col-lg-4 col-md-6 col-12">
                                        <div class="rbt-card variation-01 rbt-hover">
                                            <div class="rbt-card-img">
                                                <a href="course-details.html">
                                                    <img src="assets/images/course/course-online-01.jpg"
                                                        alt="Card image">
                                                </a>
                                            </div>
                                            <div class="rbt-card-body">
                                                <div class="rbt-card-top">
                                                    <div class="rbt-review">
                                                        <div class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <span class="rating-count"> (15 Reviews)</span>
                                                    </div>
                                                    <div class="rbt-bookmark-btn">
                                                        <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                                                class="feather-bookmark"></i></a>
                                                    </div>
                                                </div>
                                                <h4 class="rbt-card-title"><a href="course-details.html">React Front
                                                        To Back</a>
                                                </h4>
                                                <ul class="rbt-meta">
                                                    <li><i class="feather-book"></i>20 Lessons</li>
                                                    <li><i class="feather-users"></i>40 Students</li>
                                                </ul>

                                                <div class="rbt-card-bottom">
                                                    <div class="rbt-price">
                                                        <span class="current-price">$60</span>
                                                        <span class="off-price">$120</span>
                                                    </div>
                                                    <a class="rbt-btn-link" href="course-details.html">Learn
                                                        More<i class="feather-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                  
                                    <!-- End Single Course  -->
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