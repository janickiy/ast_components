<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\CatalogRepository;
use App\Http\Requests\Admin\Catalog\EditRequest;
use App\Http\Requests\Admin\Catalog\StoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * @var CatalogRepository
     */
    private CatalogRepository $categoryRepository;

    /**
     * @param CatalogRepository $categoryRepository
     */
    public function __construct(CatalogRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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

        return view('cp.catalog.create_edit', compact('options', 'parent_id'))->with('title', 'Добавление категории');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        $this->categoryRepository->create(array_merge($request->all(), ['seo_sitemap' => $seo_sitemap]));

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
        $parent_id = $row->parent_id;
        unset($options[$id]);

        return view('cp.catalog.create_edit', compact('row', 'parent_id', 'options'))->with('title', 'Редактирование категории');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        $this->categoryRepository->update($request->id, array_merge($request->all(), ['seo_sitemap' => $seo_sitemap]));

        return redirect()->route('admin.catalog.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        $this->categoryRepository->delete($request->id);
    }
}
