<?php

namespace App\Repositories;

use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

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

            if ($data['delivery_date']) {
                $order->delivery_date = Carbon::createFromFormat('d/m/Y', $data['delivery_date'])->format('Y-m-d');
            }

            $order->save();
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
