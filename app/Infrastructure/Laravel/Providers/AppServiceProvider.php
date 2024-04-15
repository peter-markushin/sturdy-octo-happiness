<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use App\Domain\Account\AccountRepository;
use App\Domain\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerTelescope();
        $this->registerIdeHelper();

        $this->app->bind(UserRepository::class, \App\Infrastructure\User\UserRepository::class);
        $this->app->bind(AccountRepository::class, \App\Infrastructure\Account\AccountRepository::class);
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

    /**
     * Conditionally register the telescope service provider
     */
    protected function registerTelescope(): void
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Conditionally register the telescope service provider
     */
    protected function registerIdeHelper(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
