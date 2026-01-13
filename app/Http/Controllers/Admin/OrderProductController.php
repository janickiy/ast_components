<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\OrderProductRepository;
use Illuminate\View\View;

class OrderProductController extends Controller
{
    /**
     * @var OrderProductRepository
     */
    private OrderProductRepository $orderProductRepository;

    /**
     * @param OrderProductRepository $orderProductRepository
     */
    public function __construct(OrderProductRepository $orderProductRepository)
    {
        $this->orderProductRepository = $orderProductRepository;
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