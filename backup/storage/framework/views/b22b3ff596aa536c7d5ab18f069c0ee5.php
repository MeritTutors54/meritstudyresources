
<?php $__env->startSection('content'); ?>



    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default rbt-breadcrumb-style-3">
        <div class="breadcrumb-inner breadcrumb-dark">
            <img src="<?php echo e(asset('frontend')); ?>/assets/images/bg/bg-image-10.jpg" alt="Education Images">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content text-start">
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active"><?php echo e($category->category_name ?? ''); ?> </li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active"><?php echo e($subcategory->subcategory_name ?? ''); ?></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active"><?php echo e($resubcategory->resubcategory_name ?? ''); ?></li>
                        </ul>
                        <h2 class="title">Your Ultimate Exam Resource Hub</h2>
                        <p class="description"> Our comprehensive resource collection is an invaluable asset for students striving to excel in exams and for teachers looking for dependable materials to guide their students. Explore a wide range of revision notes, exam questions, detailed model answers, past exam papers, and more, all carefully organized to make your search effortless.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class=" rbt-section-gapBottom">
        <div class="inner">
            <div class="container">
                <div class="col-lg-12">
                    <!-- Start Viedo Wrapper  -->
                   
                    <!-- End Viedo Wrapper  -->

                    <div class="row row--30 gy-5 pt--60">

                        <div class="col-lg-4">
                            <div class="course-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
                                <div class="inner">
                                    <div class="content-item-content">
                                        <div
                                            class="rbt-price-wrapper d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="rbt-price">
                                                
                                            </div>
                                            <div class="discount-time">
                                                
                                            </div>
                                        </div>

                                        <div class="add-to-card-button mt--15">
                                            
                                        </div>

                                        <div class="buy-now-btn mt--15">
                                            <a class="rbt-btn btn-border icon-hover w-100 d-block text-center" href="<?php echo e(url('/individuals-pricing')); ?>">
                                                <span class="btn-text">Buy Now Subscription</span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </a>
                                        </div>

                                        <span class="subtitle"><i class="feather-rotate-ccw"></i> 30-Day Money-Back
                                            Guarantee</span>


                                        <div class="rbt-widget-details has-show-more">
                                            <ul class="has-show-more-inner-content rbt-course-details-list-wrapper">
                                                <?php $__currentLoopData = $category_id->allsubcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allSub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><span><?php echo e($allSub->subcategory_name); ?></span></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                            <div class="rbt-show-more-btn">Show More</div>
                                        </div>

                                        <div class="social-share-wrapper mt--30 text-center">
                                            <div
                                                class="rbt-post-share d-flex align-items-center justify-content-center">
                                                <ul
                                                    class="social-icon social-default transparent-with-border justify-content-center">
                                                    <li><a href="<?php echo e($social->facebook); ?>">
                                                            <i class="feather-facebook"></i>
                                                        </a>
                                                    </li>
                                                    <li><a href="<?php echo e($social->twitter); ?>">
                                                            <i class="feather-twitter"></i>
                                                        </a>
                                                    </li>
                                                    <li><a href="<?php echo e($social->youtube); ?>">
                                                            <i class="feather-youtube"></i>
                                                        </a>
                                                    </li>
                                                    <li><a href="<?php echo e($social->linkend); ?>">
                                                            <i class="feather-linkedin"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <hr class="mt--20">
                                            <div class="contact-with-us text-center">
                                                <p>For details about us</p>
                                                <p class="rbt-badge-2 mt--10 justify-content-center w-100"><i
                                                        class="feather-phone mr--5"></i> Call Us: <a
                                                        href="#"><strong><?php echo e($companyInformation->mobile); ?></strong></a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <!-- Start Course Details  -->
                            <div class="course-details-content">
                                <div class="course-content rbt-shadow-box coursecontent-wrapper mt--30"
                                    id="coursecontent">
                                    <div class="rbt-course-feature-inner">
                                        <div class="section-title">
                                            <h4 class="rbt-title-style-3">Course Content</h4>
                                        </div>
                                        <div class="rbt-accordion-style rbt-accordion-02 accordion">
                                            <div class="accordion" id="accordionExampleb2">
                                                <?php
                                                    $i=100;
                                                 ?>
                                                <?php $__currentLoopData = $allPastPaper; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seriesName => $pastPapers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $i++
                                                ?>
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header card-header" id="headingTwo1<?php echo e($i); ?>">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo1<?php echo e($i); ?>"
                                                            aria-expanded="true" aria-controls="collapseTwo1<?php echo e($i); ?>">
                                                            <?php echo e($seriesName); ?> <span
                                                                class="rbt-badge-5 ml--10"><?php echo e($resubcategory->resubcategory_name ?? ''); ?></span>
                                                        </button>
                                                    </h2>
                                                    
                                                    <div id="collapseTwo1<?php echo e($i); ?>" class="accordion-collapse collapse  show"
                                                        aria-labelledby="headingTwo1<?php echo e($i); ?>"
                                                        data-bs-parent="#accordionExampleb2">
                                                        <div class="accordion-body card-body pr--0">
                                                            <ul class="rbt-course-main-content liststyle">
                                                            
                                                                <li>
                                                                    <a href="#">
                                                                        <div class="course-content-left">
                                                                            
                                                                            <span class="text">Question</span>
                                                                        </div>
                                                                     
                                                                        <div class="course-content-right">
                                                                            
                                                                            <span class="rbt-badge variation-03 ">
                                                                                
                                                                                Mark Scheme</span>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <?php $__currentLoopData = $pastPapers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li>
                                                                    <div class="myclass" style="display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;">
                                                                        <div class="course-content-left">
                                                                            <a href="<?php echo e(asset('uploads/pastpaper/'. $paper->ques_paper)); ?> ">
                                                                            <i class="feather-file-text"></i>
                                                                            <span class="rbt-badge variation-03 bg-primary-opacity"><?php echo e($paper->title); ?></span>
                                                                            </a>
                                                                        </div>
                                                                        <div class="course-content-right">
                                                                            <a href="<?php echo e(asset('uploads/pastpaper/'. $paper->ans_paper)); ?> ">
                                                                                <span class="rbt-badge variation-03 bg-primary-opacity">Mark Scheme</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                   
                                                                </li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                 
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!-- End Course Details  -->

                            <!-- Start Related Course  -->
                            
                            <!-- End Related Course  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>

  
    <!-- End Course Action Bottom  -->
    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
    <!-- Start Footer aera -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/frontend/pastpapers/pastpapersdetails.blade.php ENDPATH**/ ?>