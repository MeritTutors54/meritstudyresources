
<?php $__env->startSection('content'); ?>
<style>
    .ptb--100 {
    padding: 30px 0 !important;
}
.rbt-section-gap {
    padding: 60px 0;
}
</style>
    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">PAST PAPERS</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="index.html">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Past Paper</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <!-- Start Button Area  -->

    <div class="rbt-button-area rbt-section-gap bg-color-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">A Level</h2>
                    </div>
                </div>
            </div>
            <div class="row mt--50">
                <div class="col-lg-12">
                    <div class="rbt-button-group">
                        <?php
                            $allBoard=DB::table('exam_board')->where('ALevel',1)->select(['id','board_name'])->get();
                        ?>
                        <?php $__currentLoopData = $allBoard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="rbt-btn <?php if($key==0): ?> btn-secondary <?php endif; ?> <?php if($key==1): ?> btn-coral <?php endif; ?> <?php if($key==2): ?> btn-violet <?php endif; ?> <?php if($key==3): ?> btn-white <?php endif; ?> <?php if($key==4): ?> btn-pink <?php endif; ?>" href="<?php echo e(url('exam-subjects',$series)); ?>/<?php echo e($board->id); ?>"><?php echo e($board->board_name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rbt-button-area rbt-section-gap bg-color-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        
                        <h2 class="title">AS Level</h2>
                    </div>
                </div>
            </div>
            <div class="row mt--50">
                <div class="col-lg-12">
                    <div class="rbt-button-group">
                        <?php
                        $allBoard=DB::table('exam_board')->where('ASLevel',1)->select(['id','board_name'])->get();
                    ?>
                        <?php $__currentLoopData = $allBoard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="rbt-btn <?php if($key==0): ?> btn-secondary <?php endif; ?> <?php if($key==1): ?> btn-coral <?php endif; ?> <?php if($key==2): ?> btn-violet <?php endif; ?> <?php if($key==3): ?> btn-white <?php endif; ?> <?php if($key==4): ?> btn-pink <?php endif; ?>" href="#"><?php echo e($board->board_name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rbt-button-area rbt-section-gap bg-color-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                       
                        <h2 class="title">GCSE</h2>
                    </div>
                </div>
            </div>
            <div class="row mt--50">
                <div class="col-lg-12">
                    <div class="rbt-button-group">
                        <?php
                        $allBoard=DB::table('exam_board')->where('GCSE',1)->select(['id','board_name'])->get();
                    ?>
                        <?php $__currentLoopData = $allBoard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="rbt-btn <?php if($key==0): ?> btn-secondary <?php endif; ?> <?php if($key==1): ?> btn-coral <?php endif; ?> <?php if($key==2): ?> btn-violet <?php endif; ?> <?php if($key==3): ?> btn-white <?php endif; ?> <?php if($key==4): ?> btn-pink <?php endif; ?>" href="#"><?php echo e($board->board_name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rbt-button-area rbt-section-gap bg-color-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                       
                        <h2 class="title">IGCSE</h2>
                    </div>
                </div>
            </div>
            <div class="row mt--50">
                <div class="col-lg-12">
                    <div class="rbt-button-group">
                        <?php
                        $allBoard=DB::table('exam_board')->where('IGCSE',1)->select(['id','board_name'])->get();
                    ?>
                        <?php $__currentLoopData = $allBoard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="rbt-btn <?php if($key==0): ?> btn-secondary <?php endif; ?> <?php if($key==1): ?> btn-coral <?php endif; ?> <?php if($key==2): ?> btn-violet <?php endif; ?> <?php if($key==3): ?> btn-white <?php endif; ?> <?php if($key==4): ?> btn-pink <?php endif; ?>" href="#"><?php echo e($board->board_name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Button Area  -->
    <!-- Start Button Area  -->
    <div class="rbt-button-area rbt-section-gap bg-color-darker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="subtitle bg-white-opacity">Continue Shop</span>
                        <h2 class="title color-white">Click here to shop More Resources</h2>
                    </div>
                </div>
            </div>
            <div class="row mt--50">
                <div class="col-lg-12">
                    <div class="rbt-button-group">
                        <a class="rbt-btn btn-border radius-round color-white-off" href="<?php echo e(url('/shop')); ?>">All Resoure</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Button Area  -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/frontend/examseries/index.blade.php ENDPATH**/ ?>