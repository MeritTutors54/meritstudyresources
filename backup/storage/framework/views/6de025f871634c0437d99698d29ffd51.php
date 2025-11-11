
<?php $__env->startSection('content'); ?>
<div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                                        </i>
                                    </div>
                                    <div>Company Information Update</div>
                                </div>
                                <div class="page-title-actions">
                                    <button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark">
                                        <i class="fa fa-star"></i>
                                    </button>
                                    <div class="d-inline-block dropdown">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-business-time fa-w-20"></i>
                                            </span>
                                            Buttons
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-inbox"></i>
                                                        <span>
                                                            Inbox
                                                        </span>
                                                        <div class="ml-auto badge badge-pill badge-secondary">86</div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-book"></i>
                                                        <span>
                                                            Book
                                                        </span>
                                                        <div class="ml-auto badge badge-pill badge-danger">5</div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-picture"></i>
                                                        <span>
                                                            Picture
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a disabled href="javascript:void(0);" class="nav-link disabled">
                                                        <i class="nav-link-icon lnr-file-empty"></i>
                                                        <span>
                                                            File Disabled
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>    
                                
                            </div>
                        </div>            
                     
                  
                      
                        <div class="row">
                          
                            <div class="col-md-10">
                                <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">Update CompanyInformation</h5>
                                        <div>
                                        <form action="<?php echo e(route('admin.companyinformation.update')); ?>" method="post" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                          <div class="position-relative form-group">
                                            <label for="fname">Company Name :</label>
                                            <input type="text" class="form-control" name="company_name" id="fname" placeholder="Company Name" value="<?php echo e($companyinformation->company_name); ?>">
                                            <input type="hidden" name="id" value="<?php echo e($companyinformation->id); ?>">
                                          </div>
                                          <br>
                                          <div class="position-relative form-group">
                                            <label for="fname">Company Motto :</label>
                                            <input type="text" class="form-control" name="company_motto" id="fname" placeholder="Company Motto" value="<?php echo e($companyinformation->company_motto); ?>">
                                        
                                          </div>
                                          <br>
                                          
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="lname">Mobile Number :</label>
                                            <input type="text" class="form-control" name="mobile" id="lname" placeholder="Mobile Number" value="<?php echo e($companyinformation->mobile); ?>">
                                          </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="uname">Email :</label>
                                            <input type="text" class="form-control" name="email" id="uname" placeholder="Email" value="<?php echo e($companyinformation->email); ?>">
                                          </div>
                                          <br>
                                            <div class="position-relative form-group">
                                            <label for="uname">Fax :</label>
                                            <input type="text" class="form-control" name="fax" id="uname" placeholder="Fax" value="<?php echo e($companyinformation->fax); ?>">
                                            </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="cname">Address :</label>
                                            <textarea class="form-control" name="address" placeholder="Address"><?php echo e($companyinformation->address); ?></textarea>
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
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\ResourceProject\resources\views/backend/companyinformation/index.blade.php ENDPATH**/ ?>