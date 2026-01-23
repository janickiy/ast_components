<?php

namespace App\Repositories;

use App\DTO\RequestsCreateData;
use App\Enums\RequestStatus;
use App\Models\Requests;
use Illuminate\Pagination\LengthAwarePaginator;


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
     * @return Requests|null
     */
    public function update(int $id, array $data): ?Requests
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->status = (int) $data['status'];
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
}
