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
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        $user = $this->model->find($id);

        if ($user) {
            $user->login = $data['login'];
            $user->name = $data['name'];
            $user->description = $data['description'];

            if (!empty($request->role)) $user->role = $request->input('role');

            if (isset($data['password']) && !empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();
        }
        return null;
    }
}
