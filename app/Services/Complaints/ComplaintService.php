<?php

namespace App\Services\Complaints;

use App\Contracts\Complaints\ComplaintServiceInterface;
use App\DTO\Complaints\ComplaintCreateData;
use App\Enums\ComplaintStatus;
use App\Exceptions\ComplaintCreationException;
use App\Models\Complaints;
use App\Models\OrderProduct;
use Illuminate\Database\DatabaseManager;

class ComplaintService implements ComplaintServiceInterface
{
    /**
     * @param DatabaseManager $database
     */
    public function __construct(private readonly DatabaseManager $database)
    {
    }

    /**
     * @param ComplaintCreateData $data
     * @return Complaints
     * @throws \Throwable
     */
    public function create(ComplaintCreateData $data): Complaints
    {
        return $this->database->transaction(function () use ($data): Complaints {
            $orderProduct = OrderProduct::query()
                ->where('order_id', $data->orderId)
                ->where('product_id', $data->productId)
                ->first();

            if (!$orderProduct) {
                throw new ComplaintCreationException('Не удалось найти позицию заказа для претензии.');
            }

            return Complaints::query()->create([
                'type' => $data->type,
                'status' => ComplaintStatus::Created->value,
                'order_count' => (int) $orderProduct->count,
                'return_count' => $data->returnCount,
                'order_id' => $data->orderId,
                'product_id' => $data->productId,
                'customer_id' => $data->customerId,
            ]);
        });
    }
}
