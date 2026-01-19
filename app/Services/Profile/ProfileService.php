<?php

declare(strict_types=1);

namespace App\Services\Profile;

use App\Contracts\ProfileServiceInterface;
use App\Models\Complaints;
use App\Models\OrderProduct;
use App\Models\Orders;
use Illuminate\Support\Collection;

class ProfileService implements ProfileServiceInterface
{
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
