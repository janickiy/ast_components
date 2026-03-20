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
        private readonly CatalogRepository $categoryRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.catalog.index', [
            'catalogsList' => $this->categoryRepository->getCatalogsList(),
            'title' => 'Каталог',
        ]);
    }

    public function create(int $parent_id = 0): View
    {
        $options = $this->categoryRepository->getOptions();

        if ($parent_id > 0) {
            $row = $this->categoryRepository->find($parent_id);

            abort_if($row === null, 404);

            $title = 'Добавление подкатегории в категорию ' . $row->name;
        } else {
            $title = 'Добавление категории';
        }

        return view('cp.catalog.create_edit', [
            'options' => $options,
            'parent_id' => $parent_id,
            'title' => $title,
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $this->categoryRepository->create(
                ArrayData::from([
                    ...$request->validated(),
                    'seo_sitemap' => $request->boolean('seo_sitemap'),
                ]),
            );
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
        $row = $this->categoryRepository->find($id);

        abort_if($row === null, 404);

        $options = $this->categoryRepository->getOptions();
        unset($options[$id]);

        return view('cp.catalog.create_edit', [
            'row' => $row,
            'parent_id' => $row->parent_id,
            'options' => $options,
            'title' => 'Редактирование категории',
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->categoryRepository->updateWithMapping(
                $request->id,
                ArrayData::from([
                    ...$request->validated(),
                    'seo_sitemap' => $request->boolean('seo_sitemap'),
                ]),
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

    public function destroy(int $parent_id): void
    {
        $this->categoryRepository->remove($parent_id);
    }
}