<?php

namespace App\Modules\AdminManagementCategory\Providers;

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
        $this->loadTranslationsFrom(module_path('adminManagementCategory', 'Resources/Lang', 'app'), 'adminManagementCategory');
        $this->loadViewsFrom(module_path('adminManagementCategory', 'Resources/Views', 'app'), 'adminManagementCategory');
        $this->loadMigrationsFrom(module_path('adminManagementCategory', 'Database/Migrations', 'app'), 'adminManagementCategory');
        $this->loadConfigsFrom(module_path('adminManagementCategory', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminManagementCategory', 'Database/Factories', 'app'));
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
