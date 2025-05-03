<?php

namespace AccessibleResources;

use Illuminate\Support\ServiceProvider;
use AccessibleResources\Macros\AccessibleResourceMacro;

class AccessibleResourcesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        AccessibleResourceMacro::register();

        $this->publishes([
            __DIR__.'/config/accessible-resources.php' => config_path('accessible-resources.php'),
            __DIR__.'/database/migrations/2025_05_03_000000_create_resource_user_table.php' =>
                database_path('migrations/' . date('Y_m_d_His', time()) . '_create_resource_user_table.php'),
        ], 'accessible-resources');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/accessible-resources.php', 'accessible-resources');
    }
}
