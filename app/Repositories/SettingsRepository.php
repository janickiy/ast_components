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
            $settings->key_cd = $data['key_cd'] ?? null;
            $settings->name = $data['name'] ;
            $settings->display_value = $data['display_value'] ?? null;
            $settings->value = $data['value'] ?? null;
            $settings->published = $data['published'];
            $settings->save();
        }
        return null;
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $settings = $this->model->find($id);

        if ($settings) {
            $settings->remove();
        }
    }
}