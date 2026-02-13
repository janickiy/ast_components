<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Support\Collection;

class NewsRepository extends BaseRepository
{
    public function __construct(News $model)
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
        $news = $this->model->find($id);

        if ($news) {
            $news->remove();
        }
    }

    public function newsBanner(): Collection
    {
        return $this->model->orderBy('created_at')
            ->where('promotion', 1)
            ->limit(1)
            ->get();
    }

    /**
     * @param int $limit
     * @return Collection
     */
    public function lastNews(int $limit = 3): Collection
    {
        return $this->model->inRandomOrder()
            ->published()
            ->limit($limit)
            ->get();
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
            ->when(!isset($data['image']), function ($collection) {
                return $collection->forget('image');
            })
            ->only($this->model->getFillable())
            ->mapWithKeys(function ($value, $key) {
                if (in_array($key, [
                        'published',
                        'seo_sitemap',
                    ]) && !is_null($value)) {
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
