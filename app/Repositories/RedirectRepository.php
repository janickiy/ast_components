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
     * @return null
     */
    public function update(int $id, array $data): mixed
    {
        $catalog = $this->model->find($id);

        if ($catalog) {
            $catalog->from = $data['from'];
            $catalog->to = $data['to'];
            $catalog->status = (int) $data['status'];
            $catalog->save();
        }
        return null;
    }

}