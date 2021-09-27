<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Telescope\TelescopeServiceProvider;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->afterResolving(EmailVerificationNotificationController::class, function ($controller) {
            $controller->middleware('throttle:verification');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        RateLimiter::for('verification', function (Request $request) {
            return Limit::perHour(2)->by($request->ip());
        });
        
        Paginator::useBootstrap();
    }
}
