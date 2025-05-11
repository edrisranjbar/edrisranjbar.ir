<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Navbar;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        Paginator::useBootstrap();
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        } else {
            URL::forceScheme('http');
        }
        View::composer('*', function ($view) {
            $navbarItems = Navbar::orderBy('ordering')->get();
            $view->with('navbarItems', $navbarItems);
            $view->with('user', Auth::guard('user')?->user());
        });
    }
}
