<?php

namespace App\Modules\AdminUsers\Providers;

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
        $this->loadTranslationsFrom(module_path('adminUsers', 'Resources/Lang', 'app'), 'adminUsers');
        $this->loadViewsFrom(module_path('adminUsers', 'Resources/Views', 'app'), 'adminUsers');
        $this->loadMigrationsFrom(module_path('adminUsers', 'Database/Migrations', 'app'), 'adminUsers');
        $this->loadConfigsFrom(module_path('adminUsers', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminUsers', 'Database/Factories', 'app'));
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
