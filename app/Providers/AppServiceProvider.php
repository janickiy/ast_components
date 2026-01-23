<?php

namespace App\Providers;


use App\Models\Products;
use App\Helpers\{MoneyFormatterHelper, PermissionsHelper, SettingsHelper, StringHelper,};
use App\Helpers\MenuHelper;
use App\Models\Catalog;
use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.frontend', function ($view){
            $view->with('catalogsList', Catalog::getCatalogList());
            $view->with('catalogs', Catalog::orderBy('name')->where('parent_id', 0)->get());
            $view->with('menu', MenuHelper::getMenuList());
            $view->with('cartCount', app(CartService::class)->totalQty());
            $view->with('productsSearch', Products::query()->get());
        });
    }
}

