<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Products\DeleteRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Repositories\CatalogRepository;
use App\Repositories\ManufacturerRepository;
use App\Repositories\ProductsRepository;
use App\Services\ProductsService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function __construct(
        private readonly ProductsRepository $productRepository,
        private readonly ProductsService $productService,
        private readonly CatalogRepository $categoryRepository,
        private readonly ManufacturerRepository $manufacturerRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.products.index', [
            'title' => 'Продукция',
        ]);
    }

    public function create(): View
    {
        return view('cp.products.create_edit', [
            'options' => $this->categoryRepository->getOptions(),
            'manufacturerOptions' => $this->manufacturerRepository->getOptions(),
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'title' => 'Добавление продукции',
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $origin = null;
            $thumbnail = null;

            if ($request->hasFile('image')) {
                $filename = $this->productService->storeImage($request);
                $origin = 'origin_' . $filename;
                $thumbnail = 'thumbnail_' . $filename;
            }

            $this->productRepository->create(
                ArrayData::from([
                    ...$request->validated(),
                    'thumbnail' => $thumbnail,
                    'origin' => $origin,
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
            ->route('admin.products.index')
            ->with('success', 'Информация успешно добавлена');
    }

    public function edit(int $id): View
    {
        $row = $this->productRepository->find($id);

        abort_if($row === null, 404);

        return view('cp.products.create_edit', [
            'row' => $row,
            'options' => $this->categoryRepository->getOptions(),
            'manufacturerOptions' => $this->manufacturerRepository->getOptions(),
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'title' => 'Редактирование продукции',
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $product = $this->productRepository->find($request->id);

            abort_if($product === null, 404);

            if ($request->hasFile('image')) {
                $this->productService->updateImage($request, $product);
            }

            $this->productRepository->updateWithMapping(
                $request->id,
                ArrayData::from([
                    ...$request->validated(),
                    'in_stock' => $request->boolean('in_stock'),
                    'under_order' => $request->boolean('under_order'),
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
            ->route('admin.products.index')
            ->with('success', 'Данные обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->productRepository->remove($request->id);
    }
}