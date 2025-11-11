
<?php $__env->startSection('content'); ?>

<div class="rbt-overlay-page-wrapper">
    <div class="breadcrumb-image-container breadcrumb-style-max-width">
        <div class="breadcrumb-image-wrapper">
            <div class="breadcrumb-dark">
                <img src="<?php echo e(asset('frontend')); ?>/assets/images/bg/bg-image-10.jpg" alt="Education Images">
            </div>
        </div>
        <div class="breadcrumb-content-top text-center">
            <ul class="meta-list justify-content-center mb--10">
                <li class="list-item">
                    <div class="author-thumbnail">
                        <img src="<?php echo e(asset('frontend')); ?>/assets/images/testimonial/client-06.png" alt="blog-image">
                    </div>
                    <div class="author-info">
                        <a href="#"><strong>Post By Merit Hub</strong></a>
                    </div>
                </li>
                <li class="list-item">
                    <i class="feather-clock"></i>
                    <span><?php echo e($data->created_at->format('d M Y')); ?>

                    </span>
                </li>
            </ul>
            <h1 class="title"><?php echo e($data->title); ?></h1>
            
        </div>
    </div>

    <div class="rbt-blog-details-area rbt-section-gapBottom breadcrumb-style-max-width">
        <div class="blog-content-wrapper rbt-article-content-wrapper">
            <div class="content">
                <div class="post-thumbnail mb--30 position-relative wp-block-image alignwide">
                    <figure>
                        <img src="<?php echo e(asset('uploads/blogs/'.$data->image)); ?>" alt="Blog Images">
                        
                    </figure>
                </div>
                <div class="wp-block-gallery columns-3 is-cropped">
                    <?php echo $data->details; ?>

                </div>
                <?php
                // Assuming $tags is the comma-separated string of tags
                        $tagsArray = explode(',', $data->tags);
                ?>
            
                <!-- BLog Tag Clound  -->
                <div class="tagcloud">
                    <?php $__currentLoopData = $tagsArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="#"><?php echo e(trim($tag)); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   
                </div>

                <!-- Social Share Block  -->
                <div class="social-share-block">
                    
                    <ul class="social-icon social-default transparent-with-border">
                        <li><a href="https://www.facebook.com/">
                                <i class="feather-facebook"></i>
                            </a>
                        </li>
                        <li><a href="https://www.twitter.com">
                                <i class="feather-twitter"></i>
                            </a>
                        </li>
                        <li><a href="https://www.instagram.com/">
                                <i class="feather-instagram"></i>
                            </a>
                        </li>
                        <li><a href="https://www.linkdin.com/">
                                <i class="feather-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>


                <!-- Blog Author  -->
               

                


            </div>
            <div class="related-post pt--60">
                <div class="section-title text-start mb--40">
                    <span class="subtitle bg-primary-opacity">Related Post</span>
                    <h4 class="title">Similar Post</h4>
                </div>
                <?php $__currentLoopData = $allRelatedPost; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- Start Single Card  -->
                <div class="rbt-card card-list variation-02 rbt-hover mt--30">
                    <div class="rbt-card-img">
                        <a href="<?php echo e(url('blog-details/'.$rPost->slug)); ?>">
                            <img src="<?php echo e(asset('uploads/blogs/'.$rPost->image)); ?>" alt="Card image"> </a>
                    </div>
                    <div class="rbt-card-body">
                        <h5 class="rbt-card-title"><a href="<?php echo e(url('blog-details/'.$rPost->slug)); ?>"><?php echo e($rPost->title); ?></a>
                        </h5>
                        <div class="rbt-card-bottom">
                            <a class="transparent-button" href="<?php echo e(url('blog-details/'.$rPost->slug)); ?>">Read
                                Article<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg">
                                        <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                            <path d="M10.614 0l5.629 5.629-5.63 5.629" />
                                            <path stroke-linecap="square" d="M.663 5.572h14.594" />
                                        </g>
                                    </svg></i></a>
                        </div>
                    </div>
                </div>
          
                   
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merithub.co.uk/public_html/core/resources/views/frontend/blogs/details.blade.php ENDPATH**/ ?>