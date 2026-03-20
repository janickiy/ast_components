<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Filters\ProductFilter;
use App\Models\Catalog;
use App\Models\Invites;
use App\Models\Manufacturers;
use App\Models\Pages;
use App\Models\Products;
use App\Models\Seo;
use App\Repositories\CatalogRepository;
use App\Repositories\ProductsRepository;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function __construct(
        private readonly ProductsRepository $productRepository,
        private readonly CatalogRepository $catalogRepository,
    ) {
    }

    public function index(): View
    {
        $page = Pages::where('main', 1)->published()->first();

        abort_if($page === null, 404);

        $title = $page->title ?? 'Главная';

        return view('frontend.page', [
            'page' => $page,
            'meta_description' => $page->meta_description ?? '',
            'meta_keywords' => $page->meta_keywords ?? '',
            'meta_title' => $page->meta_title ?? '',
            'h1' => $page->seo_h1 ?? $title,
            'seo_url_canonical' => $page->seo_url_canonical ?? '',
            'title' => $title,
        ]);
    }

    public function page(string $slug): View
    {
        $page = Pages::where('slug', $slug)->published()->first();

        abort_if($page === null, 404);

        $title = $page->title ?? 'Главная страница';

        return view('frontend.page', [
            'page' => $page,
            'productIds' => $this->productRepository->viewedProducts(),
            'meta_description' => $page->meta_description ?? '',
            'meta_keywords' => $page->meta_keywords ?? '',
            'meta_title' => $page->meta_title ?? '',
            'h1' => $page->seo_h1 ?? $title,
            'seo_url_canonical' => $page->seo_url_canonical ?? '',
            'title' => $title,
        ]);
    }

    public function invite(): View
    {
        $seo = Seo::getSeo('frontend.invite', 'Пригласить АСТ Компонентс к участию в тендере');

        return view('frontend.invite', [
            'meta_description' => $seo['meta_description'],
            'meta_keywords' => $seo['meta_keywords'],
            'meta_title' => $seo['meta_title'],
            'options' => Invites::getPlatformList(),
            'h1' => $seo['h1'],
            'seo_url_canonical' => $seo['seo_url_canonical'],
            'title' => $seo['title'],
        ]);
    }

    public function converters(): View
    {
        $seo = Seo::getSeo('frontend.converters', 'Конвертеры');

        return view('frontend.converters', [
            'meta_description' => $seo['meta_description'],
            'meta_keywords' => $seo['meta_keywords'],
            'meta_title' => $seo['meta_title'],
            'h1' => $seo['h1'],
            'seo_url_canonical' => $seo['seo_url_canonical'],
            'title' => $seo['title'],
        ]);
    }

    public function manufacturers(): View
    {
        $seo = Seo::getSeo('frontend.manufacturers', 'Производители');

        return view('frontend.manufacturers', [
            'meta_description' => $seo['meta_description'],
            'meta_keywords' => $seo['meta_keywords'],
            'meta_title' => $seo['meta_title'],
            'h1' => $seo['h1'],
            'seo_url_canonical' => $seo['seo_url_canonical'],
            'productIds' => $this->productRepository->viewedProducts(),
            'manufacturers' => Manufacturers::orderBy('title')->published()->get(),
            'title' => $seo['title'],
        ]);
    }

    public function manufacturer(string $slug): View
    {
        $manufacturer = Manufacturers::where('slug', $slug)->published()->first();

        abort_if($manufacturer === null, 404);

        $title = $manufacturer->title;

        return view('frontend.manufacturer', [
            'meta_description' => $manufacturer->meta_description ?? '',
            'meta_keywords' => $manufacturer->meta_keywords ?? '',
            'meta_title' => $manufacturer->meta_title ?? '',
            'productIds' => $this->productRepository->viewedProducts(),
            'otherCatalogs' => $this->catalogRepository->getOtherCatalogs($manufacturer),
            'manufacturer' => $manufacturer,
            'breadcrumbs' => [
                ['url' => route('frontend.manufacturers'), 'title' => 'Производители'],
            ],
            'h1' => $manufacturer->seo_h1 ?? $title,
            'seo_url_canonical' => $manufacturer->seo_url_canonical ?? '',
            'title' => $title,
        ]);
    }

    public function catalog(Request $request, ProductFilter $filter, ?string $slug = null): View
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

        if ($slug !== null) {
            $catalog = Catalog::where('slug', $slug)->first();

            abort_if($catalog === null, 404);

            $catalogIds = Catalog::getAllChildren($catalog->id);
            $catalogIds[] = $catalog->id;

            $filterCatalogs = $this->catalogRepository->getFilterCatalogs($catalog->id);
            $products = $this->productRepository->getProducts($request, $filter, 10, $catalogIds);
            $breadcrumbs = [
                ['url' => route('frontend.catalog'), 'title' => 'Каталог'],
            ];

            $title = $catalog->name;
            $meta_description = $catalog->meta_description;
            $meta_keywords = $catalog->meta_keywords;
            $meta_title = $catalog->meta_title;
            $seo_url_canonical = $catalog->seo_url_canonical;
            $h1 = $catalog->seo_h1 ?? $title;
        } else {
            $catalog = null;
            $catalogIds = null;
            $products = $this->productRepository->getProducts($request, $filter, 10);
            $filterCatalogs = $this->catalogRepository->getFilterCatalogs();
        }

        return view('frontend.catalog.index', [
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'meta_title' => $meta_title,
            'products' => $products,
            'manufacturers' => $manufacturers,
            'productIds' => $this->productRepository->viewedProducts(),
            'breadcrumbs' => $breadcrumbs,
            'catalogIds' => $catalogIds,
            'catalog' => $catalog,
            'inStockCount' => Products::getProductInStockCount($catalogIds),
            'underOrder' => Products::getProductUnderOrderCount($catalogIds),
            'filterCatalogs' => $filterCatalogs,
            'h1' => $h1,
            'seo_url_canonical' => $seo_url_canonical,
            'cartItems' => app(CartService::class)->items(),
            'title' => $title,
        ]);
    }

    public function conditions(): View
    {
        $seo = Seo::getSeo('frontend.conditions', 'Доставка и оплата');

        return view('frontend.conditions', [
            'meta_description' => $seo['meta_description'],
            'meta_keywords' => $seo['meta_keywords'],
            'meta_title' => $seo['meta_title'],
            'h1' => $seo['h1'],
            'seo_url_canonical' => $seo['seo_url_canonical'],
            'title' => $seo['title'],
        ]);
    }

    public function product(Request $request, string $slug): View
    {
        $product = Products::where('slug', $slug)->first();

        abort_if($product === null, 404);

        $title = $product->title;

        return view('frontend.product', [
            'meta_description' => $product->meta_description,
            'meta_keywords' => $product->meta_keywords,
            'meta_title' => $product->meta_title,
            'product' => $product,
            'productIds' => $this->productRepository->setViewed($request, $product->id),
            'breadcrumbs' => [
                ['url' => route('frontend.catalog'), 'title' => 'Каталог'],
                [
                    'url' => route('frontend.catalog', ['slug' => $product->catalog->slug]),
                    'title' => $product->catalog->name,
                ],
            ],
            'h1' => $product->seo_h1 ?? $title,
            'seo_url_canonical' => $product->seo_url_canonical,
            'cartItems' => app(CartService::class)->items(),
            'title' => $title,
        ]);
    }

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