<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\DownloadController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\OrderHistoryController;
use App\Http\Controllers\Frontend\PastPaperController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ResourceController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\Frontend\SubscriptionController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\StripeWebhookController;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'team.permission'], function () {
    Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])
        ->name('forget.password.form');
    Route::post('/forget-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('/organize', [RegisterController::class, 'create'])->name('organize');
    Route::get('/verification', [RegisterController::class, 'verification'])->name('verification');

    Route::get('/', [FrontendController::class, 'home'])->name('home');
    // Route::get('/home2', [FrontendController::class, 'anotherHome'])->name('home');

    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
    Route::get('/blogs/{slug}', [BlogController::class, 'details'])->name('blogs.details');
    Route::post('/blogs/post-a-comment/{blog}', [BlogController::class, 'comment'])->name('blogs.comment.post');

    Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about-us');

    Route::get('/all-products', [ProductController::class, 'allProducts'])->name('products');
    Route::get('/get-product/{product_slug}', [ProductController::class, 'details'])
        ->name('single.product');

    Route::get('/pricing', [FrontendController::class, 'pricing'])->name('pricing');
    /*
    |--------------------------------------------------------------------------
    | Resource Section
    |--------------------------------------------------------------------------
    */
       Route::get('/search', [ResourceController::class, 'search'])->name('resource.search');
       Route::get('/all-resources/{educationLevelSlug?}',
           [ResourceController::class, 'educationalLevelResource'])->name('resource.category');
       Route::get('/all-resources/{educationLevelSlug}/{subjectSlug}/{groupSlug?}/{topicSlug?}/{subTopicSlug?}',
           [ResourceController::class, 'topicResource'])->name('resources.topic');
       Route::get('/get/{resource}/{resourceSlug}', [ResourceController::class, 'resourceDetails'])->name('resources.topic.details');
       Route::get('/get-product/{product_slug}', [ProductController::class, 'details'])
           ->name('single.product');
    /*
    |--------------------------------------------------------------------------
    | Past Paper Section
    |--------------------------------------------------------------------------
    */
    Route::get(
        '/past-papers/{categorySlug?}/{subcategorySlug?}/{resubSlug?}/{title?}',
        [PastPaperController::class, 'index']
    )->name('past.papers');
    Route::get('/pdf/view/{id}/{type}', [PastPaperController::class, 'viewPDF'])->name('pdf.view');
    Route::get('/pdf/{secret}', [PastPaperController::class, 'secretView'])->name('pdf.secret.view');

    Route::get('/contact', [FrontendController::class, 'contactUs'])->name('contact-us');
    Route::post('/contact', [App\Http\Controllers\Frontend\FrontendController::class, 'contactUsStore']);

    Route::get('/terms-and-conditions', [FrontendController::class, 'termsCondition'])->name('terms-condition');
    Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy.policy');
    Route::get('/refund-policy', [FrontendController::class, 'refundPolicy'])->name('refund.policy');
    Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
    //Route::post('/newsletter-subscribe', [FrontendController::class, 'newsletterSubscribe'])->name('newsletterSubscribe');

    Route::post('/collect-emails', [FrontendController::class, 'collectEmails'])->name('collect-emails');

    Route::get('/test-mail', function () {
        $user = User::query()->find(1);

        SendWelcomeEmail::dispatch($user);

        dd('mail sent');
    });

    /*
    |--------------------------------------------------------------------------
    | Auth Section
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth']], function () {

        Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/logout', [UserDashboardController::class, 'logout'])->name('user.logout');
        Route::get('/subscription-list', [UserDashboardController::class, 'subscriptionList'])->name('user.subscription.list');
        Route::get('/order-history', [OrderHistoryController::class, 'index'])->name('user.order.history');
        Route::get('/order-history/{invoice}', [OrderHistoryController::class, 'details'])->name('user.order.history.details');
        Route::get('/cancel-order/{order}', [OrderHistoryController::class, 'cancelOrder'])->name('user.cancel.order');


        /*
        |--------------------------------------------------------------------------
        | Subscription Section
        |--------------------------------------------------------------------------
        */
        Route::get('/checkout', [SubscriptionController::class, 'checkout'])->name('user.subscription.checkout');
        Route::post('/checkout', [SubscriptionController::class, 'subscribe']);
        Route::post('/pause-subscription/{subscription}', [SubscriptionController::class, 'pause'])->name('user.pause');
        Route::post('/cancel-subscription/{subscription}', [SubscriptionController::class, 'cancel'])->name('user.cancel');
        Route::post('/resume-subscription/{subscription}', [SubscriptionController::class, 'resume'])->name('user.resume');


        /*
        |--------------------------------------------------------------------------
        | Download Section
        |--------------------------------------------------------------------------
        */
        Route::post('/pdf/download', [DownloadController::class, 'downloadPDF'])
            ->name('user.ajax.download.pdf');

        /*
        |--------------------------------------------------------------------------
        | Dashboard Section
        |--------------------------------------------------------------------------
        */
        Route::get('/download/history', [UserDashboardController::class, 'history'])->name('user.download.history');
        Route::resource('users', UserController::class);

        Route::get('/users/{user}/permission', [UserController::class, 'permission'])->name('user.permission');
        Route::post('/users/{user}/permission', [UserController::class, 'updatePermission'])->name('user.permission.update');

        Route::post('/update/team', [UserDashboardController::class, 'updateTeam'])->name('user.update.team');

        /*
       |--------------------------------------------------------------------------
       | Cart Section
       |--------------------------------------------------------------------------
       */
        Route::get('/view-cart', [CartController::class, 'index'])->name('view.cart');
        Route::get('/order-checkout', [CheckoutController::class, 'checkout'])->name('user.order.checkout');

        /*
        |--------------------------------------------------------------------------
        | Order Section
        |--------------------------------------------------------------------------
        */
        Route::post('/order-payment', [OrderController::class, 'store'])->name('user.process.to.payment');
        Route::get('/complete-payment/{invoice}', [OrderController::class, 'payment'])
            ->name('user.complete.payment');
        Route::post('/complete-payment/{invoice}', [OrderController::class, 'complete']);
        Route::get('/return-payment', [OrderController::class, 'returnPayment'])->name('user.return.payment');


        /*
        |--------------------------------------------------------------------------
        | Profile Section
        |--------------------------------------------------------------------------
        */
        Route::get('/edit-profile', [UserDashboardController::class, 'editProfile'])->name('user.edit.profile');
        Route::get('/profile', [UserDashboardController::class, 'profile']);
        Route::post('/update-profile', [UserDashboardController::class, 'profileUpdate'])->name('user.profile.update');
        Route::post('/update-password', [UserDashboardController::class, 'profilePasswordUpdate'])->name('user.password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Ajax Section
    |--------------------------------------------------------------------------
    */
    Route::post('ajax/login', [AjaxController::class, 'login'])->name('ajax.login');
    Route::get('check-packs', [AjaxController::class, 'checkAllPacks'])->name('ajax.check.packs');
    Route::post('ajax/add-to-cart', [AjaxController::class, 'addToCart'])
        ->name('ajax.add.cart')->middleware('auth');
    Route::post('ajax/cart/item', [AjaxController::class, 'cartItem'])
        ->name('ajax.cart.item')->middleware('auth');
    Route::post('ajax/apply-coupon', [AjaxController::class, 'applyCoupon'])->name('ajax.apply.coupon')
        ->middleware('auth');

    Route::post('ajax/get-past-paper', [AjaxController::class, 'getPastPaper'])->name('ajax.get.past.paper');
});

/*
|--------------------------------------------------------------------------
| Sitemap Section
|--------------------------------------------------------------------------
*/
Route::get('/sitemap', function () {
    return to_route('sitemap.index');
});
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');

/*
|--------------------------------------------------------------------------
| Webhook Section
|--------------------------------------------------------------------------
*/
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

Route::get('/find-extention', [App\Http\Controllers\Frontend\FrontendController::class, 'findextention']);

/*
|--------------------------------------------------------------------------
| Socialite
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::post('/auth/final/callback', [SocialAuthController::class, 'finalCallback'])->name('google.final.callback');

require base_path('/routes/admin.web.php');
