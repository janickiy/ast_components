<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Seo;
use App\Repositories\NewsRepository;
use Illuminate\Contracts\View\View;

class NewsController extends Controller
{
    public function __construct(
        private readonly NewsRepository $newsRepository,
    ) {
    }

    public function index(): View
    {
        $seo = Seo::getSeo('frontend.news', 'Новости');

        return view('frontend.news.index', [
            'meta_description' => $seo['meta_description'],
            'meta_keywords' => $seo['meta_keywords'],
            'meta_title' => $seo['meta_title'],
            'news' => News::orderBy('created_at')->published()->paginate(9),
            'newsBanner' => $this->newsRepository->newsBanner(),
            'h1' => $seo['h1'],
            'seo_url_canonical' => $seo['seo_url_canonical'],
            'title' => $seo['title'],
        ]);
    }

    public function item(string $slug): View
    {
        $news = News::where('slug', $slug)->published()->first();

        abort_if($news === null, 404);

        $title = $news->title;

        return view('frontend.news.news_item', [
            'meta_description' => $news->meta_description ?? '',
            'meta_keywords' => $news->meta_keywords ?? '',
            'meta_title' => $news->meta_title ?? '',
            'news' => $news,
            'lastNews' => $this->newsRepository->lastNews(3),
            'breadcrumbs' => [
                ['url' => route('frontend.news'), 'title' => 'Новости'],
            ],
            'h1' => $news->seo_h1 ?? $title,
            'seo_url_canonical' => $news->seo_url_canonical ?? '',
            'title' => $title,
        ]);
    }
}