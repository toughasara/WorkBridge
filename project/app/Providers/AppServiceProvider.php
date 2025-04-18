<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;

// Offres
use App\Interfaces\Repositories\OffreRepositoryInterface;
use App\Repositories\OffreRepository;
use App\Interfaces\Services\OffreServiceInterface;
use App\Services\OffreService;

// Resumes
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
        // Resumes
        $this->app->bind(
            ResumeRepositoryInterface::class,
            ResumeRepository::class
        );

        // Offres
        $this->app->bind(
            OffreRepositoryInterface::class,
            OffreRepository::class
        );
        
        $this->app->bind(
            OffreServiceInterface::class,
            OffreService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useTailwind();
    }
}
