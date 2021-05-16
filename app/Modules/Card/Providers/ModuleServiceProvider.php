<?php

namespace App\Modules\Card\Providers;

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
        $this->loadTranslationsFrom(module_path('card', 'Resources/Lang', 'app'), 'card');
        $this->loadViewsFrom(module_path('card', 'Resources/Views', 'app'), 'card');
        $this->loadMigrationsFrom(module_path('card', 'Database/Migrations', 'app'), 'card');
        $this->loadConfigsFrom(module_path('card', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('card', 'Database/Factories', 'app'));
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
