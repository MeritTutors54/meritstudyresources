
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
                                    <h4 class="rbt-title-style-3">Wishlist</h4>
                                </div>
                                <div class="row g-5">
                                    <!-- Start Single Course  -->
                                    
                                  
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/frontend/dashboard/wishlist.blade.php ENDPATH**/ ?>