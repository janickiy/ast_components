<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\ProductParametersRepository;
use App\Repositories\ProductsRepository;
use App\Http\Requests\Admin\ProductParameters\EditRequest;
use App\Http\Requests\Admin\ProductParameters\StoreRequest;
use App\Http\Requests\Admin\ProductParameters\DeleteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductParametersController extends Controller
{
    /**
     * @var ProductParametersRepository
     */
    private ProductParametersRepository $productParametersRepository;

    /**
     * @var ProductsRepository
     */
    private ProductsRepository $productsRepository;

    /**
     * @param ProductParametersRepository $productParametersRepository
     * @param ProductsRepository $productsRepository
     */
    public function __construct(ProductParametersRepository $productParametersRepository, ProductsRepository $productsRepository)
    {
        $this->productParametersRepository = $productParametersRepository;
        $this->productsRepository = $productsRepository;
        parent::__construct();
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $product = $this->productsRepository->find($product_id);

        if (!$product) abort(404);

        $breadcrumbs[] = ['url' => route('admin.products.index'), 'title' => 'Продукция'];

        return view('cp.product_parameters.index', compact('product_id', 'breadcrumbs'))->with('title', 'Технические характеристики: ' . $product->title);
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
        $breadcrumbs[] = ['url' => route('admin.product_parameters.index', ['product_id' => $product_id]), 'title' => $row->product->title];

        return view('cp.product_parameters.create_edit', compact('product_id', 'breadcrumbs'))->with('title', 'Добавление параметра');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->productParametersRepository->create(array_merge($request->all(), ['category_id' => $request->category_id ?? 0]));;

        return redirect()->route('admin.product_parameters.index', ['product_id' => $request->product_id])->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->productParametersRepository->find($id);

        if (!$row) abort(404);

        $product_id = $row->product_id;

        $breadcrumbs[] = ['url' => route('admin.products.index'), 'title' => 'Продукция'];
        $breadcrumbs[] = ['url' => route('admin.product_parameters.index', ['product_id' => $product_id]), 'title' => $row->product->title];

        return view('cp.product_parameters.create_edit', compact('row', 'product_id', 'breadcrumbs'))->with('title', 'Редактирование параметра');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = $this->productParametersRepository->find($request->id);

        if (!$row) abort(404);

        $this->productParametersRepository->update($request->id, $request->all());

        return redirect()->route('admin.product_parameters.index', ['product_id' => $row->product_id])->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->productParametersRepository->delete($request->id);
    }
}