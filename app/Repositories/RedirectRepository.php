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
     * @return bool
     */
    public function updateWithMapping(int $id, array $data): bool
    {
       return $this->update($id, $this->mapping($data));
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