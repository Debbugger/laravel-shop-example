<?php

namespace App\Modules\AdminOrders\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('adminOrders', 'Resources/Lang', 'app'), 'adminOrders');
        $this->loadViewsFrom(module_path('adminOrders', 'Resources/Views', 'app'), 'adminOrders');
        $this->loadMigrationsFrom(module_path('adminOrders', 'Database/Migrations', 'app'), 'adminOrders');
        $this->loadConfigsFrom(module_path('adminOrders', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminOrders', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
