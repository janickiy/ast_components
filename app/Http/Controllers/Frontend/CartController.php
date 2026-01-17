<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\MenuHelper;
use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Seo;
use Illuminate\Contracts\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $seo = Seo::getSeo('frontend.cart', 'Корзина');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return view('frontend.cart', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'catalogs',
                'catalogsList',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', $title);
    }
}