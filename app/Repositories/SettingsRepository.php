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
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateWithMapping(int $id, array $data): bool
    {
       return $this->update($id, $this->mapping($data));
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

    private function mapping(array $data): array
    {
        return collect($data)
            ->merge([
                'key_cd' => $data['key_cd'] ?? null,
                'display_value' => $data['display_value'] ?? null,
                'value' => $data['value'] ?? null,
            ])
            ->only($this->model->getFillable())
            ->mapWithKeys(function ($value, $key) {
                if ($key === 'published' && !is_null($value)) {
                    return (int)$value;
                }
                return $value;
            })
            ->toArray();
    }
}