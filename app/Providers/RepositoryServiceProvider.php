<?php

namespace App\Providers;

use App\Repositories\Eloquent\PlanCostRepository;
use App\Repositories\Eloquent\PlanRepository;
use App\Repositories\Eloquent\SubscriptionTransactionRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\UserSubscriptionRepository;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;
use Core\SubscriptionTransaction\Domain\Repositories\SubscriptionTransactionInterface;
use Core\User\Domain\Repositories\UserRepositoryInterface;
use Core\UserSubscription\Domain\Repositories\UserSubscriptionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PlanCostRepositoryInterface::class, PlanCostRepository::class);
        $this->app->singleton(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(UserSubscriptionRepositoryInterface::class, UserSubscriptionRepository::class);
        $this->app->singleton(SubscriptionTransactionInterface::class, SubscriptionTransactionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
