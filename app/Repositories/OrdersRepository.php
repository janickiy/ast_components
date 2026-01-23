<?php

namespace App\Repositories;

use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
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

    /**
     * @param int $customerId
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginateByCustomer(
        int   $customerId,
        int   $perPage = 10,
        array $filters = []
    ): LengthAwarePaginator
    {
        $q = $this->model->newQuery()
            ->with(['items.product'])
            ->where('customer_id', $customerId)
            ->orderByDesc('created_at'); // или created_at

        // Примеры фильтров (по желанию)
        if (!empty($filters['status'])) {
            $q->where('status', $filters['status']);
        }

        if (!empty($filters['from'])) {
            $q->whereDate('created_at', '>=', $filters['from']);
        }

        if (!empty($filters['to'])) {
            $q->whereDate('created_at', '<=', $filters['to']);
        }

        return $q->paginate($perPage);
    }
}
