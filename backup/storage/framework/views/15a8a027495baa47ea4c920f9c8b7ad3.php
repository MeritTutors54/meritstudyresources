
<?php $__env->startSection('content'); ?>

<style>
div.dataTables_wrapper div.dataTables_length select {

  height: 33px;
}
div.dataTables_wrapper div.dataTables_filter input {

    height: 25px;
}
</style>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                    </i>
                </div>
                <div>All WorkSheet Subject</div>
            </div>
            <div class="page-title-actions">

                <div class="d-inline-block dropdown">
                    <a href="<?php echo e(route('admin.worksheetsubject.create')); ?>">    <button type="button"  class="btn-shadow dropdown-toggle btn btn-info">
                        Add WorkSheet Subject
                    </button>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">All Worksheet Subject</h5>
                    <div class="table-responsive">
                    <table id="dataTableExample1" class="table table-bordered table-striped table-hover mb-2">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Name</th>
                            <th>Created By</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $allData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(++$key); ?></td>
                            <td><?php echo e($data->subject_name); ?></td>
                            <td></td>
                            <td>
                            <?php if($data->is_active==1): ?>
                                <span class="btn-sm btn-success">Active</span>
                            <?php else: ?>
                                <span class="btn-sm btn-danger">Deactive</span>
                            <?php endif; ?>
                            </td>
                        
                            <td>
                            <?php if($data->is_active==1): ?>
                            <a class=" bg-success-light" style="color:green"  data-toggle="tooltip" data-placement="top"  href="<?php echo e(url('admin/worksheet-subject/deactive/'.$data->id)); ?>" data-original-title="Active"><i class="fa fa-thumbs-up"></i></a>
                            <?php else: ?>
                                <a class="bg-danger-light" style="color:red"  data-toggle="tooltip" data-placement="top" href="<?php echo e(url('admin/worksheet-subject/active/'.$data->id)); ?>" data-original-title="Deactive"><i class="fa fa-thumbs-down"></i></a>
                            <?php endif; ?>
                            <a class=" bg-primary-light"  href="<?php echo e(url('admin/worksheet-subject/edit/'.$data->id)); ?>"  title="edit"><i class="fas fa-pencil-alt"></i></a>
                            <a id="delete" class="bg-danger-light" style="color:red"  data-toggle="tooltip" data-placement="top" href="<?php echo e(url('admin/worksheet-subject/delete/'.$data->id)); ?>" data-original-title="Delete"> <i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/worksheetsubject/index.blade.php ENDPATH**/ ?>