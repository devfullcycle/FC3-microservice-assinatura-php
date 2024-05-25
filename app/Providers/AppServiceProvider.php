<?php

namespace App\Providers;

use App\Events\UserCreatedEvent;
use Core\User\Application\Interfaces\UserCreatedEventInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserCreatedEventInterface::class, UserCreatedEvent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
