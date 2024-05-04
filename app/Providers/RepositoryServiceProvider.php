<?php

namespace App\Providers;

use App\Repositories\Eloquent\PlanRepository;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PlanRepositoryInterface::class, PlanRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
