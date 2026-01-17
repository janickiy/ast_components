<?php

namespace App\Providers;


use \App\Helpers\{
    PermissionsHelper,
    StringHelper,
    SettingsHelper,
    MoneyFormatterHelper,
};
use App\Contracts\Complaints\ComplaintServiceInterface;
use App\Contracts\Profile\ProfileServiceInterface;
use App\Services\Complaints\ComplaintService;
use App\Services\Profile\ProfileService;
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
        $loader->alias('PermissionsHelper', PermissionsHelper::class);
        $loader->alias('StringHelper', StringHelper::class);
        $loader->alias('SettingsHelper', SettingsHelper::class);
        $loader->alias('MoneyFormatterHelper', MoneyFormatterHelper::class);

        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
        $this->app->bind(ComplaintServiceInterface::class, ComplaintService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

