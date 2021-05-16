<?php

namespace App\Modules\AdminManagementSpecification\Providers;

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
        $this->loadTranslationsFrom(module_path('adminManagementSpecification', 'Resources/Lang', 'app'), 'adminManagementSpecification');
        $this->loadViewsFrom(module_path('adminManagementSpecification', 'Resources/Views', 'app'), 'adminManagementSpecification');
        $this->loadMigrationsFrom(module_path('adminManagementSpecification', 'Database/Migrations', 'app'), 'adminManagementSpecification');
        $this->loadConfigsFrom(module_path('adminManagementSpecification', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminManagementSpecification', 'Database/Factories', 'app'));
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
