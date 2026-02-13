<?php

namespace App\Repositories;

use App\DTO\RequestsCreateData;
use App\Enums\RequestStatus;
use App\Models\Requests;

class RequestsRepository extends BaseRepository
{
    /**
     * @param Requests $model
     */
    public function __construct(Requests $model)
    {
        parent::__construct($model);
    }

    /**
     * @param RequestsCreateData $data
     * @return Requests
     */
    public function add(RequestsCreateData $data): Requests
    {
        return Requests::query()->create([
            'name' => $data->name,
            'company' => $data->company,
            'phone' => $data->phone,
            'email' => $data->email,
            'message' => $data->message,
            'nomenclature' => $data->nomenclature,
            'count' => $data->count,
            'unit' => $data->unit,
            'ip' => $data->ip,
            'status' => RequestStatus::Created->value,
            'customer_id' => $data->customerId,
            'attach' => $data->attach,
        ]);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateWithMapping(int $id, array $data): bool
    {
        return $this->update($id, $this->mapping($data));
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

    private function mapping(array $data): array
    {
        return collect($data)

            ->only($this->model->getFillable())
            ->mapWithKeys(function ($value, $key) {
                if ($key === 'status' && !is_null($value)) {
                    return (int)$value;
                }
                return $value;
            })
            ->toArray();
    }
}
