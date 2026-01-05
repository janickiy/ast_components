<?php

namespace App\Helpers;

use Harimayco\Menu\Models\Menus;

class MenuHelper
{
    /**
     * @return array
     */
    public static function getMenuList(): array
    {
        $menu = [];
        $menu['top'] = Menus::where('name', 'top')->with('items')->first()?->items?->toArray();
        $menu['bottom-right'] = Menus::where('name', 'bottom-right')->with('items')->first()?->items?->toArray();
        $menu['bottom-left'] = Menus::where('name', 'bottom-left')->with('items')->first()?->items?->toArray();

        return $menu;
    }
}