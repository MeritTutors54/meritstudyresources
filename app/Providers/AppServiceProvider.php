<?php

namespace App\Providers;

use App\Events\SubscribeEvent;
use App\Listeners\SendSubscriberEmailListener;
use App\Models\Cart;
use App\Models\SiteSettings;
use App\Models\Subject;
use App\Models\Subscription;
use App\Repositories\Interfaces\PastPaperRepositoryInterface;
use App\Repositories\PastPaperRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Social;
use App\Repositories\Interfaces\SubscriptionPlanRepositoryInterface;
use App\Repositories\SubscriptionPlanRepository;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PastPaperRepositoryInterface::class, PastPaperRepository::class);

        $this->app->bind(SubscriptionPlanRepositoryInterface::class, SubscriptionPlanRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            SubscribeEvent::class,
            SendSubscriberEmailListener::class
        );

        Cashier::useSubscriptionModel(Subscription::class);

        if ($this->app->runningInConsole()) {
            return;
        }

        $this->bootViewGlobals();
    }

    protected function bootViewGlobals(): void
    {
        // Lazy-load layout data only when views are actually rendered
        View::composer('*', function ($view) {
            $view->with('cartCount', Auth::check() ? Cart::query()->where('user_id', Auth::id())->count() : 0);
        });

        // Query database items once or pull from cache if preferred
        $settings = SiteSettings::query()->first();
        $socials = Social::all();
        $subjects = Subject::with('educationLevel')
            ->get()
            ->groupBy('name');

        View::share([
            'subject' => $subjects,
            'settings' => $settings,
            'socials' => $socials,
            'v' => Config::get('app.v'),
            'version' => Config::get('app.version'),
            'global_seo' => [
                'seo_title' => 'MeritStudyResource - meritstudyresource.co.uk',
                'seo_description' => 'Boost your exam results with Merit Study Resources! Access free GCSE, IGCSE, and A-Level past papers, revision notes, and worksheets instantly.',
                'seo_keywords' => 'GCSE past papers, IGCSE past papers, A-Level past papers, exam revision, revision notes, worksheets, free past papers',
                'seo_author' => 'Merit Study Resource',
            ]
        ]);
    }
}
