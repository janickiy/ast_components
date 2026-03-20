<?php

namespace App\Repositories;

use App\DTO\DataTransferObjectInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class BaseRepository implements RepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function create(array|DataTransferObjectInterface $data): Model
    {
        return $this->model->create($this->normalizeData($data));
    }

    public function update(int $id, array|DataTransferObjectInterface $data): bool
    {
        $model = $this->model->find($id);

        if ($model) {
            return $model->fill($this->normalizeData($data))->save();
        }

        return false;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function delete(int $id): bool
    {
        $model = $this->model->find($id);
        if ($model) {
            $model->delete();
            return true;
        }
        return false;
    }

    public function paginateByCustomer(
        int   $customerId,
        int   $perPage = 10,
        array $filters = []
    ): LengthAwarePaginator
    {
        $q = $this->model->newQuery()
            ->where('customer_id', $customerId)
            ->orderByDesc('created_at');

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

    protected function normalizeData(array|DataTransferObjectInterface $data): array
    {
        return $data instanceof DataTransferObjectInterface ? $data->toArray() : $data;
    }
}
