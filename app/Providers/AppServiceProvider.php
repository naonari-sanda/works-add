<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Interfaces\JobInterface::class,
            \App\Repositories\Eloquents\JobRepository::class
        );

        $this->app->bind(
            \App\Services\Interfaces\LikeInterface::class,
            \App\Services\LikeService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // voyagerの設定
        Schema::defaultStringLength(191);
    }
}
