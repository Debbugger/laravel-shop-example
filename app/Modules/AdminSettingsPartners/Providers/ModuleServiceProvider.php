<?php

namespace App\Modules\AdminSettingsPartners\Providers;

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
        $this->loadTranslationsFrom(module_path('adminSettingsPartners', 'Resources/Lang', 'app'), 'adminSettingsPartners');
        $this->loadViewsFrom(module_path('adminSettingsPartners', 'Resources/Views', 'app'), 'adminSettingsPartners');
        $this->loadMigrationsFrom(module_path('adminSettingsPartners', 'Database/Migrations', 'app'), 'adminSettingsPartners');
        $this->loadConfigsFrom(module_path('adminSettingsPartners', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminSettingsPartners', 'Database/Factories', 'app'));
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
