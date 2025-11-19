<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Pages\EditRequest;
use App\Http\Requests\Admin\Pages\StoreRequest;
use App\Helpers\StringHelper;
use App\Repositories\PagesRepository;
use App\Services\PagesService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @var PagesRepository
     */
    private PagesRepository $pageRepository;
    /**
     * @var PagesService
     */
    private PagesService $pageService;

    /**
     * @param PagesRepository $pageRepository
     * @param PagesService $pageService
     */
    public function __construct(PagesRepository $pageRepository, PagesService $pageService)
    {
        $this->pageRepository = $pageRepository;
        $this->pageService = $pageService;
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.pages.index')->with('title', 'Страницы и разделы');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = $this->pageRepository->getOption();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.pages.create_edit', compact('options', 'maxUploadFileSize'))->with('title', 'Добавление раздела');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $originName = $this->pageService->storeImage($request);
        }

        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        $this->pageRepository->create(array_merge(array_merge($request->all()), [
            'image' => $originName ?? null,
            'published' => $published,
            'seo_sitemap' => $seo_sitemap,
        ]));

        return redirect()->route('admin.pages.index')->with('success', 'Данные успешно добавлены');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->pageRepository->find($id);
        $options = $this->pageRepository->getOption();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.pages.create_edit', compact('row', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование раздела');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = $this->pageRepository->find($request->input('id'));

        if ($request->hasFile('image')) {
            $originName = $this->pageService->updateImage($row, $request);
        }

        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        $row->published = $published;
        $main = 0;

        if ($request->input('main')) {
            $main = 1;
        }

        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        $this->pageRepository->update($request->id, array_merge($request->all(), [
            'main' => $main,
            'seo_sitemap' => $seo_sitemap,
            'image' => $originName ?? null,
            'published' => $published,
        ]));

        return redirect()->route('admin.pages.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        $this->pageRepository->remove($request->id);
    }
}