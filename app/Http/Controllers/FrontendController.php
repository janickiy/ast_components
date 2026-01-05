<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Manufacturers;
use App\Models\Feedback;
use App\Models\Pages;
use App\Models\Catalog;
use App\Models\Seo;
use App\Models\News;
use App\Mail\InviteMailer;
use App\Mail\NomenclatureRequestMailer;
use App\Services\FeedbackService;
use App\Helpers\SettingsHelper;
use App\Helpers\MenuHelper;
use App\Http\Requests\Frontend\Invite\SendRequest;
use App\Http\Requests\Frontend\NomenclatureRequest\SendNomenclatureRequest;
use App\Http\Requests\Frontend\Contacts\FeedbackRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public FeedbackService $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
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
        $h1 = $seo->h1 ?? $title;
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
        $h1 = $seo->h1 ?? $title;
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
        $seo = Seo::where('type', 'frontend.invite')->first();
        $title = $seo->h1 ?? 'Пригласить АСТ Компонентс к участию в тендере';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
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
        $seo = Seo::where('type', 'frontend.invite')->first();
        $title = $seo->h1 ?? 'Запрос номенклатуры';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
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
        $seo = Seo::where('type', 'frontend.news')->first();
        $title = $seo->h1 ?? 'Новости';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
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
        $h1 = $manufacturer->seo_h1 ?? $title;
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
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', $title);
    }

    public function contacts(): View
    {
        $seo = Seo::where('type', 'frontend.contacts')->first();
        $title = $seo->h1 ?? 'Контакты';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
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
        $seo = Seo::where('type', 'frontend.converters')->first();
        $title = $seo->h1 ?? 'Конвертеры';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
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
        $seo = Seo::where('type', 'frontend.manufacturers')->first();
        $title = $seo->h1 ?? 'Производители';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
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
                'menu',
                'productIds',
                'catalogs',
                'catalogsList',
                'manufacturers',
                'h1',
                'seo_url_canonical',
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
        $seo = Seo::where('type', 'frontend.catalog')->first();
        $title = $seo->h1 ?? 'Каталог';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

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
                'productIds',
                'catalogs',
                'catalogsList',
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
        $seo = Seo::where('type', 'frontend.conditions')->first();
        $title = $seo->h1 ?? 'Доставка и оплата';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;
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

    public function getSubcategory()
    {

    }
}