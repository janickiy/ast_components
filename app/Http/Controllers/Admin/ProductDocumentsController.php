<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\ProductDocuments\DeleteRequest;
use App\Http\Requests\Admin\ProductDocuments\EditRequest;
use App\Http\Requests\Admin\ProductDocuments\StoreRequest;
use App\Repositories\ProductDocumentsRepository;
use App\Repositories\ProductsRepository;
use App\Services\ProductDocumentsService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductDocumentsController extends Controller
{
    public function __construct(
        private readonly ProductDocumentsRepository $productDocumentsRepository,
        private readonly ProductsRepository $productsRepository,
        private readonly ProductDocumentsService $productDocumentsService,
    ) {
        parent::__construct();
    }

    public function index(int $product_id): View
    {
        $product = $this->productsRepository->find($product_id);

        abort_if($product === null, 404);

        return view('cp.product_documents.index', [
            'product_id' => $product_id,
            'breadcrumbs' => [
                ['url' => route('admin.products.index'), 'title' => 'Продукция'],
            ],
            'title' => 'Список документации: ' . $product->title,
        ]);
    }

    public function create(int $product_id): View
    {
        $product = $this->productsRepository->find($product_id);

        abort_if($product === null, 404);

        return view('cp.product_documents.create_edit', [
            'product_id' => $product_id,
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'breadcrumbs' => [
                ['url' => route('admin.products.index'), 'title' => 'Продукция'],
                [
                    'url' => route('admin.product_documents.index', ['product_id' => $product_id]),
                    'title' => $product->title,
                ],
            ],
            'title' => 'Добавление документации',
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $filename = $this->productDocumentsService->storeFile($request);

            $this->productDocumentsRepository->create(
                ArrayData::from([
                    ...$request->validated(),
                    'file' => $filename,
                ]),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.product_documents.index', ['product_id' => $request->product_id])
            ->with('success', 'Информация успешно добавлена');
    }

    public function edit(int $id): View
    {
        $row = $this->productDocumentsRepository->find($id);

        abort_if($row === null, 404);

        return view('cp.product_documents.create_edit', [
            'row' => $row,
            'product_id' => $row->product_id,
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'breadcrumbs' => [
                ['url' => route('admin.products.index'), 'title' => 'Продукция'],
                [
                    'url' => route('admin.product_documents.index', ['product_id' => $row->product_id]),
                    'title' => $row->product->title,
                ],
            ],
            'title' => 'Редактирование списка документации',
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $row = $this->productDocumentsRepository->find((int) $request->id);

            abort_if($row === null, 404);

            $file = $row->file;

            if ($request->hasFile('file')) {
                $file = $this->productDocumentsService->updateFile($row->id, $request);
            }

            $this->productDocumentsRepository->updateWithMapping(
                (int) $request->id,
                ArrayData::from([
                    ...$request->validated(),
                    'file' => $file,
                ]),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.product_documents.index', ['product_id' => $row->product_id])
            ->with('success', 'Данные обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $row = $this->productDocumentsRepository->find((int) $request->id);

        abort_if($row === null, 404);

        $this->productDocumentsRepository->remove((int) $request->id);
    }
}