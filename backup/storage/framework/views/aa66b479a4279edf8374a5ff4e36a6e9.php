<footer class="rbt-footer footer-style-1">
    <div class="footer-top">
        <div class="container">
            <div class="row row--15 mt_dec--30">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <div class="logo logo-dark">
                            <a href="<?php echo e(url('/')); ?>">
                                <img src="<?php echo e(asset('uploads/logo/'.$logo->logo)); ?>" alt="Edu-cause">
                            </a>
                        </div>
                        <div class="logo d-none logo-light">
                            <a href="<?php echo e(url('/')); ?>">
                                <img src="<?php echo e(asset('uploads/logo/'.$logo->logo)); ?>" alt="Edu-cause">
                            </a>
                        </div>

                        <p class="description mt--20"><?php echo e($companyInformation->company_motto); ?>

                        </p>

                        <div class="contact-btn mt--30">
                            <a class="rbt-btn hover-icon-reverse btn-border-gradient radius-round" href="<?php echo e(url('contact')); ?>">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Contact With Us</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <h5 class="ft-title">Useful Links</h5>
                        <ul class="ft-link">
                            <li>
                                <a href="<?php echo e(url('about-us')); ?>">About Us</a>
                            </li>
                            <li>
                                <a href="<?php echo e(url('past-papers')); ?>">Past Papers</a>
                            </li>
                            <li>
                                <a href="<?php echo e(url('faq')); ?>">FAQ</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <h5 class="ft-title">Our Company</h5>
                        <ul class="ft-link">
                            <li>
                                <a href="<?php echo e(url('contact')); ?>">Contact Us</a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(url('blogs')); ?>">Blogs</a>
                            </li>
                         
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <h5 class="ft-title">Get Contact</h5>
                        <ul class="ft-link">
                            
                            <li><span>E-mail:</span> <a href="<?php echo e($companyInformation->mobile); ?>"><?php echo e($companyInformation->email); ?></a>
                            </li>
                            
                        </ul>
                        <ul class="social-icon social-default icon-naked justify-content-start mt--20">
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
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer aera -->
<div class="rbt-separator-mid">
    <div class="container">
        <hr class="rbt-separator m-0">
    </div>
</div>
<!-- Start Copyright Area  -->
<div class="copyright-area copyright-style-1 ptb--20">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                <p class="rbt-link-hover text-center text-lg-start">Copyright © <?php echo e(Carbon\Carbon::now()->format('Y')); ?> <a
                        href=""><?php echo e($companyInformation->company_name); ?></a> All Rights Reserved</p>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                <ul
                    class="copyright-link rbt-link-hover justify-content-center justify-content-lg-end mt_sm--10 mt_md--10">
                    <li><a href="<?php echo e(url('terms-condition')); ?>">Terms of service</a></li>
                    <li><a href="<?php echo e(url('privacy-policy')); ?>">Privacy policy</a></li>
                    <li><a href="<?php echo e(url('/pricing')); ?>">Subscription</a></li>
                    <li><a href="<?php echo e(url('/login')); ?>">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
</div><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/frontend/include/footer.blade.php ENDPATH**/ ?>