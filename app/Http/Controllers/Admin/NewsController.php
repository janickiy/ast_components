<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\News\StoreRequest;
use App\Http\Requests\Admin\News\EditRequest;
use App\Helpers\StringHelper;
use App\Repositories\NewsRepository;
use App\Services\NewsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @var NewsRepository
     */
    private NewsRepository $newsRepository;
    /**
     * @var NewsService
     */
    private NewsService $newsService;

    /**
     * @param NewsRepository $newsRepository
     * @param NewsService $newsService
     */
    public function __construct(NewsRepository $newsRepository, NewsService $newsService)
    {
        $this->newsRepository = $newsRepository;
        $this->newsService = $newsService;
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.news.index')->with('title', 'Новости');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.news.create_edit', compact('maxUploadFileSize'))->with('title', 'Добавление новости');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $filename = $this->newsService->storeImage($request);
        }

        $this->newsRepository->create(array_merge(array_merge($request->all()), [
            'image' => $filename ?? null,
        ]));

        return redirect()->route('admin.news.index')->with('success', 'Данные успешно добавлены');

    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->newsRepository->find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.news.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование новости');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $news = $this->newsRepository->find($request->id);

        if ($request->hasFile('image')) {
            $filename = $this->newsService->updateImage($news, $request);
        }

        $this->newsRepository->update($request->id, array_merge(array_merge($request->all()), [
            'image' => $filename ?? null,
        ]));

        return redirect()->route('admin.news.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        $this->newsRepository->remove($request->id);
    }
}