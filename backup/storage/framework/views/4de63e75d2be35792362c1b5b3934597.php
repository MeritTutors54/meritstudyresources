
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
                <div>Resources Uploads</div>
            </div>
            <div class="page-title-actions">
              
                <div class="d-inline-block dropdown">
                    <a href="<?php echo e(url('/admin/merittutors-resources/index')); ?>" type="button" class="btn-shadow dropdown-toggle btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-business-time fa-w-20"></i>
                        </span>
                        ALL RESOURCES
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
                        <h5 class="card-title">Upload Resources</h5>
                    <div>
                    <form action="<?php echo e(url('/admin/merittutors-resources/create')); ?>" method="post" enctype="multipart/form-data">
                       
                        <div class="position-relative form-group"><label for="exampleFile" class="">Resource Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Resource Title" required>
                                <?php echo csrf_field(); ?>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="exampleFile" class="">Category</label>
                            <select class="form-control" name="category" onchange="getSubCategory(this)" id="category_id" required>
                                <option disabled selected>Select</option>
                                <?php $__currentLoopData = $allCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->category_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                        <label for="uname">Sub-Category</label>
                        <select class="form-control" name="subcategory" id="sub_category">
                            <option disabled selected>Select</option>
                          
                        </select>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                        <label for="uname">Year:</label>
                        <select class="form-control" name="year">
                            <option disabled selected>Select</option>
                            <?php $__currentLoopData = $allYear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($year->id); ?>"><?php echo e($year->year_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                            <label for="dob">Type:</label>
                            <select class="form-control" name="type">
                                <option disabled selected>Select</option>
                                <?php $__currentLoopData = $allType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>"><?php echo e($type->type_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                             <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_paid" id="inlineRadio1" value="1" onclick="ispaid(this)">
                                <label class="form-check-label" for="inlineRadio1">Paid</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_paid" id="inlineRadio2" value="0" checked onclick="ispaid(this)">
                                <label class="form-check-label" for="inlineRadio2">Free</label>
                              </div>
                        </div>
                        <br>
                        <div class="position-relative form-group" id="price_section" style="display: none">
                            <label for="exampleFile" class="">Price</label>
                            <input type="number" class="form-control" name="price" placeholder="Please Enter Price">
                        </div>
                        <br>
                        <div class="position-relative form-group">
                        <label for="cname">Description</label>
                        <textarea  class="form-control" name="description" id="summernote" placeholder="Please Enter Description" required></textarea>
                        </div>
                        <br>
                        
                        <div class="position-relative form-group">
                        <label for="cname">Thumbnail Image</label> <br>
                        <input type="file"  name="thumbnail_image" required>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                        <label for="cname">Demo PDF File</label><br>
                        <input type="file"  name="demo_pdf" required>
                        </div>
                        <br>
                        <div class="position-relative form-group">
                        <label for="cname">Main PDF File</label><br>
                        <input type="file" name="main_file" required>
                        </div>
                        <br>
                        <div class="input-group">
                            <button type="submit" class="mb-2 mr-2 btn btn-success">Create</button>
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
                  url: "<?php echo e(url('get/admin/merittutors-resources/subcategory/')); ?>/"+cate_id,
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

<script>
    $(document).ready(function() {
        $('#inlineRadio1').change(function() {
            if ($(this).is(':checked')) {
                $('#price_section').show();
            } 
        });

        $('#inlineRadio2').change(function() {
            if ($(this).is(':checked')) {
                $('#price_section').hide();
            } 
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/meritresource/create.blade.php ENDPATH**/ ?>