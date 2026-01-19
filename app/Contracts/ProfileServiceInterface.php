<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface ProfileServiceInterface
{
    /**
     * @param int $customerId
     * @return Collection
     */
    public function getOrdersForCustomer(int $customerId): Collection;

    /**
     * @param int $customerId
     * @return Collection
     */
    public function getComplaintsForCustomer(int $customerId): Collection;

    /**
     * @param int $customerId
     * @return Collection
     */
    public function getComplaintOrderProducts(int $customerId): Collection;
}
