<?php if($paginator->hasPages()): ?>
    <div class="row">
        <div class="col-lg-12 mt--60">
            <nav>
                <ul class="rbt-pagination">
                    
                    <?php if($paginator->onFirstPage()): ?>
                        <li class="disabled"><span><i class="feather-chevron-left"></i></span></li>
                    <?php else: ?>
                        <li><a href="<?php echo e($paginator->previousPageUrl()); ?>" aria-label="Previous"><i class="feather-chevron-left"></i></a></li>
                    <?php endif; ?>

                    
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_string($element)): ?>
                            <li class="disabled"><span><?php echo e($element); ?></span></li>
                        <?php elseif(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $paginator->currentPage()): ?>
                                    <li class="active"><a href="#" class="active"><?php echo e($page); ?></a></li>
                                <?php else: ?>
                                    <li><a href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($paginator->hasMorePages()): ?>
                        <li><a href="<?php echo e($paginator->nextPageUrl()); ?>" aria-label="Next"><i class="feather-chevron-right"></i></a></li>
                    <?php else: ?>
                        <li class="disabled"><span><i class="feather-chevron-right"></i></span></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/vendor/pagination/mycustompagination.blade.php ENDPATH**/ ?>