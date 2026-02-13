<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CatalogRepository;
use App\Http\Requests\Admin\Catalog\EditRequest;
use App\Http\Requests\Admin\Catalog\StoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;;

class CatalogController extends Controller
{
    public function __construct(private CatalogRepository $categoryRepository)
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {

        $catalogsList = $this->categoryRepository->getCatalogsList();

        return view('cp.catalog.index', compact('catalogsList'))->with('title', 'Каталог');
    }

    /**
     * @param int $parent_id
     * @return View
     */
    public function create(int $parent_id = 0): View
    {
        $options = $this->categoryRepository->getOptions();

        $row = $this->categoryRepository->find($parent_id);

        if (!$row) abort(404);

        $title = $parent_id > 0 ? 'Добавление подкатегории в категорию ' . $row->name:'Добавление категории';

        return view('cp.catalog.create_edit', compact('options', 'parent_id'))->with('title', $title);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            $this->categoryRepository->create(array_merge($request->all(), ['seo_sitemap' => $seo_sitemap]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.catalog.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->categoryRepository->find($id);

        if (!$row) abort(404);

        $options = $this->categoryRepository->getOptions();
        unset($options[$id]);
        $parent_id = $row->parent_id;

        return view('cp.catalog.create_edit', compact('row', 'parent_id', 'options'))->with('title', 'Редактирование категории');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            $this->categoryRepository->updateWithMapping($request->id, array_merge($request->all(), ['seo_sitemap' => $seo_sitemap]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.catalog.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param int $parent_id
     * @return RedirectResponse
     */
    public function destroy(int $parent_id): RedirectResponse
    {
        $this->categoryRepository->remove($parent_id);

        return redirect()->route('admin.catalog.index')->with('success', 'Данные успешно удалены!');
    }
}
