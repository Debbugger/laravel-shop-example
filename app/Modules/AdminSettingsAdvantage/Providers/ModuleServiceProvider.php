<?php

namespace App\Modules\AdminSettingsAdvantage\Providers;

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
        $this->loadTranslationsFrom(module_path('adminSettingsAdvantage', 'Resources/Lang', 'app'), 'adminSettingsAdvantage');
        $this->loadViewsFrom(module_path('adminSettingsAdvantage', 'Resources/Views', 'app'), 'adminSettingsAdvantage');
        $this->loadMigrationsFrom(module_path('adminSettingsAdvantage', 'Database/Migrations', 'app'), 'adminSettingsAdvantage');
        $this->loadConfigsFrom(module_path('adminSettingsAdvantage', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminSettingsAdvantage', 'Database/Factories', 'app'));
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
