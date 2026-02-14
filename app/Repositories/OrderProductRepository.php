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
     * @return bool
     */
    public function updateWithMapping(int $id, array $data): bool
    {
        return $this->update($id, $this->mapping($data));
    }

    private function mapping(array $data): array
    {
        return collect($data)
            ->only($this->model->getFillable())
            ->map(function ($value, $key) {
                if ($key === 'count' && !is_null($value)) {
                    return (int)$value;
                }
                if ($key === 'price' && !is_null($value)) {
                    return (float)$value;
                }
                return $value;
            })
            ->all();
    }
}
