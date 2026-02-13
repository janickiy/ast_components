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
     * @return Seo|null
     */
    public function update(int $id, array $data): ?Seo
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->h1 = $data['h1'];
            $model->title = $data['title'];
            $model->keyword = $data['keyword'];
            $model->description = $data['description'];
            $model->url_canonical = $data['url_canonical'];
            $model->save();

            return $model;
        }
        return null;
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

                if (in_array($key, [
                        'meta_title',
                        'meta_description',
                        'meta_keywords',
                        'seo_h1',
                        'seo_url_canonical',
                    ]) && empty($value)) {
                    return null;
                }

                return $value;
            })
            ->toArray();
    }
}