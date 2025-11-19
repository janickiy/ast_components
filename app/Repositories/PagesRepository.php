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
     * @return null
     */
    public function update(int $id, array $data): mixed
    {
        $page = $this->model->find($id);

        if ($page) {
            $page->title = $data['title'];
            $page->text = $data['text'];
            $page->meta_title = $data['meta_title'];
            $page->meta_description = $data['meta_description'];
            $page->meta_keywords = $data['meta_keywords'];
            $page->slug = $data['slug'];
            $page->seo_h1 = $data['seo_h1'];
            $page->seo_url_canonical = $data['seo_url_canonical'];
            $page->published = $data['published'];

            if ($data['image']) {
                $page->image = $data['image'];
            }

            if ($data['main'] === 1) {
                Pages::where('main', 1)->update(['main' => 0]);
            }

            $page->main = $data['main'];
            $page->seo_sitemap = $data['seo_sitemap'];
            $page->save();
        }
        return null;
    }

    /**
     * @return array
     */
    public function getOption(): array
    {
        $options = [];

        foreach (Pages::orderBy('id')->published()->get() as $page) {
            $options[$page->id] = $page->title;
        }

        return $options;
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $page = $this->find($id);

        if ($page) {
            $page->remove();
        }
    }
}