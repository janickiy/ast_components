<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\OrderProductRepository;
use Illuminate\View\View;

class OrderProductController extends Controller
{
    /**
     * @param OrderProductRepository $orderProductRepository
     */
    public function __construct(private OrderProductRepository $orderProductRepository)
    {
        parent::__construct();
    }

    /**
     * @param int $order_id
     * @return View
     */
    public function index(int $order_id): View
    {
        $row = $this->orderProductRepository->find($order_id);

        if (!$row) abort(404);

        return view('cp.order_product.index', compact('order_id'))->with('title', 'Заказ: #' . $order_id);
    }
}