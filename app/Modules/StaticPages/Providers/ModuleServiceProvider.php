<?php

namespace App\Modules\StaticPages\Providers;

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
        $this->loadTranslationsFrom(module_path('staticPages', 'Resources/Lang', 'app'), 'staticPages');
        $this->loadViewsFrom(module_path('staticPages', 'Resources/Views', 'app'), 'staticPages');
        $this->loadMigrationsFrom(module_path('staticPages', 'Database/Migrations', 'app'), 'staticPages');
        $this->loadConfigsFrom(module_path('staticPages', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('staticPages', 'Database/Factories', 'app'));
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
