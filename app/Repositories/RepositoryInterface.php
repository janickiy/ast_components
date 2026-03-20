<?php

namespace App\Repositories;

use App\DTO\DataTransferObjectInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Model;

    public function create(array|DataTransferObjectInterface $data): Model;

    public function update(int $id, array|DataTransferObjectInterface $data): bool;

    public function delete(int $id): bool;
}
