<?php

namespace App\Modules\AdminManagementProduct\Providers;

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
        $this->loadTranslationsFrom(module_path('adminManagementProduct', 'Resources/Lang', 'app'), 'adminManagementProduct');
        $this->loadViewsFrom(module_path('adminManagementProduct', 'Resources/Views', 'app'), 'adminManagementProduct');
        $this->loadMigrationsFrom(module_path('adminManagementProduct', 'Database/Migrations', 'app'), 'adminManagementProduct');
        $this->loadConfigsFrom(module_path('adminManagementProduct', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminManagementProduct', 'Database/Factories', 'app'));
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
