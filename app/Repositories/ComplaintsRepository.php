<?php

namespace App\Repositories;

use App\DTO\ComplaintCreateData;
use App\Enums\ComplaintStatus;
use App\Models\Complaints;
use App\Models\OrderProduct;
use Illuminate\Database\DatabaseManager;
use Exception;

class ComplaintsRepository extends BaseRepository
{
    /**
     * @param Complaints $model
     * @param DatabaseManager $database
     */
    public function __construct(Complaints $model, private readonly DatabaseManager $database)
    {
        parent::__construct($model);
    }

    /**
     * @param ComplaintCreateData $data
     * @return mixed
     * @throws \Throwable
     */
    public function add(ComplaintCreateData $data): Complaints
    {
        return $this->database->transaction(function () use ($data): \Illuminate\Database\Eloquent\Model {
            $orderProduct = OrderProduct::query()
                ->where('order_id', $data->orderId)
                ->where('product_id', $data->productId)
                ->first();

            if (!$orderProduct) {
                throw new Exception('Не удалось найти позицию заказа для претензии.');
            }

            return $this->create([
                'type' => $data->type,
                'status' => ComplaintStatus::Created->value,
                'order_count' => (int) $orderProduct->count,
                'return_count' => $data->returnCount,
                'order_id' => $data->orderId,
                'product_id' => $data->productId,
                'customer_id' => $data->customerId,
                'blank' => $data->blank,
            ]);
        });
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateWithMapping(int $id, array $data): bool
    {
        return $this->update($id,$this->mapping($data));
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->remove();
        }
    }

    /**
     * @param array $data
     * @return array
     */
    private function mapping(array $data): array
    {
        return collect($data)
            ->merge([
                'result' => $data['result'] ?? null,
            ])
            ->only($this->model->getFillable())
            ->map(function ($value, $key) {
                if ($key === 'status' && !is_null($value)) {
                    return (int)$value;
                }
                return $value;
            })
            ->all();
    }
}
