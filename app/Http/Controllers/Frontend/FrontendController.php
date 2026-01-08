<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\MenuHelper;
use App\Helpers\SettingsHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contacts\FeedbackRequest;
use App\Http\Requests\Frontend\Invite\SendRequest;
use App\Http\Requests\Frontend\NomenclatureRequest\SendNomenclatureRequest;
use App\Mail\InviteMailer;
use App\Mail\NomenclatureRequestMailer;
use App\Models\Catalog;
use App\Models\Feedback;
use App\Models\Manufacturers;
use App\Models\News;
use App\Models\Pages;
use App\Models\Products;
use App\Models\Seo;
use App\Repositories\ProductsRepository;
use App\Services\FeedbackService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use stdClass;

class FrontendController extends Controller
{
    public FeedbackService $feedbackService;

    /**
     * @var ProductsRepository
     */
    public ProductsRepository $productRepository;

    public function __construct(FeedbackService $feedbackService, ProductsRepository $productsRepository)
    {
        $this->feedbackService = $feedbackService;
        $this->productRepository = $productsRepository;
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

        $menu = MenuHelper::getMenuList();
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
     * Контент
     *
     * @param Request $request
     * @param string $slug
     * @return View
     */
    public function page(Request $request, string $slug): View
    {
        $page = Pages::where('slug', $slug)->published()->first();

        if (!$page) abort(404);

        $title = $page->title ?? 'Главная страница';
        $meta_description = $page->meta_description ?? '';
        $meta_keywords = $page->meta_keywords ?? '';
        $meta_title = $page->meta_title ?? '';
        $seo_url_canonical = $page->seo_url_canonical ?? '';
        $h1 = $page->seo_h1 ?? $title;
        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        if ($request->session()->has('productIds')) {
            $productIds = $request->session()->get('productIds');
        } else {
            $productIds = null;
        }

        return view('frontend.page', compact(
                'page',
                'catalogs',
                'catalogsList',
                'productIds',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'menu')
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

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();
        $options = Feedback::getPlatformList();

        return view('frontend.invite', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'options',
                'catalogs',
                'catalogsList',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', $title);
    }

    /**
     *
     *
     * @param SendRequest $request
     * @return RedirectResponse
     */
    public function sendInvite(SendRequest $request): RedirectResponse
    {
        try {
            $data = new stdClass();
            $data->name = $request->name;
            $data->company = $request->company;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->platform = $request->platform;
            $data->numb = $request->numb;
            $data->message = $request->message;

            $message = 'Номер извещения о закупочной процедуре: ' . $request->numb . '<br>Сообщение: ' . $request->message;

            Mail::to(explode(",", SettingsHelper::getInstance()->getValueForKey('EMAIL_NOTIFY')))->send(new InviteMailer($data));

            Feedback::create(array_merge($request->all(), [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $message,
                'type' => 1,
                'ip' => $request->ip()
            ]));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('frontend.invite')->with('success', 'Ваше приглашение успешно отправлено');
    }

    /**
     * Запрос номенклатуры
     *
     * @return View
     */
    public function nomenclatureRequest(): View
    {
        $seo = Seo::getSeo('frontend.invite', 'Запрос номенклатуры');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return view('frontend.nomenclature_request', compact(
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

    /**
     * @param SendNomenclatureRequest $request
     * @return RedirectResponse
     */
    public function sendNomenclatureRequest(SendNomenclatureRequest $request): RedirectResponse
    {
        try {
            $data = new stdClass();
            $data->name = $request->name;
            $data->company = $request->company;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->message = $request->message;

            if ($request->hasFile('attach')) {
                $filename = $this->feedbackService->storeFile($request);
            }

            $message = 'Маркировка: ' . $request->count . '<br>Количество: ' . $request->count . '<br>Ед.упаковки' . '<br><br>Комментарий: ' . $request->message;

            Mail::to(explode(",", SettingsHelper::getInstance()->getValueForKey('EMAIL_NOTIFY')))->send(new NomenclatureRequestMailer($data));

            Feedback::create(array_merge($request->all(), [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $message,
                'type' => 2,
                'ip' => $request->ip(),
                'attach' => $filename ?? null
            ]));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('frontend.invite')->with('success', 'Ваше приглашение успешно отправлено');
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

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();
        $news = News::orderBy('created_at')->published()->paginate(9);

        return view('frontend.news', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'news',
                'catalogs',
                'catalogsList',
                'h1',
                'seo_url_canonical',
                'title'
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

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();
        $lastNews = News::inRandomOrder()->published()->limit(3)->get();

        return view('frontend.news_item', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'catalogs',
                'catalogsList',
                'news',
                'lastNews',
                'breadcrumbs',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', $title);
    }

    public function contacts(): View
    {
        $seo = Seo::getSeo('frontend.contacts', 'Контакты');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return view('frontend.contacts', compact(
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

    /**
     * @param FeedbackRequest $request
     * @return RedirectResponse
     */
    public function sendFeedback(FeedbackRequest $request): RedirectResponse
    {
        try {
            $data = new stdClass();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->message = $request->message;

            Mail::to(explode(",", SettingsHelper::getInstance()->getValueForKey('EMAIL_NOTIFY')))->send(new NomenclatureRequestMailer($data));

            Feedback::create(array_merge($request->all(), [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
                'type' => 0,
                'ip' => $request->ip(),
                'attach' => $filename ?? null
            ]));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('frontend.invite')->with('success', 'Ваш запрос успешно отправлен');
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

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return view('frontend.converters', compact(
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

    /**
     * Список производителей
     *
     * @param Request $request
     * @return View
     */
    public function manufacturers(Request $request): View
    {
        $seo = Seo::getSeo('frontend.manufacturers', 'Производители');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();
        $manufacturers = Manufacturers::orderBy('title')->published()->get();

        if ($request->session()->has('productIds')) {
            $productIds = $request->session()->get('productIds');
        } else {
            $productIds = null;
        }

        return view('frontend.manufacturers', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'menu',
                'productIds',
                'catalogs',
                'catalogsList',
                'manufacturers',
                'title'
            )
        )->with('title', $title);
    }

    /**
     * Страница производителя
     *
     * @param Request $request
     * @param string $slug
     * @return View
     */
    public function manufacturer(Request $request, string $slug): View
    {
        $manufacturer = Manufacturers::where('slug', $slug)->published()->first();

        if (!$manufacturer) abort(404);

        $title = $manufacturer->title;
        $meta_description = $manufacturer->meta_description ?? '';
        $meta_keywords = $seo->meta_keywords ?? '';
        $meta_title = $manufacturer->meta_title ?? '';
        $seo_url_canonical = $manufacturer->seo_url_canonical ?? '';
        $h1 = $manufacturer->seo_h1 ?? $title;

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        $breadcrumbs[] = ['url' => route('frontend.manufacturers'), 'title' => 'Производители'];

        if ($request->session()->has('productIds')) {
            $productIds = $request->session()->get('productIds');
        } else {
            $productIds = null;
        }

        return view('frontend.manufacturer', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'productIds',
                'menu',
                'catalogs',
                'catalogsList',
                'manufacturer',
                'breadcrumbs',
                'h1',
                'seo_url_canonical',
                'title'
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

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();
        $manufacturers = Manufacturers::orderBy('title')->published()->get();

        $breadcrumbs = null;

        if ($slug) {
            $catalog = Catalog::where('slug', $slug)->first();

            if (!$catalog) abort(404);

            $products = $catalog->products()->paginate(10);

            $breadcrumbs[] = ['url' => route('frontend.catalog'), 'title' => 'Каталог'];

            $title = $catalog->name;
            $meta_description = $catalog->meta_description;
            $meta_keywords = $catalog->meta_keywords;
            $meta_title = $catalog->meta_title;
            $seo_url_canonical = $catalog->seo_url_canonical;
            $h1 = $catalog->seo_h1 ?? $title;
        } else {
            $products = Products::query()->paginate(10);
        }

        if ($request->session()->has('productIds')) {
            $productIds = $request->session()->get('productIds');
        } else {
            $productIds = null;
        }

        return view('frontend.catalog', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'products',
                'manufacturers',
                'productIds',
                'catalogs',
                'catalogsList',
                'breadcrumbs',
                'h1',
                'seo_url_canonical',
                'title'
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

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return view('frontend.conditions', compact(
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

        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        $breadcrumbs[] = ['url' => route('frontend.catalog'), 'title' => 'Каталог'];
        $breadcrumbs[] = ['url' => route('frontend.catalog', ['slug' => $product->catalog->slug]), 'title' => $product->catalog->name];

        $productIds = $this->productRepository->setViewed($request, $product->id);

        return view('frontend.product', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'product',
                'catalogs',
                'catalogsList',
                'productIds',
                'breadcrumbs',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', $title);
    }
}