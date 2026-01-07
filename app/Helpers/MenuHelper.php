<?php

namespace App\Helpers;

use Harimayco\Menu\Models\Menus;
use Illuminate\Support\Facades\Cache;

class MenuHelper
{
    /**
     * @return array
     */
    public static function getMenuList(): array
    {
        if (Cache::has('menu')) {
            return Cache::get('menu');
        } else {
            $menu = [];
            $menu['top'] = Menus::where('name', 'top')->with('items')->first()?->items?->toArray();
            $menu['bottom-right'] = Menus::where('name', 'bottom-right')->with('items')->first()?->items?->toArray();
            $menu['bottom-left'] = Menus::where('name', 'bottom-left')->with('items')->first()?->items?->toArray();

            Cache::put('menu', $menu);

            return $menu;
        }
    }
}