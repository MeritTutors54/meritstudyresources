
<?php $__env->startSection('content'); ?>
<div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-display1 icon-gradient bg-premium-dark">
                                        </i>
                                    </div>
                                    <div>Seo Update</div>
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
                            <div class="col-md-2"></div>
                            <div class="col-md-6">
                                <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">Update Seo</h5>
                                        <div>
                                        <form action="<?php echo e(route('admin.seo.update')); ?>" method="post" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                          <div class="position-relative form-group"><label for="exampleFile" class="">Meta Title</label>
                                          <input type="text" class="form-control" name="meta_title" placeholder="Meta Title" value="<?php echo e($seo->meta_title); ?>">
                                             <input type="hidden" name="id" value="<?php echo e($seo->id); ?>">
                                          </div>
                                            <br>
                                            <div class="position-relative form-group"><label for="exampleFile" class="">Meta Author</label>
                                                <input type="text" class="form-control" name="meta_author" placeholder="Meta Author" value="<?php echo e($seo->meta_author); ?>">
                                          </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="uname">Meta Keyword :</label>
                                            <input type="text" class="form-control" data-role="tagsinput" name="meta_keyword" placeholder="" value="<?php echo e($seo->meta_keyword); ?>">
                                          </div>
                                          <br>
                                            <div class="position-relative form-group">
                                            <label for="uname">Meta Description :</label>
                                            <input type="text" class="form-control" name="meta_description" id="uname" placeholder="Meta Description" value="<?php echo e($seo->meta_description); ?>">
                                            </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="cname">Google Verification :</label>
                                            <input type="text" class="form-control" name="google_verification" id="uname" placeholder="Google Verification" value="<?php echo e($seo->google_verification); ?>">
                                            </div>
                                            <br>
                                            <div class="position-relative form-group">
                                                <label for="dob">Bing Verification :</label>
                                                <input type="text" class="form-control" name="bing_verification" id="uname" placeholder="Bing Verification" value="<?php echo e($seo->bing_verification); ?>">
                                            </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="dob">Google Analytics :</label>
                                            <input type="text" class="form-control" name="google_analytics" id="uname" placeholder="Google Analytics" value="<?php echo e($seo->google_analytics); ?>">
                                            </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="dob">Alexa Analytics :</label>
                                            <input type="text" class="form-control" name="alexa_analytics" id="uname" placeholder="Alexa Analytics" value="<?php echo e($seo->alexa_analytics); ?>">
                                            </div>
                                            <br>
                                            <div class="position-relative form-group">
                                            <label for="dob">Facebook Pixel :</label>
                                            <input type="text" class="form-control" name="facebook_pixel" id="uname" placeholder="Facebook Pixel" value="<?php echo e($seo->facebook_pixel); ?>">
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
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\MeritTutorsProjectUpdate\ResourceProject\resources\views/backend/seo/index.blade.php ENDPATH**/ ?>