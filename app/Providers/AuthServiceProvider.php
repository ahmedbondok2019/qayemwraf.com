<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            if ($user instanceof \App\Models\Admin && $user->permission_group == 1) {
                return true;
            }
        });

        \Illuminate\Support\Facades\Gate::define('check-permission', function ($user, $permission) {
            if ($user instanceof \App\Models\Admin) {
                return $user->hasPermission($permission);
            }
            return false;
        });
    }
}
