<?php


use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Backend\AdminActivityLogController;
use App\Http\Controllers\Backend\AdminStuffController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Blog\BlogCategoryController;
use App\Http\Controllers\Backend\Blog\BlogsController;
use App\Http\Controllers\Backend\Blog\BlogTagsController;
use App\Http\Controllers\Backend\Coupon\CouponController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Ecommerce\BookCategoryController;
use App\Http\Controllers\Backend\Ecommerce\BookSubjectController;
use App\Http\Controllers\Backend\Ecommerce\BookVariantController;
use App\Http\Controllers\Backend\Ecommerce\DeliveryChargeController;
use App\Http\Controllers\Backend\Ecommerce\OrderController;
use App\Http\Controllers\Backend\Ecommerce\ProductController;
use App\Http\Controllers\Backend\PastPaper\CategoryController;
use App\Http\Controllers\Backend\PastPaper\ExamSeriesController;
use App\Http\Controllers\Backend\PastPaper\PastPaperController;
use App\Http\Controllers\Backend\PastPaper\ReSubCategoryController;
use App\Http\Controllers\Backend\PastPaper\SubCategoryController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\Policiy\PolicyController;
use App\Http\Controllers\Backend\Profile\ProfileController;
use App\Http\Controllers\Backend\SiteSettings\FaqController;
use App\Http\Controllers\Backend\SiteSettings\SeoController;
use App\Http\Controllers\Backend\SiteSettings\SettingsController;
use App\Http\Controllers\Backend\SiteSettings\SocialController;
use App\Http\Controllers\Backend\SiteSettings\TestimonialController;
use App\Http\Controllers\Backend\StudyMaterial\EducationLevelController;
use App\Http\Controllers\Backend\StudyMaterial\MeritResourceController;
use App\Http\Controllers\Backend\StudyMaterial\SubjectController;
use App\Http\Controllers\Backend\StudyMaterial\TopicController;
use App\Http\Controllers\Backend\SubscriptionPlanController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('admin.login')->middleware('user-access');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});


