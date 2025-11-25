<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\Catalog;
use Illuminate\Contracts\View\View;
use Harimayco\Menu\Models\Menus;

class FrontendController extends Controller
{
    /**
     * Главная страница
     *
     * @return View
     */
    public function index(): View
    {


        $page = Pages::where('main', 1)->published()->first();

       // dd($page);


        if (!$page) abort(404);

        $title = $page->title ?? 'Главная';
        $meta_description = $page->meta_description ?? '';
        $meta_keywords = $page->meta_keywords ?? '';
        $meta_title = $page->meta_title ?? '';
        $seo_url_canonical = $page->seo_url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
        $menu = $this->getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();



        return view('frontend.index', compact(
                'catalogs',
                'catalogsList',
                'page',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'seo_url_canonical',
                'h1',
                'menu')
        )->with('title', $title);
    }

    /**
     * @return array
     */
    private function getMenuList(): array
    {
        $menu = [];

        $menu['top'] = Menus::where('name', 'top')->with('items')->first()?->items?->toArray();
        $menu['bottom-right'] = Menus::where('name', 'bottom-right')->with('items')->first()?->items?->toArray();
        $menu['bottom-left'] = Menus::where('name', 'bottom-left')->with('items')->first()?->items?->toArray();

        return $menu;
    }
}