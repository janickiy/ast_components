<?php

namespace App\Repositories;

use App\Models\Orders;

class OrdersRepository extends BaseRepository
{
    public function __construct(Orders $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        $order = $this->model->find($id);

        if ($order) {
            $order->status = $data['status'];
            $order->delivery_date = $data['delivery_date'];

            if ($data['invoice']) {
                $order->invoice = $data['invoice'];
            }

            $order->save();
        }
        return null;
    }
}
