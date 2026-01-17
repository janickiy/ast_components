<?php

namespace App\Repositories;

use App\Models\Products;
use Illuminate\Http\Request;

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
            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->catalog_id = (int) $data['catalog_id'];
            $product->manufacturer_id = (int) $data['manufacturer_id'];
            $product->price = (int) $data['price'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->slug = $data['slug'];
            $product->seo_h1 = $data['seo_h1'];
            $product->seo_url_canonical = $data['seo_url_canonical'];
            $product->seo_sitemap = $data['seo_sitemap'];
            $product->image_title = $data['image_title'];
            $product->image_alt = $data['image_alt'];
            $product->in_stock = (int) $data['in_stock'];
            $product->under_order = (int) $data['under_order'];
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

    /**
     * @param Request $request
     * @param int $id
     * @return array
     */
    public function setViewed(Request $request, int $id): array
    {
        $product = $this->model->find($id);

        $productIds = null;

        if ($product) {
            if ($request->session()->has('productIds')) {
                $productIds = $request->session()->get('productIds');
                array_push($productIds, $product->id);
                $productIds = array_unique($productIds);
                $request->session()->put(['productIds' => $productIds]);
            } else {
                $productIds = [$product->id];
                $request->session()->put(['productIds' => $productIds]);
            }
        }

        return $productIds;
    }
}