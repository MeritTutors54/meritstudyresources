<div class="rbt-tutor-information">
    <div class="rbt-tutor-information-left">
       
        <div class="tutor-content">
            <h5 class="title"><?php echo e(Auth::user()->name); ?></h5>
            <div class="rbt-review">
                <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                
            </div>
        </div>
    </div>
    <div class="rbt-tutor-information-right">
        <div class="tutor-btn">
            <a class="rbt-btn btn-md hover-icon-reverse" href="<?php echo e(url('/shop')); ?>">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Purchase Resources</span>
                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                </span>
            </a>
        </div>
    </div>
</div><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/frontend/dashboard/include/header.blade.php ENDPATH**/ ?>