<?php

namespace App\Providers;

use App\Service\Cache\RedisCache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('redisCache', function ($app) {
            return new RedisCache(app("redis.connection"));
        });
    }
}
