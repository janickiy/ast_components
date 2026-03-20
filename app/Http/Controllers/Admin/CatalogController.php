<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Http\Requests\Admin\Catalog\EditRequest;
use App\Http\Requests\Admin\Catalog\StoreRequest;
use App\Repositories\CatalogRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __construct(
        private readonly CatalogRepository $catalogRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        $catalogsList = $this->catalogRepository->getCatalogsList();

        return view('cp.catalog.index', compact('catalogsList'))
            ->with('title', 'Каталог');
    }

    public function create(int $parent_id = 0): View
    {
        $options = $this->catalogRepository->getOptions();
        $row = $this->catalogRepository->find($parent_id);

        abort_if($row === null, 404);

        $title = $parent_id > 0
            ? 'Добавление подкатегории в категорию ' . $row->name
            : 'Добавление категории';

        return view('cp.catalog.create_edit', compact('options', 'parent_id'))
            ->with('title', $title);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $this->catalogRepository->create($this->makeDto($request->validated(), $request->boolean('seo_sitemap')));
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.catalog.index')
            ->with('success', 'Информация успешно добавлена');
    }

    public function edit(int $id): View
    {
        $row = $this->catalogRepository->find($id);

        abort_if($row === null, 404);

        $options = $this->catalogRepository->getOptions();
        unset($options[$id]);

        $parent_id = $row->parent_id;

        return view('cp.catalog.create_edit', compact('row', 'parent_id', 'options'))
            ->with('title', 'Редактирование категории');
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->catalogRepository->updateWithMapping(
                $request->id,
                $this->makeDto($request->validated(), $request->boolean('seo_sitemap')),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.catalog.index')
            ->with('success', 'Данные обновлены');
    }

    public function destroy(int $parent_id): RedirectResponse
    {
        $this->catalogRepository->remove($parent_id);

        return redirect()
            ->route('admin.catalog.index')
            ->with('success', 'Данные успешно удалены!');
    }

    private function makeDto(array $validated, bool $seoSitemap): ArrayData
    {
        return ArrayData::from([
            ...$validated,
            'seo_sitemap' => $seoSitemap,
        ]);
    }
}