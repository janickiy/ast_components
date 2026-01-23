<?php

namespace App\Repositories;

use App\Models\Redirect;

class RedirectRepository extends BaseRepository
{
    public function __construct(Redirect $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Redirect|null
     */
    public function update(int $id, array $data): ?Redirect
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->from = $data['from'];
            $model->to = $data['to'];
            $model->status = (int) $data['status'];
            $model->save();

            return $model;
        }
        return null;
    }

}