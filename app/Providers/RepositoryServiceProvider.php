<?php

namespace App\Providers;

use App\Repositories\Eloquent\PlanRepository;
use App\Repositories\Eloquent\UserRepository;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
