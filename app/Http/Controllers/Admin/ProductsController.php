<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\CatalogRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\ManufacturerRepository;
use App\Services\ProductsService;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Http\Requests\Admin\Products\DeleteRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductsController extends Controller
{
    /**
     * @var ProductsRepository
     */
    private ProductsRepository $productRepository;

    /**
     * @var ProductsService
     */
    private ProductsService $productService;

    /**
     * @var CatalogRepository
     */
    private CatalogRepository $categoryRepository;

    /**
     * @var ManufacturerRepository
     */
    private ManufacturerRepository $manufacturerRepository;


    /**
     * @param ProductsRepository $productRepository
     * @param ProductsService $productService
     * @param CatalogRepository $categoryRepository
     * @param ManufacturerRepository $manufacturerRepository
     */
    public function __construct(ProductsRepository $productRepository, ProductsService $productService, CatalogRepository $categoryRepository, ManufacturerRepository $manufacturerRepository)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->categoryRepository = $categoryRepository;
        $this->manufacturerRepository = $manufacturerRepository;
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.products.index')->with('title', 'Продукция');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = $this->categoryRepository->getOptions();
        $manufacturerOptions = $this->manufacturerRepository->getOptions();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('options', 'manufacturerOptions', 'maxUploadFileSize'))->with('title', 'Добавление продукции');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $request->n_number = (int)$request->n_number;

        if ($request->hasFile('image')) {
            $filename = $this->productService->storeImage($request);
            $fileNameToStore = 'origin_' . $filename;
            $thumbnailFileNameToStore = 'thumbnail_' . $filename;
        }

        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        $this->productRepository->create(array_merge(array_merge($request->all()), [
            'thumbnail' => $thumbnailFileNameToStore ?? null,
            'origin' => $fileNameToStore ?? null,
            'seo_sitemap' => $seo_sitemap,
        ]));

        return redirect()->route('admin.products.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->productRepository->find($id);

        if (!$row) abort(404);

        $options = $this->categoryRepository->getOptions();
        $manufacturerOptions = $this->manufacturerRepository->getOptions();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('row', 'options', 'manufacturerOptions', 'maxUploadFileSize'))->with('title', 'Редактирование продукции');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $product = $this->productRepository->find($request->id);
            $this->productService->updateImage($request, $product);
        }

        $in_stock = 0;

        if ($request->input('in_stock')) {
            $in_stock = 1;
        }

        $under_order = 0;

        if ($request->input('under_order')) {
            $under_order = 1;
        }

        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        $this->productRepository->update($request->id, array_merge($request->all(),[
            'in_stock' => $in_stock,
            'under_order' => $under_order,
            'seo_sitemap' => $seo_sitemap,
        ]));

        return redirect()->route('admin.products.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->productRepository->remove($request->id);
    }
}