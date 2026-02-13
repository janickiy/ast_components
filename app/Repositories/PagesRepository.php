<?php

namespace App\Repositories;

use App\Models\Pages;

class PagesRepository extends BaseRepository
{
    public function __construct(Pages $model)
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
        if ($data['main'] === 1) {
            $this->model->where('main', 1)->update(['main' => 0]);
        }

        return $this->update($id, $this->mapping($data));
    }

    /**
     * @return array
     */
    public function getOption(): array
    {
        $options = [];

        foreach (Pages::orderBy('id')->published()->get() ?? [] as $page) {
            $options[$page->id] = $page->title;
        }

        return $options;
    }

    private function mapping(array $data): array
    {
        return collect($data)
            ->merge([
                'meta_title' => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'meta_keywords' => $data['meta_keywords'] ?? null,
                'seo_h1' => $data['seo_h1'] ?? null,
                'seo_url_canonical' => $data['seo_url_canonical'] ?? null,
                'seo_sitemap' => $data['seo_sitemap'] ?? 1,
            ])
            ->when(!isset($data['invoice']), function ($collection) {
                return $collection->forget('image');
            })
            ->only($this->model->getFillable())
            ->mapWithKeys(function ($value, $key) {
                if (in_array($key, [
                        'published',
                        'main',
                        'seo_sitemap',
                    ]) && !is_null($value)) {
                    return (int)$value;
                }
                return $value;
            })
            ->toArray();
    }
}