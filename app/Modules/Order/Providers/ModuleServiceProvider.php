<?php

namespace App\Modules\Order\Providers;

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
        $this->loadTranslationsFrom(module_path('order', 'Resources/Lang', 'app'), 'order');
        $this->loadViewsFrom(module_path('order', 'Resources/Views', 'app'), 'order');
        $this->loadMigrationsFrom(module_path('order', 'Database/Migrations', 'app'), 'order');
        $this->loadConfigsFrom(module_path('order', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('order', 'Database/Factories', 'app'));
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
