<?php

namespace App\Providers;

use App\Models\User;
use App\Services\MLMService;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        User::observe(UserObserver::class);
    }

    public function register()
    {
        $this->app->singleton(MLMService::class, function ($app) {
            return new MLMService();
        });
    }
}
