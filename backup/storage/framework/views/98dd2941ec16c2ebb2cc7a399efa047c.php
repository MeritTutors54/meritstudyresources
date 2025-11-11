<?php $__env->startSection('content'); ?>
<?php
$allSubcategory=App\Models\SubCategory::where('is_deleted',0)->where('is_active',1)->where('category_id',$edit->category)->get();
$allReSubcategory=App\Models\Resubcategory::where('is_deleted',0)->where('is_active',1)->where('subcategory_id',$edit->subcategory)->get();
?>
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
                <div>Past Paper Update</div>
            </div>
            <div class="page-title-actions">
                <button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark">
                    <i class="fa fa-star"></i>
                </button>
                <div class="d-inline-block dropdown">
                    <a href="<?php echo e(route('admin.past-paper.index')); ?>">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-business-time fa-w-20"></i>
                        </span>
                        ALL PAST PAPERS 
                    </button>
                </a>
                
                </div>
            </div>    
        </div>
    </div>     
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Update Past Papers</h5>
                    <div>
                    <form action="<?php echo e(url('admin/past-paper/update')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Title</label>
                            <input type="hidden" name="id" value="<?php echo e($edit->id); ?>">
                            <input type="text" class="form-control" name="title" placeholder="Enter Past Paper Title" required value="<?php echo e($edit->title); ?>">
                            <?php if($errors->has('title')): ?>
                                <div class="text-danger"><?php echo e($errors->first('title')); ?></div>
                            <?php endif; ?>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                        <label for="uname">Series</label>
                        <select class="form-control" name="exam_series" id="series">
                            <option disabled selected>Select</option>
                            <?php $__currentLoopData = $examSeries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $series): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($series->id); ?>" <?php if($edit->exam_series==$series->id): ?> selected <?php endif; ?>><?php echo e($series->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                            <?php if($errors->has('exam_series')): ?>
                            <div class="text-danger"><?php echo e($errors->first('exam_series')); ?></div>
                            <?php endif; ?>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">Category</label>
                            <select class="form-control" name="category" onchange="getCategory(this)" id="category" required>
                                <option disabled selected>Select</option>
                                <?php $__currentLoopData = $allCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php if($edit->category==$category->id): ?> selected <?php endif; ?>><?php echo e($category->category_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('category')): ?>
                            <div class="text-danger"><?php echo e($errors->first('category')); ?></div>
                            <?php endif; ?>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">SubCategory</label>
                           
                            <select class="form-control" name="subcategory" onchange="getSubCategory(this)" id="subcategory" required>
                                <option disabled selected>Select</option>
                                <?php $__currentLoopData = $allSubcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subcategory->id); ?>" <?php if($edit->subcategory==$subcategory->id): ?> selected <?php endif; ?>><?php echo e($subcategory->subcategory_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('subcategory')): ?>
                            <div class="text-danger"><?php echo e($errors->first('subcategory')); ?></div>
                            <?php endif; ?>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">ReSubCategory</label>
                            <select class="form-control" name="resubcategory"  id="resubcategory" required>
                                <option disabled selected>Select</option>
                                <?php $__currentLoopData = $allReSubcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resubcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($resubcategory->id); ?>" <?php if($edit->resubcategory==$resubcategory->id): ?> selected <?php endif; ?>><?php echo e($resubcategory->resubcategory_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('resubcategory')): ?>
                            <div class="text-danger"><?php echo e($errors->first('resubcategory')); ?></div>
                            <?php endif; ?>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="cname">Question Paper (PDF File)</label><br>
                            <input type="file"  name="ques_paper" > 
                            <br>
                            <br>
                            <a href="<?php echo e(asset('uploads/pastpaper/'.$edit->ques_paper)); ?>" class="btn btn-success">File</a>
                            <?php if($errors->has('ques_paper')): ?>
                            <div class="text-danger"><?php echo e($errors->first('ques_paper')); ?></div>
                            <?php endif; ?>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                        <label for="cname">
                            Mark Scheme (PDF File)</label><br>
                        <input type="file" name="ans_paper" >
                        <br>
                        <br>
                        <a href="<?php echo e(asset('uploads/pastpaper/'.$edit->ans_paper)); ?>" class="btn btn-success">File</a>
                            <?php if($errors->has('ans_paper')): ?>
                            <div class="text-danger"><?php echo e($errors->first('ans_paper')); ?></div>
                            <?php endif; ?>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_paid" id="inlineRadio1" value="1" <?php if($edit->is_paid==1): ?> checked <?php endif; ?>>
                            <label class="form-check-label" for="inlineRadio1">Paid</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_paid" id="inlineRadio2" value="0"  <?php if($edit->is_paid==0): ?> checked <?php endif; ?>>
                            <label class="form-check-label" for="inlineRadio2">Free</label>
                          </div>
                        </div>
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
<script>
    function getCategory(el){
    
       
         var category=$("#category").val();
         
           if(category) {
              $.ajax({
                  url: "<?php echo e(url('get/admin/allsubcategory/')); ?>/"+category,
                  type:"GET",
                  dataType:"json",
                  success:function(data) {
                    
                         $('#subcategory').empty();
                         $('#subcategory').append('<option selected disabled>Select</option>');
                         $.each(data,function(index,districtObj){
 
                          $('#subcategory').append('<option value="' + districtObj.id + '">'+districtObj.subcategory_name+'</option>');
                          
                        });
                             
                         
 
                      }
              });
          } else {
              alert('sorry data not found');
          }
     
    }
    // getSubCategory
    function getSubCategory(el){
    
       
    var subcategory=$("#subcategory").val();
    
      if(subcategory) {
         $.ajax({
             url: "<?php echo e(url('get/admin/allresubcategory/')); ?>/"+subcategory,
             type:"GET",
             dataType:"json",
             success:function(data) {
               
                    $('#resubcategory').empty();
                    $('#resubcategory').append('<option selected disabled>Select</option>');
                    $.each(data,function(index,districtObj){

                     $('#resubcategory').append('<option value="' + districtObj.id + '">'+districtObj.resubcategory_name+'</option>');
                     
                   });
                        
                    

                 }
         });
     } else {
         alert('sorry data not found');
     }

}
 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merithub.co.uk/public_html/core/resources/views/backend/pastpaper/update.blade.php ENDPATH**/ ?>