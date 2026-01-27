<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Seo;
use App\Repositories\NewsRepository;
use Illuminate\Contracts\View\View;

class NewsController extends Controller
{
    public function __construct(
        private NewsRepository $newsRepository,
    )
    {
    }

    /**
     * Список новостей
     *
     * @return View
     */
    public function index(): View
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

        return view('frontend.news.index', compact(
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
    public function item(string $slug): View
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

        return view('frontend.news.news_item', compact(
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
}