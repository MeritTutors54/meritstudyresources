
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
                <div>WorkSheet Uploads</div>
            </div>
            <div class="page-title-actions">
                <button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark">
                    <i class="fa fa-star"></i>
                </button>
                <div class="d-inline-block dropdown">
                    <a href="<?php echo e(route('admin.worksheet.index')); ?>" class="btn-shadow dropdown-toggle btn btn-info">   
                        ALL Work Sheet
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
                        <h5 class="card-title">Upload WorkSheet</h5>
                    <div>
                    <form action="<?php echo e(url('admin/worksheet/update')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Past Paper Title" required value="<?php echo e($edit->title); ?>">
                            <input type="hidden"  name="id" value="<?php echo e($edit->id); ?>">
                        </div>
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile" class="">SubTitle</label>
                            <input type="text" class="form-control" name="sub_title" placeholder="Enter Past Paper Title" required value="<?php echo e($edit->sub_title); ?>">
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">Subject</label>
                            <select class="form-control" name="subject_id" id="subject_id" onchange="getCategory(this)" required>
                                <option disabled selected>Select</option>
                                <?php $__currentLoopData = $allSubject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subject->id); ?>" <?php if($edit->subject_id==$subject->id): ?> selected <?php endif; ?>><?php echo e($subject->subject_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">Category</label>
                            <select class="form-control" name="category_id" id="category_id" onchange="getSubCategory(this)" required>
                                <option disabled selected>Select</option>
                                <?php
                                    $allCategory=App\Models\WorkSheetCategory::where('is_deleted',0)->where('is_active',1)->where('subject_id',$edit->subject_id)->get();
                                ?>
                                <?php $__currentLoopData = $allCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php if($category->id==$edit->category_id): ?> selected <?php endif; ?>><?php echo e($category->category_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </select>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">SubCategory</label>
                            <select class="form-control" name="subcategory_id" id="subcategory_id" onchange="getReSubCategory(this)" required>
                                <option disabled selected>Select</option>
                                <?php
                                $allSubCategory=App\Models\WorkSheetSubCategory::where('is_deleted',0)->where('is_active',1)->where('category_id',$edit->category_id)->get();
                            ?>
                            <?php $__currentLoopData = $allSubCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subcategory->id); ?>" <?php if($edit->subcategory_id==$subcategory->id): ?> selected <?php endif; ?>><?php echo e($subcategory->subcategory_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">ReSubCategory</label>
                            <select class="form-control" name="resubcategory_id" id="resubcategory_id" required>
                                <option disabled selected>Select</option>
                                <?php
                                $allReSubCategory=App\Models\WorkSheetReSubCategory::where('is_deleted',0)->where('is_active',1)->where('subcategory_id',$edit->subcategory_id)->get();
                            ?>
                            <?php $__currentLoopData = $allReSubCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resubcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($resubcategory->id); ?>" <?php if($edit->resubcategory_id==$resubcategory->id): ?> selected <?php endif; ?>><?php echo e($resubcategory->resubcategory_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          
                            </select>
                        </div>
                        <br>
                        <div class="position-relative form-group"><label for="exampleFile" class="">Option Code(Optional)</label>
                            <input type="text" class="form-control" name="option_code" placeholder="Enter Option Code" value="<?php echo e($edit->option_code); ?>" >
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter Description"><?php echo e($edit->description); ?></textarea>
                        </div>
                        <br>
                        <br>
                        <div class="position-relative form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="file_type" id="inlineRadio1" value="1" <?php if($edit->file_type==1): ?> checked <?php endif; ?>>
                                <label class="form-check-label" for="inlineRadio1">Question</label>
                            </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="file_type" id="inlineRadio2" value="0" <?php if($edit->file_type==0): ?> checked <?php endif; ?>>
                            <label class="form-check-label" for="inlineRadio2">Solution</label>
                          </div>
                        </div>
                        <div class="position-relative form-group">
                        <label for="cname"> File Paper (PDF File)</label><br>
                        <input type="file"  name="main_file"><br>

                        <a target="_blank" href="<?php echo e(asset('uploads/worksheet/mainfile/'.$edit->main_file)); ?>">Main File</a>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="cname"> Thumbnail Image </label><br>
                            <input type="file"  name="thumbnail_image"><br>
                            <a target="_blank" href="<?php echo e(asset('uploads/worksheet/thumbnail/'.$edit->thumbnail_image)); ?>">Thumbnail Image</a>
                            </div>
                            <br>
                        <div class="position-relative form-group">
                            <label for="cname">Page Number</label><br>
                            <input type="number"  name="page_number"  class="form-control" placeholder="Please Enter Page Number" value="<?php echo e($edit->page_number); ?>">
                        </div>
                         <br>


                        <div class="position-relative form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_paid" id="inlineRadio1" value="1" <?php if($edit->is_paid==1): ?> checked <?php endif; ?>>
                                <label class="form-check-label" for="inlineRadio1">Paid</label>
                            </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_paid" id="inlineRadio2" value="0" <?php if($edit->is_paid==0): ?> checked <?php endif; ?>>
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
    
         var subject_id=$("#subject_id").val();
        
         
           if(subject_id) {
              $.ajax({
                  url: "<?php echo e(url('get/admin/worksheet-category/')); ?>/"+subject_id,
                  type:"GET",
                  dataType:"json",
                  success:function(data) {
                    
                         $('#category_id').empty();
                         $('#category_id').append('<option selected disabled>Select</option>');
                         $.each(data,function(index,districtObj){
 
                          $('#category_id').append('<option value="' + districtObj.id + '">'+districtObj.category_name+'</option>');
                          
                        });
                             
                         
 
                      }
              });
          } else {
              alert('sorry data not found');
          }
         
         
         
     
    }
 </script>
 <script>
    function getSubCategory(el){
    
         var cate_id=$("#category_id").val();
        
         
           if(cate_id) {
              $.ajax({
                  url: "<?php echo e(url('get/admin/worksheet-subcategory/')); ?>/"+cate_id,
                  type:"GET",
                  dataType:"json",
                  success:function(data) {
                    
                         $('#subcategory_id').empty();
                         $('#subcategory_id').append('<option selected disabled>Select</option>');
                         $.each(data,function(index,districtObj){
 
                          $('#subcategory_id').append('<option value="' + districtObj.id + '">'+districtObj.subcategory_name+'</option>');
                          
                        });
                             
 
                      }
              });
          } else {
              alert('sorry data not found');
          }
         
         
         
     
    }
 </script>
  <script>
    function getReSubCategory(el){
    
         var subcate_id=$("#subcategory_id").val();
        
         
           if(subcate_id) {
              $.ajax({
                  url: "<?php echo e(url('get/admin/worksheet-resubcategory/')); ?>/"+subcate_id,
                  type:"GET",
                  dataType:"json",
                  success:function(data) {
                    
                         $('#resubcategory_id').empty();
                         $('#resubcategory_id').append('<option selected disabled>Select</option>');
                         $.each(data,function(index,districtObj){
 
                          $('#resubcategory_id').append('<option value="' + districtObj.id + '">'+districtObj.resubcategory_name+'</option>');
                          
                        });
                             
 
                      }
              });
          } else {
              alert('sorry data not found');
          }
         
         
         
     
    }
 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/worksheet/update.blade.php ENDPATH**/ ?>