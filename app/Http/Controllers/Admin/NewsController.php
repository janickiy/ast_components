<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\News\StoreRequest;
use App\Http\Requests\Admin\News\EditRequest;
use App\Http\Requests\Admin\News\DeleteRequest;
use App\Helpers\StringHelper;
use App\Repositories\NewsRepository;
use App\Services\NewsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class NewsController extends Controller
{
    /**
     * @param NewsRepository $newsRepository
     * @param NewsService $newsService
     */
    public function __construct(private NewsRepository $newsRepository, private NewsService $newsService)
    {
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
        try {
            if ($request->hasFile('image')) {
                $filename = $this->newsService->storeImage($request);
            }

            $this->newsRepository->create(array_merge(array_merge($request->all()), [
                'image' => $filename ?? null,
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

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
        try {
            $news = $this->newsRepository->find($request->id);

            if ($request->hasFile('image')) {
                $filename = $this->newsService->updateImage($news, $request);
            }

            $this->newsRepository->updateWithMapping($request->id, array_merge(array_merge($request->all()), [
                'image' => $filename ?? null,
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.news.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->newsRepository->remove($request->id);
    }
}