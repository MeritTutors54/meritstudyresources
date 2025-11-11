
<?php $__env->startSection('content'); ?>
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                            </i>
                        </div>
                        <div>Worksheet Subject Manage</div>
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
                                <h5 class="card-title">Worksheet Subject Update</h5>
                            <div>
                            <form action="<?php echo e(url('/admin/worksheet-subject/update')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="position-relative form-group"><label for="exampleFile" class="">Subject name</label>
                                    <input type="text" class="form-control" name="subject_name"  placeholder="Enter Category Name" value="<?php echo e($edit->subject_name); ?>">
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
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/worksheetsubject/update.blade.php ENDPATH**/ ?>