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
     * @return null
     */
    public function update(int $id, array $data): ?Pages
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->title = $data['title'];
            $model->text = $data['text'];
            $model->meta_title = $data['meta_title'];
            $model->meta_description = $data['meta_description'];
            $model->meta_keywords = $data['meta_keywords'];
            $model->slug = $data['slug'];
            $model->seo_h1 = $data['seo_h1'];
            $model->seo_url_canonical = $data['seo_url_canonical'];
            $model->published = (int) $data['published'];

            if ($data['main'] === 1) {
                Pages::where('main', 1)->update(['main' => 0]);
            }

            $model->main = (int) $data['main'];
            $model->seo_sitemap = $data['seo_sitemap'];
            $model->save();

            return $model;
        }
        return null;
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
}