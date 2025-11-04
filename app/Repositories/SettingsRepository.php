<?php

namespace App\Repositories;

use App\Models\Settings;

class SettingsRepository extends BaseRepository
{
    public function __construct(Settings $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        $settings = $this->model->find($id);

        if ($settings) {
            $settings->name = $data['name'];
            $settings->save();
        }
        return null;
    }
}