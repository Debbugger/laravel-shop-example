<?php

namespace App\Modules\AdminSeo\Providers;

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
        $this->loadTranslationsFrom(module_path('adminSeo', 'Resources/Lang', 'app'), 'adminSeo');
        $this->loadViewsFrom(module_path('adminSeo', 'Resources/Views', 'app'), 'adminSeo');
        $this->loadMigrationsFrom(module_path('adminSeo', 'Database/Migrations', 'app'), 'adminSeo');
        $this->loadConfigsFrom(module_path('adminSeo', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminSeo', 'Database/Factories', 'app'));
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
