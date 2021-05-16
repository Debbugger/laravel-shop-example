<?php

namespace App\Modules\AdminNews\Providers;

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
        $this->loadTranslationsFrom(module_path('adminNews', 'Resources/Lang', 'app'), 'adminNews');
        $this->loadViewsFrom(module_path('adminNews', 'Resources/Views', 'app'), 'adminNews');
        $this->loadMigrationsFrom(module_path('adminNews', 'Database/Migrations', 'app'), 'adminNews');
        $this->loadConfigsFrom(module_path('adminNews', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminNews', 'Database/Factories', 'app'));
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
