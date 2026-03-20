<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Http\Requests\Admin\ProductParameters\DeleteRequest;
use App\Http\Requests\Admin\ProductParameters\EditRequest;
use App\Http\Requests\Admin\ProductParameters\StoreRequest;
use App\Repositories\ProductParametersRepository;
use App\Repositories\ProductsRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductParametersController extends Controller
{
    public function __construct(
        private readonly ProductParametersRepository $productParametersRepository,
        private readonly ProductsRepository $productsRepository,
    ) {
        parent::__construct();
    }

    public function index(int $product_id): View
    {
        $product = $this->productsRepository->find($product_id);

        abort_if($product === null, 404);

        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'Продукция'],
        ];

        return view('cp.product_parameters.index', compact('product_id', 'breadcrumbs'))
            ->with('title', 'Технические характеристики: ' . $product->title);
    }

    public function create(int $product_id): View
    {
        $product = $this->productsRepository->find($product_id);

        abort_if($product === null, 404);

        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'Продукция'],
            ['url' => route('admin.product_parameters.index', ['product_id' => $product_id]), 'title' => $product->title],
        ];

        return view('cp.product_parameters.create_edit', compact('product_id', 'breadcrumbs'))
            ->with('title', 'Добавление параметра');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $this->productParametersRepository->create(
                ArrayData::from([
                    ...$request->validated(),
                    'category_id' => $request->category_id ?? 0,
                ]),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.product_parameters.index', ['product_id' => $request->product_id])
            ->with('success', 'Информация успешно добавлена');
    }

    public function edit(int $id): View
    {
        $row = $this->productParametersRepository->find($id);

        abort_if($row === null, 404);

        $product_id = $row->product_id;

        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'Продукция'],
            ['url' => route('admin.product_parameters.index', ['product_id' => $product_id]), 'title' => $row->product->title],
        ];

        return view('cp.product_parameters.create_edit', compact('row', 'product_id', 'breadcrumbs'))
            ->with('title', 'Редактирование параметра');
    }

    public function update(EditRequest $request): RedirectResponse
    {
        $row = $this->productParametersRepository->find($request->id);

        abort_if($row === null, 404);

        try {
            $this->productParametersRepository->updateWithMapping(
                $request->id,
                ArrayData::from($request->validated()),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.product_parameters.index', ['product_id' => $row->product_id])
            ->with('success', 'Данные обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->productParametersRepository->delete($request->id);
    }
}