<?php

namespace App\Repositories;

use App\DTO\DataTransferObjectInterface;
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
     * @return bool
     */
    public function updateWithMapping(int $id, array|DataTransferObjectInterface $data): bool
    {
        return $this->update($id, $this->mapping($data));
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

    /**
     * @param array $data
     * @return array
     */
    private function mapping(array|DataTransferObjectInterface $data): array
    {
        $data = $this->normalizeData($data);
        return collect($data)
            ->merge([
                'name' => $data['name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
            ])
            ->only($this->model->getFillable())
            ->all();
    }
}
