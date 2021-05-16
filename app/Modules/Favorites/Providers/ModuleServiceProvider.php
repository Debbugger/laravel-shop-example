<?php

namespace App\Modules\Favorites\Providers;

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
        $this->loadTranslationsFrom(module_path('favorites', 'Resources/Lang', 'app'), 'favorites');
        $this->loadViewsFrom(module_path('favorites', 'Resources/Views', 'app'), 'favorites');
        $this->loadMigrationsFrom(module_path('favorites', 'Database/Migrations', 'app'), 'favorites');
        $this->loadConfigsFrom(module_path('favorites', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('favorites', 'Database/Factories', 'app'));
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
