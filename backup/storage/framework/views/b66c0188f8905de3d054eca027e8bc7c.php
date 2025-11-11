
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
                <div class="d-inline-block dropdown">
                    <a href="<?php echo e(route('admin.worksheetsubject.index')); ?>">    <button type="button"  class="btn-shadow dropdown-toggle btn btn-info">
                            All Worksheet Subject
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
                        <h5 class="card-title">Worksheet Subject Create</h5>
                    <div>
                    <form action="<?php echo e(url('/admin/worksheet-subject/create')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="position-relative form-group"><label for="exampleFile" class="">Worksheet Subject Name</label>
                            <input type="text" class="form-control" name="subject_name"  placeholder="Enter Worksheet Subject Name">
                        </div>
                        <br>
                        <div class="input-group">
                            <button type="submit" class="mb-2 mr-2 btn btn-success">Submit</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/worksheetsubject/create.blade.php ENDPATH**/ ?>