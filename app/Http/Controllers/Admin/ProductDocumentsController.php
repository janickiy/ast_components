<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\ProductDocuments\EditRequest;
use App\Http\Requests\Admin\ProductDocuments\StoreRequest;
use App\Http\Requests\Admin\ProductParameters\DeleteRequest;
use App\Repositories\ProductDocumentsRepository;
use App\Repositories\ProductsRepository;
use App\Services\ProductDocumentsService;
use App\Helpers\StringHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductDocumentsController extends Controller
{
    /**
     * @var ProductDocumentsRepository
     */
    private ProductDocumentsRepository $productDocumentsRepository;

    /**
     * @var ProductsRepository
     */
    private ProductsRepository $productsRepository;

    /**
     * @var ProductDocumentsService
     */
    private ProductDocumentsService $productDocumentsService;

    /**
     * @param ProductDocumentsRepository $productDocumentsRepository
     * @param ProductsRepository $productsRepository
     * @param ProductDocumentsService $productDocumentsService
     */
    public function __construct(ProductDocumentsRepository $productDocumentsRepository, ProductsRepository $productsRepository, ProductDocumentsService $productDocumentsService)
    {
        $this->productDocumentsRepository = $productDocumentsRepository;
        $this->productsRepository = $productsRepository;
        $this->productDocumentsService = $productDocumentsService;
        parent::__construct();
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $row = $this->productsRepository->find($product_id);

        if (!$row) abort(404);

        $breadcrumbs[] = ['url' => route('admin.products.index'), 'title' => 'Продукция'];

        return view('cp.product_documents.index', compact('product_id', 'breadcrumbs'))->with('title', 'Список документации: ' . $row->title);
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function create(int $product_id): View
    {
        $row = $this->productsRepository->find($product_id);

        if (!$row) abort(404);

        $breadcrumbs[] = ['url' => route('admin.products.index'), 'title' => 'Продукция'];
        $breadcrumbs[] = ['url' => route('admin.product_documents.index', ['product_id' => $product_id]), 'title' => $row->title];

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_documents.create_edit', compact('product_id', 'maxUploadFileSize', 'breadcrumbs'))->with('title', 'Добавление документации');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $filename = $this->productDocumentsService->storeFile($request);
        $this->productDocumentsRepository->create(array_merge($request->all(), ['file' => $filename]));

        return redirect()->route('admin.product_documents.index', ['product_id' => $request->product_id])->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->productDocumentsRepository->find($id);

        if (!$row) abort(404);

        $product_id = $row->product_id;
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        $breadcrumbs[] = ['url' => route('admin.products.index'), 'title' => 'Продукция'];
        $breadcrumbs[] = ['url' => route('admin.product_documents.index', ['product_id' => $row->product_id]), 'title' => $row->product->title];

        return view('cp.product_documents.create_edit', compact('row', 'product_id', 'maxUploadFileSize', 'breadcrumbs'))->with('title', 'Редактирование списка документации');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = $this->productDocumentsRepository->find($request->id);

        if ($request->hasFile('file')) {
            $filename = $this->productDocumentsService->storeFile($request);
        }

        $this->productDocumentsRepository->update($request->id, array_merge(array_merge($request->all()), [
            'file' => $filename ?? null,
        ]));

        return redirect()->route('admin.product_documents.index', ['product_id' => $row->product_id])->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->productDocumentsRepository->remove($request->id);
    }
}