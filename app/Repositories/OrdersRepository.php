<?php

namespace App\Repositories;

use App\Models\Orders;
use Carbon\Carbon;

class OrdersRepository extends BaseRepository
{
    public function __construct(Orders $model)
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
            ->when(!isset($data['invoice']), function ($collection) {
                return $collection->forget('image');
            })
            ->only($this->model->getFillable())
            ->mapWithKeys(function ($value, $key) {
                if ($key === 'delivery_date' && !is_null($value)) {
                    return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
                }
                return $value;
            })
            ->toArray();
    }
}
