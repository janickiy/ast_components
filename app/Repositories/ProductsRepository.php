<?php

namespace App\Repositories;

use App\Models\Products;

class ProductsRepository extends BaseRepository
{
    public function __construct(Products $model)
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
        $product = $this->model->find($id);

        if ($product) {
            $product->name = $data['name'];
            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->catalog_id = $data['catalog_id'];
            $product->price = $data['price'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->slug = $data['slug'];
            $product->seo_h1 = $data['seo_h1'];
            $product->seo_url_canonical = $data['seo_url_canonical'];
            $product->seo_sitemap = $data['seo_sitemap'];
            $product->image_title = $data['image_title'];
            $product->image_alt = $data['image_alt'];
            $product->published = $data['published'];

            if ($data['thumbnail']) {
                $product->thumbnail = $data['thumbnail'];
            }

            if ($data['origin']) {
                $product->origin = $data['origin'];
            }

            $product->save();
        }
        return null;
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $product = $this->model->find($id);

        if ($product) {
            $product->remove();
        }
    }

}