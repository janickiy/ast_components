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
        $manufacturer = $this->model->find($id);

        if ($manufacturer) {
            $manufacturer->title = $data['title'];
            $manufacturer->country = $data['country'];
            $manufacturer->description = $data['description'];
            $manufacturer->meta_title = $data['meta_title'];
            $manufacturer->meta_description = $data['meta_description'];
            $manufacturer->meta_keywords = $data['meta_keywords'];
            $manufacturer->slug = $data['slug'];
            $manufacturer->seo_h1 = $data['seo_h1'];
            $manufacturer->seo_url_canonical = $data['seo_url_canonical'];
            $manufacturer->published = $data['published'];

            if ($data['image']) {
                $manufacturer->image = $data['image'];
            }

            $manufacturer->seo_sitemap = $data['seo_sitemap'];
            $manufacturer->save();
        }
        return null;
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