<?php

namespace App\Modules\Review\Providers;

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
        $this->loadTranslationsFrom(module_path('review', 'Resources/Lang', 'app'), 'review');
        $this->loadViewsFrom(module_path('review', 'Resources/Views', 'app'), 'review');
        $this->loadMigrationsFrom(module_path('review', 'Database/Migrations', 'app'), 'review');
        $this->loadConfigsFrom(module_path('review', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('review', 'Database/Factories', 'app'));
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
