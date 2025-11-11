<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\User;
use App\Policies\PermissionPolicy;
use App\Policies\SchoolPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Admin::class => PermissionPolicy::class,
        User::class => SchoolPolicy::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //Allow super-admin role to bypass all the permissions
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}