Route::prefix('admin')->middleware(['auth:admin', 'team.permission'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Admin Activity Tracking
    |--------------------------------------------------------------------------
    */
    Route::get('/activities', [AdminActivityLogController::class, 'index'])->name('admin.activity.index');

    /*
    |--------------------------------------------------------------------------
    | Site Settings
    |--------------------------------------------------------------------------
    */
    Route::get('/site-settings', [SettingsController::class, 'edit'])->name('admin.site.settings');
    Route::patch('/site-settings/{siteSettings}', [SettingsController::class, 'update'])->name('admin.site.settings.update');
    Route::resource('seo-settings', SeoController::class, ['as' => 'admin']);
    Route::resource('/policies', PolicyController::class, ['as' => 'admin']);
    Route::resource('/socials', SocialController::class, ['as' => 'admin']);
    Route::resource('/faqs', FaqController::class, ['as' => 'admin']);
    Route::resource('/testimonials', TestimonialController::class, ['as' => 'admin']);
    Route::get('/newsletter-emails', [SettingsController::class, 'newsletterEmails'])->name('admin.newsletter.emails');
    Route::get('/customer-inquiry', [SettingsController::class, 'customersInquiry'])->name('admin.customer.inquiry');

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */
    Route::get('/manage-permissions', [PermissionController::class, 'index'])->name('admin.permission.index');

    //AJAX
    Route::post('/get-permissions', [PermissionController::class, 'permissions'])->name('admin.permission.all');
    Route::post('/sync-permissions', [PermissionController::class, 'sync'])->name('admin.permission.sync');

    /*
    |--------------------------------------------------------------------------
    | Blog Section
    |--------------------------------------------------------------------------
    */
    Route::resource('/blog-categories', BlogCategoryController::class, ['as' => 'admin']);
    Route::resource('/blogs', BlogsController::class, ['as' => 'admin']);
    Route::post('/blogs/{blog}/comment/{comment}/reply', [BlogsController::class, 'reply'])
        ->name('admin.comment-reply');
    Route::get('/blogs/{blog}/comment/{comment}/approved', [BlogsController::class, 'approved'])
        ->name('admin.comment.approved');
    Route::get('/blogs/{blog}/comment/{comment}/rejected', [BlogsController::class, 'rejected'])
        ->name('admin.comment.rejected');

    Route::resource('/blog-tags', BlogTagsController::class, ['as' => 'admin']);

    /*
    |--------------------------------------------------------------------------
    | Profile Section
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.update');
    Route::post('/profile', [ProfileController::class, 'update']);


    /*
    |--------------------------------------------------------------------------
    | Past Paper Section
    |--------------------------------------------------------------------------
    */
    Route::resource('/past-papers', PastPaperController::class, ['as' => 'admin']);
    Route::resource('/categories', CategoryController::class, ['as' => 'admin']);
    Route::resource('/sub-categories', SubCategoryController::class, ['as' => 'admin']);
    Route::resource('/resub-categories', ResubCategoryController::class, ['as' => 'admin']);
    Route::resource('/exam-series', ExamSeriesController::class, ['as' => 'admin']);

    /*
    |--------------------------------------------------------------------------
    | Subscription Section
    |--------------------------------------------------------------------------
    */
    Route::resource('/subscription-plans', SubscriptionPlanController::class, ['as' => 'admin']);

    /*
    |--------------------------------------------------------------------------
    | Study Materials Section
    |--------------------------------------------------------------------------
    */
    Route::resource('/educational-levels', EducationLevelController::class, ['as' => 'admin']);
    Route::resource('/subjects', SubjectController::class, ['as' => 'admin']);
    Route::resource('/topics', TopicController::class, ['as' => 'admin']);
    Route::resource('/resources', MeritResourceController::class, ['as' => 'admin']);

    /*
    |--------------------------------------------------------------------------
    | Ecommerce Section
    |--------------------------------------------------------------------------
    */
    Route::resource('/delivery-charge', DeliveryChargeController::class, ['as' => 'admin']);

    // Shop Product
    Route::resource('/book-categories', BookCategoryController::class, ['as' => 'admin']);
    Route::resource('/book-subjects', BookSubjectController::class, ['as' => 'admin']);
    Route::resource('/book-variants', BookVariantController::class, ['as' => 'admin']);
    Route::resource('/products', ProductController::class, ['as' => 'admin']);

    Route::get('/manage-orders', [OrderController::class, 'index'])->name('admin.manage.order');
    Route::get('/manage-orders/{order}', [OrderController::class, 'details'])
        ->name('admin.manage.order.details');
    Route::post('/manage-orders/{order}/track/update', [OrderController::class, 'updateTrack'])
        ->name('admin.manage.order.update.track');

    /*
    |--------------------------------------------------------------------------
    | Coupon Section
    |--------------------------------------------------------------------------
    */
    Route::resource('/coupons', CouponController::class, ['as' => 'admin']);


    /*
    |--------------------------------------------------------------------------
    | Admin Stuff Section
    |--------------------------------------------------------------------------
    */
    Route::resource('/stuffs', AdminStuffController::class, ['as' => 'admin']);

    Route::get('/stuff/{stuff}/permissions', [AdminStuffController::class, 'permissions'])->name('admin.stuff.permissions');
    Route::patch('/stuff/{stuff}/permissions/update', [AdminStuffController::class, 'updatePermissions'])->name('admin.stuff.permissions.update');


    /*
    |--------------------------------------------------------------------------
    | Ajax Section
    |--------------------------------------------------------------------------
    */
    Route::post('/get-subjects', [AjaxController::class, 'getSubjects'])->name('admin.ajax.getSubjects');
//    Route::get('/getPastPaperData', [AjaxController::class, 'getPastPaper'])->name('admin.ajax.getPastPaper');
    Route::get('/get-sub-category/{category_id}', [AjaxController::class, 'getSubCategory'])->name('admin.ajax.getSubCategory');
    Route::get('/get-resub-category/{subcategory_id}/', [AjaxController::class, 'getReSubCategory'])->name('admin.ajax.getReSubCategory');
    Route::get('/users/data', [AjaxController::class, 'indexData'])->name('admin.ajax.getPastPaper');
});
