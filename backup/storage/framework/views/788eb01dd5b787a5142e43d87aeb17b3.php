
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
                            <li class="rbt-breadcrumb-item"><a href="index.html">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active"><?php echo e($category->category_name ?? ''); ?></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active"><?php echo e($subcategory->subcategory_name ?? ''); ?></li>
                        </ul>
                        <h2 class="title">Your Ultimate Exam Resource Hub</h2>
                        <p class="description">Our comprehensive resource collection is an invaluable asset for students striving to excel in exams and for teachers looking for dependable materials to guide their students. Explore a wide range of revision notes, exam questions, detailed model answers, past exam papers, and more, all carefully organized to make your search effortless.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->
    <div class="rbt-course-details-area ptb--60">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-12">
                    <div class="course-details-content">
                        <div class="rbt-inner-onepage-navigation sticky-top mt--30">
                            <nav class="mainmenu-nav onepagenav">
                                <ul class="mainmenu">
                                    <?php $__currentLoopData = $subcategory->resubcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resubkey => $resubcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li <?php if($resubkey==0): ?> class="current" <?php endif; ?>>
                                        <a href="#<?php echo e($resubcategory->resubcategory_name); ?>"><?php echo e($resubcategory->resubcategory_name); ?></a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </nav>
                        </div>
                        <?php $__currentLoopData = $subcategory->resubcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resubkey => $resubcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="rbt-course-feature-box rbt-shadow-box details-wrapper mt--30" id="<?php echo e($resubcategory->resubcategory_name ?? ''); ?>">
                            <div class="row g-5">
                                <!-- Start Feture Box  -->
                                <div class="col-lg-12">
                                    <p class="description"><?php echo e($category->category_name ?? ''); ?> <?php echo e($resubcategory->resubcategory_name ?? ''); ?> <?php echo e($subcategory->subcategory_name ?? ''); ?></p>
                                </div>
                                <?php if($resubcategory->past_papers==1): ?>
                                <div class="col-lg-3">
                                    
                                    <a href="<?php echo e(url('pastpapers/' . $category->slug . '/' . $subcategory->slug . '/' . $resubcategory->slug)); ?>">

                                    <div class="section-title newDesign">
                                        <i class="fa fa-book"></i>
                                        <h4 class="rbt-title-style-3 mb--20">Past Paper <i class="fa fa-arrow-right"></i></h4>
                                    </div>
                                    </a>
                                </div>
                                <?php endif; ?>
                                <!-- End Feture Box  -->
                                <!-- Start Feture Box  -->
                                <?php if($resubcategory->revision_notes==1): ?>
                                <div class="col-lg-3">
                                    <div class="section-title newDesign">
                                        <i class="fa fa-book"></i>
                                        <h4 class="rbt-title-style-3 mb--20">Revision Notes <i class="fa fa-arrow-right"></i></h4>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if($resubcategory->exam_questions==1): ?>
                                <div class="col-lg-3">
                                    <div class="section-title newDesign">
                                        <i class="fa fa-book"></i>
                                        <h4 class="rbt-title-style-3 mb--20">Exam Questions <i class="fa fa-arrow-right"></i></h4>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if($resubcategory->flashcards==1): ?>
                                <div class="col-lg-3">
                                    <div class="section-title newDesign">
                                        <i class="fa fa-book"></i>
                                        <h4 class="rbt-title-style-3 mb--20">Flash Cards<i class="fa fa-arrow-right"></i></h4>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <!-- End Feture Box  -->
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  
                </div>

               
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/frontend/resourceDetails/index.blade.php ENDPATH**/ ?>