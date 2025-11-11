
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
                    <div>Password Change</div>
                </div>
                <div class="page-title-actions">


                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <form action="<?php echo e(route('admin.password.change')); ?>" method="POST" enctype='multipart/form-data'>
                <?php echo csrf_field(); ?>

                        <div class="card shadow-sm shadow-showcase">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Password Change Content</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-3 text-right">
                                        <div class="form-group">
                                            <label for="fname">Old Password: <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                      <div class="col-md-8">
                                          <div class="form-group">
                                              <input type="password" class="form-control" name="oldpass" placeholder="Old Password"/>
                                              <?php $__errorArgs = ['oldpass'];
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
                                              <label for="fname">New Password: <span style="color:red">*</span></label>
                                              <input type="hidden" name="id" value="<?php echo e(Auth::user()->id); ?>">
                                          </div>
                                      </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" placeholder="New Password"/>
                                                <?php $__errorArgs = ['password'];
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
                                                <label for="fname">Confirm Password: <span style="color:red">*</span></label>
                                            </div>
                                        </div>
                                          <div class="col-md-8">
                                              <div class="form-group">
                                                  <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"/>
                                                  <?php $__errorArgs = ['password_confirmation'];
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




                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-8 text-center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success" name="button">Change Password</button>
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

<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/login/passchange.blade.php ENDPATH**/ ?>