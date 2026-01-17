<?php

namespace App\Services;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrdersService
{
    /**
     * @param Orders $order
     * @param Request $request
     * @return false|string
     */
    public function updateFile(Orders $order, Request $request): false|string
    {
        if (Storage::disk('public')->exists('invoices/' . $order->invoice) === true) {
            Storage::disk('public')->delete('invoices/' . $order->invoice);
        }

        $extension = $request->file('invoice')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $request->file('invoice')->move('uploads/invoices', $filename);

        return $filename;
    }
}