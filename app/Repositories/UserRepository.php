<?php

namespace App\Repositories;

use App\DTO\DataTransferObjectInterface;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array|DataTransferObjectInterface $data): bool
    {
        return parent::update($id, $this->mapping($data));
    }

    private function mapping(array|DataTransferObjectInterface $data): array
    {
        $data = $this->normalizeData($data);
        return collect($data)
            ->merge([
                'name' => $data['name'] ?? null,
                'login' => $data['login'] ?? null,
                'role' => $data['role'] ?? null,
            ])
            ->when(empty($data['password'] ?? null), fn ($collection) => $collection->forget('password'))
            ->only($this->model->getFillable())
            ->all();
    }
}
