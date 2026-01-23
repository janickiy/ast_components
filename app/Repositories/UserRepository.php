<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function update(int $id, array $data): ?User
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->login = $data['login'] ?? $model->login;
            $model->name = $data['name'] ?? $model->name;

            if (!empty($model->role)) $model->role = $data['role'];

            if (isset($data['password'])) {
                $model->password = Hash::make($data['password']);
            }

            $model->save();

            return $model;
        }
        return null;
    }
}
