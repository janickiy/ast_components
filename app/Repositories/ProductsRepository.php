<?php

namespace App\Repositories;

use App\Models\Catalog;
use App\Models\Manufacturers;
use App\Models\Products;
use App\Http\Filters\ProductFilter;
use Illuminate\Http\Request;


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

        if ($request->has('price_from') && $request->has('price_to')) {
            $baseQuery->priceRange($request->get('price_from'), $request->get('price_to'));
        }

        $items = (clone $baseQuery)
            ->with('manufacturer')
            ->orderBy('in_stock', 'desc')
            ->orderBy('price')->paginate($limit)
            ->withQueryString();

        $total = (clone $baseQuery)->count();

        return [
            'items' => $items,
            'total' => $total,
        ];
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
                'image_title' => $data['image_title'] ?? null,
                'image_alt' => $data['image_alt'] ?? null,
                'seo_sitemap' => $data['seo_sitemap'] ?? 1,
            ])
            ->when(!isset($data['image']), function ($collection) {
                return $collection->forget('image');
            })
            ->only($this->model->getFillable())
            ->mapWithKeys(function ($value, $key) {
                if (in_array($key, [
                    'in_stock',
                    'under_order',
                    'catalog_id',
                    'manufacturer_id',
                    'price',
                    ]) && !is_null($value)) {
                    return (int)$value;
                }

                if (in_array($key, [
                        'meta_title',
                        'meta_description',
                        'meta_keywords',
                        'seo_h1',
                        'seo_url_canonical',
                        'image_title',
                        'image_alt',
                    ]) && empty($value)) {
                    return null;
                }

                return $value;
            })
            ->toArray();
    }
}