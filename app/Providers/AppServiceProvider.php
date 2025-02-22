<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\NewsHidden;
use App\Listeners\NewsHiddenListener;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class,],
        NewsHidden::class => [NewsHiddenListener::class,],
    ];
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
        //
    }
}
