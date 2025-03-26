<?php

namespace App\Providers;

use App\Interfaces\Repositories\ResumeRepositoryInterface;
use App\Repositories\ResumeRepository;
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
        $this->app->bind(
            ResumeRepositoryInterface::class,
            ResumeRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
