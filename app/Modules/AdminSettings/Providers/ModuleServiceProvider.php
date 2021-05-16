<?php

namespace App\Modules\AdminSettings\Providers;

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
        $this->loadTranslationsFrom(module_path('adminSettings', 'Resources/Lang', 'app'), 'adminSettings');
        $this->loadViewsFrom(module_path('adminSettings', 'Resources/Views', 'app'), 'adminSettings');
        $this->loadMigrationsFrom(module_path('adminSettings', 'Database/Migrations', 'app'), 'adminSettings');
        $this->loadConfigsFrom(module_path('adminSettings', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminSettings', 'Database/Factories', 'app'));
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
