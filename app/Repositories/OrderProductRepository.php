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
     * @return OrderProduct|null
     */
    public function update(int $id, array $data): ?OrderProduct
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->product_info = $data['product_info'];
            $model->count = (int) $data['count'];
            $model->price = (float) $data['price'];
            $model->save();

            return $model;
        }
        return null;
    }
}
