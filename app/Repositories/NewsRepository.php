<?php

namespace App\Repositories;

use App\Models\News;

class NewsRepository extends BaseRepository
{
    public function __construct(News $model)
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
        $news = $this->model->find($id);

        if ($news) {
            $news->title = $data['title'];
            $news->text = $data['text'];
            $news->preview = $data['preview'];
            $news->meta_title = $data['meta_title'];
            $news->meta_description = $data['meta_description'];
            $news->meta_keywords = $data['meta_keywords'];
            $news->slug = $data['slug'];
            $news->seo_h1 = $data['seo_h1'];
            $news->seo_url_canonical = $data['seo_url_canonical'];

            if ($data['image']) {
                $news->image = $data['image'];
            }

            $news->image_title = $data['image_title'];
            $news->image_alt = $data['image_alt'];
            $news->save();
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


}
