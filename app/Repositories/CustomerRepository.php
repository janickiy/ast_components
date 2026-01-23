<?php

namespace App\Repositories;

use App\Models\Complaints;
use App\Models\Customers;
use App\Models\OrderProduct;
use App\Models\Orders;
use Illuminate\Support\Collection;

class CustomerRepository extends BaseRepository
{
    public function __construct(Customers $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Customers|null
     */
    public function update(int $id, array $data): ?Customers
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->name = $data['name'];
            $model->email = $data['email'];
            $model->phone = $data['phone'];
            $model->save();

            return $model;
        }
        return null;
    }

    /**
     * @param int $customerId
     * @return Collection
     */
    public function getOrdersForCustomer(int $customerId): Collection
    {
        return Orders::query()
            //->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param int $customerId
     * @return Collection
     */
    public function getComplaintsForCustomer(int $customerId): Collection
    {
        return Complaints::query()
            ->with(['order', 'product'])
            ->where('customer_id', $customerId)
            ->latest()
            ->get();
    }

    /**
     * @param int $customerId
     * @return Collection
     */
    public function getComplaintOrderProducts(int $customerId): Collection
    {
        $orderIds = Orders::query()
            ->where('customer_id', $customerId)
            ->pluck('id');

        if ($orderIds->isEmpty()) {
            return collect();
        }

        return OrderProduct::query()
            ->with(['product', 'order'])
            ->whereIn('order_id', $orderIds)
            ->get();
    }
}
