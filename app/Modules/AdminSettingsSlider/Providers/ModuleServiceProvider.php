<?php

namespace App\Modules\AdminSettingsSlider\Providers;

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
        $this->loadTranslationsFrom(module_path('adminSettingsSlider', 'Resources/Lang', 'app'), 'adminSettingsSlider');
        $this->loadViewsFrom(module_path('adminSettingsSlider', 'Resources/Views', 'app'), 'adminSettingsSlider');
        $this->loadMigrationsFrom(module_path('adminSettingsSlider', 'Database/Migrations', 'app'), 'adminSettingsSlider');
        $this->loadConfigsFrom(module_path('adminSettingsSlider', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminSettingsSlider', 'Database/Factories', 'app'));
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
