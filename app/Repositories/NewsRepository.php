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
     * @return News|null
     */
    public function update(int $id, array $data): ?News
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->title = $data['title'];
            $model->text = $data['text'];
            $model->preview = $data['preview'];
            $model->meta_title = $data['meta_title'];
            $model->meta_description = $data['meta_description'];
            $model->meta_keywords = $data['meta_keywords'];
            $model->slug = $data['slug'];
            $model->seo_h1 = $data['seo_h1'];
            $model->seo_url_canonical = $data['seo_url_canonical'];

            if ($data['image']) {
                $model->image = $data['image'];
            }

            $model->image_title = $data['image_title'];
            $model->image_alt = $data['image_alt'];
            $model->save();

            return $model;
        }
        return null;
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
        return News::query()
            ->orderBy('created_at')
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
       return News::inRandomOrder()
           ->published()
           ->limit($limit)
           ->get();
    }
}
