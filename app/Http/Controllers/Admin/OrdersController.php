<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Models\Orders;
use App\Services\OrdersService;
use App\Repositories\OrdersRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrdersController extends Controller
{
    /**
     * @var OrdersRepository
     */
    private OrdersRepository $ordersRepository;

    /**
     * @var OrdersService
     */
    private OrdersService $ordersService;

    /**
     * @param OrdersRepository $ordersRepository
     * @param OrdersService $ordersService
     */
    public function __construct(OrdersRepository $ordersRepository, OrdersService $ordersService)
    {
        $this->ordersRepository = $ordersRepository;
        $this->ordersService = $ordersService;
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.orders.index')->with('title', 'Заказы');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->ordersRepository->find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();
        $options = Orders::getOption();

        return view('cp.orders.edit', compact('row', 'maxUploadFileSize', 'options'))->with('title', 'Редактирование заказа');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = $this->ordersRepository->find($request->id);

        if ($request->hasFile('file')) {
            $filename = $this->ordersService->updateFile($row->id, $request);
        }

        $this->ordersRepository->update($request->id, array_merge(array_merge($request->all()), [
            'file' => $filename ?? null,
        ]));

        return redirect()->route('cp.orders.index')->with('success', 'Данные обновлены');
    }

}