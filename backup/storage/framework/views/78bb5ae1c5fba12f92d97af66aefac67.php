
<?php $__env->startSection('content'); ?>
<div class="rbt-overlay-page-wrapper">

    <div class="breadcrumb-image-container breadcrumb-style-max-width">
        <div class="breadcrumb-image-wrapper">
            <div class="breadcrumb-dark">
                <img src="assets/images/bg/bg-image-10.jpg" alt="Education Images">
            </div>
        </div>
        <div class="breadcrumb-content-top text-center">
            <h1 class="title">Privacy Policy</h1>
            <p class="mb--20"> Privacy Policy Here.</p>
            <ul class="page-list">
                <li class="rbt-breadcrumb-item"><a href="index.html">Home</a></li>
                <li>
                    <div class="icon-right"><i class="feather-chevron-right"></i></div>
                </li>
                <li class="rbt-breadcrumb-item active">Purchase Guide</li>
            </ul>
        </div>
    </div>


    <div class="rbt-putchase-guide-area breadcrumb-style-max-width rbt-section-gapBottom">
        <div class="rbt-article-content-wrapper">
            <div class="post-thumbnail mb--30 position-relative wp-block-image alignwide">
                
            </div>
            <div class="content">
                <?php echo $privacyPolicy->value; ?>

            </div>
        </div>
    </div>

</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merithub.co.uk/public_html/core/resources/views/frontend/privacypolicy/index.blade.php ENDPATH**/ ?>