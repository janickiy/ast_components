<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Orders\EditRequest;
use App\Models\Orders;
use App\Repositories\OrdersRepository;
use App\Services\OrdersService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrdersController extends Controller
{
    public function __construct(
        private readonly OrdersRepository $ordersRepository,
        private readonly OrdersService $ordersService,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.orders.index', [
            'title' => 'Заказы',
        ]);
    }

    public function edit(int $id): View
    {
        $row = $this->ordersRepository->find($id);

        abort_if($row === null, 404);

        return view('cp.orders.edit', [
            'row' => $row,
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'options' => Orders::getOption(),
            'title' => 'Редактирование заказа: #' . $row->id,
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $order = $this->ordersRepository->find((int) $request->id);

            abort_if($order === null, 404);

            $invoice = $order->invoice;

            if ($request->hasFile('invoice')) {
                $invoice = $this->ordersService->updateFile($order, $request);
            }

            $this->ordersRepository->updateWithMapping(
                (int) $request->id,
                ArrayData::from([
                    ...$request->validated(),
                    'invoice' => $invoice,
                ]),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Данные обновлены');
    }
}