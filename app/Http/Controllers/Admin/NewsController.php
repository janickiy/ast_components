<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\News\DeleteRequest;
use App\Http\Requests\Admin\News\EditRequest;
use App\Http\Requests\Admin\News\StoreRequest;
use App\Repositories\NewsRepository;
use App\Services\NewsService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct(
        private readonly NewsRepository $newsRepository,
        private readonly NewsService $newsService,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.news.index')
            ->with('title', 'Новости');
    }

    public function create(): View
    {
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.news.create_edit', compact('maxUploadFileSize'))
            ->with('title', 'Добавление новости');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $image = $request->hasFile('image')
                ? $this->newsService->storeImage($request)
                : null;

            $this->newsRepository->create(
                ArrayData::from([
                    ...$request->validated(),
                    'image' => $image,
                ]),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Данные успешно добавлены');
    }

    public function edit(int $id): View
    {
        $row = $this->newsRepository->find($id);

        abort_if($row === null, 404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.news.create_edit', compact('row', 'maxUploadFileSize'))
            ->with('title', 'Редактирование новости');
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $news = $this->newsRepository->find($request->id);

            abort_if($news === null, 404);

            $image = $news->image;

            if ($request->hasFile('image')) {
                $image = $this->newsService->updateImage($news, $request);
            }

            $this->newsRepository->updateWithMapping(
                $request->id,
                ArrayData::from([
                    ...$request->validated(),
                    'image' => $image,
                ]),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Данные успешно обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->newsRepository->remove($request->id);
    }
}