<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Pages\EditRequest;
use App\Http\Requests\Admin\Pages\StoreRequest;
use App\Http\Requests\Admin\Pages\DeleteRequest;
use App\Repositories\PagesRepository;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PagesController extends Controller
{
    /**
     * @param PagesRepository $pageRepository
     */
    public function __construct(private PagesRepository $pageRepository)
    {
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

        return view('cp.pages.create_edit', compact('options'))->with('title', 'Добавление раздела');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        $main = 0;

        if ($request->input('main')) {
            $main = 1;
        }

        $this->pageRepository->create(array_merge(array_merge($request->all()), [
            'published' => $published,
            'seo_sitemap' => $seo_sitemap,
            'main' => $main,
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

        if (!$row) abort(404);

        $options = $this->pageRepository->getOption();

        return view('cp.pages.create_edit', compact('row', 'options'))->with('title', 'Редактирование раздела');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

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
            'published' => $published,
        ]));

        return redirect()->route('admin.pages.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->pageRepository->delete($request->id);
    }
}