<?php

namespace App\Http\Controllers\Admin;

use App\Models\Logs;
use Illuminate\View\View;

class CustomerLogsController extends Controller
{
    /**
     * @param int $customer_id
     * @return View
     */
    public function __invoke(int $customer_id): View
    {
        $log = Logs::where('customer_id', $customer_id)->first();

        if (!$log) abort(404);

        return view('cp.customer_log.index', compact('log','customer_id'))->with('title', 'Логи: ' . $log->customer->name);
    }
}