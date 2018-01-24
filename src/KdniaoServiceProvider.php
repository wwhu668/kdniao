<?php

namespace Wwhu\Kdniao;

use Illuminate\Support\ServiceProvider;

class KdniaoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'config/kdniao.php' => config_path('kdniao.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('kdniao', function () {
            return new Kdniao();
        });
    }
}
