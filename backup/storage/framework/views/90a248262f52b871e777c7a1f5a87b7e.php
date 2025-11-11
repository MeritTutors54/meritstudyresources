
<?php $__env->startSection('content'); ?>
<style>
label {
    
    margin-bottom: .5rem;
    font-size: 16px;
    font-weight: 600;
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
                <div>Subscription</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="<?php echo e(route('admin.subscription.index')); ?>">    <button type="button"  class="btn-shadow dropdown-toggle btn btn-info">
                            All Subscription
                        </button>
                        </a>
                    </div>
            </div>    
        </div>
    </div>      
    <div class="row">
        <div class="col-md-8">
            <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Subscription Create</h5>
                    <div>
                    <form action="<?php echo e(url('/admin/subscription/create')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="position-relative form-group"><label for="exampleFile" class="">Title</label>
                            <input type="text" class="form-control" name="title"  placeholder="Enter Subscription Title" required>
                        </div>
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Sub Title</label>
                            <input type="text" class="form-control" name="sub_title"  placeholder="Enter Subscription Sub Title" required>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">Subscription Type</label>
                            <select class="form-control" name="subscription_type" required>
                                <option disabled selected>Select</option>
                                <option value="1">Monthy</option>
                                <option value="2">Yearly</option>
                               
                            </select>
                        </div>
                        
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Price</label>
                            <input type="number" class="form-control" name="price" placeholder="Enter Subscription Price" required>
                        </div>
                        <br>
                      
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">Type</label>
                            <select class="form-control" name="type" required>
                                <option disabled selected>Select</option>
                                <?php $__currentLoopData = $allSubType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>"><?php echo e($type->type_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Stripe ID</label>
                            <input type="text" class="form-control" name="stripe_id"  placeholder="Enter Subscription stripe_id" required value="">
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">Access Details</label>
                            <input type="text" class="form-control" name="access_details[]"  placeholder="Enter Access Details" required>
                        </div>
                        <br>
                        <div class="position-relative form-group" id="main_access_section">
                         
                           
                        </div>
                        <div class="position-relative form-group text-right">
                           
                           <button class="btn-sm btn-warning" type="button" onclick="addmore()">Add More</button>
                        </div>

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

<script>
function addmore(){
    $("#main_access_section").append('<div class="position-relative form-group asif"><label for="exampleFile" class="">Access Details</label><input type="text" class="form-control" name="access_details[]"  placeholder="Enter Access Details" required><a onclick="deleterow(this)" style="color:red; cursor:pointer;">Delete</a></div>')
}
function deleterow(em) {
$(em).closest(".asif").remove();
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/subscription/create.blade.php ENDPATH**/ ?>