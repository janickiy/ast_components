<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Repositories\OrderProductRepository;
use Illuminate\View\View;

class OrderProductController extends Controller
{
    public function __construct(
        private readonly OrderProductRepository $orderProductRepository,
    ) {
        parent::__construct();
    }

    public function index(int $order_id): View
    {
        $order = $this->orderProductRepository->find($order_id);

        abort_if($order === null, 404);

        return view('cp.order_product.index', compact('order_id'))
            ->with('title', 'Заказ: #' . $order_id);
    }
}