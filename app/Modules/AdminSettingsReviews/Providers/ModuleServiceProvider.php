<?php

namespace App\Modules\AdminSettingsReviews\Providers;

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
        $this->loadTranslationsFrom(module_path('adminSettingsReviews', 'Resources/Lang', 'app'), 'adminSettingsReviews');
        $this->loadViewsFrom(module_path('adminSettingsReviews', 'Resources/Views', 'app'), 'adminSettingsReviews');
        $this->loadMigrationsFrom(module_path('adminSettingsReviews', 'Database/Migrations', 'app'), 'adminSettingsReviews');
        $this->loadConfigsFrom(module_path('adminSettingsReviews', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('adminSettingsReviews', 'Database/Factories', 'app'));
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
