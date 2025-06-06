<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        dd('AuthServiceProvider boot method executed!');
        // Gate for downloading reports (already exists)
        Gate::define('download-reports', function ($user) {
            return $user->role === 'admin' || $user->role === 'manager';
        });

        // Gate for managing users
        Gate::define('manage-users', function ($user) {
            return $user->role === 'admin';
        });
    }
}
