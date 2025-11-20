<?php

namespace App\Repositories;

use App\Models\Catalog;

class CatalogRepository extends BaseRepository
{
    public function __construct(Catalog $model)
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
        $catalog = $this->model->find($id);

        if ($catalog) {
            $catalog->name = $data['name'];
            $catalog->slug = $data['slug'];
            $catalog->meta_title = $data['meta_title'];
            $catalog->meta_description = $data['meta_description'];
            $catalog->meta_keywords = $data['meta_keywords'];
            $catalog->seo_h1 = $data['seo_h1'] ;
            $catalog->seo_url_canonical = $data['seo_url_canonical'];
            $catalog->parent_id = $data['parent_id'];
            $catalog->seo_sitemap = $data['seo_sitemap'];
            $catalog->save();
        }
        return null;
    }

    /**
     * @return array
     */
    public function getCatalogsList(): array
    {
        $catalogs = Catalog::query()->orderBy('name')->get();
        $catalogsList = [];

        foreach ($catalogs?->toArray() ?? [] as $catalog) {
            $catalogsList[$catalog['parent_id']][$catalog['id']] = $catalog;
        }

        return $catalogsList;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $options[0] = 'Выберите';

        return Catalog::ShowTree($options, 0);
    }
}
