<?php

namespace App\Repositories;

use App\Models\OrderProduct;

class OrderProductRepository extends BaseRepository
{
    public function __construct(OrderProduct $model)
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
        $orderProduct = $this->model->find($id);

        if ($orderProduct) {
            $orderProduct->product_info = $data['product_info'];
            $orderProduct->count = $data['count'];
            $orderProduct->price = $data['price'];
            $orderProduct->save();
        }
        return null;
    }
}
