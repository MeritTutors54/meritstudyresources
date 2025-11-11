
<?php $__env->startSection('content'); ?>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                    </i>
                </div>
                <div>SubCategory Manage</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="<?php echo e(route('admin.subcategory.index')); ?>">    <button type="button"  class="btn-shadow dropdown-toggle btn btn-info">
                          All SubCategory
                       </button>
                     </a>
                   </div>
            </div>    
        </div>
    </div>            
    <div class="row">
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">SubCategory Update</h5>
                    <div>
                    <form action="<?php echo e(url('/admin/subcategory/update')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="position-relative form-group"><label for="exampleFile">SubCategory Name</label>
                            <input type="text" class="form-control" name="subcategory_name" placeholder="Enter SubCategory Name" value="<?php echo e($edit->subcategory_name); ?>">
                        </div>
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile">Category</label>
                            <select class="form-control" name="category_id">
                                <option disabled>Select</option>
                                <?php $__currentLoopData = $allCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cate->id); ?>" <?php if($edit->category_id==$cate->id): ?> selected <?php endif; ?>><?php echo e($cate->category_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <br>
                        <div class="input-group">
                            <input type="hidden"  name="id"  value="<?php echo e($edit->id); ?>">
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
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/subcategory/update.blade.php ENDPATH**/ ?>