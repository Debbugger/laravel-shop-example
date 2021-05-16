<?php

namespace App\Modules\AdminGraph\Providers;

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
        $this->loadTranslationsFrom(module_path('adminGraph', 'Resources/Lang', 'app'), 'adminGraph');
        $this->loadViewsFrom(module_path('adminGraph', 'Resources/Views', 'app'), 'adminGraph');
        $this->loadMigrationsFrom(module_path('adminGraph', 'Database/Migrations', 'app'), 'adminGraph');
        $this->loadConfigsFrom(module_path('adminGraph', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminGraph', 'Database/Factories', 'app'));
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
