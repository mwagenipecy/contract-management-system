<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Broadcasting\BeemSmsChannel;
use Illuminate\Notifications\ChannelManager;
use App\Http\Middleware\RequireOtpVerification;
use Illuminate\Support\Facades\Route;

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
        $this->app->make(ChannelManager::class)->extend('beem', function ($app) {
            return new BeemSmsChannel();
        });


        Route::aliasMiddleware('otp.required', RequireOtpVerification::class);

    
    }
}
