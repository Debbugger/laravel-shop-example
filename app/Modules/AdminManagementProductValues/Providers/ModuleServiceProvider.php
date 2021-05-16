<?php

namespace App\Modules\AdminManagementProductValues\Providers;

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
        $this->loadTranslationsFrom(module_path('adminManagementProductValues', 'Resources/Lang', 'app'), 'adminManagementProductValues');
        $this->loadViewsFrom(module_path('adminManagementProductValues', 'Resources/Views', 'app'), 'adminManagementProductValues');
        $this->loadMigrationsFrom(module_path('adminManagementProductValues', 'Database/Migrations', 'app'), 'adminManagementProductValues');
        $this->loadConfigsFrom(module_path('adminManagementProductValues', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminManagementProductValues', 'Database/Factories', 'app'));
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
