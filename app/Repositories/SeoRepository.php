<?php

namespace App\Repositories;

use App\Models\Seo;

class SeoRepository extends BaseRepository
{
    public function __construct(Seo $model)
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
            ->merge([
                'h1' => $data['h1'] ?? null,
                'title' => $data['title'] ?? null,
                'keyword' => $data['keyword'] ?? null,
                'description' => $data['description'] ?? null,
                'url_canonical' => $data['url_canonical'] ?? null,
                'seo_sitemap' => $data['seo_sitemap'] ?? 1,
            ])
            ->only($this->model->getFillable())
            ->mapWithKeys(function ($value, $key) {
                if ($key === 'seo_sitemap' && !is_null($value)) {
                    return (int)$value;
                }

                return $value;
            })
            ->toArray();
    }
}