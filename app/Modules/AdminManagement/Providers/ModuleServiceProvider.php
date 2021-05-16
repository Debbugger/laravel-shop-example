<?php

namespace App\Modules\AdminManagement\Providers;

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
        $this->loadTranslationsFrom(module_path('adminManagement', 'Resources/Lang', 'app'), 'adminManagement');
        $this->loadViewsFrom(module_path('adminManagement', 'Resources/Views', 'app'), 'adminManagement');
        $this->loadMigrationsFrom(module_path('adminManagement', 'Database/Migrations', 'app'), 'adminManagement');
        $this->loadConfigsFrom(module_path('adminManagement', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminManagement', 'Database/Factories', 'app'));
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
