<?php

namespace App\Modules\Home\Providers;

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
        $this->loadTranslationsFrom(module_path('home', 'Resources/Lang', 'app'), 'home');
        $this->loadViewsFrom(module_path('home', 'Resources/Views', 'app'), 'home');
        $this->loadMigrationsFrom(module_path('home', 'Database/Migrations', 'app'), 'home');
        $this->loadConfigsFrom(module_path('home', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('home', 'Database/Factories', 'app'));
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
