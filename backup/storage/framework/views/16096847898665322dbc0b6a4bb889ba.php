
<?php $__env->startSection('content'); ?>
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Individuals</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Individuals Pricing</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="rbt-pricing-area bg-color-white rbt-section-gap">
    <div class="container">
        <div class="row g-5 mb--60">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="section-title text-start">
                    <span class="subtitle bg-primary-opacity"> PRICING</span>
                    
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-12">
                <div class="pricing-billing-duration text-start text-md-end">
                    <ul>
                        <li class="nav-item">
                            <button class="nav-link yearly-plan-btn" type="button">Yearly Plan</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link monthly-plan-btn active" type="button">Monthly Plan</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <!-- Start Single Pricing  -->

            
            <?php $__currentLoopData = $allMonthly; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-4 col-lg-6 col-md-6 col-12 monthly-pricing">
                <div class="pricing-table">
                    <div class="pricing-header">
                        <h3 class="title"><?php echo e($subscription->title); ?></h3>
                        <span class="rbt-badge mb--35"><?php echo e($subscription->sub_title); ?></span>
                        <div class="price-wrap">
                            
                            <div class="" style="display: block;">
                                <span class="amount">£<?php echo e($subscription->price); ?> </span>
                                <span class="duration">/monthly</span>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="list-item">
                            <?php $__currentLoopData = json_decode($subscription->access_details); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $access): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><i class="feather-check"></i> <?php echo e($access ?? ''); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                     
                        </ul>
                    </div>
                    <div class="pricing-btn">
                        <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100" href="<?php echo e(route('plan.checkout', ['plan' => $subscription->id])); ?>">
                            <div class="icon-reverse-wrapper">
                                <span class="btn-text">Purchase Plan</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $allYearly; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-4 col-lg-6 col-md-6 col-12 yearly-pricing">
                <div class="pricing-table">
                    <div class="pricing-header">
                        <h3 class="title"><?php echo e($subscription->title); ?></h3>
                        <span class="rbt-badge mb--35"><?php echo e($subscription->sub_title); ?></span>
                        <div class="price-wrap">
                            <div class="" style="">
                                <span class="amount">£<?php echo e($subscription->price); ?></span>
                                <span class="duration">/yearly</span>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="list-item">
                            <?php $__currentLoopData = json_decode($subscription->access_details); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $access): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><i class="feather-check"></i> <?php echo e($access ?? ''); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                     
                        </ul>
                    </div>
                    <div class="pricing-btn">
                        <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100" href="<?php echo e(route('plan.checkout', ['plan' => $subscription->id])); ?>">
                            <div class="icon-reverse-wrapper">
                                <span class="btn-text">Purchase Plan</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            <!-- End Single Pricing  -->

            <!-- Start Single Pricing  -->
            
            <!-- End Single Pricing  -->

            <!-- Start Single Pricing  -->
            
            <!-- End Single Pricing  -->
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/frontend/pricing/individuals.blade.php ENDPATH**/ ?>