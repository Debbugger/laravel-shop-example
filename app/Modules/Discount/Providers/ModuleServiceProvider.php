<?php

namespace App\Modules\Discount\Providers;

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
        $this->loadTranslationsFrom(module_path('discount', 'Resources/Lang', 'app'), 'discount');
        $this->loadViewsFrom(module_path('discount', 'Resources/Views', 'app'), 'discount');
        $this->loadMigrationsFrom(module_path('discount', 'Database/Migrations', 'app'), 'discount');
        $this->loadConfigsFrom(module_path('discount', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('discount', 'Database/Factories', 'app'));
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
