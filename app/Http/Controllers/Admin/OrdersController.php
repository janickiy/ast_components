<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Orders\EditRequest;
use App\Models\Orders;
use App\Services\OrdersService;
use App\Repositories\OrdersRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Enums\ComplaintStatus;

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
  //      dd(ComplaintStatus::Created->label());

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

        return view('cp.orders.edit', compact('row', 'maxUploadFileSize', 'options'))->with('title', 'Редактирование заказа: #' . $row->id);
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = $this->ordersRepository->find($request->id);

        if ($request->hasFile('invoice')) {
            $filename = $this->ordersService->updateFile($row, $request);
        }

        $this->ordersRepository->update($request->id, array_merge(array_merge($request->all()), [
            'invoice' => $filename ?? null,
        ]));

        return redirect()->route('admin.orders.index')->with('success', 'Данные обновлены');
    }

}