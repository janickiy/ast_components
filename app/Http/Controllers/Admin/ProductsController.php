<?php

namespace App\Http\Controllers\Admin;

use App\Models\Catalog;
use App\Repositories\CatalogRepository;
use App\Repositories\ProductsRepository;
use App\Services\ProductsService;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Http\Requests\Admin\Products\StoreRequest;
use Illuminate\Http\Request;
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
     * @param ProductsRepository $productRepository
     * @param ProductsService $productService
     * @param CatalogRepository $categoryRepository
     */
    public function __construct(ProductsRepository $productRepository, ProductsService $productService, CatalogRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->categoryRepository = $categoryRepository;
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
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('options', 'maxUploadFileSize'))->with('title', 'Добавление продукции');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $filename = $this->productService->storeFile($request);
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

        return redirect()->route('cp.products.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->productRepository->find($id);
        $options = Catalog::getOption();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('row', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование продукции');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $product = $this->productRepository->find($request->id);
            $filename = $this->productService->updateFile($product, $request);
            $fileNameToStore = 'origin_' . $filename;
            $thumbnailFileNameToStore = 'thumbnail_' . $filename;
        }

        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        $this->productRepository->update($request->id, array_merge($request->all(),[
            'published' => $published,
            'seo_sitemap' => $seo_sitemap,
            'thumbnail' => $thumbnailFileNameToStore ?? null,
            'origin' => $fileNameToStore ?? null,
        ]));

        return redirect()->route('cp.products.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        $this->productRepository->remove($request->id);
    }
}