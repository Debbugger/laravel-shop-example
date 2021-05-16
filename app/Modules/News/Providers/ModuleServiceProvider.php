<?php

namespace App\Modules\News\Providers;

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
        $this->loadTranslationsFrom(module_path('news', 'Resources/Lang', 'app'), 'news');
        $this->loadViewsFrom(module_path('news', 'Resources/Views', 'app'), 'news');
        $this->loadMigrationsFrom(module_path('news', 'Database/Migrations', 'app'), 'news');
        $this->loadConfigsFrom(module_path('news', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('news', 'Database/Factories', 'app'));
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
