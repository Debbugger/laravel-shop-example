<?php

namespace App\Modules\AdminDiscount\Providers;

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
        $this->loadTranslationsFrom(module_path('adminDiscount', 'Resources/Lang', 'app'), 'adminDiscount');
        $this->loadViewsFrom(module_path('adminDiscount', 'Resources/Views', 'app'), 'adminDiscount');
        $this->loadMigrationsFrom(module_path('adminDiscount', 'Database/Migrations', 'app'), 'adminDiscount');
        $this->loadConfigsFrom(module_path('adminDiscount', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminDiscount', 'Database/Factories', 'app'));
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
