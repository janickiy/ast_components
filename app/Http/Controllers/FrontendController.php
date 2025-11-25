<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\Catalog;
use App\Models\Seo;
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
     * @param string $slug
     * @return View
     */
    public function page(string $slug): View
    {
        $page = Pages::where('slug', $slug)->published()->first();

        if (!$page) abort(404);

        $title = $page->title ?? 'Главная страница';
        $meta_description = $page->meta_description ?? '';
        $meta_keywords = $page->meta_keywords ?? '';
        $meta_title = $page->meta_title ?? '';
        $seo_url_canonical = $page->seo_url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
        $menu = $this->getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return view('frontend.page', compact(
                'page',
                'catalogs',
                'catalogsList',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'menu')
        )->with('title', $title);
    }

    /**
     * @return View
     */
    public function details(): View
    {
        $seo = Seo::where('type', 'frontend.details')->first();
        $title = $seo->h1 ?? 'Реквизиты компании';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
        $menu = $this->getMenuList();
        $catalogsList = $this->getCatalogsList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return view('frontend.details', compact(
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
        )->with('title', 'Реквизиты компании');
    }

    public function invite(): View
    {
        $seo = Seo::where('type', 'frontend.invite')->first();
        $title = $seo->h1 ?? 'Пригласить АСТ Компонентс к участию в тендере';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
        $menu = $this->getMenuList();
        $catalogsList = $this->getCatalogsList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return view('frontend.details', compact(
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
        )->with('title', 'Пригласить АСТ Компонентс к участию в тендере');
    }

    public function nomenclatureRequest(): View
    {
        $seo = Seo::where('type', 'frontend.invite')->first();
        $title = $seo->h1 ?? 'Запрос номенклатуры';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
        $menu = $this->getMenuList();
        $catalogsList = $this->getCatalogsList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return view('frontend.invite', compact(
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
        )->with('title', 'Запрос номенклатуры');
    }

    /**
     * @return View
     */
    public function news(): View
    {
        $seo = Seo::where('type', 'frontend.news')->first();
        $title = $seo->h1 ?? 'Запрос номенклатуры';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
        $menu = $this->getMenuList();
        $catalogsList = $this->getCatalogsList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return view('frontend.news', compact(
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
        )->with('title', 'Запрос номенклатуры');
    }

    /**
     * @param string $slug
     * @return View
     */
    public function showNews(string $slug): View
    {

    }

    public function contacts(): View
    {

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