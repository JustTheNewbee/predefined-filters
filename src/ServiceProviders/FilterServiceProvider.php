<?php

namespace Polyloans\Filter\ServiceProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Polyloans\Filter\Controllers\StoreFilterController;

class FilterServiceProvider extends EventServiceProvider
{
    protected $listen = [
        'Polyloans\Filter\Commands\*' => [
            DomainCommandsDispatcher::class,
        ],
    ];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        parent::boot();
        $this->loadRoutesFrom(__DIR__.'/..//Routes/Routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        include __DIR__.'/../Routes/Routes.php';
        $this->app->make(StoreFilterController::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
