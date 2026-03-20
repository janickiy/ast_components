<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Customers;
use Illuminate\View\View;

class CustomerLogsController extends Controller
{
    public function __invoke(int $customer_id): View
    {
        $customer = Customers::find($customer_id);

        abort_if($customer === null, 404);

        return view('cp.customer_log.index', compact('customer_id'))
            ->with('title', 'Логи: ' . $customer->name);
    }
}