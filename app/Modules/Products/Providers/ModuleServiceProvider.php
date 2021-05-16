<?php

namespace App\Modules\Products\Providers;

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
        $this->loadTranslationsFrom(module_path('products', 'Resources/Lang', 'app'), 'products');
        $this->loadViewsFrom(module_path('products', 'Resources/Views', 'app'), 'products');
        $this->loadMigrationsFrom(module_path('products', 'Database/Migrations', 'app'), 'products');
        $this->loadConfigsFrom(module_path('products', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('products', 'Database/Factories', 'app'));
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
