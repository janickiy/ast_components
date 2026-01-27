<?php

namespace App\Repositories;

use App\Models\Catalog;
use App\Models\Manufacturers;
use App\Models\Products;
use App\Http\Filters\ProductFilter;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class ProductsRepository extends BaseRepository
{
    public function __construct(Products $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return Products
     */
    public function create(array $data): Products
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Products|null
     */
    public function update(int $id, array $data): ?Products
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->title = $data['title'];
            $model->description = $data['description'];
            $model->catalog_id = (int)$data['catalog_id'];
            $model->manufacturer_id = (int)$data['manufacturer_id'];
            $model->price = (int)$data['price'];
            $model->meta_title = $data['meta_title'];
            $model->meta_description = $data['meta_description'];
            $model->meta_keywords = $data['meta_keywords'];
            $model->slug = $data['slug'];
            $model->seo_h1 = $data['seo_h1'];
            $model->seo_url_canonical = $data['seo_url_canonical'];
            $model->seo_sitemap = $data['seo_sitemap'];
            $model->image_title = $data['image_title'];
            $model->image_alt = $data['image_alt'];
            $model->in_stock = (int)$data['in_stock'];
            $model->under_order = (int)$data['under_order'];
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
        $model = $this->model->find($id);

        if ($model) {
            $model->remove();
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

    /**
     * @return array|null
     */
    public function viewedProducts(): ?array
    {
        if (request()->session()->has('productIds')) {
            return request()->session()->get('productIds');
        } else {
            return null;
        }
    }

    /**
     * Фильтр поиска
     *
     * @param Catalog|null $catalog
     * @return array
     */
    public function getFilters(?Catalog $catalog = null): array
    {
        $filter = [];
        $catalogsList = [];

        if ($catalog) {
            foreach ($catalog?->children->all() ?? [] as $child) {
                $catalogsList[] = ['name' => $child->name, 'count' => $child->getProductCount()];
            }
        }

        $filter['catalogs'] = $catalogsList;
        $manufacturers = Manufacturers::orderBy('title')->published()->get();
        $manufacturersList = [];

        foreach ($manufacturers as $manufacturer) {
            $manufacturersList[] = ['name' => $manufacturer->title, 'count' => $manufacturer->getProductCount()];
        }

        $filter['manufacturers'] = [$manufacturersList];

        return $filter;
    }

    /**
     * @param Request $request
     * @param ProductFilter $filter
     * @param int $limit
     * @param array|null $catalogIds
     * @return array
     */
    public function getProducts(Request $request, ProductFilter $filter, int $limit, ?array $catalogIds = null): array
    {
        $baseQuery = Products::filter($filter);

        if ($request->has('catalog_id')) {
            $baseQuery->whereIn('catalog_id', $request->get('catalog_id'));
        } else {
            if ($catalogIds) $baseQuery->whereIn('catalog_id', $catalogIds);
        }

        if ($request->has('manufacturer_id')) {
            $baseQuery->whereIn('manufacturer_id', $request->get('manufacturer_id'));
        }

        $items = (clone $baseQuery)->orderBy('in_stock', 'desc')->orderBy('price')->paginate($limit)->withQueryString();
        $total = (clone $baseQuery)->count();

        return [
            'items' => $items,
            'total' => $total,
        ];
    }
}