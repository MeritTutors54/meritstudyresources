
<?php $__env->startSection('content'); ?>
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                            </i>
                        </div>
                        <div>Worksheet Category Manage</div>
                    </div>
                    <div class="page-title-actions">
                        <button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark">
                            <i class="fa fa-star"></i>
                        </button>
                    </div>    
                </div>
            </div>            
            <div class="row">
                <div class="col-md-6">
                    <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Worksheet Category Update</h5>
                            <div>
                            <form action="<?php echo e(url('/admin/worksheet-category/update')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="position-relative form-group"><label for="exampleFile" class="">Subject</label>
                                    <select  class="form-control" name="subject_id"  placeholder="Enter Category Name">
                                        <option disabled selected>Select</option>
                                        <?php $__currentLoopData = $allSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject->id); ?>" <?php if($subject->id==$edit->subject_id): ?> selected <?php endif; ?>><?php echo e($subject->subject_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </select>
                                </div>
                                <div class="position-relative form-group"><label for="exampleFile" class="">Category</label>
                                    <input type="text" class="form-control" name="category_name"  placeholder="Enter Category Name" value="<?php echo e($edit->category_name); ?>">
                                    <input type="hidden"  name="id"  value="<?php echo e($edit->id); ?>">
                                </div>
                                <br>
                                <div class="input-group">
                                    <button type="submit" class="mb-2 mr-2 btn btn-success">Update</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/worksheetcategory/update.blade.php ENDPATH**/ ?>