<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customers;
use Illuminate\View\View;

class CustomerLogsController extends Controller
{
    /**
     * @param int $customer_id
     * @return View
     */
    public function __invoke(int $customer_id): View
    {
        $customer = Customers::find($customer_id);

        if (!$customer) abort(404);

        return view('cp.customer_log.index', compact('customer_id'))->with('title', 'Логи: ' . $customer->name);
    }
}