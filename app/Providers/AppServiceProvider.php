<?php

namespace App\Providers;

use App\Enums\SEOPage;
use App\Enums\Status;
use App\Enums\UserType;
use App\Events\SubscribeEvent;
use App\Listeners\NewSubscriberListener;
use App\Listeners\SendSubscriberEmailListener;
use App\Models\Cart;
use App\Models\EducationLevel;
use App\Models\SiteSettings;
use App\Models\Subject;
use App\Models\Subscription;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Models\CompanyInformation;
use App\Models\Logo;
use App\Models\Seo;
use App\Models\Social;
use App\Models\Category;
use Laravel\Cashier\Cashier;
use Spatie\Permission\PermissionRegistrar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $v = Config::get('app.v');

        Event::listen(
            SubscribeEvent::class,
            SendSubscriberEmailListener::class
        );

        if ($this->app->runningInConsole()) {
            return;
        }

        Cashier::useSubscriptionModel(Subscription::class);

        $version = Config::get('app.version');

        $settings = SiteSettings::query()->first();

        $socials = Social::query()->get();

        $subjects = Subject::query()
            ->with('educationLevel')
            ->get()
            ->groupBy(function ($item) {
                return $item->name;
            })
            ->toArray();

//        dd($subjects['English'][0]['education_level']['name']);

//        $educationLevels = EducationLevel::query()
//            ->with('allSubjects')
//            ->where('status', Status::ACTIVE->value)
//            ->get()->groupBy(function ($item) {
//                dd($item);
//            });

//        dd($educationLevels);

        view()->composer('*', function ($view) {
            static $shared = false;
            if (!$shared) {
                $cartCount = 0;
                if (Auth::check()) {
                    $user = Auth::user();
                    if (isset($user->type)) {
                        $cartCount = Cart::query()
                            ->where('user_id', $user->id)
                            ->count();
                    }
                }
                $view->with('cartCount', $cartCount);
                $shared = true;
            }
        });

        view()->share([
            'allResource' => $subjects ?? null,
            'settings' => $settings,
//            'defaultSEO' => $defaultSEO,
            'socials' => $socials,
            'v' => $v
        ]);
        view()->share('version', $version);
    }
}
