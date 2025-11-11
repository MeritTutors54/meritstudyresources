
<?php $__env->startSection('content'); ?>

 <!-- Start breadcrumb Area -->
 <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">About</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="index.html">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">About</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="thumbnail-wrapper">
                    <div class="thumbnail image-1">
                        <img data-parallax='{"x": 0, "y": -20}' src="<?php echo e(asset('frontend')); ?>/assets/images/about/about-07.jpg"
                            alt="Education Images">
                    </div>
                    <div class="thumbnail image-2 d-none d-xl-block">
                        <img data-parallax='{"x": 0, "y": 60}' src="<?php echo e(asset('frontend')); ?>/assets/images/about/about-09.jpg"
                            alt="Education Images">
                    </div>
                    <div class="thumbnail image-3 d-none d-md-block">
                        <img data-parallax='{"x": 0, "y": 80}' src="<?php echo e(asset('frontend')); ?>/assets/images/about/about-08.jpg"
                            alt="Education Images">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="inner pl--50 pl_sm--0 pl_md--0">
                    <div class="section-title text-start">
                        <span class="subtitle bg-coral-opacity">Know About Us</span>
                        <h2 class="title">Know About Histudy <br /> Learning Platform</h2>
                    </div>
                    <p class="description mt--30">Far far away, behind the word mountains, far from the countries
                        Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                        right at the coast of the Semantics, a large language ocean.</p>
                    <!-- Start Feature List  -->
                    <div class="rbt-feature-wrapper mt--40">

                        <div class="rbt-feature feature-style-1">
                            <div class="icon bg-pink-opacity">
                                <i class="feather-heart"></i>
                            </div>
                            <div class="feature-content">
                                <h6 class="feature-title">Flexible Classes</h6>
                                <p class="feature-description">It is a long established fact that a reader will
                                    be distracted by this on readable content of when looking at its layout.</p>
                            </div>
                        </div>

                        <div class="rbt-feature feature-style-1">
                            <div class="icon bg-primary-opacity">
                                <i class="feather-book"></i>
                            </div>
                            <div class="feature-content">
                                <h6 class="feature-title">Learn From Anywhere</h6>
                                <p class="feature-description">Sed distinctio repudiandae eos recusandae laborum
                                    eaque non eius iure suscipit laborum eaque non eius iure suscipit.</p>
                            </div>
                        </div>

                        <div class="rbt-feature feature-style-1">
                            <div class="icon bg-coral-opacity">
                                <i class="feather-monitor"></i>
                            </div>
                            <div class="feature-content">
                                <h6 class="feature-title">Experienced Teacher's service.</h6>
                                <p class="feature-description">Lorem ipsum dolor sit amet consectetur adipisicing
                                    elit. Officia, aliquid mollitia Officia, aliquid mollitia.</p>
                            </div>
                        </div>
                    </div>

                    <!-- End Feature List  -->
                    <div class="about-btn mt--40">
                        <a class="rbt-btn btn-gradient hover-icon-reverse" href="<?php echo e(url('/contact')); ?>">
                            <span class="icon-reverse-wrapper">
                                <span class="btn-text">Contact Us</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merithub.co.uk/public_html/core/resources/views/frontend/aboutus/index.blade.php ENDPATH**/ ?>