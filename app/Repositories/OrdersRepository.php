<?php

namespace App\Repositories;

use App\DTO\DataTransferObjectInterface;
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
    public function updateWithMapping(int $id, array|DataTransferObjectInterface $data): bool
    {
        return $this->update($id, $this->mapping($data));
    }

    private function mapping(array|DataTransferObjectInterface $data): array
    {
        $data = $this->normalizeData($data);
        return collect($data)
            ->when(!isset($data['invoice']), function ($collection) {
                return $collection->forget('invoice');
            })
            ->only($this->model->getFillable())
            ->map(function ($value, $key) {
                if ($key === 'delivery_date' && !is_null($value)) {
                    return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
                }
                return $value;
            })
            ->all();
    }
}
