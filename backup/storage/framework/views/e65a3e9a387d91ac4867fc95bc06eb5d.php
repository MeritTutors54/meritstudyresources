
<?php $__env->startSection('content'); ?>
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
                    <?php echo $__env->make('frontend.dashboard.include.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!-- End Tutor Information  -->
                </div>
                <!-- End Dashboard Top  -->
                <div class="row g-5">
                    <div class="col-lg-3">
                        <!-- Start Dashboard Sidebar  -->
                        <div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
                            <div class="inner">
                                <div class="content-item-content">
                                        
                                    <?php echo $__env->make('frontend.dashboard.include.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                                    <h4 class="rbt-title-style-3">Settings</h4>
                                </div>

                                <div class="advance-tab-button mb--30">
                                    <ul class="nav nav-tabs tab-button-style-2 justify-content-start"
                                        id="settinsTab-4" role="tablist">
                                        <li role="presentation">
                                            <a href="#" class="tab-button active" id="profile-tab"
                                                data-bs-toggle="tab" data-bs-target="#profile" role="tab"
                                                aria-controls="profile" aria-selected="true">
                                                <span class="title">Profile</span>
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#" class="tab-button" id="password-tab" data-bs-toggle="tab"
                                                data-bs-target="#password" role="tab" aria-controls="password"
                                                aria-selected="false">
                                                <span class="title">Password</span>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="profile" role="tabpanel"
                                        aria-labelledby="profile-tab">
                                     
                                        <!-- Start Profile Row  -->
                                        <form action="<?php echo e(url('/profile')); ?>" class="rbt-profile-row rbt-default-form row row--15" method="POST">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="rbt-form-group">
                                                    <?php echo csrf_field(); ?>
                                                    <label for="firstname">Name</label>
                                                    <input id="firstname" name="name" type="text" value="<?php echo e(Auth::user()->name); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="rbt-form-group">
                                                    <label for="phonenumber">Email</label>
                                                    <input id="phonenumber" name="email"  type="email" value="<?php echo e(Auth::user()->email); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="rbt-form-group">
                                                    <label for="phonenumber">Phone Number</label>
                                                    <input id="phonenumber" type="text" name="phone"  value="<?php echo e(Auth::user()->phone); ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="rbt-form-group">
                                                    <label for="bio">Bio</label>
                                                    <textarea id="bio" name="bio" cols="20" rows="5"><?php echo e(Auth::user()->bio); ?> </textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 mt--20">
                                                <div class="rbt-form-group">
                                                    <button type="submit" class="rbt-btn btn-gradient" href="#">Update Info</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- End Profile Row  -->
                                    </div>

                                    <div class="tab-pane fade" id="password" role="tabpanel"
                                        aria-labelledby="password-tab">
                                        <!-- Start Profile Row  -->
                                        <form action="<?php echo e(url('profile-password-update')); ?>" class="rbt-profile-row rbt-default-form row row--15" method="POST">
                                            <div class="col-12">
                                                <div class="rbt-form-group">
                                                    <?php echo csrf_field(); ?>
                                                    <label for="currentpassword">Current Password</label>
                                                    <input id="currentpassword" type="password"
                                                        placeholder="Current Password" name="old_password">
                                                        <?php $__errorArgs = ['old_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="rbt-form-group">
                                                    <label for="newpassword">New Password</label>
                                                    <input id="newpassword" type="password"
                                                        placeholder="New Password" name="password">
                                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="rbt-form-group">
                                                    <label for="retypenewpassword">Re-type New Password</label>
                                                    <input id="retypenewpassword" type="password"
                                                        placeholder="Re-type New Password" name="password_confirmation">
                                                        <?php $__errorArgs = ['confirmed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-12 mt--10">
                                                <div class="rbt-form-group">
                                                    <button type="submit" class="rbt-btn btn-gradient" href="#">Update Password</button>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/frontend/dashboard/edit-profile.blade.php ENDPATH**/ ?>