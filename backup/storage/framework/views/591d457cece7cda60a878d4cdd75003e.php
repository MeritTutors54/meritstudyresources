
<?php $__env->startSection('content'); ?>
<?php
date_default_timezone_set("asia/dhaka");
$current = date("m/d/Y");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                        </i>
                    </div>
                    <div>Profile Update Change</div>
                </div>
                <div class="page-title-actions">


                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <form action="<?php echo e(route('admin.profileupdate.change')); ?>" method="POST" enctype='multipart/form-data'>
                <?php echo csrf_field(); ?>

                        <div class="card shadow-sm shadow-showcase">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Profile Update Content</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-right">
                                        <div class="form-group">
                                            <label for="fname">User Name: <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="user_name" placeholder="Enter User Name" value="<?php echo e($edit->user_name ?? ''); ?>"/>
                                            <?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div style="color:red"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <div class="form-group">
                                            <label for="fname">Name: <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name" value="<?php echo e($edit->name ?? ''); ?>"/>
                                            <?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div style="color:red"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <div class="form-group">
                                            <label for="fname">Email: <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                      <div class="col-md-8">
                                          <div class="form-group">
                                              <input type="text" class="form-control" name="email" placeholder="Enter Email" value="<?php echo e($edit->email ?? ''); ?>"/>
                                              <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                  <div style="color:red"><?php echo e($message); ?></div>
                                              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                          </div>
                                      </div>
                                      <div class="col-md-3 text-right">
                                          <div class="form-group">
                                              <label for="fname">Address:</label>
                                              <input type="hidden" name="id" value="<?php echo e($edit->id); ?>">
                                          </div>
                                      </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <textarea type="text" class="form-control" name="address"><?php echo e($edit->address); ?></textarea>
                                            </div>
                                        </div>
                                          <div class="col-md-3 text-right">
                                              <div class="form-group">
                                                  <label for="fname">Photo: </label>
                                              </div>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="form-group">
                                                  <input type="file" name="image"/>
                                              </div>
                                          </div>
                                          

                                        <div class="col-md-8 text-center">
                                                <img src="<?php echo e(asset('uploads/'.$edit->image)); ?>" height="45px" alt="">
                                        </div>
                                        <div class="col-md-8"></div>
                                        <div class="col-md-8 text-center mt-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success" name="button">Update</button>
                                            </div>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                            </form>
                          </div>
                       </div>
                    </div>
                  </div>
                </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/login/adminprofileupdate.blade.php ENDPATH**/ ?>