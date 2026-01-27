<?php

namespace App\Repositories;

use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class OrdersRepository extends BaseRepository
{
    public function __construct(Orders $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Collection|null
     */
    public function update(int $id, array $data): ?Orders
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->status = $data['status'];
            $model->delivery_date = $data['delivery_date'];

            if ($data['invoice']) {
                $model->invoice = $data['invoice'];
            }

            if ($data['delivery_date']) {
                $model->delivery_date = Carbon::createFromFormat('d/m/Y', $data['delivery_date'])->format('Y-m-d');
            }

            $model->save();

            return $model;
        }
        return null;
    }
}
