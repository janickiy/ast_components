<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('PermissionsHelper', \App\Helpers\PermissionsHelper::class);
        $loader->alias('StringHelper', \App\Helpers\StringHelper::class);
        $loader->alias('SettingsHelper', \App\Helpers\SettingsHelper::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

