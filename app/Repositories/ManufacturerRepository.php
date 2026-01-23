<?php

namespace App\Repositories;

use App\Models\Manufacturers;

class ManufacturerRepository extends BaseRepository
{
    public function __construct(Manufacturers $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Manufacturers|null
     */
    public function update(int $id, array $data): ?Manufacturers
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->title = $data['title'];
            $model->country = $data['country'];
            $model->description = $data['description'];
            $model->meta_title = $data['meta_title'];
            $model->meta_description = $data['meta_description'];
            $model->meta_keywords = $data['meta_keywords'];
            $model->slug = $data['slug'];
            $model->seo_h1 = $data['seo_h1'];
            $model->seo_url_canonical = $data['seo_url_canonical'];
            $model->published = (int) $data['published'];

            if ($data['image']) {
                $model->image = $data['image'];
            }

            $model->image_title = $data['image_title'];
            $model->image_alt = $data['image_alt'];
            $model->seo_sitemap = $data['seo_sitemap'];
            $model->save();

            return $model;

        }
        return null;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return Manufacturers::orderBy('title')->get()->pluck('title', 'id')->toArray();
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $manufacturer = $this->find($id);

        if ($manufacturer) {
            $manufacturer->remove();
        }
    }
}