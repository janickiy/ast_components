<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Invites;
use App\Models\Manufacturers;
use App\Models\News;
use App\Models\Pages;
use App\Models\Products;
use App\Models\Seo;
use App\Repositories\NewsRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\CatalogRepository;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class FrontendController extends Controller
{
    /**
     * @param ProductsRepository $productRepository
     */
    public function __construct(
        private ProductsRepository $productRepository,
        private CatalogRepository $catalogRepository,
        private NewsRepository $newsRepository,
    )
    {
    }

    /**
     * Главная страница
     *
     * @return View
     */
    public function index(): View
    {
        $page = Pages::where('main', 1)->published()->first();

        if (!$page) abort(404);

        $title = $page->title ?? 'Главная';
        $meta_description = $page->meta_description ?? '';
        $meta_keywords = $page->meta_keywords ?? '';
        $meta_title = $page->meta_title ?? '';
        $seo_url_canonical = $page->seo_url_canonical ?? '';
        $h1 = $page->seo_h1 ?? $title;

        return view('frontend.page', compact(
                'page',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical')
        )->with('title', $title);
    }

    /**
     * Контент
     *
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
        $h1 = $page->seo_h1 ?? $title;

        $productIds = $this->productRepository->viewedProducts();

        return view('frontend.page', compact(
                'page',
                'productIds',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical')
        )->with('title', $title);
    }

    /**
     * Приглашение к участию в тендере
     *
     * @return View
     */
    public function invite(): View
    {
        $seo = Seo::getSeo('frontend.invite', 'Пригласить АСТ Компонентс к участию в тендере');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $options = Invites::getPlatformList();

        return view('frontend.invite', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'options',
                'h1',
                'seo_url_canonical'
            )
        )->with('title', $title);
    }

    /**
     * Список новостей
     *
     * @return View
     */
    public function news(): View
    {
        $seo = Seo::getSeo('frontend.news', 'Новости');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $news = News::orderBy('created_at')->published()->paginate(9);

        $newsBanner = $this->newsRepository->newsBanner();

        return view('frontend.news', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'news',
                'newsBanner',
                'h1',
                'seo_url_canonical'
            )
        )->with('title', $title);
    }

    /**
     * Страница новости
     *
     * @param string $slug
     * @return View
     */
    public function newsItem(string $slug): View
    {
        $news = News::where('slug', $slug)->published()->first();

        if (!$news) abort(404);

        $title = $news->title;
        $meta_description = $news->meta_description ?? '';
        $meta_keywords = $seo->meta_keywords ?? '';
        $meta_title = $news->meta_title ?? '';
        $seo_url_canonical = $news->seo_url_canonical ?? '';
        $h1 = $news->seo_h1 ?? $title;

        $breadcrumbs[] = ['url' => route('frontend.news'), 'title' => 'Новости'];
        $lastNews = $this->newsRepository->lastNews(3);

        return view('frontend.news_item', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'news',
                'lastNews',
                'breadcrumbs',
                'h1',
                'seo_url_canonical'
            )
        )->with('title', $title);
    }

    /**
     * @return View
     */
    public function converters(): View
    {
        $seo = Seo::getSeo('frontend.converters', 'Конвертеры');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        return view('frontend.converters', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical'
            )
        )->with('title', $title);
    }

    /**
     * Список производителей
     *
     * @return View
     */
    public function manufacturers(): View
    {
        $seo = Seo::getSeo('frontend.manufacturers', 'Производители');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $manufacturers = Manufacturers::orderBy('title')->published()->get();
        $productIds = $this->productRepository->viewedProducts();

        return view('frontend.manufacturers', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'productIds',
                'manufacturers'
            )
        )->with('title', $title);
    }

    /**
     * Страница производителя
     *
     * @param string $slug
     * @return View
     */
    public function manufacturer(string $slug): View
    {
        $manufacturer = Manufacturers::where('slug', $slug)->published()->first();

        if (!$manufacturer) abort(404);

        $title = $manufacturer->title;
        $meta_description = $manufacturer->meta_description ?? '';
        $meta_keywords = $seo->meta_keywords ?? '';
        $meta_title = $manufacturer->meta_title ?? '';
        $seo_url_canonical = $manufacturer->seo_url_canonical ?? '';
        $h1 = $manufacturer->seo_h1 ?? $title;

        $breadcrumbs[] = ['url' => route('frontend.manufacturers'), 'title' => 'Производители'];

        $productIds = $this->productRepository->viewedProducts();
        $otherCatalogs = $this->catalogRepository->getOtherCatalogs($manufacturer);

        return view('frontend.manufacturer', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'productIds',
                'otherCatalogs',
                'manufacturer',
                'breadcrumbs',
                'h1',
                'seo_url_canonical'
            )
        )->with('title', $title);
    }

    /**
     * Каталог
     *
     * @param Request $request
     * @param string|null $slug
     * @return View
     */
    public function catalog(Request $request, ?string $slug = null): View
    {
        $seo = Seo::getSeo('frontend.catalog', 'Каталог');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $manufacturers = Manufacturers::orderBy('title')->published()->get();
        $breadcrumbs = null;

        if ($slug) {
            $catalog = Catalog::where('slug', $slug)->first();

            if (!$catalog) abort(404);

            $products = $catalog->products()->orderBy('in_stock', 'desc')->orderBy('price')->paginate(10);
            $breadcrumbs[] = ['url' => route('frontend.catalog'), 'title' => 'Каталог'];

            $title = $catalog->name;
            $meta_description = $catalog->meta_description;
            $meta_keywords = $catalog->meta_keywords;
            $meta_title = $catalog->meta_title;
            $seo_url_canonical = $catalog->seo_url_canonical;
            $h1 = $catalog->seo_h1 ?? $title;
        } else {
            $search = $request->get('q');

            $q = Products::query()
                ->orderBy('in_stock', 'desc')
                ->orderBy('price');

            if ($search) {
                $q->where('title', 'LIKE', "%{$search}%");
                $q->orWhere('article', 'LIKE', "%{$search}%");
                $q->orWhere('n_number', 'LIKE', "%{$search}%");
            }

            $products = $q->paginate(10);
        }

        $productIds = $this->productRepository->viewedProducts();
        $cartItems = app(CartService::class)->items();

        return view('frontend.catalog.index', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'products',
                'manufacturers',
                'productIds',
                'breadcrumbs',
                'h1',
                'seo_url_canonical',
                'cartItems'
            )
        )->with('title', $title);
    }

    /**
     * Доставка и оплата
     *
     * @return View
     */
    public function conditions(): View
    {
        $seo = Seo::getSeo('frontend.conditions', 'Доставка и оплата');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        return view('frontend.conditions', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', $title);
    }

    /**
     * Карточка товара
     *
     * @param Request $request
     * @param string $slug
     * @return View
     */
    public function product(Request $request, string $slug): View
    {
        $product = Products::where('slug', $slug)->first();

        if (!$product) abort(404);

        $title = $product->title;
        $meta_description = $product->meta_description;
        $meta_keywords = $product->meta_keywords;
        $meta_title = $product->meta_title;
        $seo_url_canonical = $product->seo_url_canonical;
        $h1 = $product->seo_h1 ?? $title;

        $breadcrumbs[] = ['url' => route('frontend.catalog'), 'title' => 'Каталог'];
        $breadcrumbs[] = ['url' => route('frontend.catalog', ['slug' => $product->catalog->slug]), 'title' => $product->catalog->name];

        $productIds = $this->productRepository->setViewed($request, $product->id);
        $cartItems = app(\App\Services\CartService::class)->items();

        return view('frontend.product', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'product',
                'productIds',
                'breadcrumbs',
                'h1',
                'seo_url_canonical',
                'cartItems'
            )
        )->with('title', $title);
    }

    /**
     * @param int $parent_id
     * @return JsonResponse
     */
    public function subCatalogs(int $parent_id): JsonResponse
    {
        $catalogs = $this->catalogRepository->getCatalogsByParentId($parent_id);

        return response()->json([
            'html' => view('frontend.catalog.partials.sub-rows', [
                'catalogs' => $catalogs,
            ])->render(),
        ]);
    }
}