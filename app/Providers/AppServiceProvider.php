<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Inertia::share([
            'auth_base' => [
                'user' => Auth::user() ? Auth::user()->only('id', 'name', 'email') : null,
                'can' => Auth::user() ? Auth::user()->getPermissionArray() : []
            ],
        ]);
    }
}
