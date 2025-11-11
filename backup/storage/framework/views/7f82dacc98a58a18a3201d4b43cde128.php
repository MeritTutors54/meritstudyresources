
<?php $__env->startSection('content'); ?>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                    </i>
                </div>
                <div>ReSubCategory Manage</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="<?php echo e(route('admin.resubcategory.index')); ?>">    <button type="button"  class="btn-shadow dropdown-toggle btn btn-info">
                            All ReSubCategory
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
                        <h5 class="card-title">ReSubCategory Create</h5>
                    <div>
                    <form action="<?php echo e(url('/admin/resubcategory/create')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="position-relative form-group"><label for="exampleFile" class="">ReSubCategory Name</label>
                            <input type="text" class="form-control" name="resubcategory_name"  placeholder="Enter ResubCategory Name">
                                <?php $__errorArgs = ['resubcategory_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Unit Code</label>
                            <input type="text" class="form-control" name="unit_code"  placeholder="Enter Unit Code">
                                <?php $__errorArgs = ['unit_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <br>
                        
                          
                        <div class="position-relative form-group"><label for="exampleFile" class="">Category</label>
                            <select class="form-control" name="category_id" id="category_id" onchange="getSubCategory(this)">
                                <option disabled selected>Select</option>
                                    <?php $__currentLoopData = $allCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cate->id); ?>" <?php echo e(old('category_id') == $cate->id ? 'selected' : ''); ?>><?php echo e($cate->category_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Sub Category</label>
                            <select class="form-control" name="subcategory_id" id="sub_category">
                                <option disabled selected>Select</option>
                            </select>
                            <?php $__errorArgs = ['subcategory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <br>
                      
                            <div class="position-relative form-group">
                                <div class="form-check">
                                    <input class="form-check-input" name="past_papers" type="checkbox" value="1" id="flexCheckDefault" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                       Past paper
                                    </label>
                                </div>
                            </div>
                          
                            <div class="position-relative form-group">
                                <div class="form-check">
                                    <input class="form-check-input" name="revision_notes" type="checkbox" value="1" id="flexCheckDefault" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Revision Notes
                                    </label>
                                </div>
                            </div>
                            <div class="position-relative form-group">
                                <div class="form-check">
                                    <input class="form-check-input" name="exam_questions" type="checkbox" value="1" id="flexCheckDefault" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Exam Questions
                                    </label>
                                </div>
                            </div>
                            <div class="position-relative form-group">
                                <div class="form-check">
                                    <input class="form-check-input" name="flashcards" type="checkbox" value="1" id="flexCheckDefault" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Flash Cards
                                    </label>
                                </div>
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
    function getSubCategory(el){
    
         
         var cate_id=$("#category_id").val();
         
           if(cate_id) {
              $.ajax({
                  url: "<?php echo e(url('get/admin/subcategory')); ?>/"+cate_id,
                  type:"GET",
                  dataType:"json",
                  success:function(data) {
                    
                         $('#sub_category').empty();
                         $('#sub_category').append('<option selected disabled>Select</option>');
                         $.each(data,function(index,districtObj){
 
                          $('#sub_category').append('<option value="' + districtObj.id + '">'+districtObj.subcategory_name+'</option>');
                          
                        });
                             
                         
 
                      }
              });
          } else {
              alert('sorry data not found');
          }
         
    }
    // function ispaid(el){
    //     alert(el.value);

    // }

 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/resubcategory/create.blade.php ENDPATH**/ ?>