<?php

namespace App\Services;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class OrdersService
{
    /**
     * @param Orders $order
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function updateFile(Orders $order, Request $request): string
    {
        if (Storage::disk('public')->exists(Orders::getTableName() . '/' . $order->invoice) === true) {
            Storage::disk('public')->delete(Orders::getTableName() . '/' . $order->invoice);
        }

        $extension = $request->file('invoice')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('invoice')->move('uploads/invoices', $filename) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        return $filename;
    }
}